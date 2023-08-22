<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use App\Traits\ResponseData;
use Illuminate\Http\JsonResponse;

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

        $token = $this->userService->resetPassword($data);

        return $this->success($token);
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
