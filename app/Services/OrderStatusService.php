<?php

namespace App\Services;

use App\Repositories\OrderStatusRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class OrderStatusService
{

    private OrderStatusRepository $orderStatusRepository;

    public function __construct(OrderStatusRepository $orderStatusRepository)
    {
        $this->orderStatusRepository = $orderStatusRepository;
    }

    public function getAllOrderStatus(): Collection
    {
        return $this->orderStatusRepository->findAll();
    }

    public function getOrderStatus($uuid): Model
    {
        $orderStatus = $this->orderStatusRepository->find(['uuid' => $uuid])->first();

        if (!$orderStatus) {
            throw ValidationException::withMessages(['uuid' => 'Invalid uuid']);
        }

        return $orderStatus;
    }

    public function createOrderStatus($data): Model
    {
        return $this->orderStatusRepository->store($data);
    }

    public function editOrderStatus($data, $uuid): Model
    {
        $orderStatus = $this->orderStatusRepository->find(['uuid' => $uuid])->first();

        if (!$orderStatus) {
            throw ValidationException::withMessages(['uuid' => 'Invalid uuid']);
        }

        $this->orderStatusRepository->update($data, $orderStatus->id);

        return $this->orderStatusRepository->findOrFail($orderStatus->id);
    }

    public function deleteOrderStatus($uuid): void
    {
        $orderStatus = $this->orderStatusRepository->find(['uuid' => $uuid])->first();

        if (!$orderStatus) {
            throw ValidationException::withMessages(['uuid' => 'Invalid email']);
        }

        $this->orderStatusRepository->delete($orderStatus->id);
    }

}