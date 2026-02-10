@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Enseignants</h1>
        <p class="text-sm text-slate-600">Liste des enseignants.</p>
    </div>
    <a href="{{ route('teachers.create') }}" class="inline-flex items-center rounded bg-slate-900 text-white px-4 py-2 text-sm">Ajouter</a>
</div>


<form method="GET" class="mb-4 flex items-end gap-3">
    <div>
        <label class="block text-sm font-medium">Recherche</label>
        <input name="q" value="{{ $search ?? '' }}" class="mt-1 w-64 rounded border-slate-300" placeholder="Nom, email, specialite" />
    </div>
    <button class="rounded border border-slate-300 px-3 py-2 text-sm">Filtrer</button>
</form>
<div class="bg-white shadow-sm rounded border border-slate-200">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
            <tr>
                <th class="text-left px-4 py-3">Nom</th>
                <th class="text-left px-4 py-3">Email</th>
                <th class="text-left px-4 py-3">Specialite</th>
                <th class="text-right px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($teachers as $teacher)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $teacher->nom }} {{ $teacher->prenom }}</td>
                    <td class="px-4 py-3">{{ $teacher->email ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $teacher->specialite }}</td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('teachers.show', $teacher) }}" class="text-slate-700 hover:text-slate-900">Voir</a>
                        <a href="{{ route('teachers.edit', $teacher) }}" class="text-slate-700 hover:text-slate-900">Modifier</a>
                        <form method="POST" action="{{ route('teachers.destroy', $teacher) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-700" onclick="return confirm('Supprimer cet enseignant ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr class="border-t">
                    <td class="px-4 py-6 text-center text-slate-500" colspan="4">Aucun enseignant enregistre.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $teachers->links() }}
</div>
@endsection
