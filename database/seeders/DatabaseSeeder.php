<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdministratorSeeder::class,
            UserSeeder::class,

            CategorySeeder::class,
            TagSeeder::class,
            MediaFileSeeder::class,

            PostSeeder::class,
            CommentSeeder::class,

            // CrawPostSeeder::class,

            ActivitySeeder::class,
            RewardSeeder::class,
            ParticipantSeeder::class,

            RecruitmentSeeder::class,
            ApplicationSeeder::class,

            SystemSeeder::class,
            OptionSeeder::class,
        ]);
    }

}
