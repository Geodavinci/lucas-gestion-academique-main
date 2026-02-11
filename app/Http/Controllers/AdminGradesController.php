<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Grade;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminGradesController extends Controller
{
    public function index(Request $request)
    {
        $filiereId = $request->query('filiere_id');

        $gradesQuery = Grade::with(['student', 'course.filiere', 'teacher'])
            ->when($filiereId, function ($q) use ($filiereId) {
                $q->whereHas('course', function ($cq) use ($filiereId) {
                    $cq->where('filiere_id', $filiereId);
                });
            })
            ->orderByDesc('date_saisie');

        $grades = $gradesQuery->get();
        $filieres = Filiere::orderBy('nom')->get();

        return Inertia::render('Admin/Grades', [
            'grades' => $grades,
            'filieres' => $filieres,
            'filters' => [
                'filiere_id' => $filiereId,
            ],
        ]);
    }
}
