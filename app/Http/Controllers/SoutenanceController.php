<?php

namespace App\Http\Controllers;

use App\Models\Soutenance;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SoutenanceController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $search = $request->query('q');
        $statut = $request->query('statut');
        $date = $request->query('date');

        $directeur_memoire = $request->query('directeur_memoire');
        $evaluateur = $request->query('evaluateur');
        $president_jury = $request->query('president_jury');

        $soutenances = Soutenance::with(['student', 'directeurMemoire', 'evaluateurTeacher', 'presidentJury'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('student', function ($q) use ($search) {
                    $q->where('nom', 'like', '%' . $search . '%')
                      ->orWhere('prenom', 'like', '%' . $search . '%')
                      ->orWhere('matricule', 'like', '%' . $search . '%');
                });
            })
            ->when($statut, fn($q) => $q->where('statut', $statut))
            ->when($date, fn($q) => $q->where('date_soutenance', $date))
            ->when($directeur_memoire, function ($q) use ($directeur_memoire) {
                $q->whereHas('directeurMemoire', function ($dq) use ($directeur_memoire) {
                    $dq->where('nom', 'like', '%' . $directeur_memoire . '%')
                       ->orWhere('prenom', 'like', '%' . $directeur_memoire . '%');
                });
            })
            ->when($evaluateur, function ($q) use ($evaluateur) {
                $q->whereHas('evaluateurTeacher', function ($eq) use ($evaluateur) {
                    $eq->where('nom', 'like', '%' . $evaluateur . '%')
                       ->orWhere('prenom', 'like', '%' . $evaluateur . '%');
                });
            })
            ->when($president_jury, function ($q) use ($president_jury) {
                $q->whereHas('presidentJury', function ($pq) use ($president_jury) {
                    $pq->where('nom', 'like', '%' . $president_jury . '%')
                       ->orWhere('prenom', 'like', '%' . $president_jury . '%');
                });
            })
            ->orderByDesc('date_soutenance')
            ->paginate(10)
            ->withQueryString();

        return view('soutenances.index', compact('soutenances', 'search', 'statut', 'date', 'directeur_memoire', 'evaluateur', 'president_jury'));
    }

    public function create()
    {
        $students = Student::query()->orderBy('nom')->orderBy('prenom')->get();
        $teachers = Teacher::query()->orderBy('nom')->orderBy('prenom')->get();

        return view('soutenances.create', compact('students', 'teachers'));
    }

    public function createForStudent(Student $student)
    {
        $students = Student::query()->orderBy('nom')->orderBy('prenom')->get();
        $teachers = Teacher::query()->orderBy('nom')->orderBy('prenom')->get();

        return view('soutenances.create', compact('students', 'teachers', 'student'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date_soutenance' => 'required|date',
            'statut' => 'required|in:Valide,Ajourne',
            'description' => 'nullable|string|max:2000',
            'student_id' => 'required|exists:students,id',
            'directeur_memoire_id' => 'nullable|exists:teachers,id',
            'evaluateur_id' => 'nullable|exists:teachers,id',
            'president_jury_id' => 'nullable|exists:teachers,id',
        ], [
            'date_soutenance.required' => 'La date de soutenance est obligatoire.',
            'date_soutenance.date' => 'La date de soutenance est invalide.',
            'statut.required' => 'Le statut est obligatoire.',
            'statut.in' => 'Le statut doit etre Valide ou Ajourne.',
            'description.max' => 'La description ne doit pas depasser 2000 caracteres.',
            'student_id.required' => 'Veuillez selectionner un etudiant.',
            'student_id.exists' => 'L etudiant selectionne est invalide.',
            'directeur_memoire_id.exists' => 'Le directeur de memoire selectionne est invalide.',
            'evaluateur_id.exists' => 'L evaluateur selectionne est invalide.',
            'president_jury_id.exists' => 'Le president du jury selectionne est invalide.',
        ]);

        Soutenance::create($data);

        return redirect()->route('soutenances.index')
            ->with('success', 'Soutenance ajoutee avec succes.');
    }


    public function exportCsv(\Illuminate\Http\Request $request)
    {
        $search = $request->query('q');
        $statut = $request->query('statut');
        $date = $request->query('date');

        $directeur_memoire = $request->query('directeur_memoire');
        $evaluateur = $request->query('evaluateur');
        $president_jury = $request->query('president_jury');

        $rows = \App\Models\Soutenance::with(['student', 'directeurMemoire', 'evaluateurTeacher', 'presidentJury'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('student', function ($q) use ($search) {
                    $q->where('nom', 'like', '%' . $search . '%')
                      ->orWhere('prenom', 'like', '%' . $search . '%')
                      ->orWhere('matricule', 'like', '%' . $search . '%');
                });
            })
            ->when($statut, fn($q) => $q->where('statut', $statut))
            ->when($date, fn($q) => $q->where('date_soutenance', $date))
            ->when($directeur_memoire, function ($q) use ($directeur_memoire) {
                $q->whereHas('directeurMemoire', function ($dq) use ($directeur_memoire) {
                    $dq->where('nom', 'like', '%' . $directeur_memoire . '%')
                       ->orWhere('prenom', 'like', '%' . $directeur_memoire . '%');
                });
            })
            ->when($evaluateur, function ($q) use ($evaluateur) {
                $q->whereHas('evaluateurTeacher', function ($eq) use ($evaluateur) {
                    $eq->where('nom', 'like', '%' . $evaluateur . '%')
                       ->orWhere('prenom', 'like', '%' . $evaluateur . '%');
                });
            })
            ->when($president_jury, function ($q) use ($president_jury) {
                $q->whereHas('presidentJury', function ($pq) use ($president_jury) {
                    $pq->where('nom', 'like', '%' . $president_jury . '%')
                       ->orWhere('prenom', 'like', '%' . $president_jury . '%');
                });
            })
            ->orderByDesc('date_soutenance')
            ->get();

        $filename = 'soutenances-' . date('Ymd-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
        ];

        $callback = function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Date', 'Statut', 'Etudiant', 'Matricule', 'Directeur memoire', 'Evaluateur', 'President jury']);
            foreach ($rows as $soutenance) {
                fputcsv($out, [
                    $soutenance->date_soutenance,
                    $soutenance->statut,
                    optional($soutenance->student)->nom . ' ' . optional($soutenance->student)->prenom,
                    optional($soutenance->student)->matricule,
                    optional($soutenance->directeurMemoire)->nom . ' ' . optional($soutenance->directeurMemoire)->prenom,
                    optional($soutenance->evaluateurTeacher)->nom . ' ' . optional($soutenance->evaluateurTeacher)->prenom,
                    optional($soutenance->presidentJury)->nom . ' ' . optional($soutenance->presidentJury)->prenom,
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function show(Soutenance $soutenance)
    {
        return view('soutenances.show', compact('soutenance'));
    }

    public function edit(Soutenance $soutenance)
    {
        $students = Student::query()->orderBy('nom')->orderBy('prenom')->get();
        $teachers = Teacher::query()->orderBy('nom')->orderBy('prenom')->get();

        return view('soutenances.edit', compact('soutenance', 'students', 'teachers'));
    }

    public function update(Request $request, Soutenance $soutenance)
    {
        $data = $request->validate([
            'date_soutenance' => 'required|date',
            'statut' => 'required|in:Valide,Ajourne',
            'description' => 'nullable|string|max:2000',
            'student_id' => 'required|exists:students,id',
            'directeur_memoire_id' => 'nullable|exists:teachers,id',
            'evaluateur_id' => 'nullable|exists:teachers,id',
            'president_jury_id' => 'nullable|exists:teachers,id',
        ], [
            'date_soutenance.required' => 'La date de soutenance est obligatoire.',
            'date_soutenance.date' => 'La date de soutenance est invalide.',
            'statut.required' => 'Le statut est obligatoire.',
            'statut.in' => 'Le statut doit etre Valide ou Ajourne.',
            'description.max' => 'La description ne doit pas depasser 2000 caracteres.',
            'student_id.required' => 'Veuillez selectionner un etudiant.',
            'student_id.exists' => 'L etudiant selectionne est invalide.',
            'directeur_memoire_id.exists' => 'Le directeur de memoire selectionne est invalide.',
            'evaluateur_id.exists' => 'L evaluateur selectionne est invalide.',
            'president_jury_id.exists' => 'Le president du jury selectionne est invalide.',
        ]);

        $soutenance->update($data);

        return redirect()->route('soutenances.show', $soutenance)
            ->with('success', 'Soutenance mise a jour.');
    }

    public function destroy(Soutenance $soutenance)
    {
        $soutenance->delete();

        return redirect()->route('soutenances.index')
            ->with('success', 'Soutenance supprimee.');
    }
}
