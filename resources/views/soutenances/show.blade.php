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
            <h1 class="text-4xl font-bold text-gray-900">Soutenance du {{ $soutenance->date_soutenance }}</h1>
            <p class="mt-2 text-gray-600">Statut: <span class="font-semibold">{{ $soutenance->statut }}</span></p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('soutenances.edit', $soutenance) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-medium">
                <x-icon name="pencil" size="sm" class="w-4 h-4" />
                Modifier
            </a>
            <a href="{{ route('soutenances.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-gray-600 text-white hover:bg-gray-700 transition-colors duration-200 font-medium">
                <x-icon name="arrow-left" size="sm" class="w-4 h-4" />
                Retour
            </a>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:bg-blue-50 transition-colors duration-200">
            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Étudiant</p>
            <p class="mt-2 text-lg font-semibold text-gray-900">{{ $soutenance->student?->nom }} {{ $soutenance->student?->prenom }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:bg-blue-50 transition-colors duration-200">
            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Directeur de mémoire</p>
            <p class="mt-2 text-lg font-semibold text-gray-900">{{ $soutenance->directeurMemoire?->nom }} {{ $soutenance->directeurMemoire?->prenom }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:bg-blue-50 transition-colors duration-200">
            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Évaluateur</p>
            <p class="mt-2 text-lg font-semibold text-gray-900">{{ $soutenance->evaluateurTeacher?->nom }} {{ $soutenance->evaluateurTeacher?->prenom }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:bg-blue-50 transition-colors duration-200">
            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Président du jury</p>
            <p class="mt-2 text-lg font-semibold text-gray-900">{{ $soutenance->presidentJury?->nom }} {{ $soutenance->presidentJury?->prenom }}</p>
        </div>
    </div>

    <!-- Description Section -->
    @if($soutenance->description)
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2 mb-4">
                <x-icon name="file-text" size="md" class="w-5 h-5 text-gray-600" />
                Description
            </h2>
            <p class="text-gray-700 leading-relaxed">{{ $soutenance->description }}</p>
        </div>
    @endif
</div>
@endsection
