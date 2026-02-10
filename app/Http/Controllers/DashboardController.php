<?php

namespace App\Http\Controllers;

use App\Models\Memoire;
use App\Models\Soutenance;
use App\Models\RecuPaiement;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'students' => Student::count(),
            'teachers' => Teacher::count(),
            'memoires' => Memoire::count(),
            'soutenances' => Soutenance::count(),
            'recus' => RecuPaiement::count(),
        ];

        $latestMemoires = Memoire::with('student')->orderByDesc('created_at')->take(5)->get();
        $latestRecus = RecuPaiement::with('student')->orderByDesc('date_paiement')->take(5)->get();
        $latestStudents = Student::orderByDesc('created_at')->take(5)->get();
        $latestTeachers = Teacher::orderByDesc('created_at')->take(5)->get();
        $latestSoutenances = Soutenance::with('student')
            ->orderByDesc('date_soutenance')
            ->take(5)
            ->get();
        $latestPdfs = Memoire::with('student')
            ->whereNotNull('fichier_pdf')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();
        $students = Student::orderByDesc('created_at')->take(10)->get();
        $teachers = Teacher::orderByDesc('created_at')->take(10)->get();
        $memoires = Memoire::with('student')->orderByDesc('created_at')->take(10)->get();
        $soutenances = Soutenance::with(['student', 'directeurMemoire', 'evaluateurTeacher', 'presidentJury'])
            ->orderByDesc('date_soutenance')
            ->take(10)
            ->get();
        $recus = RecuPaiement::with('student')->orderByDesc('date_paiement')->take(10)->get();
        $studentsList = Student::orderBy('nom')->orderBy('prenom')->get();
        $teachersList = Teacher::orderBy('nom')->orderBy('prenom')->get();
        $users = auth()->user()?->role === 'admin'
            ? User::with('student')->orderBy('name')->get()
            : collect();

        return view('dashboard', compact(
            'stats',
            'latestMemoires',
            'latestRecus',
            'latestStudents',
            'latestTeachers',
            'latestSoutenances',
            'latestPdfs',
            'students',
            'teachers',
            'memoires',
            'soutenances',
            'recus',
            'studentsList',
            'teachersList',
            'users'
        ));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        if ($request->user()->id === $user->id && $data['role'] !== 'admin') {
            return back()->with('error', 'Vous ne pouvez pas retirer votre propre role admin.');
        }

        $user->update(['role' => $data['role']]);

        return back()->with('success', 'Role mis a jour.');
    }

    public function linkStudent(Request $request, User $user)
    {
        $data = $request->validate([
            'student_id' => 'nullable|exists:students,id',
        ]);

        $studentId = $data['student_id'] ?? null;

        if ($studentId) {
            $student = Student::findOrFail($studentId);

            if ($student->user_id && $student->user_id !== $user->id) {
                return back()->with('error', 'Cet etudiant est deja lie a un autre compte.');
            }

            if ($user->student && $user->student->id !== $student->id) {
                $user->student->update(['user_id' => null]);
            }

            $student->update(['user_id' => $user->id]);
        } else {
            if ($user->student) {
                $user->student->update(['user_id' => null]);
            }
        }

        return back()->with('success', 'Liaison mise a jour.');
    }
}
