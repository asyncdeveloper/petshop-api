<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UserRequest;
use App\Models\Order;
use App\Services\UserService;
use App\Traits\ResponseData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    use ResponseData;

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(UserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data = $this->userService->registerUser($data);

        return $this->success($data, 201);
    }

    public function login(UserRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        $data = $this->userService->loginUser($credentials);

        return $this->success($data);
    }

    public function user(): JsonResponse
    {
        return $this->success(['user' => auth()->user()]);
    }

    public function edit(UserRequest $userRequest): JsonResponse
    {
        $user = $this->userService->editUser(auth()->user(), $userRequest->validated());

        return $this->success(['user' => $user]);
    }

    public function forgotPassword(PasswordResetRequest $request): JsonResponse
    {
        $data = $request->validated();

        $token = $this->userService->generatePasswordToken($data['email']);

        return $this->success($token);
    }

    public function resetPasswordToken(PasswordResetRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->userService->resetPassword($data);

        return $this->success($user);
    }

    public function orders(Request $request): JsonResponse
    {
        $filteredOrder = Order::with(['user', 'orderStatus', 'payment'])->where('user_id', auth()->user()->id)->filter(
            );

        $paginatedData = $filteredOrder->simplePaginate(
            (int)$request->limit
        )->toArray();

        return $this->success(
            $paginatedData['data'],
            200,
            Arr::except($paginatedData, [
                'data'
            ])
        );
    }

    public function logout(): JsonResponse
    {
        $this->userService->logoutUser();

        return $this->success(null, 204);
    }

    public function delete(): JsonResponse
    {
        $this->userService->deleteUser();

        return $this->success(null, 204);
    }

}
