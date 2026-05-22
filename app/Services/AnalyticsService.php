<?php

namespace App\Services;

use App\Models\Memoire;
use App\Models\Student;
use App\Models\Soutenance;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    public static function getMemoiresByFiliereData()
    {
        $data = Student::select('filiere', DB::raw('count(DISTINCT student_id) as count'))
            ->join('memoires', 'students.id', '=', 'memoires.student_id')
            ->groupBy('filiere')
            ->pluck('count', 'filiere');

        return [
            'labels' => $data->keys()->toArray(),
            'datasets' => [[
                'label' => 'Mémoires par filière',
                'data' => $data->values()->toArray(),
                'backgroundColor' => [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                ],
                'borderColor' => [
                    'rgb(59, 130, 246)',
                    'rgb(34, 197, 94)',
                    'rgb(239, 68, 68)',
                    'rgb(245, 158, 11)',
                    'rgb(139, 92, 246)',
                    'rgb(236, 72, 153)',
                ],
                'borderWidth' => 1,
            ]],
        ];
    }

    public static function getMemoiresByNiveauData()
    {
        $data = Student::select('niveau', DB::raw('count(DISTINCT student_id) as count'))
            ->join('memoires', 'students.id', '=', 'memoires.student_id')
            ->groupBy('niveau')
            ->orderBy('niveau')
            ->pluck('count', 'niveau');

        return [
            'labels' => $data->keys()->toArray(),
            'datasets' => [[
                'label' => 'Mémoires par niveau',
                'data' => $data->values()->toArray(),
                'backgroundColor' => 'rgba(59, 130, 246, 0.8)',
                'borderColor' => 'rgb(59, 130, 246)',
                'borderWidth' => 1,
            ]],
        ];
    }

    public static function getStudentCountByFiliere()
    {
        $data = Student::select('filiere', DB::raw('count(*) as count'))
            ->groupBy('filiere')
            ->pluck('count', 'filiere');

        return [
            'labels' => $data->keys()->toArray(),
            'datasets' => [[
                'label' => 'Étudiants par filière',
                'data' => $data->values()->toArray(),
                'backgroundColor' => [
                    'rgba(59, 130, 246, 0.6)',
                    'rgba(34, 197, 94, 0.6)',
                    'rgba(239, 68, 68, 0.6)',
                    'rgba(245, 158, 11, 0.6)',
                    'rgba(139, 92, 246, 0.6)',
                    'rgba(236, 72, 153, 0.6)',
                ],
            ]],
        ];
    }

    public static function getSoutenancesByMonth()
    {
        $soutenances = Soutenance::whereNotNull('date_soutenance')
            ->get(['date_soutenance']);

        $grouped = $soutenances->groupBy(function($item) {
            return $item->date_soutenance->format('Y-m');
        })->map->count();

        $labels = [];
        $values = [];

        foreach ($grouped->sort()->keys() as $month) {
            $labels[] = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M Y');
            $values[] = $grouped[$month];
        }

        return [
            'labels' => $labels,
            'datasets' => [[
                'label' => 'Soutenances par mois',
                'data' => $values,
                'borderColor' => 'rgb(34, 197, 94)',
                'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                'tension' => 0.4,
                'fill' => true,
            ]],
        ];
    }

    public static function getTeacherWorkload()
    {
        $data = Teacher::select('teachers.id', 'teachers.nom', 'teachers.prenom')
            ->selectRaw('count(DISTINCT soutenances.id) as count')
            ->leftJoin('soutenances', function ($join) {
                $join->on('teachers.id', '=', 'soutenances.directeur_memoire_id')
                    ->orOn('teachers.id', '=', 'soutenances.evaluateur_id')
                    ->orOn('teachers.id', '=', 'soutenances.president_jury_id');
            })
            ->groupBy('teachers.id', 'teachers.nom', 'teachers.prenom')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        return [
            'labels' => $data->map(fn($t) => "{$t->nom} {$t->prenom}")->toArray(),
            'datasets' => [[
                'label' => 'Nombre de soutenances',
                'data' => $data->pluck('count')->toArray(),
                'backgroundColor' => 'rgba(139, 92, 246, 0.8)',
                'borderColor' => 'rgb(139, 92, 246)',
                'borderWidth' => 1,
            ]],
        ];
    }

    public static function getAdminStats()
    {
        return [
            'total_students' => Student::count(),
            'total_teachers' => Teacher::count(),
            'total_memoires' => Memoire::count(),
            'total_soutenances' => Soutenance::count(),
            'upcoming_soutenances' => Soutenance::where('date_soutenance', '>=', now())
                ->where('date_soutenance', '<=', now()->addDays(30))
                ->count(),
        ];
    }

    public static function getTeacherStats($teacherId)
    {
        $teacher = Teacher::findOrFail($teacherId);

        return [
            'name' => "{$teacher->nom} {$teacher->prenom}",
            'soutenances_as_director' => $teacher->soutenancesAsDirecteur()->count(),
            'soutenances_as_evaluator' => $teacher->soutenancesAsEvaluateur()->count(),
            'soutenances_as_president' => $teacher->soutenancesAsPresident()->count(),
            'total_soutenances' => $teacher->soutenancesAsDirecteur()->count() +
                $teacher->soutenancesAsEvaluateur()->count() +
                $teacher->soutenancesAsPresident()->count(),
        ];
    }

    public static function getStudentStats($studentId)
    {
        $student = Student::with('memoires', 'soutenances')->findOrFail($studentId);

        return [
            'name' => "{$student->nom} {$student->prenom}",
            'matricule' => $student->matricule,
            'filiere' => $student->filiere,
            'niveau' => $student->niveau,
            'memoires_count' => $student->memoires()->count(),
            'soutenances_count' => $student->soutenances()->count(),
            'memoires' => $student->memoires()->get(),
            'next_soutenance' => $student->soutenances()
                ->where('date_soutenance', '>=', now())
                ->orderBy('date_soutenance')
                ->first(),
        ];
    }
}
