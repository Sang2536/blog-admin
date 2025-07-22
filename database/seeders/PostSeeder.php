<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = \App\Models\User::where('is_author', true)->pluck('id')->toArray();
        $tags = \App\Models\Tag::pluck('id')->toArray();
        $categoryIds = \App\Models\Category::pluck('id')->toArray();
        $media = \App\Models\MediaFile::pluck('id')->toArray();

        foreach (range(1, rand(1000, 3000)) as $i) {
            $title = "Bài viết mẫu số " . (\App\Models\Post::max('id') + 1) . ' - ' . uniqid();

            $post = \App\Models\Post::create([
                'user_id' => $userIds[array_rand($userIds)],
                'category_id' => $categoryIds[array_rand($categoryIds)],
                'title' => $title,
                'slug' => Str::slug($title) . '-' . uniqid(),
                'excerpt' => fake()->paragraph(),
                'content' => fake()->paragraph(10),
                'status' => 'published',
                'is_featured' => rand(0, 1) === 1,
                'views' => rand(0, 10000),
                'published_at' => now()->subDays(rand(0, 30)),
            ]);

            $post->tags()->attach(array_rand(array_flip($tags), 2));
            $post->media()->attach(array_rand(array_flip($media), 2));
        }
    }
}
