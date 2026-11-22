<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Soutenance;
use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Acces reserve aux enseignants');
        }

        $teacher = Teacher::with('courses.filiere')
            ->where('user_id', $user->id)
            ->first();

        $soutenances = $teacher
            ? Soutenance::with(['student', 'directeurMemoire', 'evaluateurTeacher', 'presidentJury'])
                ->where(function ($query) use ($teacher) {
                    $query->where('directeur_memoire_id', $teacher->id)
                        ->orWhere('evaluateur_id', $teacher->id)
                        ->orWhere('president_jury_id', $teacher->id);
                })
                ->orderBy('date_soutenance')
                ->get()
            : collect();

        return view('teachers.dashboard', compact('teacher', 'soutenances'));
    }
}
