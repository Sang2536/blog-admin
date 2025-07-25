<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'slug' => 'admin',
                'is_admin' => true,
                'is_author' => true,
                'is_active' => true,
                'avatar' => null,
                'bio' => 'Admin'
            ]);
        }

        // Author
        if (!User::where('email', 'author.management@example.com')->exists()) {
            User::create([
                'name' => 'Author Management',
                'email' => 'author.management@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'slug' => 'author-management',
                'is_admin' => false,
                'is_author' => true,
                'is_active' => true,
                'avatar' => null,
                'bio' => 'Author Management'
            ]);
        }

        // Inactive user
        if (!User::where('email', 'inactive.test@example.com')->exists()) {
            User::create([
                'name' => 'Inactive Test',
                'email' => 'inactive.test@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'slug' => 'inactive-test',
                'is_admin' => false,
                'is_author' => false,
                'is_active' => false,
                'avatar' => null,
                'bio' => 'Inactive Test'
            ]);
        }

        // Random users
        User::factory()->count(10)->create();
    }
}
