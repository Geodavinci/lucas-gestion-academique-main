@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Modifier le memoire</h1>

<form method="POST" action="{{ route('memoires.update', $memoire) }}" enctype="multipart/form-data" class="bg-white p-6 rounded border border-slate-200 shadow-sm space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium">Etudiant</label>
        <select name="student_id" class="mt-1 w-full rounded border-slate-300">
            <option value="">Selectionner un etudiant</option>
            @foreach ($students as $student)
                <option value="{{ $student->id }}" @selected(old('student_id', $memoire->student_id) == $student->id)>
                    {{ $student->nom }} {{ $student->prenom }} ({{ $student->matricule }})
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium">Titre</label>
        <input name="titre" value="{{ old('titre', $memoire->titre) }}" class="mt-1 w-full rounded border-slate-300" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Annee</label>
            <input name="annee" value="{{ old('annee', $memoire->annee) }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
        <div>
            <label class="block text-sm font-medium">Fichier PDF</label>
            <input type="file" name="fichier_pdf" class="mt-1 w-full rounded border-slate-300 bg-white" />
            @if ($memoire->fichier_pdf)
                <p class="text-xs text-slate-500 mt-1">Fichier actuel: <a href="{{ route('memoires.download', $memoire) }}" target="_blank" class="underline">voir</a></p>
            @endif
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium">Fichier PDF corrigé</label>
        <input type="file" name="fichier_pdf_corrige" class="mt-1 w-full rounded border-slate-300 bg-white" />
        @if ($memoire->fichier_pdf_corrige)
            <p class="text-xs text-slate-500 mt-1">Version corrigée actuelle: <a href="{{ route('memoires.download.corrige', $memoire) }}" target="_blank" class="underline">voir</a></p>
        @endif
    </div>

    <div class="pt-2">
        <button type="submit" class="rounded bg-slate-900 text-white px-4 py-2 text-sm">Enregistrer les modifications</button>
        <a href="{{ route('memoires.index') }}" class="ml-3 text-sm text-slate-600">Annuler</a>
    </div>
</form>
@endsection