<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'page_url',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 