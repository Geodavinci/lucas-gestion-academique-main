@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">{{ $student->nom }} {{ $student->prenom }}</h1>
        <p class="text-sm text-slate-600">Matricule: {{ $student->matricule }}</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('students.memoires', $student)}}" class="rounded bg-slate-900 text-white px-4 py-2 text-sm">Voir memoires</a>
        <a href="{{ route('soutenances.createForStudent', $student) }}" class="rounded bg-emerald-600 text-white px-4 py-2 text-sm">Ajouter soutenance</a>
        <a href="{{ route('students.edit', $student) }}" class="rounded border border-slate-300 px-4 py-2 text-sm">Modifier</a>
    </div>
</div>

<div class="bg-white rounded border border-slate-200 shadow-sm p-6 mb-8">
    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div>
            <dt class="text-slate-500">Email</dt>
            <dd class="font-medium">{{ $student->email ?? '-' }}</dd>
        </div>
        <div>
            <dt class="text-slate-500">Telephone</dt>
            <dd class="font-medium">{{ $student->telephone ?? '-' }}</dd>
        </div>
        <div>
            <dt class="text-slate-500">Filiere</dt>
            <dd class="font-medium">{{ $student->filiere }}</dd>
        </div>
        <div>
            <dt class="text-slate-500">Niveau</dt>
            <dd class="font-medium">{{ $student->niveau }}</dd>
        </div>
    </dl>
</div>

<div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-semibold">Memoires de l'etudiant</h2>
    <a href="{{ route('memoires.create') }}" class="rounded bg-slate-900 text-white px-4 py-2 text-sm">Ajouter un memoire</a>
</div>

<form method="GET" class="mb-4 flex flex-wrap items-end gap-3">
    <div>
        <label class="block text-sm font-medium">Recherche</label>
        <input name="q" value="{{ request('q') }}" class="mt-1 w-56 rounded border-slate-300" placeholder="Titre du memoire" />
    </div>
   
    <button class="rounded border border-slate-300 px-3 py-2 text-sm">Filtrer</button>
</form>

<div class="bg-white rounded border border-slate-200 shadow-sm">
    <table class="w-full text-sm">
        <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-4 py-3">Titre</th>
                <th class="text-left px-4 py-3">Annee</th>
                <th class="text-right px-4 py-3">Fichier</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($memoires as $memoire)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $memoire->titre }}</td>
                    <td class="px-4 py-3">{{ $memoire->annee }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('memoires.download', $memoire) }}" target="_blank" class="text-slate-700 hover:text-slate-900">Voir PDF</a>
                    </td>
                </tr>
            @empty
                <tr class="border-t">
                    <td class="px-4 py-6 text-center text-slate-500" colspan="3">Aucun memoire trouve.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="flex items-center justify-between mt-10 mb-4">
    <h2 class="text-xl font-semibold">Recus de paiement</h2>
    <a href="{{ route('recu-paiements.create') }}" class="rounded bg-slate-900 text-white px-4 py-2 text-sm">Ajouter un recu</a>
</div>

<div class="bg-white rounded border border-slate-200 shadow-sm">
    <table class="w-full text-sm">
        <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-4 py-3">Numero</th>
                <th class="text-left px-4 py-3">Montant</th>
                <th class="text-left px-4 py-3">Date</th>
                <th class="text-right px-4 py-3">Fichier</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recus as $recu)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $recu->numero_recu }}</td>
                    <td class="px-4 py-3">{{ number_format($recu->montant, 2, '.', ' ') }} F CFA</td>
                    <td class="px-4 py-3">{{ $recu->date_paiement }} </td>
                    <td class="px-4 py-3 text-right">
                        @if ($recu->fichier_pdf)
                            <a href="{{ route('recu-paiements.download', $recu) }}" target="_blank" class="text-slate-700 hover:text-slate-900">Voir PDF</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr class="border-t">
                    <td class="px-4 py-6 text-center text-slate-500" colspan="4">Aucun recu enregistre.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
