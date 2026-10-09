<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BursaSdm extends Model
{
    protected $fillable = [
        'tipe', 'nama', 'slug', 'kategori', 'deskripsi', 'foto',
        'email', 'no_wa', 'alamat', 'website',
        'bidang_usaha', 'keahlian', 'posisi_dicari',
        'status', 'is_active',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = Str::slug($model->nama) . '-' . Str::random(5);
        });
    }

    public function scopePublik($query)
    {
        return $query->where('status', 'approved')->where('is_active', true);
    }

    public function scopePerusahaan($query)
    {
        return $query->where('tipe', 'perusahaan');
    }

    public function scopeIndividu($query)
    {
        return $query->where('tipe', 'individu');
    }
}