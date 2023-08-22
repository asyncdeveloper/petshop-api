<?php

namespace App\Repositories;

use App\Interfaces\CRUDRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements CRUDRepositoryInterface
{
    public function findAll(): Collection
    {
        return User::all();
    }

    public function store(array $data): Model
    {
        return User::query()->create($data);
    }

    public function update(array $data, int $id): void
    {
        User::query()->findOrFail($id)->update($data);
    }

    public function findOrFail(int $id): Model
    {
        return User::query()->findOrFail($id);
    }

    public function delete(int $id): void
    {
        $this->findOrFail($id)->delete();
    }
}
