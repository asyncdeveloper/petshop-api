<?php

namespace App\Http\Requests;

use OpenApi\Annotations as OA;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * @OA\Schema(
 *      title="PasswordResetRequest",
 *      description="password reset",
 *      type="object",
 *      required={"email","token","password","password_confirmation"}
 * )
 */
class PasswordResetRequest extends FormRequest
{
    /**
     * @OA\Property(
     *     property="token",
     *     type="string",
     *     example="e1adfed7194b11c9641415b0c937b8b4b8f11a3794907f8ab75d108c94941e79"
     * )
     * @OA\Property(property="email", type="string", example="contact@asyncdeveloper.com")
     * @OA\Property(property="password", type="string", example="12345678")
     * @OA\Property(property="password_confirmation", type="string", example="12345678")
     */
    public string $token;
    public string $email;
    public string $pasword;
    public string $password_confirmation;

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
            'token' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed|min:8|max:255',
            'password_confirmation' => 'required|string|min:8|max:255',
        ];
    }
}
