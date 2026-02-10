@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Nouvelle inscription</h1>

<form method="POST" action="{{ route('enrollments.store') }}" class="bg-white p-6 rounded border border-slate-200 space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium">Étudiant</label>
        <select name="student_id" class="mt-1 w-full rounded border-slate-300">
            <option value="">Sélectionner un étudiant</option>
            @foreach ($students as $student)
                <option value="{{ $student->id }}">{{ $student->nom }} {{ $student->prenom }} ({{ $student->matricule }})</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium">Filière</label>
        <select name="filiere_id" class="mt-1 w-full rounded border-slate-300">
            <option value="">Sélectionner une filière</option>
            @foreach ($filieres as $filiere)
                <option value="{{ $filiere->id }}">{{ $filiere->nom }} ({{ $filiere->code }})</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium">Année académique</label>
        <input name="annee_academique" value="{{ old('annee_academique', date('Y').'-'.(date('Y')+1)) }}" class="mt-1 w-full rounded border-slate-300" />
    </div>
    <div class="pt-2">
        <button class="rounded bg-slate-900 text-white px-4 py-2 text-sm">Enregistrer</button>
        <a href="{{ route('enrollments.index') }}" class="ml-3 text-sm text-slate-600">Annuler</a>
    </div>
</form>
@endsection
