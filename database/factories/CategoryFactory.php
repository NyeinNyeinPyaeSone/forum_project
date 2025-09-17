<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'description' => fake()->sentence(),
        ];
    }

    public function forumCategories() 
    {
        $categories = [
            [
                'name' => 'General Discussion',
                'description' => 'Open discussions about anything.',
                'slug' => 'general-discussion',
                
            ],
            [
                'name' => 'Technology',
                'description' => 'Tech news and discussions.',
                'slug' => 'technology',   
            ],
            [
                'name' => 'Help & Support',
                'description' => 'Get help and support from the community.',
                'slug' => 'help-support',     
            ],
            [
                'name' => 'Community',
                'description' => 'Community events and meetups.',
                'slug' => 'community',
            ],
            [
                'name' => 'Announcements',
                'description' => 'Important announcements from the forum team.',
                'slug' => 'announcements',
                 
            ]
        ];
        return $categories[array_rand($categories)];
    }
}
