<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @return Builder $builder
     */
    public static function apply(Builder $builder, mixed $value): Builder;
}
