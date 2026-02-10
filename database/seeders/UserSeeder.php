<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@lucas.edu'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        $users = [
            ['name' => 'User One', 'email' => 'user1@lucas.edu'],
            ['name' => 'User Two', 'email' => 'user2@lucas.edu'],
            ['name' => 'User Three', 'email' => 'user3@lucas.edu'],
            ['name' => 'User Four', 'email' => 'user4@lucas.edu'],
        ];

        foreach ($users as $u) {
            User::firstOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make('password'),
                    'role' => 'user',
                ]
            );
        }
    }
}
