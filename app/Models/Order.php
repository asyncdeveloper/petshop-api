<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     description="Order model",
 *     type="object",
 *     title="Order"
 * )
 */
class Order extends Model
{
    /**
     * @OA\Property(property="id", type="string", example="1")
     * @OA\Property(property="uuid", type="string", example="550e8400-e29b-41d4-a716-446655440000")
     * @OA\Property(property="user_id", type="string", example="1")
     * @OA\Property(property="order_status_id", type="string", example="1")
     * @OA\Property(property="products", type="json")
     * @OA\Property(property="address", type="json")
     * @OA\Property(property="delivery_fee", type="number")
     * @OA\Property(property="json", type="number")
     * @OA\Property(property="created_at", type="string", format="datetime")
     * @OA\Property(property="updated_at", type="string", format="datetime")
     * @OA\Property(property="shipped_at", type="string", format="datetime")
     */

    use HasFactory;
    use UUID;
    use Filterable;

    protected $casts = [
        'products' => 'json',
        'address' => 'json'
    ];

    protected $guarded = [];

    public function scopeFilter($query): Builder
    {
        return $this->apply($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}
