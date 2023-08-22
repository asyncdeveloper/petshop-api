<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
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

}
