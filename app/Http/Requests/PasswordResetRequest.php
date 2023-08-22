<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
{
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
        $routeName = $this->route()->getName();

        if ($routeName === 'forgot-password') {
            return [
                'email' => 'required|string|email',
            ];
        }

        if ($routeName === 'reset-password-token') {
            return [
                'token' => 'required|string',
                'email' => 'required|string|email',
                'password' => 'required|string|confirmed|min:8|max:255',
                'password_confirmation' => 'required|string|min:8|max:255',
            ];
        }

        return [];
    }
}