<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class UserService
{

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

    public function deleteUser(): void
    {
        $this->userRepo->delete(auth()->user()->id);
    }

    public function resetPassword($data): array
    {
        $user = $this->userRepo->find($data)->first();

        if (!$user) {
            throw ValidationException::withMessages(['email' => 'Invalid email']);
        }

        $token = Password::broker()->createToken($user);

        return ['token' => $token];
    }

    public function logoutUser(): void
    {
        auth()->logout();
    }
}
