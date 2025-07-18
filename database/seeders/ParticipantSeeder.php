<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Participant;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Activity::all() as $activity) {
            for ($i = 1; $i <= rand(3, 10); $i++) {
                Participant::create([
                    'activity_id' => $activity->id,
                    'name' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'avatar' => null,
                ]);
            }
        }
    }
}
