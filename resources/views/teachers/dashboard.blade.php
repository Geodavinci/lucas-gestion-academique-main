@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Dashboard enseignant</h1>
        <p class="text-sm text-slate-600">Mes cours, mes notes et mes soutenances.</p>
    </div>
</div>

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

    <section class="mt-8">
        <div class="mb-4">
            <h2 class="text-xl font-semibold text-slate-900">Mes soutenances</h2>
            <p class="mt-1 text-sm text-slate-600">
                Les soutenances auxquelles vous participez comme directeur, évaluateur ou président du jury.
            </p>
        </div>

        <div class="overflow-x-auto rounded border border-slate-200 bg-white">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3 text-left">Étudiant</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Votre rôle</th>
                        <th class="px-4 py-3 text-left">Jury</th>
                        <th class="px-4 py-3 text-right">Détails</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($soutenances as $soutenance)
                        <tr class="border-t">
                            <td class="px-4 py-3">
                                {{ $soutenance->student?->nom }} {{ $soutenance->student?->prenom }}
                            </td>
                            <td class="px-4 py-3">{{ $soutenance->date_soutenance?->format('d/m/Y') ?? 'À confirmer' }}</td>
                            <td class="px-4 py-3">
                                @if ($soutenance->directeur_memoire_id === $teacher->id)
                                    <span class="block">Directeur de mémoire</span>
                                @endif
                                @if ($soutenance->evaluateur_id === $teacher->id)
                                    <span class="block">Évaluateur</span>
                                @endif
                                @if ($soutenance->president_jury_id === $teacher->id)
                                    <span class="block">Président du jury</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="block">Directeur : {{ $soutenance->directeurMemoire?->nom }} {{ $soutenance->directeurMemoire?->prenom }}</span>
                                <span class="block">Évaluateur : {{ $soutenance->evaluateurTeacher?->nom }} {{ $soutenance->evaluateurTeacher?->prenom }}</span>
                                <span class="block">Président : {{ $soutenance->presidentJury?->nom }} {{ $soutenance->presidentJury?->prenom }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('soutenances.show', $soutenance) }}" class="text-blue-700 hover:underline">Consulter</a>
                            </td>
                        </tr>
            @empty
                        <tr class="border-t">
                            <td class="px-4 py-6 text-center text-slate-500" colspan="5">Aucune soutenance ne vous est attribuée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endif
@endsection
