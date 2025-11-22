<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_name',
        'customer_title',
        'title',
        'customer_email',
        'customer_phone',
        'content',
        'image',
        'rating',
        'is_featured',
        'status',
        'sort_order',
        'review_token',
        'reviewed_at',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_featured' => 'boolean',
        'status' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default/default_image.png');
    }
}
