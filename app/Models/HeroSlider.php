<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlider extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'background_image', 'logo_image',
        'button_text', 'button_url', 'stats', 'order',
        'is_active', 'type', 'divisi_name'
    ];

    protected $casts = [
        'stats' => 'array',
        'is_active' => 'boolean',
    ];
}