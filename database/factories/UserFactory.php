<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();

        $avatar = [
            'https://photo.znews.vn/w1920/Uploaded/zagtgt/2025_07_09/Pickleball_Sep_4.jpg',
            'https://photo.znews.vn/w210/Uploaded/wqdyqdxwp/2025_07_15/Xiao_1.jpg',
            'https://photo.znews.vn/w480/Uploaded/bpcgpivp/2025_07_17/thuphong_23_znews.jpg',
            'https://photo.znews.vn/w1000/Uploaded/zagtgt/2025_07_09/pickleball_1_1.jpeg',
            'https://photo.znews.vn/w480/Uploaded/ovhunst/2025_07_16/1x_1_3.jpg',
            'https://photo.znews.vn/w480/Uploaded/rotnba/2025_07_09/snapins_ai_3439396192491597819_1_.jpg',
            'https://photo.znews.vn/w480/Uploaded/rotnba/2025_07_10/IMGL4243_znews.jpg',
            'https://photo.znews.vn/w480/Uploaded/rotnba/2025_07_13/snapins_ai_DMAl1psT_d_1_1_.jpg',
            'https://photo.znews.vn/w480/Uploaded/pwvovowk/2025_07_10/unseen_studio_s9CC2SKySJM_unsplash.jpg',
            'https://photo.znews.vn/w480/Uploaded/wqdyqdxwp/2025_07_08/6C018A55_8CC5_4A52_B7BB_F2CFC754F8C9_1_201_a.jpeg'
        ];

        return [
            'name' => $name,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'slug' => Str::slug($name),
            'is_admin' => false,
            'is_author' => random_int(0, 1) === 1,
            'is_active' => random_int(0, 1) === 1,
            'avatar' => fake()->boolean() ? $avatar[array_rand($avatar)] : null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
