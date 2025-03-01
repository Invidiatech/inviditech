<?php
 namespace Database\Factories;

 use App\Models\Quiz;
 use Illuminate\Database\Eloquent\Factories\Factory;
 
 class QuizQuestionFactory extends Factory
 {
     public function definition()
     {
         return [
             'question' => $this->faker->sentence . '?',
             'question_type' => $this->faker->randomElement(['multiple_choice', 'true_false', 'coding']),
             'points' => $this->faker->numberBetween(1, 5),
             'explanation' => $this->faker->paragraph,
             'quiz_id' => Quiz::factory(),
         ];
     }
 }
