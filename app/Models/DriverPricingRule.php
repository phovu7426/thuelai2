<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverPricingRule extends Model
{
    protected $fillable = [
        'time_slot', 'time_icon', 'time_color', 'is_active', 'sort_order'
    ];

    protected $casts = [
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

    public function pricingDistances()
    {
        return $this->hasMany(DriverPricingRuleDistance::class, 'pricing_rule_id');
    }

    public function distanceTiers()
    {
        return $this->belongsToMany(DriverDistanceTier::class, 'driver_pricing_rule_distances')
                    ->withPivot('price', 'price_text')
                    ->withTimestamps();
    }
}
