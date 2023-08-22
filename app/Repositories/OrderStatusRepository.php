<?php

namespace App\Repositories;

use App\Interfaces\CRUDRepositoryInterface;
use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class OrderStatusRepository implements CRUDRepositoryInterface
{
    public function findAll(): Collection
    {
        return OrderStatus::all();
    }

    public function find($attributes): Collection
    {
        return OrderStatus::query()->where($attributes)->get();
    }

    public function store(array $data): Model
    {
        return OrderStatus::query()->create($data);
    }

    public function update(array $data, int $id): void
    {
        OrderStatus::query()->findOrFail($id)->update($data);
    }

    public function findOrFail(int $id): Model
    {
        return OrderStatus::query()->findOrFail($id);
    }

    public function delete(int $id): void
    {
        $this->findOrFail($id)->delete();
    }
}
