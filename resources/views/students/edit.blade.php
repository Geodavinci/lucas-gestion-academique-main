@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Modifier etudiant</h1>

<form method="POST" action="{{ route('students.update', $student) }}" class="bg-white p-6 rounded border border-slate-200 shadow-sm space-y-4">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Matricule</label>
            <input name="matricule" value="{{ old('matricule', $student->matricule) }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
        <div>
            <label class="block text-sm font-medium">Filiere</label>
            <input name="filiere" value="{{ old('filiere', $student->filiere) }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
        <div>
            <label class="block text-sm font-medium">Nom</label>
            <input name="nom" value="{{ old('nom', $student->nom) }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
        <div>
            <label class="block text-sm font-medium">Prenom</label>
            <input name="prenom" value="{{ old('prenom', $student->prenom) }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $student->email) }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
        <div>
            <label class="block text-sm font-medium">Telephone</label>
            <input name="telephone" value="{{ old('telephone', $student->telephone) }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
        <div>
            <label class="block text-sm font-medium">Niveau</label>
            <input name="niveau" value="{{ old('niveau', $student->niveau) }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
    </div>

    <div class="pt-2">
        <button type="submit" class="rounded bg-slate-900 text-white px-4 py-2 text-sm">Mettre a jour</button>
        <a href="{{ route('students.show', $student) }}" class="ml-3 text-sm text-slate-600">Annuler</a>
    </div>
</form>
@endsection
