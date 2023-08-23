<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function apply(Builder $builder): Builder
    {
        return $this->applyDecoratorsFromRequest(request(), $builder);
    }

    private function applyDecoratorsFromRequest(Request $request, Builder $query): Builder
    {
        $direction = 'asc';

        if ($request->has('desc')) {
            $desc = $request->get('desc');
            $direction = $desc === "true" ? 'desc' : 'asc';
        }

        if ($request->has('sortBy')) {
            $query->orderBy($request->get('sortBy'), $direction);
        }

        return $query;
    }
}
