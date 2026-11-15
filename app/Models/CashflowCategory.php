<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashflowCategory extends Model
{
    use HasFactory;

    protected $table = 'cashflow_categories';

    protected $fillable = [
        'tipe',
        'kode',
        'nama',
        'deskripsi',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan'    => 'integer',
    ];

    /**
     * Scope Kategori Pemasukan
     */
    public function scopeMasuk($query)
    {
        return $query->where('tipe', 'masuk');
    }

    /**
     * Scope Kategori Pengeluaran
     */
    public function scopeKeluar($query)
    {
        return $query->where('tipe', 'keluar');
    }

    /**
     * Scope Kategori Aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Relasi ke transaksi kas
     */
    public function cashflows()
    {
        return $this->hasMany(Cashflow::class, 'kode_kategori', 'kode');
    }

    /**
     * Ambil seluruh kategori aktif dikelompokkan berdasarkan tipe
     * Format: ['masuk' => ['KM-ADM' => 'Pendaftaran Siswa...'], 'keluar' => [...]]
     */
    public static function getGroupedOptions(): array
    {
        $categories = self::active()->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();

        $grouped = [
            'masuk'  => [],
            'keluar' => [],
        ];

        foreach ($categories as $cat) {
            $grouped[$cat->tipe][$cat->kode] = $cat->nama;
        }

        return $grouped;
    }
}

