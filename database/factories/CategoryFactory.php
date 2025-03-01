<?php
 namespace Database\Factories;

 use Illuminate\Database\Eloquent\Factories\Factory;
 use Illuminate\Support\Str;
 
 class CategoryFactory extends Factory
 {
     public function definition()
     {
         $name = $this->faker->unique()->words(2, true);
         return [
             'name' => $name,
             'slug' => Str::slug($name),
             'description' => $this->faker->paragraph,
             'meta_title' => $this->faker->words(6, true),
             'meta_description' => $this->faker->sentence(10),
             'meta_keywords' => implode(',', $this->faker->words(5)),
             'icon' => 'fa-' . $this->faker->word,
             'is_featured' => $this->faker->boolean(20),
             'sort_order' => $this->faker->numberBetween(1, 100),
         ];
     }
 }
