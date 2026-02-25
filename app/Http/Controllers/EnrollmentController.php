<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Filiere;
use App\Models\Student;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'filiere'])->orderByDesc('created_at')->get();

        return view('enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $students = Student::orderBy('nom')->orderBy('prenom')->get();
        $filieres = Filiere::orderBy('nom')->get();

        return view('enrollments.create', compact('students', 'filieres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'filiere_id' => 'required|exists:filieres,id',
            'annee_academique' => 'required|string|max:20',
        ]);

        Enrollment::create($data);

        return redirect()->route('enrollments.index')->with('success', 'Inscription ajoutee.');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()->route('enrollments.index')->with('success', 'Inscription supprimee.');
    }
}
