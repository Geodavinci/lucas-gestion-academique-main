@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Etudiants</h1>
        <p class="text-sm text-slate-600">Liste des etudiants enregistres.</p>
    </div>
    <a href="{{ route('students.create') }}" class="inline-flex items-center rounded bg-slate-900 text-white px-4 py-2 text-sm">Ajouter</a>
</div>


<form method="GET" class="mb-4 flex flex-wrap items-end gap-3">
    <div>
        <label class="block text-sm font-medium">Filiere</label>
        <input name="filiere" value="{{ $filiere ?? '' }}" class="mt-1 w-48 rounded border-slate-300" placeholder="Informatique" />
    </div>
    <div>
        <label class="block text-sm font-medium">Niveau</label>
        <input name="niveau" value="{{ $niveau ?? '' }}" class="mt-1 w-32 rounded border-slate-300" placeholder="L3" />
    </div>
    <div>
        <label class="block text-sm font-medium">Matricule</label>
        <input name="matricule" value="{{ $matricule ?? '' }}" class="mt-1 w-40 rounded border-slate-300" placeholder="2024-001" />
    </div>
    <button class="rounded border border-slate-300 px-3 py-2 text-sm">Filtrer</button>
</form>
<div class="bg-white shadow-sm rounded border border-slate-200">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
            <tr>
                <th class="text-left px-4 py-3">Matricule</th>
                <th class="text-left px-4 py-3">Nom</th>
                <th class="text-left px-4 py-3">Filiere</th>
                <th class="text-left px-4 py-3">Niveau</th>
                <th class="text-right px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $student->matricule }}</td>
                    <td class="px-4 py-3">{{ $student->nom }} {{ $student->prenom }}</td>
                    <td class="px-4 py-3">{{ $student->filiere }}</td>
                    <td class="px-4 py-3">{{ $student->niveau }}</td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('students.show', $student) }}" class="text-slate-700 hover:text-slate-900">Voir</a>
                        <a href="{{ route('students.edit', $student) }}" class="text-slate-700 hover:text-slate-900">Modifier</a>
                        <form method="POST" action="{{ route('students.destroy', $student) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-700" onclick="return confirm('Supprimer cet etudiant ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr class="border-t">
                    <td class="px-4 py-6 text-center text-slate-500" colspan="5">Aucun etudiant enregistre.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $students->links() }}
</div>
@endsection

