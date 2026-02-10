@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Modifier soutenance</h1>

<form method="POST" action="{{ route('soutenances.update', $soutenance) }}" class="bg-white p-6 rounded border border-slate-200 shadow-sm space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium">Date</label>
        <input type="date" name="date_soutenance" value="{{ old('date_soutenance', $soutenance->date_soutenance) }}" class="mt-1 w-full rounded border-slate-300" />
    </div>

    <div>
        <label class="block text-sm font-medium">Statut</label>
        <select name="statut" class="mt-1 w-full rounded border-slate-300">
            <option value="">Selectionner</option>
            <option value="Valide" @selected(old('statut', $soutenance->statut) == 'Valide')>Valide</option>
            <option value="Ajourne" @selected(old('statut', $soutenance->statut) == 'Ajourne')>Ajourne</option>
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Etudiant</label>
            <select name="student_id" class="mt-1 w-full rounded border-slate-300">
                <option value="">Selectionner un etudiant</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" @selected(old('student_id', $soutenance->student_id) == $student->id)>
                        {{ $student->nom }} {{ $student->prenom }} ({{ $student->matricule }})
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium">Directeur memoire (optionnel)</label>
            <select name="directeur_memoire_id" class="mt-1 w-full rounded border-slate-300">
                <option value="">Selectionner un enseignant</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" @selected(old('directeur_memoire', $soutenance->directeur_memoire_id) == $teacher->id)>
                        {{ $teacher->nom }} {{ $teacher->prenom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium">President du Jury (optionnel)</label>
            <select name="president_jury_id" class="mt-1 w-full rounded border-slate-300">
                <option value="">Selectionner un enseignant</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" @selected(old('president_jury', $soutenance->president_jury_id) == $teacher->id)>
                        {{ $teacher->nom }} {{ $teacher->prenom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium">Evaluateur (optionnel)</label>
            <select name="evaluateur_id" class="mt-1 w-full rounded border-slate-300">
                <option value="">Selectionner un enseignant</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" @selected(old('evaluateur', $soutenance->evaluateur_id) == $teacher->id)>
                        {{ $teacher->nom }} {{ $teacher->prenom }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium">Description (optionnel)</label>
        <textarea name="description" rows="4" class="mt-1 w-full rounded border-slate-300">{{ old('description', $soutenance->description) }}</textarea>
    </div>

    <div class="pt-2">
        <button type="submit" class="rounded bg-slate-900 text-white px-4 py-2 text-sm">Mettre a jour</button>
        <a href="{{ route('soutenances.show', $soutenance) }}" class="ml-3 text-sm text-slate-600">Annuler</a>
    </div>
</form>
@endsection
