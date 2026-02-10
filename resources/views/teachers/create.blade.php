@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Nouvel enseignant</h1>

<form method="POST" action="{{ route('teachers.store') }}" class="bg-white p-6 rounded border border-slate-200 shadow-sm space-y-4">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Nom</label>
            <input name="nom" value="{{ old('nom') }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
        <div>
            <label class="block text-sm font-medium">Prenom</label>
            <input name="prenom" value="{{ old('prenom') }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
        <div>
            <label class="block text-sm font-medium">Telephone</label>
            <input name="telephone" value="{{ old('telephone') }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium">Specialite</label>
            <input name="specialite" value="{{ old('specialite') }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
    </div>

    <div class="pt-2">
        <button type="submit" class="rounded bg-slate-900 text-white px-4 py-2 text-sm">Enregistrer</button>
        <a href="{{ route('teachers.index') }}" class="ml-3 text-sm text-slate-600">Annuler</a>
    </div>
</form>
@endsection
