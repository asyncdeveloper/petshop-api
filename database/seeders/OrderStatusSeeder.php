<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = config('constants.order_statuses');

        collect($statuses)->each(function ($orderStatus) {
            OrderStatus::firstOrCreate(['title' => $orderStatus]);
        });
    }
}
