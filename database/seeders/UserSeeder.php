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
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'is_admin' => true,
                'is_author' => true,
                'is_active' => true,
                'avatar' => null,
            ]);
        }

        // Author
        if (!User::where('email', 'author@example.com')->exists()) {
            User::create([
                'name' => 'Author User',
                'email' => 'author@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'is_admin' => false,
                'is_author' => true,
                'is_active' => true,
                'avatar' => null,
            ]);
        }

        // Inactive user
        if (!User::where('email', 'inactive@example.com')->exists()) {
            User::create([
                'name' => 'Inactive User',
                'email' => 'inactive@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'is_admin' => false,
                'is_author' => false,
                'is_active' => false,
                'avatar' => null,
            ]);
        }

        // Random users
        User::factory()->count(10)->create();
    }
}
