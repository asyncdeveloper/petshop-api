<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface CRUDRepository
{
    public function query(): Builder;

    public function findAll(): Collection;

    public function find($attributes): Collection;

    public function findOrFail(int $id): Model;

    public function store(array $data): Model;

    public function update(array $data, int $id): void;

    public function delete(int $id): void;
}
