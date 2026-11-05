<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnershipPillar extends Model
{
    protected $fillable = [
        'number',
        'title',
        'tag',
        'icon',
        'description',
        'image',
        'link_url',
        'link_text',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order', 'asc');
    }
}

