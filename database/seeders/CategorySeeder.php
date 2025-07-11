<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Tin tức', 'Hướng dẫn', 'Chia sẻ', 'Công nghệ'];

        foreach ($categories as $name) {
            \App\Models\Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}
