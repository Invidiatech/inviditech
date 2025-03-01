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
        $admin = User::create([
            'username' => 'admin',
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin1234'), 
            'role' => 'admin',
            'is_verified' => true
        ]);
 
        // Create author user
        $author = User::create([
            'name' => 'Author User',
            'username' => 'author',
            'email' => 'author@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
 
        // Create editor user
        $editor = User::create([
            'name' => 'Editor User',
            'username' => 'editor',
            'email' => 'editor@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
      
    }
}