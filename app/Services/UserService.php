<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\AuthenticationException;
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

        return array_merge([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ], $this->userRepo->findOrFail($user->id)->toArray());
    }

    public function editUser(User|null $user, $attributes): Model
    {
        if(!$user) {
            throw new AuthenticationException('Unauthorized');
        }

        $this->userRepo->update($attributes, $user->id);

        return $this->userRepo->findOrFail($user->id);
    }

    public function deleteUser(): void
    {
        $this->userRepo->delete(auth()->user()->id);
    }

    public function generatePasswordToken($email): array
    {
        $user = $this->userRepo->find(['email' => $email])->first();

        if (!$user) {
            throw ValidationException::withMessages(['email' => 'Invalid email']);
        }

        $token = Password::broker()->createToken($user);

        return ['token' => $token];
    }

    public function resetPassword($data): Model
    {
        $email = $data['email'];

        $user = $this->userRepo->find(['email' => $email])->first();

        if (!$user) {
            throw ValidationException::withMessages(['email' => 'Invalid email']);
        }

        $status = Password::reset($data, function ($user, $password): void {
            $user->password = $password;
            $user->save();
        });

        if ($status === Password::INVALID_TOKEN) {
            throw ValidationException::withMessages(['token' => 'Invalid token provided']);
        }

        return $this->userRepo->find(['email' => $email ])->first();
    }

    public function logoutUser(): void
    {
        auth()->logout();
    }
}
