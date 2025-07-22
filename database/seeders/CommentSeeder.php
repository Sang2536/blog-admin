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
        $userIds = \App\Models\User::pluck('id')->toArray();

        foreach ($posts as $post) {
            $createdComments = [];

            foreach (range(1, rand(0, 10)) as $i) {
                $isReply = $createdComments && rand(0, 100) < 30;

                $comment = \App\Models\Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $userIds[array_rand($userIds)],
                    'content' => fake()->sentence(10),
                    'parent_id' => $isReply ? collect($createdComments)->random()->id : null,
                ]);

                $createdComments[] = $comment;
            }
        }
    }
}
