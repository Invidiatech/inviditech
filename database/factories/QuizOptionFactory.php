<?php
 namespace Database\Factories;

 use App\Models\QuizQuestion;
 use Illuminate\Database\Eloquent\Factories\Factory;
 
 class QuizOptionFactory extends Factory
 {
     public function definition()
     {
         return [
             'option_text' => $this->faker->sentence,
             'is_correct' => $this->faker->boolean(25),
             'question_id' => QuizQuestion::factory(),
         ];
     }
 }