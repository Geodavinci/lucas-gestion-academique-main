<?php

namespace App\Console\Commands;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateUsersForExistingStudentsTeachers extends Command
{
    protected $signature = 'app:create-users-for-existing-students-teachers';
    protected $description = 'Create User accounts for existing students and teachers without user_id';

    public function handle()
    {
        $this->info('Backfilling users for students and teachers...');

        $studentCount = $this->backfillStudents();
        $teacherCount = $this->backfillTeachers();

        $this->info("✓ Created $studentCount user accounts for students");
        $this->info("✓ Created $teacherCount user accounts for teachers");
        $this->info('Done!');
    }

    private function backfillStudents(): int
    {
        $students = Student::whereNull('user_id')->get();
        $count = 0;

        foreach ($students as $student) {
            if (User::where('email', $student->email)->exists()) {
                $this->warn("User already exists for {$student->email}, skipping");
                continue;
            }

            DB::transaction(function () use ($student, &$count) {
                $user = User::create([
                    'name' => "{$student->nom} {$student->prenom}",
                    'email' => $student->email,
                    'password' => bcrypt(uniqid()),
                    'role' => 'student',
                ]);

                $student->update(['user_id' => $user->id]);
                $count++;
            });
        }

        return $count;
    }

    private function backfillTeachers(): int
    {
        $teachers = Teacher::whereNull('user_id')->whereNotNull('email')->get();
        $count = 0;

        foreach ($teachers as $teacher) {
            if (User::where('email', $teacher->email)->exists()) {
                $this->warn("User already exists for {$teacher->email}, skipping");
                continue;
            }

            DB::transaction(function () use ($teacher, &$count) {
                $user = User::create([
                    'name' => "{$teacher->nom} {$teacher->prenom}",
                    'email' => $teacher->email,
                    'password' => bcrypt(uniqid()),
                    'role' => 'teacher',
                ]);

                $teacher->update(['user_id' => $user->id]);
                $count++;
            });
        }

        return $count;
    }
}
