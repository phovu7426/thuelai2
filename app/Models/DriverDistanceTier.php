<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverDistanceTier extends Model
{
    protected $fillable = [
        'name',
        'description',
        'from_distance',
        'to_distance',
        'display_text',
        'is_active',
        'sort_order',
        'color',
        'icon'
    ];

    protected $casts = [
        'from_distance' => 'decimal:2',
        'to_distance' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function getDistanceRangeAttribute()
    {
        if ($this->to_distance === null) {
            return "Từ {$this->from_distance}km trở lên";
        }
        return "Từ {$this->from_distance}km đến {$this->to_distance}km";
    }
}
