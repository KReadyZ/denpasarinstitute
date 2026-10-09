<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisiSection extends Model
{
    protected $fillable = [
        'divisi_id',
        'section_name',
        'content',
        'image',
        'urutan',
        'design_style',
        'position_after',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc');
    }

    public function getDesignClassAttribute()
    {
        $map = [
            'light' => 'section-light',
            'dark' => 'section-dark',
            'accent' => 'section-accent',
        ];
        return $map[$this->design_style] ?? 'section-light';
    }
}