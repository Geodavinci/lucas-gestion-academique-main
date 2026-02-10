@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Nouveau cours</h1>

<form method="POST" action="{{ route('courses.store') }}" class="bg-white p-6 rounded border border-slate-200 space-y-4">
    @csrf
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
        <label class="block text-sm font-medium">Nom</label>
        <input name="nom" value="{{ old('nom') }}" class="mt-1 w-full rounded border-slate-300" />
    </div>
    <div>
        <label class="block text-sm font-medium">Code</label>
        <input name="code" value="{{ old('code') }}" class="mt-1 w-full rounded border-slate-300" />
    </div>
    <div>
        <label class="block text-sm font-medium">Coefficient</label>
        <input name="coefficient" value="{{ old('coefficient', 1) }}" class="mt-1 w-full rounded border-slate-300" />
    </div>
    <div>
        <label class="block text-sm font-medium">Semestre</label>
        <input name="semestre" value="{{ old('semestre') }}" class="mt-1 w-full rounded border-slate-300" />
    </div>
    <div>
        <label class="block text-sm font-medium">Enseignants</label>
        <select name="teacher_ids[]" multiple class="mt-1 w-full rounded border-slate-300">
            @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->nom }} {{ $teacher->prenom }}</option>
            @endforeach
        </select>
        <p class="text-xs text-slate-500 mt-1">Ctrl/Cmd + clic pour sélectionner plusieurs.</p>
    </div>
    <div class="pt-2">
        <button class="rounded bg-slate-900 text-white px-4 py-2 text-sm">Enregistrer</button>
        <a href="{{ route('courses.index') }}" class="ml-3 text-sm text-slate-600">Annuler</a>
    </div>
</form>
@endsection
