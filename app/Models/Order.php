<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
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
