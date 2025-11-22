<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverPricingTier extends Model
{
    protected $fillable = [
        'time_slot',
        'time_icon',
        'time_color',
        'from_distance',
        'to_distance',
        'price',
        'price_type',
        'description',
        'is_active',
        'sort_order'
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

    public function scopeByTimeSlot($query, $timeSlot)
    {
        return $query->where('time_slot', $timeSlot);
    }

    public function scopeByDistance($query, $distance)
    {
        return $query->where('from_distance', '<=', $distance)
            ->where(function ($q) use ($distance) {
                $q->where('to_distance', '>=', $distance)
                    ->orWhereNull('to_distance');
            });
    }

    // Helper method để lấy mô tả khoảng cách
    public function getDistanceDescriptionAttribute()
    {
        if ($this->to_distance) {
            return "{$this->from_distance} - {$this->to_distance}km";
        } else {
            return "Từ {$this->from_distance}km trở lên";
        }
    }

    // Helper method để lấy giá hiển thị
    public function getDisplayPriceAttribute()
    {
        if ($this->price_type === 'fixed') {
            return number_format($this->price) . 'đ';
        } else {
            return number_format($this->price) . 'đ/km';
        }
    }
}
