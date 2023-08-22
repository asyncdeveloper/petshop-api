<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            'order_status_id' => $this->order_status_id,
            "payment_id" => $this->payment_id,
            "uuid" => $this->uuid,
            "products" => $this->products,
            "address" => $this->address,
            "delivery_fee" => $this->delivery_fee,
            "amount" => $this->amount,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "shipped_at" => $this->shipped_at,
            "user" => $this->whenLoaded('user'),
            "order_status" => $this->whenLoaded('orderStatus'),
            "payment" => $this->whenLoaded('payment'),
        ];
    }
}
