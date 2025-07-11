<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = ['Laravel', 'VueJS', 'PHP', 'Web Development', 'Tutorial'];

        foreach ($tags as $name) {
            \App\Models\Tag::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}
