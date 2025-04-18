<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Laravel Basics',
                'description' => 'Fundamental concepts and features of the Laravel framework',
            ],
            [
                'name' => 'Eloquent ORM',
                'description' => 'Working with databases in Laravel using the Eloquent ORM',
            ],
            [
                'name' => 'Laravel APIs',
                'description' => 'Building and consuming APIs with Laravel',
            ],
            [
                'name' => 'Laravel Authentication',
                'description' => 'User authentication, authorization, and access control in Laravel',
            ],
            [
                'name' => 'Laravel Testing',
                'description' => 'Unit testing, feature testing, and test-driven development in Laravel',
            ],
            [
                'name' => 'Laravel Deployment',
                'description' => 'Deploying Laravel applications to various hosting environments',
            ],
            [
                'name' => 'Laravel Packages',
                'description' => 'Popular and useful Laravel packages to extend your application',
            ],
            [
                'name' => 'Laravel Security',
                'description' => 'Security best practices and vulnerability prevention in Laravel',
            ],
            [
                'name' => 'Laravel News',
                'description' => 'Latest updates, releases, and announcements about Laravel',
            ],
            [
                'name' => 'Laravel Performance',
                'description' => 'Optimizing and scaling Laravel applications for better performance',
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}