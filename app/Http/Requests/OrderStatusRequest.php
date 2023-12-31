<?php

namespace App\Http\Requests;

use OpenApi\Annotations as OA;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * @OA\Schema(
 *      title="OrderStatusRequest",
 *      description="create order status data",
 *      type="object",
 *      required={"title"}
 * )
 */
class OrderStatusRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="title",
     *      description="title",
     *      example="open"
     * )
     */
    public string $title;

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
            'title' => 'required|string|unique:order_statuses|max:255',
        ];
    }
}
