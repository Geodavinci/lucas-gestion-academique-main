@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">{{ $teacher->nom }} {{ $teacher->prenom }}</h1>
        <p class="text-sm text-slate-600">Specialite: {{ $teacher->specialite }}</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('teachers.edit', $teacher) }}" class="rounded border border-slate-300 px-4 py-2 text-sm">Modifier</a>
        <a href="{{ route('teachers.index') }}" class="rounded border border-slate-300 px-4 py-2 text-sm">Retour</a>
    </div>
</div>

<div class="bg-white rounded border border-slate-200 shadow-sm p-6">
    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div>
            <dt class="text-slate-500">Email</dt>
            <dd class="font-medium">{{ $teacher->email ?? '-' }}</dd>
        </div>
        <div>
            <dt class="text-slate-500">Telephone</dt>
            <dd class="font-medium">{{ $teacher->telephone ?? '-' }}</dd>
        </div>
        <div>
            <dt class="text-slate-500">Specialite</dt>
            <dd class="font-medium">{{ $teacher->specialite }}</dd>
        </div>
    </dl>
</div>

<div class="flex items-center justify-between mt-10 mb-4">
    <h2 class="text-xl font-semibold">Soutenances associees</h2>
</div>

<div class="bg-white rounded border border-slate-200 shadow-sm">
    <table class="w-full text-sm">
        <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-4 py-3">Date</th>
                <th class="text-left px-4 py-3">Statut</th>
                <th class="text-left px-4 py-3">Etudiant</th>
                <th class="text-left px-4 py-3">Role</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($soutenances as $soutenance)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $soutenance->date_soutenance }}</td>
                    <td class="px-4 py-3">{{ $soutenance->statut }}</td>
                    <td class="px-4 py-3">{{ $soutenance->student?->nom }} {{ $soutenance->student?->prenom }}</td>
                    <td class="px-4 py-3">
                        @php
                            $roles = [];
                            if ($soutenance->directeur_memoire_id === $teacher->id) $roles[] = 'Directeur';
                            if ($soutenance->evaluateur_id === $teacher->id) $roles[] = 'Evaluateur';
                            if ($soutenance->president_jury_id === $teacher->id) $roles[] = 'President jury';
                        @endphp
                        {{ implode(', ', $roles) }}
                    </td>
                </tr>
            @empty
                <tr class="border-t">
                    <td class="px-4 py-6 text-center text-slate-500" colspan="4">Aucune soutenance associee.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
