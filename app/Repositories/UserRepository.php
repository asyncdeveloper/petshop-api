<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Interfaces\CRUDRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements CRUDRepositoryInterface
{
    public function findAll(): Collection
    {
        return User::all();
    }

    public function find($attributes): Collection
    {
        return $this->query()->where($attributes)->get();
    }

    public function store(array $data): Model
    {
        return $this->query()->create($data);
    }

    public function update(array $data, int $id): void
    {
        $this->query()->findOrFail($id)->update($data);
    }

    public function findOrFail(int $id): Model
    {
        return $this->query()->findOrFail($id);
    }

    public function delete(int $id): void
    {
        $this->findOrFail($id)->delete();
    }

    public function query(): Builder
    {
        return User::query();
    }
}
