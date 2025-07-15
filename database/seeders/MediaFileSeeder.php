<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediaFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            \App\Models\MediaFile::create([
                'name' => "Ảnh demo $i",
                'file_path' => "media/demo_$i.jpg",
                'mime_type' => 'image/jpeg',
                'size' => rand(10000, 500000),
                'user_id' => 1,
            ]);
        }
    }
}
