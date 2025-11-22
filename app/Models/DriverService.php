<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverService extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'image',
        'icon',
        'price_per_hour',
        'price_per_trip',
        'is_featured',
        'status',
        'sort_order'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'price_per_hour' => 'decimal:0',
        'price_per_trip' => 'decimal:0',
        'status' => 'boolean'
    ];



    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default/default_image.png');
    }

    public function getIconUrlAttribute()
    {
        if ($this->icon) {
            return asset('storage/' . $this->icon);
        }
        return asset('images/default/default_image.png');
    }
}
