<?php
 namespace Database\Factories;

 use Illuminate\Database\Eloquent\Factories\Factory;
 use Illuminate\Support\Str;
 use App\Models\User;
 
 class ArticleFactory extends Factory
 {
     public function definition()
     {
         $title = $this->faker->sentence;
         return [
             'title' => $title,
             'slug' => Str::slug($title),
             'content' => $this->faker->paragraphs(10, true),
             'excerpt' => $this->faker->paragraph,
             'featured_image' => 'images/articles/' . $this->faker->image('public/storage/images/articles', 800, 600, null, false),
             'thumbnail' => 'images/articles/thumbs/' . $this->faker->image('public/storage/images/articles/thumbs', 300, 300, null, false),
             'meta_title' => $this->faker->words(6, true),
             'meta_description' => $this->faker->sentence(10),
             'meta_keywords' => implode(',', $this->faker->words(5)),
             'is_published' => $this->faker->boolean(80),
             'is_featured' => $this->faker->boolean(20),
             'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
             'views' => $this->faker->numberBetween(0, 10000),
             'reading_time' => $this->faker->numberBetween(1, 30),
             'user_id' => User::factory(),
         ];
     }
 }
