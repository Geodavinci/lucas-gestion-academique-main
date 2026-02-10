@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Modifier recu</h1>

<form method="POST" action="{{ route('recu-paiements.update', $recu) }}" enctype="multipart/form-data" class="bg-white p-6 rounded border border-slate-200 shadow-sm space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium">Etudiant</label>
        <select name="student_id" class="mt-1 w-full rounded border-slate-300">
            <option value="">Selectionner un etudiant</option>
            @foreach ($students as $student)
                <option value="{{ $student->id }}" @selected(old('student_id', $recu->student_id) == $student->id)>
                    {{ $student->nom }} {{ $student->prenom }} ({{ $student->matricule }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Numero recu</label>
            <input name="numero_recu" value="{{ old('numero_recu', $recu->numero_recu) }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
        <div>
            <label class="block text-sm font-medium">Montant</label>
            <input name="montant" value="{{ old('montant', $recu->montant) }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
        <div>
            <label class="block text-sm font-medium">Date paiement</label>
            <input type="date" name="date_paiement" value="{{ old('date_paiement', $recu->date_paiement) }}" class="mt-1 w-full rounded border-slate-300" />
        </div>
        <div>
            <label class="block text-sm font-medium">Fichier PDF (optionnel)</label>
            <input type="file" name="fichier_pdf" class="mt-1 w-full rounded border-slate-300 bg-white" />
            @if ($recu->fichier_pdf)
                <p class="text-xs text-slate-500 mt-1">PDF actuel: <a class="underline" href="{{ asset('storage/' . $recu->fichier_pdf) }}" target="_blank">voir</a></p>
            @endif
        </div>
    </div>

    <div class="pt-2">
        <button type="submit" class="rounded bg-slate-900 text-white px-4 py-2 text-sm">Mettre a jour</button>
        <a href="{{ route('recu-paiements.show', $recu) }}" class="ml-3 text-sm text-slate-600">Annuler</a>
    </div>
</form>
@endsection
