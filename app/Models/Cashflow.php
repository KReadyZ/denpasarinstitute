<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cashflow extends Model
{
    use HasFactory;

    protected $table = 'cashflows';

    protected $fillable = [
        'kode',
        'judul',
        'tipe',
        'kode_kategori',
        'kategori',
        'program_id',
        'project_id',
        'satuan',
        'volume',
        'harga_satuan',
        'nominal',
        'total_tagihan',
        'sisa_piutang',
        'tanggal',
        'jatuh_tempo',
        'deskripsi',
        'catatan_pelunasan',
        'nama_pihak',
        'metode_pembayaran',
        'status',
        'lampiran',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jatuh_tempo' => 'date',
        'volume' => 'decimal:2',
        'harga_satuan' => 'decimal:2',
        'nominal' => 'decimal:2',
        'total_tagihan' => 'decimal:2',
        'sisa_piutang' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public static function getSatuanOptions(): array
    {
        return [
            'orang',
            'unit',
            'hari',
            'paket',
            'jam',
            'sesi',
            'bulan',
            'lembar',
            'kegiatan',
            'batch',
            'pax',
            'item',
        ];
    }

    public function isLunas(): bool
    {
        return $this->status === 'lunas' || (float) $this->sisa_piutang <= 0;
    }

    public function isDp(): bool
    {
        return $this->status === 'dp' || (float) $this->sisa_piutang > 0;
    }

    public function getFormattedTotalTagihanAttribute(): string
    {
        $val = $this->total_tagihan ?? ($this->nominal + $this->sisa_piutang);
        return number_format((float) $val, 0, ',', '.');
    }

    public function getFormattedSisaPiutangAttribute(): string
    {
        return number_format((float) ($this->sisa_piutang ?? 0), 0, ',', '.');
    }

    /**
     * Relasi ke Program Denpasar Institute (opsional)
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    /**
     * Relasi ke User pembuat catatan
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope Pemasukan
     */
    public function scopeMasuk($query)
    {
        return $query->where('tipe', 'masuk');
    }

    /**
     * Scope Pengeluaran
     */
    public function scopeKeluar($query)
    {
        return $query->where('tipe', 'keluar');
    }

    /**
     * Format nominal ber-titik ribuan (Contoh: 1.500.000)
     */
    public function getFormattedNominalAttribute(): string
    {
        return number_format((float) $this->nominal, 0, ',', '.');
    }

    /**
     * Label Tipe
     */
    public function getTipeLabelAttribute(): string
    {
        return $this->tipe === 'masuk' ? 'Uang Masuk (Pemasukan)' : 'Uang Keluar (Pengeluaran)';
    }

    /**
     * Pilihan Kategori & Kode Resmi Denpasar Institute (Dinamis dari Database)
     */
    public static function getKategoriOptions(): array
    {
        try {
            $fromDb = CashflowCategory::getGroupedOptions();
            if (!empty($fromDb['masuk']) || !empty($fromDb['keluar'])) {
                return $fromDb;
            }
        } catch (\Throwable $e) {
            // Fallback jika tabel belum termigrasi
        }

        return [
            'masuk' => [
                'KM-ADM' => 'Pendaftaran Siswa / Mahasiswa Baru (Admission)',
                'KM-PLT' => 'Biaya Pelatihan, Workshop & Masterclass',
                'KM-SRT' => 'Uji Kompetensi & Sertifikasi BNSP / Profesi',
                'KM-KNS' => 'Layanan Konsultasi & Riset Lembaga',
                'KM-PUB' => 'Penerbitan Buku Ber-ISBN, ISSN & Jurnal',
                'KM-MTR' => 'Kemitraan, Kerja Sama & Sponsorship Industri',
                'KM-BRS' => 'Biaya Pasang Lowongan Bursa SDM Perusahaan',
                'KM-SWF' => 'Sewa Laboratorium, Ruang Kelas & Aula Diklat',
                'KM-LLN' => 'Pemasukan Lain-lain',
            ],
            'keluar' => [
                'KK-GJI' => 'Gaji & Honorarium Pegawai / Dosen / Narasumber',
                'KK-OPS' => 'Operasional Kantor, Listrik (PLN), Air & Kebersihan',
                'KK-IT'  => 'Langganan Internet, Server, Cloud & Software',
                'KK-LOG' => 'Konsumsi & Logistik Acara / Pelatihan / Rapat',
                'KK-MOD' => 'Pengadaan Buku, Modul Ajar & Perlengkapan Riset',
                'KK-MNT' => 'Pemeliharaan Gedung, AC & Sarana Prasarana',
                'KK-MKT' => 'Biaya Pemasaran, Iklan Sosial Media & Brosur',
                'KK-LEG' => 'Biaya Notaris, Pajak & Legalitas Kelembagaan',
                'KK-LLN' => 'Pengeluaran Lain-lain',
            ],
        ];
    }

    /**
     * Pilihan Metode Pembayaran
     */
    public static function getMetodePembayaranOptions(): array
    {
        return [
            'Transfer Bank (BCA / Mandiri / BNI / BRI)',
            'Tunai (Cash)',
            'QRIS / E-Wallet',
            'Virtual Account',
            'Giro / Cek',
        ];
    }

    /**
     * Generate Kode Transaksi Otomatis Unik
     */
    public static function generateKode(string $tipe, ?string $kodeKategori = null): string
    {
        $prefix = $tipe === 'masuk' ? 'KM' : 'KK';
        if ($kodeKategori) {
            $prefix = strtoupper(trim($kodeKategori));
        }

        $ym = Carbon::now()->format('ym'); // misal 2611
        $count = self::where('kode', 'like', "{$prefix}-{$ym}-%")->count() + 1;
        $seq = str_pad($count, 3, '0', STR_PAD_LEFT);

        $kode = "{$prefix}-{$ym}-{$seq}";
        while (self::where('kode', $kode)->exists()) {
            $count++;
            $seq = str_pad($count, 3, '0', STR_PAD_LEFT);
            $kode = "{$prefix}-{$ym}-{$seq}";
        }

        return $kode;
    }
}

