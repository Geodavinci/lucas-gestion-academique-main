
<x-app-layout>
    <div class="max-w-6xl mx-auto py-6">

        <h1 class="text-2xl font-bold mb-4">
            Mémoires de {{ $student->nom }} {{ $student->prenom }}
        </h1>

        <!-- Filtre par année -->
        <form method="GET" class="mb-4">
            <input
                type="number"
                name="annee"
                placeholder="Filtrer par année"
                value="{{ $annee }}"
                class="border rounded px-3 py-2"
            >
            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Rechercher
            </button>
        </form>

        @if($memoires->count())
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Titre</th>
                        <th class="border p-2">Année</th>
                        <th class="border p-2">PDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($memoires as $memoire)
                        <tr>
                            <td class="border p-2">{{ $memoire->titre }}</td>
                            <td class="border p-2">{{ $memoire->annee }}</td>
                            <td class="border p-2">
                                <a href="{{ asset('storage/'.$memoire->fichier_pdf) }}"
                                   target="_blank"
                                   class="text-blue-600 underline">
                                   Voir PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-600">Aucun mémoire trouvé.</p>
        @endif

    </div>
</x-app-layout>

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

