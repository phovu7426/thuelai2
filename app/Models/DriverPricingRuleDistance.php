<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverPricingRuleDistance extends Model
{
    protected $fillable = [
        'pricing_rule_id', 'distance_tier_id', 'price', 'price_text'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function pricingRule()
    {
        return $this->belongsTo(DriverPricingRule::class, 'pricing_rule_id');
    }

    public function distanceTier()
    {
        return $this->belongsTo(DriverDistanceTier::class, 'distance_tier_id');
    }

    public function getDisplayPriceAttribute()
    {
        if ($this->price_text) {
            return $this->price_text;
        }
        return $this->price ? number_format($this->price / 1000, 0) . 'k' : '';
    }
}

