<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            ['nom' => 'AGOSSOU', 'prenom' => 'Claire', 'email' => 'claire.agossou@lucas.edu', 'telephone' => '91000001', 'specialite' => 'Genie logiciel'],
            ['nom' => 'HOUNTON', 'prenom' => 'Marc', 'email' => 'marc.hounton@lucas.edu', 'telephone' => '91000002', 'specialite' => 'Reseaux'],
            ['nom' => 'KOFFI', 'prenom' => 'Judith', 'email' => 'judith.koffi@lucas.edu', 'telephone' => '91000003', 'specialite' => 'Securite'],
            ['nom' => 'SODO', 'prenom' => 'Brice', 'email' => 'brice.sodo@lucas.edu', 'telephone' => '91000004', 'specialite' => 'Data'],
            ['nom' => 'DOSSOU', 'prenom' => 'Mireille', 'email' => 'mireille.dossou@lucas.edu', 'telephone' => '91000005', 'specialite' => 'SI'],
        ];

        foreach ($teachers as $teacher) {
            Teacher::firstOrCreate(['email' => $teacher['email']], $teacher);
        }
    }
}
