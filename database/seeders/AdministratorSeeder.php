<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;

class AdministratorSeeder extends Seeder
{
    public function run(): void
    {
        Administrator::truncate();

        if (!Administrator::exists()) {
            Administrator::updateOrCreate(
                ['email' => 'admin.myblog@example.com'],
                [
                    'name' => 'Super Admin',
                    'password' => Hash::make('password'),
                    'is_super' => true,
                    'avatar' => null,
                    'role' => 'Founder'
                ]
            );

            $roles = [
                'Administrator', 'Technician', 'Editor', 'Sub-editor', 'Contributor',
                'Designer', 'Website Developer', 'Reviewer', 'Translator', 'Columnist',
                'Reporter', 'Event Organizer', 'Publisher', 'Marketing', 'Fact-checker',
                'Photojournalist', 'Journalist', 'Producer', 'Content Creator', 'Copywriter',
                'Social Media Manager', 'Online Editor', 'SEO Specialist', 'Web Content Manager',
            ];

            foreach ($roles as $role) {
                $isSuper = in_array($role, [
                    'Administrator',
                    'Technician',
                    'Website Developer',
                    'Web Content Manager',
                ]);

                Administrator::create(
                    [
                        'name' => fake()->name(),
                        'email' => fake()->unique()->safeEmail(),
                        'password' => Hash::make('password'),
                        'is_super' => $isSuper,
                        'avatar' => null,
                        'role' => $role
                    ]
                );
            }
        }
    }
}
