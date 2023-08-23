<?php

namespace App\Models;

use App\Traits\UUID;
use OpenApi\Annotations as OA;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @OA\Schema(
 *     description="User model",
 *     type="object",
 *     title="User"
 * )
 */
class User extends Authenticatable implements JWTSubject
{
    /**
     * @OA\Property(property="id", type="string", example="1")
     * @OA\Property(property="uuid", type="string", example="550e8400-e29b-41d4-a716-446655440000")
     * @OA\Property(property="first_name", type="string", example="Oluwaseyi")
     * @OA\Property(property="last_name", type="string", example="Adeogun")
     * @OA\Property(property="is_admin", type="boolean", example=false)
     * @OA\Property(property="email", type="string", example="contact@asyncdeveloper.com")
     * @OA\Property(property="email_verified_at", type="string", format="datetime")
     * @OA\Property(property="avatar", type="string", example="https://placehold.co/600x400/png")
     * @OA\Property(property="address", type="string", example="Lagos,Nigeria")
     * @OA\Property(property="phone_number", type="string", example="08165551288")
     * @OA\Property(property="is_marketing", type="boolean", example=false)
     * @OA\Property(property="created_at", type="string", format="datetime")
     * @OA\Property(property="updated_at", type="string", format="datetime")
     * @OA\Property(property="last_login_at", type="string", format="datetime")
     */

    use HasFactory;
    use Notifiable;
    use UUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'avatar',
        'address',
        'phone_number',
        'is_marketing',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array<string, string>
     */
    public function getJWTCustomClaims(): array
    {
        return [
            'user_uuid' => $this->uuid,
        ];
    }
}
