<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'kode',
        'nama_proyek',
        'nama_peserta',
        'pic',
        'program_id',
        'divisi_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'nilai_proyek',
        'status',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'nilai_proyek'    => 'decimal:2',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function cashflows()
    {
        return $this->hasMany(Cashflow::class, 'project_id');
    }

    public function getPemasukanAttribute(): float
    {
        return (float) $this->cashflows()->where('tipe', 'masuk')->sum('nominal');
    }

    public function getPengeluaranAttribute(): float
    {
        return (float) $this->cashflows()->where('tipe', 'keluar')->sum('nominal');
    }

    public function getSisaTagihanAttribute(): float
    {
        return max(0.0, (float) $this->nilai_proyek - $this->pemasukan);
    }

    public function getLabaBersihAttribute(): float
    {
        return (float) $this->pemasukan;
    }

    public function getPersenTerbayarAttribute(): float
    {
        $nilai = (float) $this->nilai_proyek;
        if ($nilai <= 0) return 100.0;
        return min(100.0, round(($this->pemasukan / $nilai) * 100, 1));
    }

    public function getPersenSisaAttribute(): float
    {
        return max(0.0, round(100.0 - $this->persen_terbayar, 1));
    }

    public function getPersenBiayaAttribute(): float
    {
        $nilai = (float) $this->nilai_proyek;
        if ($nilai <= 0) return 0.0;
        return round(($this->pengeluaran / $nilai) * 100, 1);
    }

    public function getMarginProfitAttribute(): float
    {
        $masuk = $this->pemasukan;
        if ($masuk <= 0) return 0.0;
        return round(($this->laba_bersih / $masuk) * 100, 1);
    }

    public function isLunas(): bool
    {
        return $this->sisa_tagihan <= 0;
    }

    public static function generateKode(): string
    {
        $ym = Carbon::now()->format('ym');
        $prefix = "KRS-{$ym}";
        $count = self::where('kode', 'like', "{$prefix}-%")->count() + 1;
        $seq = str_pad($count, 3, '0', STR_PAD_LEFT);
        $kode = "{$prefix}-{$seq}";

        while (self::where('kode', $kode)->exists()) {
            $count++;
            $seq = str_pad($count, 3, '0', STR_PAD_LEFT);
            $kode = "{$prefix}-{$seq}";
        }

        return $kode;
    }
}

