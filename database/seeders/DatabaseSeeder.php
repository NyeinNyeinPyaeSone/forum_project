<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Forum;
use App\Models\Tag;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
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
        foreach ($categories as $categoryData){
            Category::create($categoryData);
        }

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
        foreach($tags as $tagData) {
            Tag::create($tagData);
        }
        Thread::factory(10)
            ->has(Comment::factory()->count(3))
            ->create([
            'category_id' => rand(1, 5)
            
        ]);
    }
}
