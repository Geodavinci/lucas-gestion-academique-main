@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Saisie des notes</h1>
        <p class="text-sm text-slate-600">{{ $course->nom }} - {{ $course->filiere?->nom }}</p>
    </div>
    <a href="{{ route('teacher.dashboard') }}" class="text-sm text-slate-600">Retour</a>
</div>

<form method="POST" action="{{ route('grades.store', $course) }}" class="space-y-4">
    @csrf
    <div class="bg-white rounded border border-slate-200 p-4">
        <label class="block text-sm font-medium">Session</label>
        <select name="session" class="mt-1 w-full rounded border-slate-300">
            <option value="normal">Normal</option>
            <option value="rattrapage">Rattrapage</option>
        </select>
    </div>

    <div class="bg-white rounded border border-slate-200">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-4 py-3">Étudiant</th>
                    <th class="text-left px-4 py-3">Matricule</th>
                    <th class="text-left px-4 py-3">Note (/20)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $student->nom }} {{ $student->prenom }}</td>
                        <td class="px-4 py-3">{{ $student->matricule }}</td>
                        <td class="px-4 py-3">
                            <input type="hidden" name="grades[{{ $loop->index }}][student_id]" value="{{ $student->id }}" />
                            <input name="grades[{{ $loop->index }}][note]" class="w-32 rounded border-slate-300" />
                        </td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td class="px-4 py-6 text-center text-slate-500" colspan="3">Aucun étudiant inscrit dans cette filière.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <button class="rounded bg-slate-900 text-white px-4 py-2 text-sm">Enregistrer</button>
</form>
@endsection
