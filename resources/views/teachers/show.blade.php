@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['label' => 'Enseignants', 'url' => route('teachers.index')],
    ['label' => $teacher->nom . ' ' . $teacher->prenom]
]" />

<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">{{ $teacher->nom }} {{ $teacher->prenom }}</h1>
            <p class="mt-2 text-gray-600">Spécialité: <span class="font-semibold text-gray-900">{{ $teacher->specialite }}</span></p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('teachers.edit', $teacher) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-medium">
                <x-icon name="pencil" size="sm" class="w-4 h-4" />
                Modifier
            </a>
            <a href="{{ route('teachers.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-gray-600 text-white hover:bg-gray-700 transition-colors duration-200 font-medium">
                <x-icon name="arrow-left" size="sm" class="w-4 h-4" />
                Retour
            </a>
        </div>
    </div>

    <!-- Info Card -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Email</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $teacher->email ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Téléphone</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $teacher->telephone ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Spécialité</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $teacher->specialite }}</p>
            </div>
        </div>
    </div>

    <!-- Soutenances Section -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Soutenances associées</h2>
        </div>

        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-4 font-semibold text-gray-800 text-xs uppercase tracking-wide">Date</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-800 text-xs uppercase tracking-wide">Statut</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-800 text-xs uppercase tracking-wide">Étudiant</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-800 text-xs uppercase tracking-wide">Rôle</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($soutenances as $soutenance)
                        <tr class="hover:bg-blue-50 transition-colors duration-200 group">
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-900">{{ $soutenance->date_soutenance }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                    {{ $soutenance->statut }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $soutenance->student?->nom }} {{ $soutenance->student?->prenom }}</td>
                            <td class="px-6 py-4 text-gray-600">
                                @php
                                    $roles = [];
                                    if ($soutenance->directeur_memoire_id === $teacher->id) $roles[] = 'Directeur';
                                    if ($soutenance->evaluateur_id === $teacher->id) $roles[] = 'Évaluateur';
                                    if ($soutenance->president_jury_id === $teacher->id) $roles[] = 'Président du jury';
                                @endphp
                                {{ implode(', ', $roles) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-8 text-center" colspan="4">
                                <div class="flex flex-col items-center gap-3">
                                    <x-icon name="calendar" class="w-8 h-8 text-gray-400" />
                                    <p class="text-gray-600 font-medium">Aucune soutenance associée</p>
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
