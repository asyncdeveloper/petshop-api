<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'avatar' => fake()->name(),
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'is_marketing' => false,
            'is_admin' => false,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function defaultAdmin(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_admin' => true,
            'email' => 'admin@buckhill.co.uk',
            'password' => '$2a$12$HeTHsyGDAn.5ll4JcP/5NOQpn3stSf4dug82dxPgJGd6BvIJm/Rvq', // admin
        ]);
    }

    public function isMarketing(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_marketing' => true,
        ]);
    }
}
