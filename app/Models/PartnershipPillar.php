<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnershipPillar extends Model
{
    protected $fillable = [
        'number',
        'title',
        'slug',
        'subtitle',
        'badge',
        'hero_title',
        'hero_sub',
        'tag',
        'icon',
        'description',
        'image',
        'detail_image',
        'image_tag',
        'image_sub',
        'intro',
        'services',
        'highlights',
        'cta_title',
        'cta_sub',
        'wa_text',
        'wa_btn',
        'link_url',
        'link_text',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'order'      => 'integer',
        'services'   => 'array',
        'highlights' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order', 'asc');
    }
}
