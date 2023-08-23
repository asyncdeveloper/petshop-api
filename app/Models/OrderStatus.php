<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

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

    protected $fillable = ['title'];
}
