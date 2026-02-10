<?php

namespace Database\Seeders;

use App\Models\Memoire;
use App\Models\Student;
use Illuminate\Database\Seeder;

class MemoireSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        if ($students->isEmpty()) {
            return;
        }

        $titles = [
            'Systeme de gestion academique',
            'Application de suivi des memoires',
            'Portail universitaire numerique',
            'Archivage des soutenances',
            'Gestion des dossiers etudiants',
        ];

        $year = (int) date('Y');
        $i = 0;
        foreach ($students as $student) {
            Memoire::firstOrCreate(
                ['student_id' => $student->id],
                [
                    'titre' => $titles[$i % count($titles)] . ' - ' . $student->matricule,
                    'annee' => $year - ($i % 3),
                    'fichier_pdf' => null,
                ]
            );
            $i++;
        }
    }
}
