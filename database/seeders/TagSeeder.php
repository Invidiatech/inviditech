<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'PHP'],
            ['name' => 'Laravel'],
            ['name' => 'Web Development'],
            ['name' => 'Backend'],
            ['name' => 'Frontend'],
            ['name' => 'API'],
            ['name' => 'Blade Templates'],
            ['name' => 'Eloquent ORM'],
            ['name' => 'MySQL'],
            ['name' => 'Authentication']
        ];

        foreach ($tags as $tagData) {
            Tag::firstOrCreate([
                'name' => $tagData['name']
            ]);
        }
    }
}
