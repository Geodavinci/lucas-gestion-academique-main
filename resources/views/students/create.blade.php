
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un étudiant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h3 class="text-center mb-4">
        Enregistrement d’un étudiant
    </h3>

    {{-- Affichage des erreurs --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('students.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Matricule</label>
                <input type="text" name="matricule" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Téléphone</label>
                <input type="text" name="telephone" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Filière</label>
                <input type="text" name="filiere" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Niveau</label>
                <select name="niveau" class="form-select" required>
                    <option value="">-- Sélectionner --</option>
                    <option value="BTS 1">BTS 1</option>
                    <option value="BTS 2">BTS 2</option>
                    <option value="Licence 1">Licence 1</option>
                    <option value="Licence 2">Licence 2</option>
                    <option value="Licence 3">Licence 3</option>
                    <option value="Master 1">Master 1</option>
                    <option value="Master 2">Master 2</option>
                </select>
            </div>
        </div>

        <div class="text-center">
            <button class="btn btn-success">
                Enregistrer
            </button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                Annuler
            </a>
        </div>

    </form>

</div>

</body>
</html>
@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Nouvel etudiant</h1>

<form method="POST" action="{{ route('students.store') }}" class="bg-white p-6 rounded border border-slate-200 shadow-sm space-y-4">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Matricule</label>
            <input name="matricule" value="{{ old('matricule') }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
        <div>
            <label class="block text-sm font-medium">Filiere</label>
            <input name="filiere" value="{{ old('filiere') }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
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
        <div>
            <label class="block text-sm font-medium">Niveau</label>
            <input name="niveau" value="{{ old('niveau') }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
    </div>

    <div class="pt-2">
        <button type="submit" class="rounded bg-slate-900 text-white px-4 py-2 text-sm">Enregistrer</button>
        <a href="{{ route('students.index') }}" class="ml-3 text-sm text-slate-600">Annuler</a>
    </div>
</form>
@endsection

