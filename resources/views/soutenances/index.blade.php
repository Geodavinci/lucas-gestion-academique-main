@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Soutenances</h1>
        <p class="text-sm text-slate-600">Historique des soutenances.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('soutenances.export', request()->query()) }}" class="inline-flex items-center rounded border border-slate-300 px-4 py-2 text-sm">Exporter CSV</a>
        <a href="{{ route('soutenances.create') }}" class="inline-flex items-center rounded bg-slate-900 text-white px-4 py-2 text-sm">Ajouter</a>
    </div>
</div>


<form method="GET" class="mb-4 flex flex-wrap items-end gap-3">
    <div>
        <label class="block text-sm font-medium">Recherche</label>
        <input name="q" value="{{ $search ?? '' }}" class="mt-1 w-56 rounded border-slate-300" placeholder="Etudiant" />
    </div>
    <div>
        <label class="block text-sm font-medium">Statut</label>
        <select name="statut" class="mt-1 w-40 rounded border-slate-300">
            <option value="">Tous</option>
            <option value="Valide" @selected(($statut ?? '') == 'Valide')>Valide</option>
            <option value="Ajourne" @selected(($statut ?? '') == 'Ajourne')>Ajourne</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium">Date</label>
        <input type="date" name="date" value="{{ $date ?? '' }}" class="mt-1 w-44 rounded border-slate-300" />
    </div>
    
    <div>
        <label class="block text-sm font-medium">Directeur</label>
        <input name="directeur_memoire" value="{{ $directeur_memoire ?? '' }}" class="mt-1 w-44 rounded border-slate-300" placeholder="Nom" />
    </div>
    <div>
        <label class="block text-sm font-medium">Evaluateur</label>
        <input name="evaluateur" value="{{ $evaluateur ?? '' }}" class="mt-1 w-44 rounded border-slate-300" placeholder="Nom" />
    </div>
    <div>
        <label class="block text-sm font-medium">President jury</label>
        <input name="president_jury" value="{{ $president_jury ?? '' }}" class="mt-1 w-44 rounded border-slate-300" placeholder="Nom" />
    </div>
    <button class="rounded border border-slate-300 px-3 py-2 text-sm">Filtrer</button>
    <a href="{{ route('soutenances.index') }}" class="rounded border border-slate-300 px-3 py-2 text-sm">Reinitialiser</a>
</form>
<div class="bg-white shadow-sm rounded border border-slate-200">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
            <tr>
                <th class="text-left px-4 py-3">Date</th>
                <th class="text-left px-4 py-3">Statut</th>
                <th class="text-left px-4 py-3">Description</th>
                <th class="text-left px-4 py-3">Etudiant</th>
                <th class="text-left px-4 py-3">Directeur</th>
                <th class="text-left px-4 py-3">Evaluateur</th>
                <th class="text-left px-4 py-3">President jury</th>
                <th class="text-right px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($soutenances as $soutenance)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $soutenance->date_soutenance }}</td>
                    <td class="px-4 py-3">{{ $soutenance->statut }}</td>
                    <td class="px-4 py-3">{{ $soutenance->description ? \Illuminate\Support\Str::limit($soutenance->description, 40) : '-' }}</td>
                    <td class="px-4 py-3">{{ $soutenance->student?->nom }} {{ $soutenance->student?->prenom }}</td>
                    <td class="px-4 py-3">{{ $soutenance->directeurMemoire?->nom }} {{ $soutenance->directeurMemoire?->prenom }}</td>
                    <td class="px-4 py-3">{{ $soutenance->evaluateurTeacher?->nom }} {{ $soutenance->evaluateurTeacher?->prenom }}</td>
                    <td class="px-4 py-3">{{ $soutenance->presidentJury?->nom }} {{ $soutenance->presidentJury?->prenom }}</td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('soutenances.show', $soutenance) }}" class="text-slate-700 hover:text-slate-900">Voir</a>
                        <a href="{{ route('soutenances.edit', $soutenance) }}" class="text-slate-700 hover:text-slate-900">Modifier</a>
                        <form method="POST" action="{{ route('soutenances.destroy', $soutenance) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-700" onclick="return confirm('Supprimer cette soutenance ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr class="border-t">
                    <td class="px-4 py-6 text-center text-slate-500" colspan="9">Aucune soutenance enregistree.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $soutenances->links() }}
</div>
@endsection
