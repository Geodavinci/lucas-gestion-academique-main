@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Soutenance du {{ $soutenance->date_soutenance }}</h1>
        <p class="text-sm text-slate-600">Statut: {{ $soutenance->statut }}</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('soutenances.edit', $soutenance) }}" class="rounded border border-slate-300 px-4 py-2 text-sm">Modifier</a>
        <a href="{{ route('soutenances.index') }}" class="rounded border border-slate-300 px-4 py-2 text-sm">Retour</a>
    </div>
</div>

<div class="bg-white rounded border border-slate-200 shadow-sm p-6">
    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div>
            <dt class="text-slate-500">Etudiant</dt>
            <dd class="font-medium">{{ $soutenance->student?->nom }} {{ $soutenance->student?->prenom }}</dd>
        </div>
        <div>
            <dt class="text-slate-500">Directeur memoire</dt>
            <dd class="font-medium">{{ $soutenance->directeurMemoire?->nom }} {{ $soutenance->directeurMemoire?->prenom }}</dd>
        </div>
        <div>
            <dt class="text-slate-500">Evaluateur</dt>
            <dd class="font-medium">{{ $soutenance->evaluateurTeacher?->nom }} {{ $soutenance->evaluateurTeacher?->prenom }}</dd>
        </div>
        <div>
            <dt class="text-slate-500">President du jury</dt>
            <dd class="font-medium">{{ $soutenance->presidentJury?->nom }} {{ $soutenance->presidentJury?->prenom }}</dd>
        </div>
        <div class="md:col-span-2">
            <dt class="text-slate-500">Description</dt>
            <dd class="font-medium">{{ $soutenance->description ?? '-' }}</dd>
        </div>
    </dl>
</div>
@endsection
