<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Grade;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminGradeController extends Controller
{
    public function index(Request $request)
    {
        $filiereId = $request->query('filiere_id');

        $grades = Grade::with(['student', 'course.filiere', 'teacher'])
            ->when($filiereId, function ($query) use ($filiereId) {
                $query->whereHas('course', function ($q) use ($filiereId) {
                    $q->where('filiere_id', $filiereId);
                });
            })
            ->orderByDesc('date_saisie')
            ->orderByDesc('id')
            ->get();

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
