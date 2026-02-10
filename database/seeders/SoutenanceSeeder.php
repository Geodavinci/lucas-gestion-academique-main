<?php

namespace Database\Seeders;

use App\Models\Soutenance;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class SoutenanceSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $teachers = Teacher::all();
        if ($students->isEmpty() || $teachers->count() < 3) {
            return;
        }

        $statuts = ['Valide', 'Ajourne'];
        $i = 0;

        foreach ($students as $student) {
            $directeur = $teachers[$i % $teachers->count()];
            $evaluateur = $teachers[($i + 1) % $teachers->count()];
            $president = $teachers[($i + 2) % $teachers->count()];

            Soutenance::firstOrCreate(
                ['student_id' => $student->id],
                [
                    'date_soutenance' => now()->addDays($i * 2)->toDateString(),
                    'statut' => $statuts[$i % 2],
                    'description' => 'Soutenance planifiee.',
                    'directeur_memoire_id' => $directeur->id,
                    'evaluateur_id' => $evaluateur->id,
                    'president_jury_id' => $president->id,
                ]
            );

            $i++;
        }
    }
}
