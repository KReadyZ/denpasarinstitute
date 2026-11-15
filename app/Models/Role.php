<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'badge_color',
        'icon',
        'is_system',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    /**
     * Relasi ke pengguna dengan role ini
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role', 'slug');
    }

    /**
     * Scope untuk role internal (staf institusi)
     */
    public function scopeInternal($query)
    {
        return $query->where('category', 'internal');
    }

    /**
     * Scope untuk role aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

