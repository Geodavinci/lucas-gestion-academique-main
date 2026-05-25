@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['label' => 'Reçus de Paiement', 'url' => route('recu-paiements.index')],
    ['label' => $recu->numero_recu]
]" />

<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">{{ $recu->numero_recu }}</h1>
            <p class="mt-2 text-gray-600">Date: <span class="font-semibold text-gray-900">{{ $recu->date_paiement }}</span></p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('recu-paiements.edit', $recu) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-medium">
                <x-icon name="pencil" size="sm" class="w-4 h-4" />
                Modifier
            </a>
            <a href="{{ route('recu-paiements.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-gray-600 text-white hover:bg-gray-700 transition-colors duration-200 font-medium">
                <x-icon name="arrow-left" size="sm" class="w-4 h-4" />
                Retour
            </a>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:bg-emerald-50 transition-colors duration-200">
            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Étudiant</p>
            <p class="mt-2 text-lg font-semibold text-gray-900">{{ $recu->student?->nom }} {{ $recu->student?->prenom }}</p>
            @if ($recu->student)
                <p class="text-xs text-gray-500 mt-1">{{ $recu->student->matricule }}</p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:bg-emerald-50 transition-colors duration-200">
            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Montant</p>
            <p class="mt-2 text-lg font-semibold text-emerald-700 bg-gradient-to-r from-emerald-50 to-teal-50 px-4 py-2 rounded-lg w-fit">
                {{ number_format($recu->montant, 0, '.', ' ') }} FCFA
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:bg-emerald-50 transition-colors duration-200">
            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Fichier PDF</p>
            <div class="mt-2">
                @if ($recu->fichier_pdf)
                    <a href="{{ route('recu-paiements.download', $recu) }}" target="_blank" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 hover:bg-emerald-100 px-3 py-2 rounded-md transition-all text-sm font-medium">
                        <x-icon name="download" size="sm" class="w-4 h-4" />
                        Télécharger
                    </a>
                @else
                    <span class="text-gray-500 text-sm">Aucun fichier</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2 mb-4">
            <x-icon name="trash" size="md" class="w-5 h-5 text-red-600" />
            Zone dangereuse
        </h3>
        <p class="text-gray-600 text-sm mb-4">
            Cette action supprimera définitivement ce reçu de paiement. Cette action ne peut pas être annulée.
        </p>
        <form method="POST" action="{{ route('recu-paiements.destroy', $recu) }}" class="inline" data-confirm="Êtes-vous sûr de vouloir supprimer ce reçu de paiement ?">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md transition-colors duration-200 font-medium">
                <x-icon name="trash" size="sm" class="w-4 h-4" />
                Supprimer ce reçu
            </button>
        </form>
    </div>
</div>
@endsection
