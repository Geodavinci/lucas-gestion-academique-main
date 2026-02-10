@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Recus de paiement</h1>
        <p class="text-sm text-slate-600">Liste des recus.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('recu-paiements.export', request()->query()) }}" class="inline-flex items-center rounded border border-slate-300 px-4 py-2 text-sm">Exporter CSV</a>
        <a href="{{ route('recu-paiements.create') }}" class="inline-flex items-center rounded bg-slate-900 text-white px-4 py-2 text-sm">Ajouter</a>
    </div>
</div>


<form method="GET" class="mb-4 flex flex-wrap items-end gap-3">
    <div>
        <label class="block text-sm font-medium">Recherche</label>
        <input name="q" value="{{ $search ?? '' }}" class="mt-1 w-56 rounded border-slate-300" placeholder="Numero recu, etudiant" />
    </div>
    <div>
        <label class="block text-sm font-medium">Date</label>
        <input type="date" name="date" value="{{ $date ?? '' }}" class="mt-1 w-44 rounded border-slate-300" />
    </div>
    <button class="rounded border border-slate-300 px-3 py-2 text-sm">Filtrer</button>
</form>
<div class="bg-white shadow-sm rounded border border-slate-200">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
            <tr>
                <th class="text-left px-4 py-3">Numero</th>
                <th class="text-left px-4 py-3">Etudiant</th>
                <th class="text-left px-4 py-3">Montant</th>
                <th class="text-left px-4 py-3">Date</th>
                <th class="text-right px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recus as $recu)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $recu->numero_recu }}</td>
                    <td class="px-4 py-3">{{ $recu->student?->nom }} {{ $recu->student?->prenom }}</td>
                    <td class="px-4 py-3">{{ number_format($recu->montant, 2, '.', ' ') }}</td>
                    <td class="px-4 py-3">{{ $recu->date_paiement }}</td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('recu-paiements.show', $recu) }}" class="text-slate-700 hover:text-slate-900">Voir</a>
                        <a href="{{ route('recu-paiements.edit', $recu) }}" class="text-slate-700 hover:text-slate-900">Modifier</a>
                        <form method="POST" action="{{ route('recu-paiements.destroy', $recu) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-700" onclick="return confirm('Supprimer ce recu ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr class="border-t">
                    <td class="px-4 py-6 text-center text-slate-500" colspan="5">Aucun recu enregistre.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $recus->links() }}
</div>
@endsection
