<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseData
{
    protected function success($data = [], $status = 200, $meta = []): JsonResponse
    {
        $dataBody = [
            'success' => true,
            'data' => $data,
        ];

        if (!empty($meta)) {
            $dataBody = array_merge($dataBody, $meta);
        }
        return response()->json($dataBody, $status);
    }
}
