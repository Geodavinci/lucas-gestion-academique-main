<?php

namespace App\Http\Controllers;

use App\Models\Memoire;
use App\Models\Soutenance;
use App\Models\RecuPaiement;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Admin dashboard with analytics
        if ($user->role === 'admin') {
            $stats = Cache::remember('dashboard.admin.stats', 300, fn() => AnalyticsService::getAdminStats());

            $memoiresByFiliereData = Cache::remember('dashboard.memoires.filiere', 300, fn() => AnalyticsService::getMemoiresByFiliereData());
            $memoiresByNiveauData = Cache::remember('dashboard.memoires.niveau', 300, fn() => AnalyticsService::getMemoiresByNiveauData());
            $studentsByFiliereData = Cache::remember('dashboard.students.filiere', 300, fn() => AnalyticsService::getStudentCountByFiliere());
            $soutenancesByMonthData = Cache::remember('dashboard.soutenances.month', 300, fn() => AnalyticsService::getSoutenancesByMonth());
            $teacherWorkloadData = Cache::remember('dashboard.teachers.workload', 300, fn() => AnalyticsService::getTeacherWorkload());

            $latestMemoires = Memoire::with('student')->orderByDesc('created_at')->take(5)->get();
            $latestSoutenances = Soutenance::with('student')
                ->orderByDesc('date_soutenance')
                ->take(5)
                ->get();
            $studentsList = Student::orderBy('nom')->orderBy('prenom')->get();
            $teachersList = Teacher::orderBy('nom')->orderBy('prenom')->get();

            return view('dashboard.admin', compact(
                'stats',
                'memoiresByFiliereData',
                'memoiresByNiveauData',
                'studentsByFiliereData',
                'soutenancesByMonthData',
                'teacherWorkloadData',
                'latestMemoires',
                'latestSoutenances',
                'studentsList',
                'teachersList'
            ));
        }

        // Teacher dashboard
        if ($user->role === 'teacher') {
            $teacher = Teacher::where('user_id', $user->id)->first();

            if ($teacher) {
                $teacherStats = AnalyticsService::getTeacherStats($teacher->id);
                $upcomingSoutenances = Soutenance::where(function ($q) use ($teacher) {
                    $q->where('directeur_memoire_id', $teacher->id)
                        ->orWhere('evaluateur_id', $teacher->id)
                        ->orWhere('president_jury_id', $teacher->id);
                })
                    ->where('date_soutenance', '>=', now())
                    ->orderBy('date_soutenance')
                    ->take(10)
                    ->get();

                return view('dashboard.teacher', compact('teacherStats', 'upcomingSoutenances'));
            }
        }

        // Student dashboard
        if ($user->role === 'student') {
            $student = $user->student;

            if ($student) {
                $studentStats = AnalyticsService::getStudentStats($student->id);

                return view('dashboard.student', compact('studentStats'));
            }
        }

        // Fallback
        return view('dashboard');
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
