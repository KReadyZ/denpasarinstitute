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

    public function getBackgroundImageUrlAttribute(): ?string
    {
        if (empty($this->background_image)) {
            return null;
        }
        if (str_starts_with($this->background_image, 'http://') || str_starts_with($this->background_image, 'https://')) {
            return $this->background_image;
        }
        if (str_starts_with($this->background_image, 'image/')) {
            return asset($this->background_image);
        }
        return asset('storage/' . ltrim($this->background_image, '/'));
    }

    public function getLogoImageUrlAttribute(): ?string
    {
        if (empty($this->logo_image)) {
            return null;
        }
        if (str_starts_with($this->logo_image, 'http://') || str_starts_with($this->logo_image, 'https://')) {
            return $this->logo_image;
        }
        if (str_starts_with($this->logo_image, 'image/')) {
            return asset($this->logo_image);
        }
        return asset('storage/' . ltrim($this->logo_image, '/'));
    }
}