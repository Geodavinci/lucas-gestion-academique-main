<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Filiere;
use App\Models\Student;
use Illuminate\Database\Seeder;

class FiliereStudentSeeder extends Seeder
{
    public function run(): void
    {
        $filieres = Filiere::orderBy('code')->get();
        if ($filieres->isEmpty()) {
            return;
        }

        $year = date('Y') . '-' . (date('Y') + 1);

        foreach ($filieres as $filiere) {
            $existing = Enrollment::where('filiere_id', $filiere->id)
                ->distinct('student_id')
                ->count('student_id');

            $toCreate = max(0, 20 - $existing);

            for ($i = 1; $i <= $toCreate; $i++) {
                $num = str_pad((string) ($existing + $i), 3, '0', STR_PAD_LEFT);
                $matricule = 'STU-' . $filiere->code . '-' . $num;
                $email = 'stu' . strtolower($filiere->code) . $num . '@lucas.edu';

                $student = Student::firstOrCreate(
                    ['matricule' => $matricule],
                    [
                        'nom' => 'Etudiant',
                        'prenom' => $filiere->code . $num,
                        'email' => $email,
                        'telephone' => '93' . str_pad((string) ($existing + $i), 6, '0', STR_PAD_LEFT),
                        'filiere' => $filiere->nom,
                        'niveau' => 'Licence 3',
                    ]
                );

                Enrollment::firstOrCreate(
                    [
                        'student_id' => $student->id,
                        'filiere_id' => $filiere->id,
                        'annee_academique' => $year,
                    ],
                    []
                );
            }
        }
    }
}
