<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnershipSubmission extends Model
{
    use HasFactory;

    protected $table = 'partnership_submissions';

    protected $fillable = [
        'pillar_slug',
        'pillar_title',
        'nama_pic',
        'institusi',
        'kategori',
        'email',
        'no_wa',
        'link_gmap',
        'website',
        'logo',
        'pesan',
        'status',
        'urutan',
        'verified_at',
        'verified_by',
        'admin_notes',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'urutan'      => 'integer',
    ];

    /**
     * Scope untuk mitra & klien yang sudah disetujui/diverifikasi
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope untuk pengajuan yang masih menunggu verifikasi
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk pengajuan yang ditolak
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Cek apakah status sudah approved
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Helper URL logo atau fallback
     */
    public function getLogoUrlAttribute(): ?string
    {
        if ($this->logo && file_exists(public_path($this->logo))) {
            return asset($this->logo);
        }
        return null;
    }
}
