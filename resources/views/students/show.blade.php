@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['label' => 'Étudiants', 'url' => route('students.index')],
    ['label' => $student->nom . ' ' . $student->prenom]
]" />

<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">{{ $student->nom }} {{ $student->prenom }}</h1>
            <p class="mt-2 text-gray-600">Matricule: <span class="font-semibold text-gray-900">{{ $student->matricule }}</span></p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('students.edit', $student) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-medium">
                <x-icon name="pencil" size="sm" class="w-4 h-4" />
                Modifier
            </a>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('soutenances.createForStudent', $student) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700 transition-colors duration-200 font-medium">
                    <x-icon name="plus-circle" size="sm" class="w-4 h-4" />
                    Soutenance
                </a>
            @endif
        </div>
    </div>

    <!-- Info Card -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Email</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $student->email ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Téléphone</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $student->telephone ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Filière</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $student->filiere }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Niveau</p>
                <span class="inline-flex items-center mt-2 px-3 py-1.5 rounded-full text-sm font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                    {{ $student->niveau }}
                </span>
            </div>
        </div>
    </div>

    <!-- Memoires Section -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Mémoires de l'étudiant</h2>
            <a href="{{ route('memoires.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-colors duration-200 font-medium">
                <x-icon name="plus-circle" size="sm" class="w-4 h-4" />
                Ajouter
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-4 font-semibold text-gray-800 text-xs uppercase tracking-wide">Titre</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-800 text-xs uppercase tracking-wide">Année</th>
                        <th class="text-right px-6 py-4 font-semibold text-gray-800 text-xs uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($memoires as $memoire)
                        <tr class="hover:bg-blue-50 transition-colors duration-200 group">
                            <td class="px-6 py-4">
                                <a href="{{ route('memoires.show', $memoire) }}" class="font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                                    {{ $memoire->titre }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $memoire->annee }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @if ($memoire->fichier_pdf)
                                        <a href="{{ route('memoires.download', $memoire) }}" target="_blank" class="inline-flex items-center gap-1.5 text-green-600 hover:text-green-700 hover:bg-green-100 px-3 py-2 rounded-md transition-all text-sm font-medium" title="Télécharger">
                                            <x-icon name="download" size="sm" class="w-4 h-4" />
                                            <span class="hidden sm:inline">PDF</span>
                                        </a>
                                    @endif
                                    @if (auth()->user()?->role === 'admin')
                                        <a href="{{ route('memoires.edit', $memoire) }}" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 hover:bg-amber-100 px-3 py-2 rounded-md transition-all text-sm font-medium" title="Modifier">
                                            <x-icon name="pencil" size="sm" class="w-4 h-4" />
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-8 text-center" colspan="3">
                                <div class="flex flex-col items-center gap-3">
                                    <x-icon name="document" class="w-8 h-8 text-gray-400" />
                                    <p class="text-gray-600 font-medium">Aucun mémoire enregistré</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recus Section -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Reçus de paiement</h2>
            <a href="{{ route('recu-paiements.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-colors duration-200 font-medium">
                <x-icon name="plus-circle" size="sm" class="w-4 h-4" />
                Ajouter
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-4 font-semibold text-gray-800 text-xs uppercase tracking-wide">Numéro</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-800 text-xs uppercase tracking-wide">Montant</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-800 text-xs uppercase tracking-wide">Date</th>
                        <th class="text-right px-6 py-4 font-semibold text-gray-800 text-xs uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($recus as $recu)
                        <tr class="hover:bg-blue-50 transition-colors duration-200 group">
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $recu->numero_recu }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ number_format($recu->montant, 0, '.', ' ') }} FCFA</td>
                            <td class="px-6 py-4 text-gray-600">{{ $recu->date_paiement }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @if ($recu->fichier_pdf)
                                        <a href="{{ route('recu-paiements.download', $recu) }}" target="_blank" class="inline-flex items-center gap-1.5 text-green-600 hover:text-green-700 hover:bg-green-100 px-3 py-2 rounded-md transition-all text-sm font-medium" title="Télécharger">
                                            <x-icon name="download" size="sm" class="w-4 h-4" />
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-8 text-center" colspan="4">
                                <div class="flex flex-col items-center gap-3">
                                    <x-icon name="document" class="w-8 h-8 text-gray-400" />
                                    <p class="text-gray-600 font-medium">Aucun reçu enregistré</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
