<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;


/**
 * @OA\Schema(
 *      title="ForgotPasswordRequest",
 *      description="forgot password",
 *      type="object",
 *      required={"email"}
 * )
 */
class ForgotPasswordRequest extends FormRequest
{
    /**
     * @var string
     * @OA\Property(property="email", type="string", example="contact@asyncdeveloper.com")
     */
    public string $email;

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
        ];
    }
}
