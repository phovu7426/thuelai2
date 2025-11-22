<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'link',
        'button_text',
        'status',
        'is_announcement',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_announcement' => 'boolean',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }
        // If image looks like a full URL, return as-is; otherwise use asset helper
        if (preg_match('/^https?:\/\//i', $this->image)) {
            return $this->image;
        }
        return asset('storage/' . ltrim($this->image, '/'));
    }
}


