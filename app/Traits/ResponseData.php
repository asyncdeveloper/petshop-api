<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseData
{
    protected function success($data = [], $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
        ], $status);
    }

}
