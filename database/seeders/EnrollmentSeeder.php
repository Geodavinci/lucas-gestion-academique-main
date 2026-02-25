<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Filiere;
use App\Models\Student;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::orderBy('id')->get();
        $filieres = Filiere::orderBy('id')->get();

        if ($students->isEmpty() || $filieres->isEmpty()) {
            return;
        }

        $year = date('Y') . '-' . (date('Y') + 1);
        $i = 0;

        foreach ($students as $student) {
            $filiere = $filieres[$i % $filieres->count()];

            Enrollment::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'filiere_id' => $filiere->id,
                    'annee_academique' => $year,
                ],
                []
            );

            $i++;
        }
    }
}
