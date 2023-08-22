<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use UUID;

    protected $casts = [
        'products' => 'json',
        'address' => 'json'
    ];

    protected $guarded = [];
}
