<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherUserSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = Teacher::orderBy('id')->get();
        if ($teachers->isEmpty()) {
            return;
        }

        $i = 1;
        foreach ($teachers as $teacher) {
            $email = 'teacher' . $i . '@lucas.edu';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $teacher->nom . ' ' . $teacher->prenom,
                    'password' => Hash::make('password'),
                    'role' => 'teacher',
                ]
            );

            $teacher->update(['user_id' => $user->id]);
            $i++;
        }
    }
}
