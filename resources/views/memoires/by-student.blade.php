@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Memoires de {{ $student->nom }} {{ $student->prenom }}</h1>
        <p class="text-sm text-slate-600">Matricule: {{ $student->matricule }}</p>
    </div>
    <a href="{{ route('students.show', $student) }}" class="rounded border border-slate-300 px-4 py-2 text-sm">Retour</a>
</div>

<form method="GET" class="mb-4 flex items-end gap-3">
    <div>
        <label class="block text-sm font-medium">Filtrer par annee</label>
        <input name="annee" value="{{ $annee }}" class="mt-1 w-40 rounded border-slate-300" />
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
@endsection

