<?php

namespace App\Services;

use Illuminate\Support\Arr;
use App\Repositories\OrderRepository;

class OrderService
{
    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getUserOrders(): array
    {
        $filteredOrder = $this->orderRepository
            ->query()
            ->with(['user', 'orderStatus', 'payment'])
            ->where('user_id', auth()->user()->id)
            ->filter();

        $paginatedData = $filteredOrder->simplePaginate(
            (int) request()->limit
        )->toArray();

        return [
            'data' => $paginatedData['data'],
            'meta' => Arr::except($paginatedData, [
                'data',
            ]),
        ];
    }
}
