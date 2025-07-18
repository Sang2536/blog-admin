<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Reward;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RewardSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Activity::all() as $activity) {
            for ($i = 1; $i <= rand(1, 3); $i++) {
                $name = 'Reward ' . $i;

                Reward::create([
                    'activity_id' => $activity->id,
                    'name' => $name,
                    'value' => '$' . rand(50, 500),
                    'slug' => Str::slug($name),
                    'description' => fake()->sentence(),
                ]);
            }
        }
    }
}
