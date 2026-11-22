<?php

use App\Models\Memoire;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('a student cannot change the owner of their memoir through the update request', function () {
    $owner = User::factory()->create(['role' => 'student']);
    $otherUser = User::factory()->create(['role' => 'student']);

    $ownerStudent = Student::create([
        'matricule' => 'OWNER-001',
        'nom' => 'Owner',
        'prenom' => 'Student',
        'email' => 'owner@example.com',
        'filiere' => 'Informatique',
        'niveau' => 'Master 2',
        'user_id' => $owner->id,
    ]);

    $otherStudent = Student::create([
        'matricule' => 'OTHER-001',
        'nom' => 'Other',
        'prenom' => 'Student',
        'email' => 'other@example.com',
        'filiere' => 'Informatique',
        'niveau' => 'Master 2',
        'user_id' => $otherUser->id,
    ]);

    $memoire = Memoire::create([
        'student_id' => $ownerStudent->id,
        'titre' => 'Memoire de test',
        'annee' => 2026,
        'status' => 'draft',
    ]);

    $this->actingAs($owner)
        ->put(route('memoires.update', $memoire), [
            'titre' => $memoire->titre,
            'annee' => $memoire->annee,
            'student_id' => $otherStudent->id,
        ])
        ->assertRedirect(route('memoires.index'));

    $this->assertDatabaseHas('memoires', [
        'id' => $memoire->id,
        'student_id' => $ownerStudent->id,
        'titre' => 'Memoire de test',
    ]);
});

test('an administrator cannot register a memoir with a future year', function () {
    Storage::fake('public');

    $admin = User::factory()->create(['role' => 'admin']);
    $student = Student::create([
        'matricule' => 'FUTURE-MEMOIRE-001',
        'nom' => 'Future',
        'prenom' => 'Student',
        'email' => 'future-memoire@example.com',
        'filiere' => 'Informatique',
        'niveau' => 'Master 2',
    ]);

    $this->actingAs($admin)
        ->from(route('memoires.create'))
        ->post(route('memoires.store'), [
            'student_id' => $student->id,
            'titre' => 'Memoire non soutenu',
            'annee' => now()->year + 1,
            'fichier_pdf' => UploadedFile::fake()->create('memoire.pdf', 10, 'application/pdf'),
        ])
        ->assertSessionHasErrors('annee');

    $this->assertDatabaseMissing('memoires', [
        'student_id' => $student->id,
        'titre' => 'Memoire non soutenu',
    ]);
});

test('an administrator can register a memoir for the current year', function () {
    Storage::fake('public');

    $admin = User::factory()->create(['role' => 'admin']);
    $student = Student::create([
        'matricule' => 'CURRENT-MEMOIRE-001',
        'nom' => 'Current',
        'prenom' => 'Student',
        'email' => 'current-memoire@example.com',
        'filiere' => 'Informatique',
        'niveau' => 'Master 2',
    ]);

    $this->actingAs($admin)
        ->post(route('memoires.store'), [
            'student_id' => $student->id,
            'titre' => 'Memoire soutenu cette annee',
            'annee' => now()->year,
            'fichier_pdf' => UploadedFile::fake()->create('memoire.pdf', 10, 'application/pdf'),
        ])
        ->assertRedirect(route('memoires.index'));

    $this->assertDatabaseHas('memoires', [
        'student_id' => $student->id,
        'titre' => 'Memoire soutenu cette annee',
        'annee' => now()->year,
    ]);
});

test('a student cannot change their memoir to a future year', function () {
    $owner = User::factory()->create(['role' => 'student']);
    $student = Student::create([
        'matricule' => 'FUTURE-UPDATE-001',
        'nom' => 'Owner',
        'prenom' => 'Student',
        'email' => 'future-update@example.com',
        'filiere' => 'Informatique',
        'niveau' => 'Master 2',
        'user_id' => $owner->id,
    ]);
    $memoire = Memoire::create([
        'student_id' => $student->id,
        'titre' => 'Memoire deja soutenu',
        'annee' => now()->year,
        'status' => 'draft',
    ]);

    $this->actingAs($owner)
        ->put(route('memoires.update', $memoire), [
            'titre' => $memoire->titre,
            'annee' => now()->year + 1,
        ])
        ->assertSessionHasErrors('annee');

    $this->assertDatabaseHas('memoires', [
        'id' => $memoire->id,
        'annee' => now()->year,
    ]);
});

