@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['label' => 'Mémoires', 'url' => route('memoires.index')],
    ['label' => $memoire->titre]
]" />

<div class="space-y-8">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-8">
        <div class="flex justify-between items-start gap-6">
            <div class="flex-1">
                <h1 class="text-4xl font-bold text-gray-900">{{ $memoire->titre }}</h1>
                <p class="text-gray-600 mt-2">
                    Par <strong>{{ $memoire->student_full_name }}</strong>
                    • Année: {{ $memoire->annee }}
                </p>
            </div>
            <x-status-badge :status="$memoire->status" />
        </div>

        <!-- Actions -->
        <div class="mt-6 flex gap-3 flex-wrap">
            @can('update', $memoire)
                @if($memoire->canBeEdited())
                    <a href="{{ route('memoires.edit', $memoire) }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200 font-medium">
                        <x-icon name="pencil" size="sm" class="w-4 h-4" />
                        Modifier
                    </a>
                @endif
            @endcan

            @can('submit', $memoire)
                @if($memoire->status === 'draft')
                    <form action="{{ route('memoires.submit', $memoire) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors duration-200 font-medium">
                            <x-icon name="check" size="sm" class="w-4 h-4" />
                            Soumettre pour révision
                        </button>
                    </form>
                @endif
            @endcan

            @can('delete', $memoire)
                <form action="{{ route('memoires.destroy', $memoire) }}" method="POST" style="display: inline;" data-confirm="Êtes-vous sûr de vouloir supprimer ce mémoire ?">
                    @csrf @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors duration-200 font-medium">
                        <x-icon name="trash" size="sm" class="w-4 h-4" />
                        Supprimer
                    </button>
                </form>
            @endcan

            @if($memoire->fichier_pdf)
                <a href="{{ route('memoires.download', $memoire) }}" class="inline-flex items-center gap-2 bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors duration-200 font-medium">
                    <x-icon name="download" size="sm" class="w-4 h-4" />
                    Télécharger original
                </a>
            @endif

            @if($memoire->fichier_pdf_corrige)
                <a href="{{ route('memoires.download.corrige', $memoire) }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200 font-medium">
                    <x-icon name="download" size="sm" class="w-4 h-4" />
                    Télécharger corrigé
                </a>
            @endif
        </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:bg-blue-50 transition-colors duration-200">
            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Créé le</p>
            <p class="mt-2 text-lg font-semibold text-gray-900">{{ $memoire->created_at->format('d/m/Y H:i') }}</p>
        </div>

        @if($memoire->submitted_at)
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:bg-blue-50 transition-colors duration-200">
                <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Soumis le</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $memoire->submitted_at->format('d/m/Y H:i') }}</p>
            </div>
        @endif

        @if($memoire->reviewer)
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:bg-blue-50 transition-colors duration-200">
                <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Révisé par</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $memoire->reviewer->name }}</p>
            </div>
        @endif
    </div>

    <!-- Review Notes -->
    @if($memoire->review_notes)
        <x-alert
            type="warning"
            title="Notes de révision"
            :message="$memoire->review_notes"
            closeable="false"
        />
    @endif

    <!-- Admin Review Panel -->
    @if(auth()->user()->role === 'admin' && in_array($memoire->status, ['submitted', 'in_review']))
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2 mb-6">
                <x-icon name="clipboard-check" size="md" class="w-5 h-5 text-blue-600" />
                Panneau d'examen
            </h3>

            <div class="space-y-4">
                <!-- Request Changes -->
                <form action="{{ route('memoires.requestChanges', $memoire) }}" method="POST" class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    @csrf
                    <label for="review_notes" class="block text-gray-600 text-sm font-semibold uppercase tracking-wide mb-2">Demander des corrections</label>
                    <textarea name="review_notes" id="review_notes" rows="3" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500" placeholder="Décrivez les corrections demandées..."></textarea>
                    <button type="submit" class="mt-3 inline-flex items-center gap-2 bg-amber-600 text-white px-4 py-2 rounded-md hover:bg-amber-700 transition-colors duration-200 font-medium">
                        <x-icon name="alert-circle" size="sm" class="w-4 h-4" />
                        Demander des corrections
                    </button>
                </form>

                <hr class="border-gray-200">

                <!-- Approve -->
                <form action="{{ route('memoires.approve', $memoire) }}" method="POST" data-confirm="Êtes-vous sûr de vouloir approuver ce mémoire ?" data-confirm-text="Approuver" data-confirm-danger="false" class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors duration-200 font-medium">
                        <x-icon name="check-circle" size="sm" class="w-4 h-4" />
                        Approuver
                    </button>
                </form>

                <hr class="border-gray-200">

                <!-- Reject -->
                <form action="{{ route('memoires.reject', $memoire) }}" method="POST" class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    @csrf
                    <label for="reason" class="block text-gray-600 text-sm font-semibold uppercase tracking-wide mb-2">Rejeter avec raison</label>
                    <textarea name="reason" id="reason" rows="2" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500" placeholder="Raison du rejet..."></textarea>
                    <button type="submit" class="mt-3 inline-flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors duration-200 font-medium">
                        <x-icon name="x-circle" size="sm" class="w-4 h-4" />
                        Rejeter
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- Historique -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <x-icon name="history" size="md" class="w-5 h-5 text-gray-600" />
                Historique des modifications
            </h3>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($memoire->history as $entry)
                <div class="px-6 py-4 hover:bg-blue-50 transition-colors duration-200">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 flex items-center gap-2">
                                @if($entry->action === 'submitted')
                                    <x-icon name="check" size="sm" class="w-4 h-4 text-blue-600" />
                                    Soumis
                                @elseif($entry->action === 'reviewed')
                                    <x-icon name="eye" size="sm" class="w-4 h-4 text-amber-600" />
                                    En révision
                                @elseif($entry->action === 'changes_requested')
                                    <x-icon name="pencil" size="sm" class="w-4 h-4 text-yellow-600" />
                                    Corrections demandées
                                @elseif($entry->action === 'approved')
                                    <x-icon name="check-circle" size="sm" class="w-4 h-4 text-green-600" />
                                    Approuvé
                                @elseif($entry->action === 'rejected')
                                    <x-icon name="x-circle" size="sm" class="w-4 h-4 text-red-600" />
                                    Rejeté
                                @else
                                    {{ ucfirst($entry->action) }}
                                @endif
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                Par <strong>{{ $entry->user->name }}</strong>
                            </p>
                            @if($entry->notes)
                                <p class="text-sm text-gray-700 mt-2 bg-gray-50 p-2 rounded-md border border-gray-200">
                                    {{ $entry->notes }}
                                </p>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">{{ $entry->created_at->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $entry->created_at->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <x-icon name="history" class="w-8 h-8 text-gray-400" />
                        <p class="text-gray-600 font-medium">Aucun historique</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
