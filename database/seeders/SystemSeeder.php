<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $system = [
            ['name' => 'name', 'value' => Env('APP_NAME')],
            ['name' => 'url', 'value' => Env('APP_URL')],
            ['name' => 'language', 'value' => 'vi'],
            ['name' => 'owner', 'value' => []],
            ['name' => 'description', 'value' => 'A blog has many different topics and content.'],
            ['name' => 'keywords', 'value' => 'blog,laravel,vuejs,php,web development,tutorial'],
            ['name' => 'operating_days', 'value' => '2025-07-11'],
            ['name' => 'logo', 'value' => ''],
            ['name' => 'favicon', 'value' => ''],
            ['name' => 'contact_email', 'value' => '<EMAIL>'],
            ['name' => 'contact_phone', 'value' => '0987654321'],
            ['name' => 'contact_address', 'value' => 'My Workspace'],
        ];

        foreach ($system as $item) {
            \App\Models\System::create([
                'name' => $item['name'],
                'value' => $item['value'],
                'type' => 'system',
            ]);
        }
    }
}
