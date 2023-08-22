<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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

        if ($routeName === 'register') {
            return [
                'first_name' => 'required|string|min:3|max:255',
                'last_name' => 'required|string|min:3|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|confirmed|min:6',
                'password_confirmation' => 'required|string|min:3|max:255',
                'avatar' => 'nullable|string|max:255',
                'address' => 'required|string|min:3|max:255',
                'phone_number' => 'required|string|min:3|max:15',
                'is_marketing' => 'boolean',
            ];
        }

        if ($routeName === 'login') {
            return [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ];
        }

        return [];
    }

}
