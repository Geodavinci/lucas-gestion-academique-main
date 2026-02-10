@extends('layouts.app')

@section('content')
<div class="max-w-4xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Mon dossier</h1>
            <p class="text-sm text-slate-600">Informations personnelles et details de soutenance.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('student.profile.pdf') }}" class="rounded bg-slate-900 text-white px-4 py-2 text-sm">Telecharger PDF</a>
        </div>
    </div>

    @if (session('error'))
        <div class="mb-4 rounded bg-rose-50 border border-rose-200 px-4 py-3 text-rose-700">
            {{ session('error') }}
        </div>
    @endif

    @if (!$student)
        <div class="rounded border border-amber-200 bg-amber-50 px-4 py-3 text-amber-800">
            Aucune fiche etudiant n'est liee a votre compte. Contactez l'administration.
        </div>
    @else
        <div class="bg-white rounded border border-slate-200 p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Informations</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><span class="text-slate-500">Matricule:</span> {{ $student->matricule }}</div>
                <div><span class="text-slate-500">Nom:</span> {{ $student->nom }} {{ $student->prenom }}</div>
                <div><span class="text-slate-500">Email:</span> {{ $student->email }}</div>
                <div><span class="text-slate-500">Telephone:</span> {{ $student->telephone }}</div>
                <div><span class="text-slate-500">Filiere:</span> {{ $student->filiere }}</div>
                <div><span class="text-slate-500">Niveau:</span> {{ $student->niveau }}</div>
            </div>
        </div>

        <div class="bg-white rounded border border-slate-200 p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Memoire</h2>
            @php
                $memoire = $student->memoires->sortByDesc('annee')->first();
            @endphp
            @if ($memoire)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div><span class="text-slate-500">Titre:</span> {{ $memoire->titre }}</div>
                    <div><span class="text-slate-500">Annee:</span> {{ $memoire->annee }}</div>
                    <div><span class="text-slate-500">Fichier:</span>
                        @if ($memoire->fichier_pdf)
                            <a href="{{ route('memoires.download', $memoire) }}" class="text-slate-700">Voir PDF</a>
                        @else
                            Aucun fichier
                        @endif
                    </div>
                </div>
            @else
                <p class="text-sm text-slate-500">Aucun memoire enregistre.</p>
            @endif
        </div>

        <div class="bg-white rounded border border-slate-200 p-6">
            <h2 class="text-lg font-semibold mb-4">Soutenance</h2>
            @php
                $soutenance = $student->soutenances->sortByDesc('date_soutenance')->first();
            @endphp
            @if ($soutenance)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div><span class="text-slate-500">Date:</span> {{ $soutenance->date_soutenance }}</div>
                    <div><span class="text-slate-500">Statut:</span> {{ $soutenance->statut }}</div>
                    <div><span class="text-slate-500">Directeur memoire:</span> {{ $soutenance->directeurMemoire?->nom }} {{ $soutenance->directeurMemoire?->prenom }}</div>
                    <div><span class="text-slate-500">Evaluateur:</span> {{ $soutenance->evaluateurTeacher?->nom }} {{ $soutenance->evaluateurTeacher?->prenom }}</div>
                    <div><span class="text-slate-500">President du jury:</span> {{ $soutenance->presidentJury?->nom }} {{ $soutenance->presidentJury?->prenom }}</div>
                    <div class="md:col-span-2"><span class="text-slate-500">Description:</span> {{ $soutenance->description }}</div>
                </div>
            @else
                <p class="text-sm text-slate-500">Aucune soutenance enregistree.</p>
            @endif
        </div>

        <div class="bg-white rounded border border-slate-200 p-6 mt-6">
            <h2 class="text-lg font-semibold mb-4">Notes</h2>
            @php
                $grades = $student->grades->load('course');
            @endphp
            @if ($grades->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="text-left px-4 py-3">Cours</th>
                                <th class="text-left px-4 py-3">Code</th>
                                <th class="text-left px-4 py-3">Note</th>
                                <th class="text-left px-4 py-3">Session</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grades as $grade)
                                <tr class="border-t">
                                    <td class="px-4 py-3">{{ $grade->course?->nom }}</td>
                                    <td class="px-4 py-3">{{ $grade->course?->code }}</td>
                                    <td class="px-4 py-3">{{ $grade->note }}</td>
                                    <td class="px-4 py-3">{{ $grade->session }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-slate-500">Aucune note disponible.</p>
            @endif
        </div>
    @endif
</div>
@endsection
