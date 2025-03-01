<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFileFactory extends Factory
{
    public function definition()
    {
        $fileName = $this->faker->uuid . '.jpg';
        return [
            'file_name' => $fileName,
            'file_path' => 'uploads/' . $fileName,
            'file_type' => 'image',
            'mime_type' => 'image/jpeg',
            'file_size' => $this->faker->numberBetween(100000, 5000000),
            'alt_text' => $this->faker->words(3, true),
            'caption' => $this->faker->sentence,
            'dimensions' => '1920x1080',
            'user_id' => User::factory(),
        ];
    }
}