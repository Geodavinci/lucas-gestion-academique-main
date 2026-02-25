<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        if ($user && $user->role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        }

        $student = Student::with([
            'memoires',
            'soutenances.directeurMemoire',
            'soutenances.evaluateurTeacher',
            'soutenances.presidentJury',
            'grades.course',
        ])->where('user_id', $user->id)->first();

        return view('students.profile', compact('student'));
    }

    public function pdf(Request $request)
    {
        $user = $request->user();
        if ($user && $user->role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        }

        $student = Student::with([
            'memoires',
            'soutenances.directeurMemoire',
            'soutenances.evaluateurTeacher',
            'soutenances.presidentJury',
            'grades.course',
        ])->where('user_id', $user->id)->first();

        if (!$student) {
            return redirect()->route('student.profile')->with('error', "Aucune fiche etudiant associee a ce compte.");
        }

        if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return redirect()->route('student.profile')->with('error', "Le PDF n'est pas active. Installez barryvdh/laravel-dompdf.");
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('students.profile-pdf', compact('student'));

        return $pdf->download('fiche-etudiant-' . $student->matricule . '.pdf');
    }
}
