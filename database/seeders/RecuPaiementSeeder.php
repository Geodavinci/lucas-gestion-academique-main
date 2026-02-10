<?php

namespace Database\Seeders;

use App\Models\RecuPaiement;
use App\Models\Student;
use Illuminate\Database\Seeder;

class RecuPaiementSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        if ($students->isEmpty()) {
            return;
        }

        $i = 1;
        foreach ($students as $student) {
            RecuPaiement::firstOrCreate(
                ['numero_recu' => 'RCU' . str_pad((string) $i, 3, '0', STR_PAD_LEFT)],
                [
                    'montant' => 50000 + ($i * 1000),
                    'date_paiement' => now()->subDays($i)->toDateString(),
                    'fichier_pdf' => null,
                    'student_id' => $student->id,
                ]
            );
            $i++;
        }
    }
}
