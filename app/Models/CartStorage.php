<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartStorage extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'cart_data'
    ];

    public $incrementing = false;
    protected $keyType = 'string';
} 