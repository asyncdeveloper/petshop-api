<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => 'credit_card',
            'details' => [
                "holder_name" => fake()->name(),
                "number" => fake()->creditCardNumber(),
                "ccv" => 123,
                "expire_date" => fake()->creditCardExpirationDateString()
            ]
        ];
    }
}
