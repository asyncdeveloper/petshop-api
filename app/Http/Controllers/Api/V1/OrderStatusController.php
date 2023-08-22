<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStatusRequest;
use App\Services\OrderStatusService;
use App\Traits\ResponseData;
use Illuminate\Http\JsonResponse;

class OrderStatusController extends Controller
{

    use ResponseData;

    private OrderStatusService $orderStatusService;

    public function __construct(OrderStatusService $orderStatusService)
    {
        $this->orderStatusService = $orderStatusService;
    }


    public function all(): JsonResponse
    {
        $data = $this->orderStatusService->getAllOrderStatus()->toArray();

        return $this->success($data);
    }

    public function create(OrderStatusRequest $request): JsonResponse
    {
        $data = $request->validated();

        $orderStatus = $this->orderStatusService->createOrderStatus($data);

        return $this->success($orderStatus, 201);
    }

    public function show(string $uuid): JsonResponse
    {
        $orderStatus = $this->orderStatusService->getOrderStatus($uuid);

        return $this->success(['order_status' => $orderStatus]);
    }

    public function update(OrderStatusRequest $request, string $uuid): JsonResponse
    {
        $orderStatus = $this->orderStatusService->editOrderStatus($request->validated(), $uuid);

        return $this->success($orderStatus);
    }

    public function delete(string $uuid): JsonResponse
    {
        $this->orderStatusService->deleteOrderStatus($uuid);

        return $this->success(null, 204);
    }
}
