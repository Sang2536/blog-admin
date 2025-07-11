<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = \App\Models\Post::all();
        $user = \App\Models\User::first();

        foreach ($posts as $post) {
            foreach (range(1, 3) as $i) {
                \App\Models\Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                    'content' => fake()->sentence(10),
                ]);
            }
        }
    }
}
