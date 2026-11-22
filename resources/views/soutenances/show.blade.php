@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['label' => 'Soutenances', 'url' => route('soutenances.index')],
    ['label' => $soutenance->date_soutenance . ' - ' . ($soutenance->student?->nom ?? '') . ' ' . ($soutenance->student?->prenom ?? '')]
]" />

<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">Soutenance du {{ $soutenance->date_soutenance->format('d/m/Y') }}</h1>
            <div class="mt-3 flex items-center gap-3">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold {{ $soutenance->statut == 'Valide' ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 border border-green-200' : 'bg-gradient-to-r from-amber-100 to-orange-100 text-amber-700 border border-amber-200' }}">
                    {{ $soutenance->statut ?? '-' }}
                </span>
            </div>
        </div>
        <div class="flex gap-3">
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('soutenances.edit', $soutenance) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-semibold">
                    <x-icon name="pencil" size="sm" class="w-4 h-4" />
                    Modifier / affecter le jury
                </a>
            @endif
            <a href="{{ route('soutenances.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-600 text-white hover:bg-gray-700 transition-colors duration-200 font-semibold">
                <x-icon name="arrow-left" size="sm" class="w-4 h-4" />
                Retour
            </a>
        </div>
    </div>

    <!-- Info Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Étudiant -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:bg-orange-50 transition-colors duration-200">
            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Étudiant</p>
            <p class="mt-2 text-lg font-semibold text-gray-900">{{ $soutenance->student?->nom }} {{ $soutenance->student?->prenom }}</p>
            @if ($soutenance->student)
                <p class="text-xs text-gray-500 mt-1">{{ $soutenance->student->matricule }}</p>
            @endif
        </div>

        <!-- Directeur de mémoire -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:bg-orange-50 transition-colors duration-200">
            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Directeur de mémoire</p>
            <p class="mt-2 text-lg font-semibold text-gray-900">{{ $soutenance->directeurMemoire?->nom ?? '-' }} {{ $soutenance->directeurMemoire?->prenom ?? '' }}</p>
            @if ($soutenance->directeurMemoire)
                <p class="text-xs text-gray-500 mt-1">{{ $soutenance->directeurMemoire->specialite }}</p>
            @endif
        </div>

        <!-- Évaluateur -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:bg-orange-50 transition-colors duration-200">
            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Évaluateur</p>
            <p class="mt-2 text-lg font-semibold text-gray-900">{{ $soutenance->evaluateurTeacher?->nom ?? '-' }} {{ $soutenance->evaluateurTeacher?->prenom ?? '' }}</p>
            @if ($soutenance->evaluateurTeacher)
                <p class="text-xs text-gray-500 mt-1">{{ $soutenance->evaluateurTeacher->specialite }}</p>
            @endif
        </div>

        <!-- Président du jury -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:bg-orange-50 transition-colors duration-200">
            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Président du jury</p>
            <p class="mt-2 text-lg font-semibold text-gray-900">{{ $soutenance->presidentJury?->nom ?? '-' }} {{ $soutenance->presidentJury?->prenom ?? '' }}</p>
            @if ($soutenance->presidentJury)
                <p class="text-xs text-gray-500 mt-1">{{ $soutenance->presidentJury->specialite }}</p>
            @endif
        </div>
    </div>

    <!-- Description Section -->
    @if($soutenance->description)
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2 mb-4">
                <x-icon name="file-text" size="md" class="w-5 h-5 text-orange-600" />
                Description
            </h2>
            <p class="text-gray-700 leading-relaxed">{{ $soutenance->description }}</p>
        </div>
    @endif

    @if (auth()->user()->role === 'admin')
    <!-- Delete Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2 mb-4">
            <x-icon name="trash" size="md" class="w-5 h-5 text-red-600" />
            Zone dangereuse
        </h3>
        <p class="text-gray-600 text-sm mb-4">
            Cette action supprimera définitivement cette soutenance. Cette action ne peut pas être annulée.
        </p>
        <form method="POST" action="{{ route('soutenances.destroy', $soutenance) }}" class="inline" data-confirm="Êtes-vous sûr de vouloir supprimer cette soutenance ?">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md transition-colors duration-200 font-medium">
                <x-icon name="trash" size="sm" class="w-4 h-4" />
                Supprimer cette soutenance
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
