<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $table = 'admissions';
    
    protected $fillable = [
        'nama_lengkap',
        'hp_wa',
        'email',
        'special_request',
        'bukti_bayar_pendaftaran',
        'bukti_bayar_program',
        'sumber_informasi',
        'status',
        'catatan_admin',
        'approved_at',
    ];

    protected $casts = [
        'sumber_informasi' => 'collection',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'admission_program', 'admission_id', 'program_id');
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

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Unknown',
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => '<span class="badge badge-warning">Menunggu</span>',
            'approved' => '<span class="badge badge-success">Disetujui</span>',
            'rejected' => '<span class="badge badge-danger">Ditolak</span>',
            default => '<span class="badge badge-secondary">Unknown</span>',
        };
    }
}