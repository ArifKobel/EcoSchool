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
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'school_name' => fake()->optional(0.7)->company(),
            'school_type' => fake()->optional(0.7)->randomElement(['grundschule', 'gymnasium', 'realschule', 'gesamtschule', 'berufsschule']),
            'school_location' => fake()->optional(0.7)->city(),
            'role' => fake()->optional(0.8)->randomElement(['lehrkraft', 'schulleitung', 'sonstige']),
            'data_consent' => true,
            'consent_given_at' => now(),
            'anonymous_mode' => fake()->boolean(20), // 20% anonym
            'preferences' => ['theme' => 'light', 'language' => 'de']
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
