<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderStatus extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'open',
            'pending',
            'payment',
            'paid',
            'shipped',
            'cancelled',
        ];

        collect($statuses)->each(function ($orderStatus) {
            \App\Models\OrderStatus::firstOrCreate(['title' => $orderStatus]);
        });
    }
}
