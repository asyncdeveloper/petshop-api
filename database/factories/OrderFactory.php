<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        Payment::factory()->create();

        return [
            'order_status_id' => fake()->randomElement(OrderStatus::pluck('id')),
            'user_id' => fake()->randomElement(User::pluck('id')),
            'payment_id' => fake()->randomElement(Payment::pluck('id')),
            'products' => [
                ['product' => fake()->uuid(), 'quantity' => 3],
                ['product' => fake()->uuid(), 'quantity' => 2]
            ],
            'address' => [
                'billing' => fake()->address(),
                'shipping' => fake()->address()
            ],
            'delivery_fee' => fake()->randomFloat(2,0,3),
            'amount' => fake()->randomFloat(2,0, 100),
        ];
    }
}
