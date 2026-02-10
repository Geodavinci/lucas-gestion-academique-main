<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Filiere;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class FiliereCourseSeeder extends Seeder
{
    public function run(): void
    {
        $filieres = [
            'DEV' => 'Développement Web & Mobile',
            'CYB' => 'Cybersécurité',
            'CCA' => 'Comptabilité & Contrôle d’Audit',
            'MKT' => 'Marketing',
            'TOU' => 'Tourisme',
            'MAN' => 'Management',
            'HOT' => 'Hôtellerie',
            'LOG' => 'Transport & Logistique',
        ];

        $teachers = [
            ['nom' => 'KOUASSI', 'prenom' => 'Daniel', 'email' => 'daniel.kouassi@lucas.edu', 'telephone' => '92000001', 'specialite' => 'Développement'],
            ['nom' => 'NOUKPO', 'prenom' => 'Rita', 'email' => 'rita.noukpo@lucas.edu', 'telephone' => '92000002', 'specialite' => 'Mobile'],
            ['nom' => 'ADEKAMBI', 'prenom' => 'Sara', 'email' => 'sara.adekambi@lucas.edu', 'telephone' => '92000003', 'specialite' => 'Cybersécurité'],
            ['nom' => 'DUPON', 'prenom' => 'Marc', 'email' => 'marc.dupon@lucas.edu', 'telephone' => '92000004', 'specialite' => 'Réseaux'],
            ['nom' => 'HOUNKPE', 'prenom' => 'Sylvie', 'email' => 'sylvie.hounkpe@lucas.edu', 'telephone' => '92000005', 'specialite' => 'Marketing'],
            ['nom' => 'KONE', 'prenom' => 'Ismael', 'email' => 'ismael.kone@lucas.edu', 'telephone' => '92000006', 'specialite' => 'Comptabilité'],
            ['nom' => 'ADJOVI', 'prenom' => 'Pauline', 'email' => 'pauline.adjovi@lucas.edu', 'telephone' => '92000007', 'specialite' => 'Tourisme'],
            ['nom' => 'DOSSOU', 'prenom' => 'Patrick', 'email' => 'patrick.dossou@lucas.edu', 'telephone' => '92000008', 'specialite' => 'Management'],
            ['nom' => 'YAO', 'prenom' => 'Claire', 'email' => 'claire.yao@lucas.edu', 'telephone' => '92000009', 'specialite' => 'Hôtellerie'],
            ['nom' => 'MENSAH', 'prenom' => 'Eric', 'email' => 'eric.mensah@lucas.edu', 'telephone' => '92000010', 'specialite' => 'Logistique'],
        ];

        foreach ($teachers as $teacher) {
            Teacher::firstOrCreate(['email' => $teacher['email']], $teacher);
        }

        $teacherMap = Teacher::all()->keyBy('specialite');

        $coursesByFiliere = [
            'DEV' => [
                ['code' => 'DEV101', 'nom' => 'Développement Web', 'coef' => 3, 'semestre' => 'S1', 'specialite' => 'Développement'],
                ['code' => 'DEV201', 'nom' => 'Développement Mobile', 'coef' => 3, 'semestre' => 'S2', 'specialite' => 'Mobile'],
                ['code' => 'DEV301', 'nom' => 'Bases de données', 'coef' => 2, 'semestre' => 'S2', 'specialite' => 'Développement'],
            ],
            'CYB' => [
                ['code' => 'CYB101', 'nom' => 'Sécurité réseau', 'coef' => 3, 'semestre' => 'S1', 'specialite' => 'Cybersécurité'],
                ['code' => 'CYB201', 'nom' => 'Ethical Hacking', 'coef' => 3, 'semestre' => 'S2', 'specialite' => 'Cybersécurité'],
                ['code' => 'CCNA101', 'nom' => 'CCNA 1', 'coef' => 2, 'semestre' => 'S1', 'specialite' => 'Réseaux'],
            ],
            'CCA' => [
                ['code' => 'CCA101', 'nom' => 'Comptabilité générale', 'coef' => 3, 'semestre' => 'S1', 'specialite' => 'Comptabilité'],
                ['code' => 'CCA201', 'nom' => 'Contrôle de gestion', 'coef' => 3, 'semestre' => 'S2', 'specialite' => 'Comptabilité'],
            ],
            'MKT' => [
                ['code' => 'MKT101', 'nom' => 'Marketing fondamental', 'coef' => 3, 'semestre' => 'S1', 'specialite' => 'Marketing'],
                ['code' => 'MKT201', 'nom' => 'Marketing digital', 'coef' => 3, 'semestre' => 'S2', 'specialite' => 'Marketing'],
            ],
            'TOU' => [
                ['code' => 'TOU101', 'nom' => 'Géographie touristique', 'coef' => 2, 'semestre' => 'S1', 'specialite' => 'Tourisme'],
                ['code' => 'TOU201', 'nom' => 'Gestion des agences', 'coef' => 3, 'semestre' => 'S2', 'specialite' => 'Tourisme'],
            ],
            'MAN' => [
                ['code' => 'MAN101', 'nom' => 'Management général', 'coef' => 3, 'semestre' => 'S1', 'specialite' => 'Management'],
                ['code' => 'MAN201', 'nom' => 'Gestion des équipes', 'coef' => 2, 'semestre' => 'S2', 'specialite' => 'Management'],
            ],
            'HOT' => [
                ['code' => 'HOT101', 'nom' => 'Accueil et réception', 'coef' => 2, 'semestre' => 'S1', 'specialite' => 'Hôtellerie'],
                ['code' => 'HOT201', 'nom' => 'Gestion hôtelière', 'coef' => 3, 'semestre' => 'S2', 'specialite' => 'Hôtellerie'],
            ],
            'LOG' => [
                ['code' => 'LOG101', 'nom' => 'Transport et logistique', 'coef' => 3, 'semestre' => 'S1', 'specialite' => 'Logistique'],
                ['code' => 'LOG201', 'nom' => 'Supply chain', 'coef' => 3, 'semestre' => 'S2', 'specialite' => 'Logistique'],
            ],
        ];

        foreach ($filieres as $code => $nom) {
            $filiere = Filiere::firstOrCreate(['code' => $code], ['nom' => $nom]);

            foreach ($coursesByFiliere[$code] as $courseData) {
                $course = Course::firstOrCreate(
                    ['code' => $courseData['code']],
                    [
                        'filiere_id' => $filiere->id,
                        'nom' => $courseData['nom'],
                        'coefficient' => $courseData['coef'],
                        'semestre' => $courseData['semestre'],
                    ]
                );

                $teacher = $teacherMap->get($courseData['specialite']);
                if ($teacher) {
                    $course->teachers()->syncWithoutDetaching([$teacher->id]);
                }
            }
        }
    }
}
