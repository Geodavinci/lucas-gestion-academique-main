<?php

use App\Models\Student;
use App\Models\Soutenance;
use App\Models\Teacher;
use App\Models\User;

function createTeacherForJuryTest(string $email): Teacher
{
    $user = User::factory()->create([
        'email' => $email,
        'role' => 'teacher',
    ]);

    return Teacher::create([
        'nom' => 'Enseignant',
        'prenom' => $email,
        'email' => $email,
        'specialite' => 'Informatique',
        'user_id' => $user->id,
    ]);
}

function createSoutenanceForJuryTest(Teacher $director): Soutenance
{
    $student = Student::create([
        'matricule' => 'STU-' . uniqid(),
        'nom' => 'Etudiant',
        'prenom' => 'Test',
        'email' => uniqid() . '@example.com',
        'filiere' => 'Informatique',
        'niveau' => 'Master 2',
    ]);

    return Soutenance::create([
        'date_soutenance' => now()->toDateString(),
        'statut' => 'Valide',
        'student_id' => $student->id,
        'directeur_memoire_id' => $director->id,
    ]);
}

test('the administrator can schedule a future soutenance with three distinct teachers', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $director = createTeacherForJuryTest('director@example.com');
    $evaluator = createTeacherForJuryTest('evaluator@example.com');
    $president = createTeacherForJuryTest('president@example.com');
    $student = Student::create([
        'matricule' => 'STU-' . uniqid(),
        'nom' => 'Etudiant',
        'prenom' => 'Test',
        'email' => uniqid() . '@example.com',
        'filiere' => 'Informatique',
        'niveau' => 'Master 2',
    ]);

    $response = $this->actingAs($admin)->post(route('soutenances.store'), [
        'date_soutenance' => now()->addDay()->toDateString(),
        'statut' => 'Valide',
        'student_id' => $student->id,
        'directeur_memoire_id' => $director->id,
        'evaluateur_id' => $evaluator->id,
        'president_jury_id' => $president->id,
    ]);

    $response->assertRedirect(route('soutenances.index'));
    $this->assertDatabaseHas('soutenances', [
        'student_id' => $student->id,
        'directeur_memoire_id' => $director->id,
        'evaluateur_id' => $evaluator->id,
        'president_jury_id' => $president->id,
    ]);
    $this->assertDatabaseCount('notifications', 3);
});

test('the administrator can assign a jury to an existing soutenance', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $director = createTeacherForJuryTest('director@example.com');
    $evaluator = createTeacherForJuryTest('evaluator@example.com');
    $president = createTeacherForJuryTest('president@example.com');
    $soutenance = createSoutenanceForJuryTest($director);

    $this->actingAs($admin)
        ->put(route('soutenances.update', $soutenance), [
            'date_soutenance' => now()->toDateString(),
            'statut' => 'Valide',
            'student_id' => $soutenance->student_id,
            'directeur_memoire_id' => $director->id,
            'evaluateur_id' => $evaluator->id,
            'president_jury_id' => $president->id,
        ])
        ->assertRedirect(route('soutenances.show', $soutenance));

    $this->assertDatabaseHas('soutenances', [
        'id' => $soutenance->id,
        'directeur_memoire_id' => $director->id,
        'evaluateur_id' => $evaluator->id,
        'president_jury_id' => $president->id,
    ]);
    $this->assertDatabaseCount('notifications', 3);
});

test('the administrator cannot assign one teacher to multiple jury roles', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $director = createTeacherForJuryTest('director@example.com');
    $evaluator = createTeacherForJuryTest('evaluator@example.com');
    $student = Student::create([
        'matricule' => 'STU-' . uniqid(),
        'nom' => 'Etudiant',
        'prenom' => 'Test',
        'email' => uniqid() . '@example.com',
        'filiere' => 'Informatique',
        'niveau' => 'Master 2',
    ]);

    $response = $this->actingAs($admin)
        ->from(route('soutenances.create'))
        ->post(route('soutenances.store'), [
            'date_soutenance' => now()->toDateString(),
            'statut' => 'Valide',
            'student_id' => $student->id,
            'directeur_memoire_id' => $director->id,
            'evaluateur_id' => $evaluator->id,
            'president_jury_id' => $evaluator->id,
        ]);

    $response->assertSessionHasErrors('president_jury_id');
    $this->assertDatabaseMissing('soutenances', ['student_id' => $student->id]);
});

test('a teacher cannot create or edit a soutenance or its jury', function () {
    $teacher = createTeacherForJuryTest('teacher@example.com');

    $this->actingAs($teacher->user)
        ->get(route('soutenances.create'))
        ->assertForbidden();

    $this->actingAs($teacher->user)
        ->put(route('soutenances.update', createSoutenanceForJuryTest($teacher)), [
            'date_soutenance' => now()->toDateString(),
            'statut' => 'Valide',
            'student_id' => 1,
        ])
        ->assertForbidden();
});

test('teachers can view soutenances where they are assigned as jury members', function () {
    $director = createTeacherForJuryTest('director@example.com');
    $evaluator = createTeacherForJuryTest('evaluator@example.com');
    $president = createTeacherForJuryTest('president@example.com');
    $soutenance = createSoutenanceForJuryTest($director);
    $soutenance->update([
        'evaluateur_id' => $evaluator->id,
        'president_jury_id' => $president->id,
    ]);

    $this->actingAs($evaluator->user)
        ->get(route('teacher.dashboard'))
        ->assertOk()
        ->assertSee('Mes soutenances')
        ->assertSee('Évaluateur')
        ->assertSee('Etudiant Test');

    $this->actingAs($president->user)
        ->get(route('teacher.dashboard'))
        ->assertOk()
        ->assertSee('Président du jury');
});
