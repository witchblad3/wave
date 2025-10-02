<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password',
            ],
            [
                'name' => 'Moderator User',
                'email' => 'moderator@example.com',
                'password' => 'moderator123',
            ],
            [
                'name' => 'Demo Member',
                'email' => 'member@example.com',
                'password' => 'member123',
            ],
        ];

        foreach ($users as $user) {
            User::factory()->create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
            ]);
        }

        User::factory(20)->create();
    }
}
