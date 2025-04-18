<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Create a user first
        $userId = DB::table('users')->insertGetId([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Create a category if needed
        $categoryId = DB::table('categories')->first()->id ?? DB::table('categories')->insertGetId([
            'name' => 'Laravel Basics',
            'slug' => 'laravel-basics',
            'description' => 'Fundamental concepts of Laravel',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Create the article using the user you just created
        $articleId = DB::table('articles')->insertGetId([
            'user_id' => $userId,
            'category_id' => $categoryId,
            'title' => 'Getting Started with Laravel 11',
            'slug' => 'getting-started-with-laravel-11',
            'excerpt' => 'Learn how to set up and use Laravel 11 for your web applications.',
            'content' => '<p>Laravel 11 brings significant improvements to the framework. This quick guide will help you get started with the latest version.</p>
                         <p>To install Laravel 11, you need PHP 8.2+ and Composer. Run the following command:</p>
                         <pre><code>composer create-project laravel/laravel example-app</code></pre>
                         <p>Laravel 11 introduces a more streamlined structure and improved performance. Start building your application today!</p>',
            'featured_image' => 'articles/laravel11.jpg',
            'featured_image_alt' => 'Laravel 11 logo',
            'status' => 'published',
            'is_premium' => false,
            'is_featured' => true,
            'reading_time' => 5,
            'published_at' => Carbon::now(),
            'views_count' => 120,
            'likes_count' => 25,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Add the article to the article_category pivot table
        DB::table('article_category')->insert([
            'article_id' => $articleId,
            'category_id' => $categoryId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}