test('a student cannot upload a corrected memoir PDF', function () {
    $owner = User::factory()->create(['role' => 'student']);

    $student = Student::create([
        'matricule' => 'OWNER-002',
        'nom' => 'Owner',
        'prenom' => 'Student',
        'email' => 'owner2@example.com',
        'filiere' => 'Informatique',
        'niveau' => 'Master 2',
        'user_id' => $owner->id,
    ]);

    $memoire = Memoire::create([
        'student_id' => $student->id,
        'titre' => 'Memoire de test',
        'annee' => 2026,
        'status' => 'draft',
    ]);

    $file = UploadedFile::fake()->create(
        'corrige.pdf',
        10,
        'application/pdf'
    );

    $this->actingAs($owner)
        ->put(route('memoires.update', $memoire), [
            'titre' => $memoire->titre,
            'annee' => $memoire->annee,
            'fichier_pdf_corrige' => $file,
        ])
        ->assertSessionHasErrors('fichier_pdf_corrige');

    $this->assertNull($memoire->fresh()->fichier_pdf_corrige);
});

test('a student cannot download another students original memoir PDF', function () {
    $owner = User::factory()->create(['role' => 'student']);
    $otherUser = User::factory()->create(['role' => 'student']);

    $ownerStudent = Student::create([
        'matricule' => 'DOWNLOAD-OWNER-001',
        'nom' => 'Owner',
        'prenom' => 'Student',
        'email' => 'download-owner@example.com',
        'filiere' => 'Informatique',
        'niveau' => 'Master 2',
        'user_id' => $owner->id,
    ]);

    Student::create([
        'matricule' => 'DOWNLOAD-OTHER-001',
        'nom' => 'Other',
        'prenom' => 'Student',
        'email' => 'download-other@example.com',
        'filiere' => 'Informatique',
        'niveau' => 'Master 2',
        'user_id' => $otherUser->id,
    ]);

    $memoire = Memoire::create([
        'student_id' => $ownerStudent->id,
        'titre' => 'Memoire de test',
        'annee' => 2026,
        'fichier_pdf' => 'memoires/original.pdf',
        'status' => 'draft',
    ]);

    $this->actingAs($otherUser)
        ->get(route('memoires.download', $memoire))
        ->assertForbidden();
});

test('a student cannot download another students corrected memoir PDF', function () {
    $owner = User::factory()->create(['role' => 'student']);
    $otherUser = User::factory()->create(['role' => 'student']);

    $ownerStudent = Student::create([
        'matricule' => 'CORRECTED-OWNER-001',
        'nom' => 'Owner',
        'prenom' => 'Student',
        'email' => 'corrected-owner@example.com',
        'filiere' => 'Informatique',
        'niveau' => 'Master 2',
        'user_id' => $owner->id,
    ]);

    Student::create([
        'matricule' => 'CORRECTED-OTHER-001',
        'nom' => 'Other',
        'prenom' => 'Student',
        'email' => 'corrected-other@example.com',
        'filiere' => 'Informatique',
        'niveau' => 'Master 2',
        'user_id' => $otherUser->id,
    ]);

    $memoire = Memoire::create([
        'student_id' => $ownerStudent->id,
        'titre' => 'Memoire de test',
        'annee' => 2026,
        'fichier_pdf_corrige' => 'memoires/corriges/corrige.pdf',
        'status' => 'draft',
    ]);

    $this->actingAs($otherUser)
        ->get(route('memoires.download.corrige', $memoire))
        ->assertForbidden();
});
