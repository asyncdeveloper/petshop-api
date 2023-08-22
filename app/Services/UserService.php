<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Traits\ResponseData;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    use ResponseData;

    private UserRepository $userRepo;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function registerUser(array $data): Model
    {
        return $this->userRepo->store($data);
    }

    public function loginUser(array $credentials): array
    {
        $token = auth()->attempt($credentials);

        if (!$token) {
            throw new AuthenticationException('Unauthorized');
        }

        $user = auth()->user();

        $this->userRepo->update(['last_login_at' => now()], $user->id);

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $this->userRepo->findOrFail($user->id),
        ];
    }

    public function editUser(Model $user, $attributes): Model
    {
        $this->userRepo->update($attributes, $user->id);

        return $this->userRepo->findOrFail($user->id);
    }

    public function logoutUser(): void
    {
        auth()->logout();
    }
}
