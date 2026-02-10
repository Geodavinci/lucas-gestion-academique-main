<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche etudiant</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        h1 { font-size: 18px; margin-bottom: 6px; }
        h2 { font-size: 14px; margin-top: 16px; margin-bottom: 6px; }
        .section { border: 1px solid #e5e7eb; padding: 10px; margin-bottom: 12px; }
        .row { margin-bottom: 4px; }
        .label { color: #6b7280; }
    </style>
</head>
<body>
    <h1>Fiche etudiant</h1>

    <div class="section">
        <h2>Informations</h2>
        <div class="row"><span class="label">Matricule:</span> {{ $student->matricule }}</div>
        <div class="row"><span class="label">Nom:</span> {{ $student->nom }} {{ $student->prenom }}</div>
        <div class="row"><span class="label">Email:</span> {{ $student->email }}</div>
        <div class="row"><span class="label">Telephone:</span> {{ $student->telephone }}</div>
        <div class="row"><span class="label">Filiere:</span> {{ $student->filiere }}</div>
        <div class="row"><span class="label">Niveau:</span> {{ $student->niveau }}</div>
    </div>

    @php
        $memoire = $student->memoires->sortByDesc('annee')->first();
        $soutenance = $student->soutenances->sortByDesc('date_soutenance')->first();
    @endphp

    <div class="section">
        <h2>Memoire</h2>
        @if ($memoire)
            <div class="row"><span class="label">Titre:</span> {{ $memoire->titre }}</div>
            <div class="row"><span class="label">Annee:</span> {{ $memoire->annee }}</div>
            <div class="row"><span class="label">Fichier PDF:</span> {{ $memoire->fichier_pdf ? 'Disponible' : 'Aucun' }}</div>
        @else
            <div class="row">Aucun memoire enregistre.</div>
        @endif
    </div>

    <div class="section">
        <h2>Soutenance</h2>
        @if ($soutenance)
            <div class="row"><span class="label">Date:</span> {{ $soutenance->date_soutenance }}</div>
            <div class="row"><span class="label">Statut:</span> {{ $soutenance->statut }}</div>
            <div class="row"><span class="label">Directeur memoire:</span> {{ $soutenance->directeurMemoire?->nom }} {{ $soutenance->directeurMemoire?->prenom }}</div>
            <div class="row"><span class="label">Evaluateur:</span> {{ $soutenance->evaluateurTeacher?->nom }} {{ $soutenance->evaluateurTeacher?->prenom }}</div>
            <div class="row"><span class="label">President du jury:</span> {{ $soutenance->presidentJury?->nom }} {{ $soutenance->presidentJury?->prenom }}</div>
            <div class="row"><span class="label">Description:</span> {{ $soutenance->description }}</div>
        @else
            <div class="row">Aucune soutenance enregistree.</div>
        @endif
    </div>

    <div class="section">
        <h2>Notes</h2>
        @if ($student->grades->isNotEmpty())
            <table width="100%" cellspacing="0" cellpadding="4" border="1" style="border-collapse: collapse; font-size: 11px;">
                <thead>
                    <tr>
                        <th align="left">Cours</th>
                        <th align="left">Code</th>
                        <th align="left">Note</th>
                        <th align="left">Session</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student->grades as $grade)
                        <tr>
                            <td>{{ $grade->course?->nom }}</td>
                            <td>{{ $grade->course?->code }}</td>
                            <td>{{ $grade->note }}</td>
                            <td>{{ $grade->session }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="row">Aucune note disponible.</div>
        @endif
    </div>
</body>
</html>
