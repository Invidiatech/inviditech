<?php
namespace Database\Factories;

use App\Models\Article;
use App\Models\ArticleSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class CodeSnippetFactory extends Factory
{
    public function definition()
    {
        $languages = ['php', 'javascript', 'python', 'java', 'html', 'css'];
        return [
            'title' => $this->faker->words(3, true),
            'code' => $this->faker->text(500),
            'language' => $this->faker->randomElement($languages),
            'description' => $this->faker->sentence,
            'article_id' => Article::factory(),
            'section_id' => ArticleSection::factory(),
        ];
    }
}

