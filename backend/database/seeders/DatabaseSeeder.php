<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Viagens;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            ['name' => 'Admin User', 'email' => 'admin@test.com', 'role' => 'admin'],
            ['name' => 'Test User', 'email' => 'user@test.com', 'role' => 'user']
        ];

        foreach ($usuarios as $dado) {
            $user = User::factory()->create([
                'name' => $dado['name'],
                'email' => $dado['email'],
                'password' => Hash::make('senha123'),
                'role' => $dado['role'],
            ]);

            Viagens::factory()->count(5)->create([
                'user_id' => $user->id,
                'enabled' => 1
            ]);
        }
    }
}