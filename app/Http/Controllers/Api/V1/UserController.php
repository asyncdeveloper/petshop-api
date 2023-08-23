<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UserRequest;
use App\Services\OrderService;
use App\Services\UserService;
use App\Traits\ResponseData;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    use ResponseData;

    private UserService $userService;
    private OrderService $orderService;

    public function __construct(UserService $userService, OrderService $orderService)
    {
        $this->userService = $userService;
        $this->orderService = $orderService;
    }

    /**
     * @OA\Post(
     *      path="/api/v1/user/create",
     *      operationId="registerUser",
     *      tags={"User"},
     *      summary="Create a new user",
     *      security={{"bearer_token":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateUserRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/User"
     *              )
     *         )
     *      ),
     *      @OA\Response(response=401,description="Unauthourized"),
     *      @OA\Response(response=422,description="Validation Error")
     *  )
     */
    public function register(CreateUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data = $this->userService->registerUser($data);

        return $this->success($data, 201);
    }


    /**
     * @OA\Post(
     *      path="/api/v1/user/login",
     *      operationId="loginUser",
     *      tags={"User"},
     *      summary="login a user",
     *      security={{"bearer_token":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LoginUserRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/User"
     *              )
     *         )
     *      ),
     *      @OA\Response(response=401,description="Unauthourized"),
     *      @OA\Response(response=422,description="Validation Error")
     *  )
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        $data = $this->userService->loginUser($credentials);

        return $this->success($data);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/user",
     *      operationId="getCurrentUser",
     *      tags={"User"},
     *      summary="get current user",
     *      security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/User"
     *              )
     *         )
     *      ),
     *      @OA\Response(response=401,description="Unauthorized")
     *  )
     */
    public function user(): JsonResponse
    {
        return $this->success(auth()->user());
    }

    /**
     * @OA\Put(
     *      path="/api/v1/users/edit",
     *      operationId="updateUser",
     *      tags={"User"},
     *      summary="update current user",
     *      security={{"bearer_token":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateUserRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean"),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/User"
     *              )
     *         )
     *      ),
     *      @OA\Response(response=401,description="Unauthourized"),
     *      @OA\Response(response=422,description="Validation Error")
     *  )
     */
    public function edit(UserRequest $userRequest): JsonResponse
    {
        $user = $this->userService->editUser(auth()->user(), $userRequest->validated());

        return $this->success(['user' => $user]);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/user/forgot-password",
     *      operationId="forgotPassword",
     *      tags={"User"},
     *      summary="forgot password",
     *      security={{"bearer_token":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ForgotPasswordRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="token",
     *                      type="string",
     *                      example="e1adfed7194b11c9641415b0c937b8b4b8f11a3794907f8ab75d108c94941e79"
     *                  )
     *              )
     *         )
     *      ),
     *      @OA\Response(response=401,description="Unauthourized"),
     *      @OA\Response(response=422,description="Validation Error")
     *  )
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $data = $request->validated();

        $token = $this->userService->generatePasswordToken($data['email']);

        return $this->success($token);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/user/reset-password-token",
     *      operationId="resetPasswordToken",
     *      tags={"User"},
     *      summary="reset password token",
     *      security={{"bearer_token":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PasswordResetRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean"),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/User"
     *              )
     *         )
     *      ),
     *      @OA\Response(response=401,description="Unauthourized"),
     *      @OA\Response(response=422,description="Validation Error")
     *  )
     */
    public function resetPasswordToken(PasswordResetRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->userService->resetPassword($data);

        return $this->success($user);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/user/orders",
     *      operationId="getUserOrders",
     *      tags={"User"},
     *      summary="Get all user orders",
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          name="page",
     *          in="path",
     *          @OA\Schema(
     *              type="int"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="limit",
     *          in="path",
     *          @OA\Schema(
     *              type="int"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="sortBy",
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="desc",
     *          in="path",
     *          @OA\Schema(
     *              type="boolean"
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
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Order")
     *              )
     *         )
     *      ),
     *      @OA\Response(response=401,description="Unauthorized")
     *  )
     */
    public function orders(): JsonResponse
    {
        $userOrders = $this->orderService->getUserOrders();

        return $this->success($userOrders['data'], 200, $userOrders['meta']);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/user/logout",
     *      operationId="logoutUser",
     *      tags={"User"},
     *      summary="logout current user",
     *      security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=204,
     *          description="OK"
     *      ),
     *      @OA\Response(response=401,description="Unauthorized")
     *  )
     */
    public function logout(): JsonResponse
    {
        $this->userService->logoutUser();

        return $this->success(null, 204);
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/user/delete",
     *      operationId="deleteUser",
     *      tags={"User"},
     *      summary="delete current user",
     *      security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=204,
     *          description="OK"
     *      ),
     *      @OA\Response(response=401,description="Unauthourized")
     *  )
     */
    public function delete(): JsonResponse
    {
        $this->userService->deleteUser();

        return $this->success(null, 204);
    }

}
