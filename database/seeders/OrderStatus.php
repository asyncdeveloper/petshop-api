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
        $statuses = config('constants.order_statuses');

        collect($statuses)->each(function ($orderStatus) {
            \App\Models\OrderStatus::firstOrCreate(['title' => $orderStatus]);
        });
    }
}
