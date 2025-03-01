<?php
namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'time_limit' => $this->faker->numberBetween(5, 60),
            'passing_score' => $this->faker->numberBetween(60, 80),
            'article_id' => Article::factory(),
        ];
    }
}
