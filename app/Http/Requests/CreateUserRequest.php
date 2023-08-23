<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      title="CreateUserRequest",
 *      description="register a new user",
 *      type="object",
 *      required={"first_name","last_name","email","avatar","address","phone_number","password","password_confirmation"}
 * )
 */
class CreateUserRequest extends FormRequest
{
    /**
     * @var string
     * @OA\Property(property="first_name", type="string", example="Oluwaseyi")
     * @OA\Property(property="last_name", type="string", example="Adeogun")
     * @OA\Property(property="email", type="string", example="contact@asyncdeveloper.com")
     * @OA\Property(property="avatar", type="string", example="https://placehold.co/600x400/png")
     * @OA\Property(property="address", type="string", example="Lagos,Nigeria")
     * @OA\Property(property="phone_number", type="string", example="08165551288")
     * @OA\Property(property="password", type="string", example="12345678")
     * @OA\Property(property="password_confirmation", type="string", example="12345678")
     */
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $avatar;
    public string $address;
    public string $phone_number;
    public string $password;
    public string $password_confirmation;

    /**
     * @var bool
     * @OA\Property(property="is_admin", type="boolean", example="false")
     * @OA\Property(property="is_marketing", type="boolean", example=false)
     */
    public bool $is_admin;
    public bool $is_marketing;

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
            'first_name' => 'required|string|min:3|max:255',
            'last_name' => 'required|string|min:3|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user()?->id),
            ],
            'password' => 'required|string|confirmed|min:8|max:255',
            'password_confirmation' => 'required|string|min:8|max:255',
            'avatar' => 'nullable|string|max:255',
            'address' => 'required|string|min:3|max:255',
            'phone_number' => 'required|string|min:3|max:100',
            'is_marketing' => 'boolean',
        ];
    }
}
