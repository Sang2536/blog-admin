<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\Recruitment;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $recruitments = Recruitment::all();
        $users = \App\Models\User::where('is_admin', false)->get();

        foreach ($recruitments as $recruitment) {
            $numApplications = rand(3, 8);

            for ($i = 0; $i < $numApplications; $i++) {
                $user = $users->random();

                Application::create([
                    'recruitment_id' => $recruitment->id,
                    'user_id'        => fake()->boolean() ? $user->id : null,
                    'full_name'      => $user->name,
                    'email'          => $user->email,
                    'phone'          => fake()->phoneNumber(),
                    'cv_path'        => 'applications/cv_' . fake()->uuid() . '.pdf',
                    'cover_letter'   => fake()->paragraph(3),
                    'status'         => fake()->randomElement(['pending', 'reviewed', 'accepted', 'rejected']),
                ]);
            }
        }
    }
}
