@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Dashboard enseignant</h1>
        <p class="text-sm text-slate-600">Mes cours et saisie des notes.</p>
    </div>
</div>

@if (session('success'))
    <div class="mb-4 rounded bg-emerald-50 border border-emerald-200 px-4 py-3 text-emerald-700">
        {{ session('success') }}
    </div>
@endif

@if (!$teacher)
    <div class="rounded border border-amber-200 bg-amber-50 px-4 py-3 text-amber-800">
        Aucun profil enseignant lie a ce compte. Contactez l'administration.
    </div>
@else
    <div class="bg-white rounded border border-slate-200">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-4 py-3">Cours</th>
                    <th class="text-left px-4 py-3">Filiere</th>
                    <th class="text-left px-4 py-3">Code</th>
                    <th class="text-right px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($teacher->courses as $course)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $course->nom }}</td>
                        <td class="px-4 py-3">{{ $course->filiere?->nom }}</td>
                        <td class="px-4 py-3">{{ $course->code }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('grades.create', $course) }}" class="text-slate-700">Saisir notes</a>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td class="px-4 py-6 text-center text-slate-500" colspan="4">Aucun cours assigne.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endif
@endsection
