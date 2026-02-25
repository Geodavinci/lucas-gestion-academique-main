@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Cours</h1>
        <p class="text-sm text-slate-600">Gestion des cours par filière.</p>
    </div>
    <a href="{{ route('courses.create') }}" class="rounded bg-slate-900 text-white px-4 py-2 text-sm">Ajouter</a>
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
                <th class="text-left px-4 py-3">Nom</th>
                <th class="text-left px-4 py-3">Code</th>
                <th class="text-left px-4 py-3">Filière</th>
                <th class="text-left px-4 py-3">Coefficient</th>
                <th class="text-left px-4 py-3">Semestre</th>
                <th class="text-right px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($courses as $course)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $course->nom }}</td>
                    <td class="px-4 py-3">{{ $course->code }}</td>
                    <td class="px-4 py-3">{{ $course->filiere?->nom }}</td>
                    <td class="px-4 py-3">{{ $course->coefficient }}</td>
                    <td class="px-4 py-3">{{ $course->semestre }}</td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('courses.edit', $course) }}" class="text-slate-700">Éditer</a>
                        <form method="POST" action="{{ route('courses.destroy', $course) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-rose-600" onclick="return confirm('Supprimer ce cours ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr class="border-t">
                    <td class="px-4 py-6 text-center text-slate-500" colspan="6">Aucun cours.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
