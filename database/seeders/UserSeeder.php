<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Muhammad Nawaz',
            'username' => 'Nawaz',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        // Create author user
        User::create([
            'name' => 'Author User',
            'username' => 'author',
            'email' => 'author@example.com',
            'password' => Hash::make('password'),
            'role' => 'author',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        // Create editor user
        User::create([
            'name' => 'Editor User',
            'username' => 'editor',
            'email' => 'editor@example.com',
            'password' => Hash::make('password'),
            'role' => 'editor',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);
    }
}
