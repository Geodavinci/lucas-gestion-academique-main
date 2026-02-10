<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['matricule' => 'STU001', 'nom' => 'KOFFI', 'prenom' => 'Jean', 'email' => 'jean.koffi@lucas.edu', 'telephone' => '90000001', 'filiere' => 'Informatique', 'niveau' => 'Licence 3'],
            ['matricule' => 'STU002', 'nom' => 'ADJO', 'prenom' => 'Alice', 'email' => 'alice.adjo@lucas.edu', 'telephone' => '90000002', 'filiere' => 'Reseaux', 'niveau' => 'Licence 2'],
            ['matricule' => 'STU003', 'nom' => 'MENSAH', 'prenom' => 'Eric', 'email' => 'eric.mensah@lucas.edu', 'telephone' => '90000003', 'filiere' => 'Genie logiciel', 'niveau' => 'Licence 3'],
            ['matricule' => 'STU004', 'nom' => 'KASSA', 'prenom' => 'Mina', 'email' => 'mina.kassa@lucas.edu', 'telephone' => '90000004', 'filiere' => 'Informatique', 'niveau' => 'Master 1'],
            ['matricule' => 'STU005', 'nom' => 'DJOKO', 'prenom' => 'Paulin', 'email' => 'paulin.djoko@lucas.edu', 'telephone' => '90000005', 'filiere' => 'SI', 'niveau' => 'Licence 2'],
            ['matricule' => 'STU006', 'nom' => 'SINA', 'prenom' => 'Noel', 'email' => 'noel.sina@lucas.edu', 'telephone' => '90000006', 'filiere' => 'Informatique', 'niveau' => 'Licence 1'],
            ['matricule' => 'STU007', 'nom' => 'ALI', 'prenom' => 'Nadia', 'email' => 'nadia.ali@lucas.edu', 'telephone' => '90000007', 'filiere' => 'Genie logiciel', 'niveau' => 'Master 2'],
            ['matricule' => 'STU008', 'nom' => 'TCHAKO', 'prenom' => 'Leo', 'email' => 'leo.tchako@lucas.edu', 'telephone' => '90000008', 'filiere' => 'Reseaux', 'niveau' => 'Licence 3'],
        ];

        foreach ($students as $student) {
            Student::firstOrCreate(['matricule' => $student['matricule']], $student);
        }
    }
}
