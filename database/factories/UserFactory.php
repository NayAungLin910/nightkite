<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'image' => '/default_images/nightkite_logo_transparent.webp',
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'description' => fake()->paragraph(1),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role' => '1',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user has already accepted to be an admin
     */
    public function accepted(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'role' => '2',
        ]);
    }

    /**
     * Indicate that the user has is the super admin
     */
    public function superAdmin(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'role' => '3',
        ]);
    }
}
