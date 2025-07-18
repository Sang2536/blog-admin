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
        $categories = [
            'Tin tức', 'Hướng dẫn', 'Chia sẻ', 'Công nghệ',
            'Kinh doanh', 'Thể thao', 'Sức khỏe', 'Đời sống',
            'Giải trí', 'Sách', 'Du lịch', 'Phong cách sống',
            'Xã hội', 'Tài chính', 'Pháp luật', 'Giáo dục'
        ];

        foreach ($categories as $name) {
            \App\Models\Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}
