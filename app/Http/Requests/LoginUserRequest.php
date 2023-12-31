<?php

namespace App\Http\Requests;

use OpenApi\Annotations as OA;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * @OA\Schema(
 *      title="LoginUserRequest",
 *      description="login a user",
 *      type="object",
 *      required={"email", "password"}
 * )
 */
class LoginUserRequest extends FormRequest
{
    /**
     * @OA\Property(property="email", type="string", example="contact@asyncdeveloper.com")
     * @OA\Property(property="password", type="string", example="12345678")
     */
    public string $email;
    public string $password;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }
}
