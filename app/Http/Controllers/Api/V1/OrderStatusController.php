<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStatusRequest;
use App\Services\OrderStatusService;
use App\Traits\ResponseData;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class OrderStatusController extends Controller
{

    use ResponseData;

    private OrderStatusService $orderStatusService;

    public function __construct(OrderStatusService $orderStatusService)
    {
        $this->orderStatusService = $orderStatusService;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/order-status",
     *      operationId="getAllOrderStatus",
     *      tags={"Order Statuses"},
     *      summary="list all order statuses",
     *      security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/OrderStatus")
     *              )
     *         )
     *      ),
     *      @OA\Response(response=401,description="Unauthorized")
     *  )
     */
    public function all(): JsonResponse
    {
        $data = $this->orderStatusService->getAllOrderStatus()->toArray();

        return $this->success($data);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/order-status/create",
     *      operationId="createOrderStatus",
     *      tags={"Order Statuses"},
     *      summary="Create a new order status",
     *      security={{"bearer_token":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/OrderStatusRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="OK",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/OrderStatus")
     *              )
     *         )
     *      ),
     *      @OA\Response(response=401,description="Unauthorized"),
     *      @OA\Response(response=422,description="Validation Error")
     *  )
     */
    public function create(OrderStatusRequest $request): JsonResponse
    {
        $data = $request->validated();

        $orderStatus = $this->orderStatusService->createOrderStatus($data);

        return $this->success($orderStatus, 201);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/order-status/{uuid}",
     *      operationId="getOneOrderStatus",
     *      tags={"Order Statuses"},
     *      summary="Get one order status",
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          name="uuid",
     *          in="path",
     *          @OA\Schema(
     *              type="uuid"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/OrderStatus")
     *              )
     *         )
     *      ),
     *      @OA\Response(response=401,description="Unauthorized"),
     *      @OA\Response(response=404,description="Not Found")
     *  )
     */
    public function show(string $uuid): JsonResponse
    {
        $orderStatus = $this->orderStatusService->getOrderStatus($uuid);

        return $this->success($orderStatus->toArray());
    }

    /**
     * @OA\Put(
     *      path="/api/v1/order-status/{uuid}",
     *      operationId="updateOrderStatus",
     *      tags={"Order Statuses"},
     *      summary="update one order status",
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          name="uuid",
     *          in="path",
     *          @OA\Schema(
     *              type="uuid"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/OrderStatusRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean"),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/OrderStatus")
     *              )
     *         )
     *      ),
     *      @OA\Response(response=422,description="Validation Error")
     *  )
     */
    public function update(OrderStatusRequest $request, string $uuid): JsonResponse
    {
        $orderStatus = $this->orderStatusService->editOrderStatus($request->validated(), $uuid);

        return $this->success($orderStatus);
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/order-status/{uuid}",
     *      operationId="deleteOrderStatus",
     *      tags={"Order Statuses"},
     *      summary="delete one order status",
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          name="uuid",
     *          in="path",
     *          @OA\Schema(
     *              type="uuid"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="OK"
     *      ),
     *      @OA\Response(response=401,description="Unauthorized")
     *  )
     */
    public function delete(string $uuid): JsonResponse
    {
        $this->orderStatusService->deleteOrderStatus($uuid);

        return $this->success(null, 204);
    }
}
