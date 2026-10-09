<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'kategori',
        'kontributor',
        'no_anggota',
        'published_at',
        'title',
        'content',
        'image',
        'views',
        'is_active',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
        'rejection_note',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'approved_at'  => 'datetime',
        'is_active'    => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending'  => 'Menunggu Verifikasi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default    => $this->status,
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            'pending'  => 'badge-regular',
            'approved' => 'badge-active',
            'rejected' => 'badge-inactive',
            default    => 'badge-regular',
        };
    }
}