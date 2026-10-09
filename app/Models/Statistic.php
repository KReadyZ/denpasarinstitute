<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $fillable = [
        'icon',
        'number',
        'label',
        'trend_percentage',
        'trend_direction',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active'         => 'boolean',
        'number'            => 'integer',
        'trend_percentage'  => 'integer',
        'order'             => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}