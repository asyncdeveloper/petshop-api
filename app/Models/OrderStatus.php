<?php

namespace App\Models;

use App\Traits\UUID;
use App\Traits\Filterable;
use OpenApi\Annotations as OA;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     description="OrderStatus model",
 *     type="object",
 *     title="OrderStatus"
 * )
 */
class OrderStatus extends Model
{
    /**
     * @OA\Property(property="id", type="string", example="1")
     * @OA\Property(property="uuid", type="string", example="550e8400-e29b-41d4-a716-446655440000")
     * @OA\Property(property="title", type="string", example="open")
     * @OA\Property(property="created_at", type="string", format="datetime")
     * @OA\Property(property="updated_at", type="string", format="datetime")
     */

    use HasFactory;
    use UUID;
    use Filterable;

    protected $fillable = ['title'];

    public function scopeFilter($query): Builder
    {
        return $this->apply($query);
    }
}
