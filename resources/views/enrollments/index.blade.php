@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Inscriptions</h1>
        <p class="text-sm text-slate-600">Lier un étudiant à une filière.</p>
    </div>
    <a href="{{ route('enrollments.create') }}" class="rounded bg-slate-900 text-white px-4 py-2 text-sm">Ajouter</a>
</div>

@if (session('success'))
    <div class="mb-4 rounded bg-emerald-50 border border-emerald-200 px-4 py-3 text-emerald-700">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded border border-slate-200">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
            <tr>
                <th class="text-left px-4 py-3">Étudiant</th>
                <th class="text-left px-4 py-3">Filière</th>
                <th class="text-left px-4 py-3">Année</th>
                <th class="text-right px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($enrollments as $enrollment)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $enrollment->student?->nom }} {{ $enrollment->student?->prenom }}</td>
                    <td class="px-4 py-3">{{ $enrollment->filiere?->nom }}</td>
                    <td class="px-4 py-3">{{ $enrollment->annee_academique }}</td>
                    <td class="px-4 py-3 text-right">
                        <form method="POST" action="{{ route('enrollments.destroy', $enrollment) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-rose-600" onclick="return confirm('Supprimer cette inscription ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr class="border-t">
                    <td class="px-4 py-6 text-center text-slate-500" colspan="4">Aucune inscription.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
