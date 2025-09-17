<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'slug' => fake()->slug(),
        ];
    }
    public function forumTags() 
    {
        $tags = [
            [
                'name' => 'Laravel',
                'slug' => 'laravel',
                
            ],
            [
                'name' => 'Vue',
                'slug' => 'vue',
                
            ],
            [
                'name' => 'JavaScript',
                'slug' => 'javascript',
                
            ],
            [
                'name' => 'CSS',
                'slug' => 'css',
                
            ],
            [
                'name' => 'PHP',
                'slug' => 'php',
                
            ],
            [
                'name' => 'Tailwind',
                'slug' => 'tailwind',
                
            ],
        ];
        return $tags[array_rand($tags)];
    }
}
