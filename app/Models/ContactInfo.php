<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    protected $table = 'contact_infos';

    protected $fillable = [
        'address',
        'phone',
        'email',
        'working_time',
        'facebook',
        'instagram',
        'youtube',
        'linkedin',
        'map_embed',
        'pricing_background_image'
    ];
}

