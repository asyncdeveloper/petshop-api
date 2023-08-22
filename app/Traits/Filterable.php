<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Filterable
{

    public function apply(Builder $builder): Builder
    {
        return $this->applyDecoratorsFromRequest(request(), $builder);
    }

    private function applyDecoratorsFromRequest(Request $request, Builder $query): Builder
    {
        $asc = $request->get('desc', false);

        if ($request->has('sortBy')) {
            $query->orderBy($request->get('sortBy'), $asc ? 'asc' : 'desc');
        }

        return $query;
    }

}
