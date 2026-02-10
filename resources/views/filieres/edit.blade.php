@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Modifier filière</h1>

<form method="POST" action="{{ route('filieres.update', $filiere) }}" class="bg-white p-6 rounded border border-slate-200 space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm font-medium">Nom</label>
        <input name="nom" value="{{ old('nom', $filiere->nom) }}" class="mt-1 w-full rounded border-slate-300" />
    </div>
    <div>
        <label class="block text-sm font-medium">Code</label>
        <input name="code" value="{{ old('code', $filiere->code) }}" class="mt-1 w-full rounded border-slate-300" />
    </div>
    <div class="pt-2">
        <button class="rounded bg-slate-900 text-white px-4 py-2 text-sm">Mettre à jour</button>
        <a href="{{ route('filieres.index') }}" class="ml-3 text-sm text-slate-600">Annuler</a>
    </div>
</form>
@endsection
