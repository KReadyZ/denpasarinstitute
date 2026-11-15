<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Cashflow;
use App\Models\Program;
use App\Models\Divisi;
use App\Models\Admission;
use App\Models\Project;
use App\Models\CashflowCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class CashflowController extends Controller
{
    /**
     * Tampilkan data buku kas keluar & masuk
     */
    /**
     * Tampilkan data buku kas keluar & masuk
     */
    public function index(Request $request)
    {
        $baseQuery = $this->buildBaseFilteredQuery($request);

        $selectedTipeKategori = $request->get('tipe_kategori', 'all');
        $selectedKategori = $request->get('kategori', 'all');
        $selectedDivisiId = $request->get('divisi_id', 'all');
        $selectedProgramId = $request->get('program_id', 'all');

        // Hitung Ringkasan / Rekapitulasi (Sebelum filter tipe spesifik tabel)
        $summaryQuery = clone $baseQuery;
        $totalMasukQuery = (clone $summaryQuery)->where('tipe', 'masuk');
        $totalKeluarQuery = (clone $summaryQuery)->where('tipe', 'keluar');

        $totalMasuk = (float) $totalMasukQuery->sum('nominal');
        $totalKeluar = (float) $totalKeluarQuery->sum('nominal');
        $saldoKas = $totalMasuk - $totalKeluar;

        // Data Piutang & Status Pembayaran Peserta (DP / Bertahap)
        $totalPiutang = (float) (clone $totalMasukQuery)->sum('sisa_piutang');
        $countPiutang = (clone $totalMasukQuery)->where('sisa_piutang', '>', 0)->count();
        $countLunas = (clone $totalMasukQuery)->where(function ($q) {
            $q->where('status', 'lunas')->orWhere('sisa_piutang', '<=', 0);
        })->count();
        $totalPotensiOmset = $totalMasuk + $totalPiutang;

        // Query Tabel dengan Filter Tipe (Termasuk Piutang / Foto 5):
        $query = clone $baseQuery;
        if ($request->filled('tipe')) {
            if ($request->tipe === 'piutang') {
                $query->where('tipe', 'masuk')->where(function ($q) {
                    $q->where('sisa_piutang', '>', 0)->orWhere('status', 'dp');
                });
            } elseif (in_array($request->tipe, ['masuk', 'keluar'])) {
                $query->where('tipe', $request->tipe);
            }
        } elseif ($selectedTipeKategori && in_array($selectedTipeKategori, ['masuk', 'keluar']) && (!$selectedKategori || $selectedKategori === 'all')) {
            $query->where('tipe', $selectedTipeKategori);
        }
        $countTransaksi = (clone $query)->count();

        // Hitung Analisis Persentase Sesuai Aliran Kas & Piutang
        $persenMasuk = $totalPotensiOmset > 0 ? round(($totalMasuk / $totalPotensiOmset) * 100, 1) : 100.0;
        $persenPiutang = $totalPotensiOmset > 0 ? round(($totalPiutang / $totalPotensiOmset) * 100, 1) : 0.0;
        $persenKeluar = $totalMasuk > 0 ? round(($totalKeluar / $totalMasuk) * 100, 1) : 0.0;
        $persenKas = $totalMasuk > 0 ? round(($saldoKas / $totalMasuk) * 100, 1) : 0.0;

        // Hitung Analisis Persentase Untung & Rugi
        $statusUntungRugi = 'impas';
        $persenUntungRugi = 0.0;
        $persenBebanKeluar = 0.0;
        $totalVolume = $totalMasuk + $totalKeluar;
        $porsiMasuk = $totalVolume > 0 ? round(($totalMasuk / $totalVolume) * 100, 1) : 0.0;
        $porsiKeluar = $totalVolume > 0 ? round(($totalKeluar / $totalVolume) * 100, 1) : 0.0;

        if ($totalMasuk > 0) {
            $persenUntungRugi = round(($saldoKas / $totalMasuk) * 100, 1);
            $persenBebanKeluar = round(($totalKeluar / $totalMasuk) * 100, 1);
            if ($saldoKas > 0) {
                $statusUntungRugi = 'untung';
            } elseif ($saldoKas < 0) {
                $statusUntungRugi = 'rugi';
            }
        } elseif ($totalKeluar > 0) {
            $statusUntungRugi = 'rugi';
            $persenUntungRugi = -100.0;
            $persenBebanKeluar = 100.0;
        }

        // 10. Sorting
        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'terlama':
                $query->orderBy('tanggal', 'asc')->orderBy('id', 'asc');
                break;
            case 'nominal_desc':
                $query->orderBy('nominal', 'desc');
                break;
            case 'nominal_asc':
                $query->orderBy('nominal', 'asc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('tanggal', 'desc')->orderBy('id', 'desc');
                break;
        }

        $cashflows = $query->paginate(15)->withQueryString();

        // Dropdown Pilihan Kategori & Metode
        $kategoriOptions = Cashflow::getKategoriOptions();
        $metodeOptions = Cashflow::getMetodePembayaranOptions();
        $programs = Program::with('divisi')->orderBy('nama')->get();

        // Rekapitulasi Kas Masuk & Piutang per Program Denpasar Institute
        $rekapPerProgram = Program::with('divisi')
            ->withCount(['cashflows as total_pendaftar' => function ($q) {
                $q->where('tipe', 'masuk');
            }])
            ->withSum(['cashflows as total_nominal' => function ($q) {
                $q->where('tipe', 'masuk');
            }], 'nominal')
            ->withSum(['cashflows as total_piutang' => function ($q) {
                $q->where('tipe', 'masuk');
            }], 'sisa_piutang')
            ->orderByDesc('total_nominal')
            ->get();

        $divisiList = Divisi::with('programs')->orderBy('nama')->get();

        // Daftar Tahun Tersedia (dari database + tahun saat ini)
        $minYear = Cashflow::min('tanggal') ? Carbon::parse(Cashflow::min('tanggal'))->year : Carbon::now()->year;
        $maxYear = Carbon::now()->addYear()->year;
        $yearOptions = range(max(2022, $minYear), $maxYear);
        rsort($yearOptions);

        $monthNames = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $satuanOptions = Cashflow::getSatuanOptions();

        // Hitung Akumulasi per Kategori Program DI (Sesuai Foto 3 untuk diletakkan di paling bawah Keuangan Umum)
        $divisiActive = Divisi::with(['programs' => function ($q) {
            $q->where('is_active', true)->orderBy('nama');
        }])->where('is_active', true)->orderBy('id')->get();

        $divisiSummaries = [];
        $totalAkumulasiMasuk = 0.0;
        $totalAkumulasiKeluar = 0.0;
        $totalAkumulasiTransaksi = 0;

        foreach ($divisiActive as $d) {
            $progIds = $d->programs->pluck('id')->toArray();
            $projIds = Project::where('divisi_id', $d->id)
                ->orWhereIn('program_id', $progIds)
                ->pluck('id')->toArray();

            $cfCat = Cashflow::where(function ($q) use ($progIds, $projIds) {
                $q->whereIn('program_id', $progIds)
                  ->orWhereIn('project_id', $projIds);
            })->get();

            $inCat = (float) $cfCat->where('tipe', 'masuk')->sum('nominal');
            $outCat = (float) $cfCat->where('tipe', 'keluar')->sum('nominal');
            $saldoCat = $inCat - $outCat;
            $countCat = $cfCat->count();
            $marginCat = $inCat > 0 ? round(($saldoCat / $inCat) * 100, 1) : 0.0;

            $divisiSummaries[] = [
                'divisi'          => $d,
                'programs'        => $d->programs,
                'programs_count'  => $d->programs->count(),
                'pemasukan'       => $inCat,
                'pengeluaran'     => $outCat,
                'saldo'           => $saldoCat,
                'margin'          => $marginCat,
                'transaksi_count' => $countCat,
            ];

            $totalAkumulasiMasuk += $inCat;
            $totalAkumulasiKeluar += $outCat;
            $totalAkumulasiTransaksi += $countCat;
        }

        // Akumulasi untuk Umum (Operasional Non-Program)
        $cfUmum = Cashflow::whereNull('program_id')->whereNull('project_id')->get();
        $inUmum = (float) $cfUmum->where('tipe', 'masuk')->sum('nominal');
        $outUmum = (float) $cfUmum->where('tipe', 'keluar')->sum('nominal');
        $saldoUmum = $inUmum - $outUmum;
        $countUmum = $cfUmum->count();
        $marginUmum = $inUmum > 0 ? round(($saldoUmum / $inUmum) * 100, 1) : 0.0;

        $umumSummary = [
            'nama'            => 'Umum (Operasional Non-Program)',
            'pemasukan'       => $inUmum,
            'pengeluaran'     => $outUmum,
            'saldo'           => $saldoUmum,
            'margin'          => $marginUmum,
            'transaksi_count' => $countUmum,
        ];

        $totalAkumulasiMasuk += $inUmum;
        $totalAkumulasiKeluar += $outUmum;
        $totalAkumulasiTransaksi += $countUmum;
        $totalAkumulasiSaldo = $totalAkumulasiMasuk - $totalAkumulasiKeluar;

        return view('backoffice.cashflow.index', compact(
            'cashflows',
            'totalMasuk',
            'totalKeluar',
            'saldoKas',
            'totalVolume',
            'countTransaksi',
            'totalPiutang',
            'countPiutang',
            'countLunas',
            'totalPotensiOmset',
            'statusUntungRugi',
            'persenUntungRugi',
            'persenBebanKeluar',
            'porsiMasuk',
            'porsiKeluar',
            'persenMasuk',
            'persenPiutang',
            'persenKeluar',
            'persenKas',
            'kategoriOptions',
            'selectedTipeKategori',
            'selectedKategori',
            'metodeOptions',
            'satuanOptions',
            'programs',
            'rekapPerProgram',
            'divisiList',
            'selectedDivisiId',
            'selectedProgramId',
            'yearOptions',
            'monthNames',
            'divisiSummaries',
            'umumSummary',
            'totalAkumulasiMasuk',
            'totalAkumulasiKeluar',
            'totalAkumulasiSaldo',
            'totalAkumulasiTransaksi'
        ));
    }

    /**
     * Helper privat untuk query filtering bersama (digunakan di index & exportCsv)
     */
    private function buildBaseFilteredQuery(Request $request)
    {
        $baseQuery = Cashflow::with(['creator', 'program.divisi', 'project']);

        // 1. Filter Kategori (Mendukung Cascading: Tipe Kategori -> Rincian Kategori)
        $selectedTipeKategori = $request->get('tipe_kategori', 'all');
        $selectedKategori = $request->get('kategori', 'all');

        if ($selectedKategori && $selectedKategori !== 'all' && ($selectedTipeKategori === 'all' || !$request->filled('tipe_kategori'))) {
            $allKategoriOptions = Cashflow::getKategoriOptions();
            if (in_array($selectedKategori, $allKategoriOptions['masuk'] ?? [])) {
                $selectedTipeKategori = 'masuk';
            } elseif (in_array($selectedKategori, $allKategoriOptions['keluar'] ?? [])) {
                $selectedTipeKategori = 'keluar';
            }
        }

        if ($selectedKategori && $selectedKategori !== 'all') {
            $baseQuery->where('kategori', $selectedKategori);
        }

        // 2. Filter Divisi & Program Terkait (Fokus Program Denpasar Institute)
        $selectedDivisiId = $request->get('divisi_id', 'all');
        $selectedProgramId = $request->get('program_id', 'all');

        if ($selectedProgramId && $selectedProgramId !== 'all' && $selectedProgramId !== 'none' && ($selectedDivisiId === 'all' || !$request->filled('divisi_id'))) {
            $matchedProg = Program::find($selectedProgramId);
            if ($matchedProg && $matchedProg->divisi_id) {
                $selectedDivisiId = (string) $matchedProg->divisi_id;
            }
        }

        if ($selectedDivisiId && $selectedDivisiId !== 'all') {
            if ($selectedDivisiId === 'none') {
                $baseQuery->whereNull('program_id');
            } else {
                $divId = (int) $selectedDivisiId;
                if (!$selectedProgramId || $selectedProgramId === 'all') {
                    $baseQuery->whereHas('program', function ($pq) use ($divId) {
                        $pq->where('divisi_id', $divId);
                    });
                }
            }
        }

        if ($selectedProgramId && $selectedProgramId !== 'all') {
            if ($selectedProgramId === 'none') {
                $baseQuery->whereNull('program_id');
            } else {
                $baseQuery->where('program_id', $selectedProgramId);
            }
        }

        // 3. Filter Status
        if ($request->filled('status') && $request->status !== 'all') {
            $baseQuery->where('status', $request->status);
        }

        // 4. Filter Kode Kategori
        if ($request->filled('kode_kategori') && $request->kode_kategori !== 'all') {
            $baseQuery->where('kode_kategori', $request->kode_kategori);
        }

        // 5. Filter Metode Pembayaran
        if ($request->filled('metode_pembayaran') && $request->metode_pembayaran !== 'all') {
            $baseQuery->where('metode_pembayaran', $request->metode_pembayaran);
        }

        // 6. Filter Pencarian Keyword (kode, judul, deskripsi, nama pihak, kategori, program, proyek)
        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $baseQuery->where(function ($q) use ($keyword) {
                $q->where('kode', 'like', "%{$keyword}%")
                  ->orWhere('judul', 'like', "%{$keyword}%")
                  ->orWhere('deskripsi', 'like', "%{$keyword}%")
                  ->orWhere('nama_pihak', 'like', "%{$keyword}%")
                  ->orWhere('kategori', 'like', "%{$keyword}%")
                  ->orWhere('kode_kategori', 'like', "%{$keyword}%")
                  ->orWhereHas('program', function ($pq) use ($keyword) {
                      $pq->where('nama', 'like', "%{$keyword}%");
                  })
                  ->orWhereHas('project', function ($pjq) use ($keyword) {
                      $pjq->where('nama_proyek', 'like', "%{$keyword}%")
                          ->orWhere('kode', 'like', "%{$keyword}%");
                  });
            });
        }

        // 7. Filter Rentang Tanggal & Periode Waktu
        $periode = $request->get('periode');

        if ($request->filled('tanggal_dari') || $request->filled('tanggal_sampai') || $request->filled('tanggal')) {
            if ($request->filled('tanggal_dari')) {
                $baseQuery->whereDate('tanggal', '>=', $request->tanggal_dari);
            }
            if ($request->filled('tanggal_sampai')) {
                $baseQuery->whereDate('tanggal', '<=', $request->tanggal_sampai);
            }
            if ($request->filled('tanggal') && !$request->filled('tanggal_dari') && !$request->filled('tanggal_sampai')) {
                $baseQuery->whereDate('tanggal', $request->tanggal);
            }
        } elseif ($periode === 'hari_ini') {
            $baseQuery->whereDate('tanggal', Carbon::today());
        } elseif ($periode === 'bulan_ini') {
            $baseQuery->whereMonth('tanggal', Carbon::now()->month)
                      ->whereYear('tanggal', Carbon::now()->year);
        } elseif ($periode === 'tahun_ini') {
            $baseQuery->whereYear('tanggal', Carbon::now()->year);
        } elseif ($periode === 'tahunan') {
            if ($request->filled('tahun') && $request->tahun !== 'all') {
                $baseQuery->whereYear('tanggal', $request->tahun);
            }
        } elseif ($periode === 'bulanan') {
            if ($request->filled('bulan_dari') && $request->filled('bulan_sampai')) {
                $bDari = (int) $request->bulan_dari;
                $bSampai = (int) $request->bulan_sampai;
                if ($bDari > 0 && $bSampai >= $bDari) {
                    $baseQuery->whereMonth('tanggal', '>=', $bDari)
                              ->whereMonth('tanggal', '<=', $bSampai);
                }
            } elseif ($request->filled('bulan') && $request->bulan !== 'all') {
                $baseQuery->whereMonth('tanggal', (int) $request->bulan);
            }
            if ($request->filled('tahun') && $request->tahun !== 'all') {
                $baseQuery->whereYear('tanggal', $request->tahun);
            }
        } elseif ($periode === 'all') {
            // Semua Periode -> Jangan batasi waktu
        } else {
            if ($request->filled('tahun') && $request->tahun !== 'all') {
                $baseQuery->whereYear('tanggal', $request->tahun);
            }
            if ($request->filled('bulan_dari') && $request->filled('bulan_sampai')) {
                $bDari = (int) $request->bulan_dari;
                $bSampai = (int) $request->bulan_sampai;
                if ($bDari > 0 && $bSampai >= $bDari) {
                    $baseQuery->whereMonth('tanggal', '>=', $bDari)
                              ->whereMonth('tanggal', '<=', $bSampai);
                }
            } elseif ($request->filled('bulan') && $request->bulan !== 'all') {
                $baseQuery->whereMonth('tanggal', (int) $request->bulan);
            }
        }

        return $baseQuery;
    }

    /**
     * Export data buku kas ke format CSV (Sesuai Foto 1)
     */
    public function exportCsv(Request $request)
    {
        $baseQuery = $this->buildBaseFilteredQuery($request);

        $query = clone $baseQuery;
        if ($request->filled('tipe')) {
            if ($request->tipe === 'piutang') {
                $query->where('tipe', 'masuk')->where(function ($q) {
                    $q->where('sisa_piutang', '>', 0)->orWhere('status', 'dp');
                });
            } elseif (in_array($request->tipe, ['masuk', 'keluar'])) {
                $query->where('tipe', $request->tipe);
            }
        }

        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'terlama':
                $query->orderBy('tanggal', 'asc')->orderBy('id', 'asc');
                break;
            case 'nominal_desc':
                $query->orderBy('nominal', 'desc');
                break;
            case 'nominal_asc':
                $query->orderBy('nominal', 'asc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('tanggal', 'desc')->orderBy('id', 'desc');
                break;
        }

        $items = $query->get();
        $filename = 'laporan_keuangan_di_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($items) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            $delimiter = ';';
            $escape = function ($value) {
                $value = (string) $value;
                return preg_match('/^[=+@\-\t\r]/', $value) ? "'" . $value : $value;
            };

            // Header baris CSV
            fputcsv($handle, [
                'No', 'Kode Transaksi', 'Tanggal', 'Tipe Kas', 'Program / Divisi',
                'Program Kursus Terkait', 'Kategori Transaksi', 'Judul / Deskripsi',
                'Pihak (Peserta / Mitra)', 'Satuan', 'Volume', 'Harga Satuan (Rp)',
                'Nominal (Rp)', 'Status Bayar', 'Total Tagihan (Rp)', 'Sisa Piutang (Rp)',
                'Metode Pembayaran', 'Dicatat Oleh',
            ], $delimiter);

            foreach ($items as $idx => $item) {
                fputcsv($handle, array_map($escape, [
                    $idx + 1,
                    $item->kode,
                    $item->tanggal ? $item->tanggal->format('Y-m-d') : '-',
                    $item->tipe === 'masuk' ? 'Pemasukan' : 'Pengeluaran',
                    $item->program ? $item->program->nama : 'Umum / Non-Program',
                    $item->project ? $item->project->nama_proyek : '-',
                    $item->kategori,
                    $item->judul ?: $item->deskripsi,
                    $item->nama_pihak ?: '-',
                    $item->satuan ?: '-',
                    $item->volume ?: 1,
                    $item->harga_satuan ?? 0,
                    $item->nominal,
                    ucfirst($item->status ?? 'lunas'),
                    $item->total_tagihan ?? 0,
                    $item->sisa_piutang ?? 0,
                    $item->metode_pembayaran ?: '-',
                    $item->creator ? $item->creator->name : '-',
                ]), $delimiter);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Tampilkan form tambah transaksi
     */
    public function create()
    {
        $kategoriOptions = Cashflow::getKategoriOptions();
        $metodeOptions = Cashflow::getMetodePembayaranOptions();
        $satuanOptions = Cashflow::getSatuanOptions();
        $programs = Program::with('divisi')->orderBy('nama')->get();
        $divisiList = Divisi::with(['programs' => fn($q) => $q->orderBy('nama')])->orderBy('nama')->get();
        $projects = Project::orderByDesc('id')->get();
        $defaultKode = Cashflow::generateKode('masuk', 'KM-ADM');

        $selectedDivisiId = old('divisi_id');
        if (!$selectedDivisiId && old('program_id')) {
            $p = $programs->firstWhere('id', old('program_id'));
            if ($p) $selectedDivisiId = $p->divisi_id;
        }

        return view('backoffice.cashflow.create', compact('kategoriOptions', 'metodeOptions', 'satuanOptions', 'programs', 'divisiList', 'projects', 'defaultKode', 'selectedDivisiId'));
    }

    /**
     * Simpan transaksi kas baru
     */
    public function store(Request $request)
    {
        // Sanitasi nominal: hilangkan format titik ribuan dan teks Rp
        $rawNominal = $this->cleanNominal($request->nominal);
        $rawHargaSatuan = $request->filled('harga_satuan') ? $this->cleanNominal($request->harga_satuan) : null;
        $volume = $request->filled('volume') ? (float) $request->volume : 1.0;
        if ($rawHargaSatuan !== null && $rawHargaSatuan > 0 && ($rawNominal <= 0 || !$request->filled('nominal'))) {
            $rawNominal = $volume * $rawHargaSatuan;
        }
        $request->merge(['nominal_clean' => $rawNominal]);

        // Auto-generate kode jika tidak diinput manual dari form
        if (!$request->filled('kode')) {
            $tipe = $request->tipe === 'keluar' ? 'keluar' : 'masuk';
            $prefix = $tipe === 'masuk' ? 'KM' : 'KK';
            $kodeKategori = $prefix;
            if ($request->filled('kategori')) {
                $cat = CashflowCategory::where('nama', $request->kategori)->first();
                if ($cat) $kodeKategori = $cat->kode;
            }
            $request->merge([
                'kode' => Cashflow::generateKode($tipe, $kodeKategori),
                'kode_kategori' => $kodeKategori,
            ]);
        }

        // Auto-set judul dari deskripsi jika kosong (hilangkan tag HTML Summernote)
        if (!$request->filled('judul')) {
            $plainJudul = trim(strip_tags((string) $request->deskripsi));
            $request->merge([
                'judul' => !empty($plainJudul) ? \Illuminate\Support\Str::limit($plainJudul, 120, '...') : trim($request->kategori),
            ]);
        }

        $request->validate([
            'tipe'              => 'required|in:masuk,keluar',
            'kode'              => 'required|string|max:60|unique:cashflows,kode',
            'kode_kategori'     => 'nullable|string|max:30',
            'kategori'          => 'required|string|max:120',
            'judul'             => 'nullable|string|max:255',
            'program_id'        => 'nullable|exists:programs,id',
            'project_id'        => 'nullable|exists:projects,id',
            'satuan'            => 'nullable|string|max:50',
            'custom_satuan'     => 'nullable|string|max:50',
            'volume'            => 'nullable|numeric|min:0.01',
            'harga_satuan'      => 'nullable',
            'status'            => 'nullable|in:lunas,dp,pending',
            'skema_bayar'       => 'nullable|in:lunas,dp',
            'total_tagihan'     => 'nullable',
            'nominal_clean'     => 'required|numeric|min:1',
            'tanggal'           => 'required|date',
            'jatuh_tempo'       => 'nullable|date',
            'deskripsi'         => 'nullable|string',
            'nama_pihak'        => 'nullable|string|max:150',
            'metode_pembayaran' => 'nullable|string|max:60',
            'lampiran'          => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:5120',
        ], [
            'tipe.required'          => 'Pilih jenis transaksi kas (Uang Masuk / Uang Keluar).',
            'kode.required'          => 'Kode transaksi wajib diisi.',
            'kode.unique'            => 'Kode transaksi ini sudah digunakan, silakan buat kode baru.',
            'kategori.required'      => 'Kategori / jenis transaksi wajib dipilih.',
            'nominal_clean.min'      => 'Nominal transaksi harus lebih dari 0.',
            'nominal_clean.numeric'  => 'Format nominal tidak valid.',
            'tanggal.required'       => 'Tanggal transaksi wajib diisi.',
            'lampiran.max'           => 'Ukuran file lampiran maksimal 5MB.',
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $dir = public_path('image/kas');
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true, true);
            }
            $file = $request->file('lampiran');
            $filename = 'kas_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $lampiranPath = 'image/kas/' . $filename;
        }

        // Resolusi satuan (custom atau preset)
        $satuan = $request->satuan;
        if ($satuan === '__custom__' && $request->filled('custom_satuan')) {
            $satuan = trim($request->custom_satuan);
        }

        // Hitung Skema Pembayaran: Lunas vs DP (Piutang)
        $nominalDibayar = (float) $rawNominal;
        $isDp = $request->get('skema_bayar') === 'dp' || $request->get('status') === 'dp';

        if ($isDp && $request->tipe === 'masuk') {
            $rawTagihan = $request->filled('total_tagihan') ? (float) $this->cleanNominal($request->total_tagihan) : $nominalDibayar;
            $totalTagihan = max($rawTagihan, $nominalDibayar);
            $sisaPiutang = max(0.0, $totalTagihan - $nominalDibayar);
            $status = ($sisaPiutang > 0) ? 'dp' : 'lunas';
            $jatuhTempo = $request->jatuh_tempo;
        } else {
            $totalTagihan = $nominalDibayar;
            $sisaPiutang = 0.0;
            $status = $request->status ?? 'lunas';
            $jatuhTempo = null;
        }

        $programId = $request->filled('program_id') ? (int) $request->program_id : null;
        $projectId = $request->filled('project_id') ? (int) $request->project_id : null;

        // Jika user memilih program namun project_id belum terisi, otomatis hubungkan ke Program Kursus terkait
        if ($programId && !$projectId) {
            $project = Project::where('program_id', $programId)->first();
            if (!$project) {
                $prog = Program::find($programId);
                if ($prog) {
                    $project = Project::create([
                        'kode'          => Project::generateKode(),
                        'nama_proyek'   => 'Kelas ' . $prog->nama,
                        'nama_peserta'  => $request->nama_pihak ?: 'Peserta ' . $prog->nama,
                        'pic'           => auth()->user()->name ?? 'Tim Pengajar DI',
                        'program_id'    => $prog->id,
                        'divisi_id'     => $prog->divisi_id,
                        'tanggal_mulai' => $request->tanggal ?: now(),
                        'nilai_proyek'  => $nominalDibayar ?: 0,
                        'status'        => 'aktif',
                        'created_by'    => auth()->id(),
                    ]);
                }
            }
            if ($project) {
                $projectId = $project->id;
            }
        }

        Cashflow::create([
            'kode'              => trim($request->kode),
            'tipe'              => $request->tipe,
            'kode_kategori'     => $request->kode_kategori,
            'kategori'          => trim($request->kategori),
            'judul'             => $request->filled('judul') ? trim($request->judul) : trim($request->kategori),
            'program_id'        => $programId,
            'project_id'        => $projectId,
            'satuan'            => $satuan,
            'volume'            => $volume,
            'harga_satuan'      => $rawHargaSatuan,
            'status'            => $status,
            'nominal'           => $nominalDibayar,
            'total_tagihan'     => $totalTagihan,
            'sisa_piutang'      => $sisaPiutang,
            'tanggal'           => $request->tanggal,
            'jatuh_tempo'       => $jatuhTempo,
            'deskripsi'         => $request->deskripsi,
            'nama_pihak'        => $request->nama_pihak,
            'metode_pembayaran' => $request->metode_pembayaran ?? 'Transfer Bank',
            'lampiran'          => $lampiranPath,
            'created_by'        => auth()->id(),
        ]);

        $label = $request->tipe === 'masuk' ? 'Uang Masuk' : 'Uang Keluar';
        return redirect()->route('backoffice.cashflow.index')
            ->with('success', "Transaksi {$label} [{$request->kode}] berhasil dicatat.");
    }

    /**
     * Tampilkan form edit transaksi
     */
    public function edit($id)
    {
        $cashflow = Cashflow::findOrFail($id);
        $kategoriOptions = Cashflow::getKategoriOptions();
        $metodeOptions = Cashflow::getMetodePembayaranOptions();
        $satuanOptions = Cashflow::getSatuanOptions();
        $programs = Program::with('divisi')->orderBy('nama')->get();
        $divisiList = Divisi::with(['programs' => fn($q) => $q->orderBy('nama')])->orderBy('nama')->get();
        $projects = Project::orderByDesc('id')->get();

        $selectedDivisiId = old('divisi_id', $cashflow->program ? $cashflow->program->divisi_id : null);
        if (!$selectedDivisiId && old('program_id')) {
            $p = $programs->firstWhere('id', old('program_id'));
            if ($p) $selectedDivisiId = $p->divisi_id;
        }

        return view('backoffice.cashflow.edit', compact('cashflow', 'kategoriOptions', 'metodeOptions', 'satuanOptions', 'programs', 'divisiList', 'projects', 'selectedDivisiId'));
    }

    /**
     * Perbarui data transaksi kas
     */
    public function update(Request $request, $id)
    {
        $cashflow = Cashflow::findOrFail($id);

        $rawNominal = $this->cleanNominal($request->nominal);
        $rawHargaSatuan = $request->filled('harga_satuan') ? $this->cleanNominal($request->harga_satuan) : null;
        $volume = $request->filled('volume') ? (float) $request->volume : 1.0;
        if ($rawHargaSatuan !== null && $rawHargaSatuan > 0 && ($rawNominal <= 0 || !$request->filled('nominal'))) {
            $rawNominal = $volume * $rawHargaSatuan;
        }
        $request->merge(['nominal_clean' => $rawNominal]);

        $request->validate([
            'tipe'              => 'required|in:masuk,keluar',
            'kode'              => 'required|string|max:60|unique:cashflows,kode,' . $cashflow->id,
            'kode_kategori'     => 'nullable|string|max:30',
            'kategori'          => 'required|string|max:120',
            'judul'             => 'nullable|string|max:255',
            'program_id'        => 'nullable|exists:programs,id',
            'project_id'        => 'nullable|exists:projects,id',
            'satuan'            => 'nullable|string|max:50',
            'custom_satuan'     => 'nullable|string|max:50',
            'volume'            => 'nullable|numeric|min:0.01',
            'harga_satuan'      => 'nullable',
            'status'            => 'nullable|in:lunas,dp,pending',
            'skema_bayar'       => 'nullable|in:lunas,dp',
            'total_tagihan'     => 'nullable',
            'sisa_piutang'      => 'nullable',
            'nominal_clean'     => 'required|numeric|min:1',
            'tanggal'           => 'required|date',
            'jatuh_tempo'       => 'nullable|date',
            'deskripsi'         => 'nullable|string',
            'nama_pihak'        => 'nullable|string|max:150',
            'metode_pembayaran' => 'nullable|string|max:60',
            'lampiran'          => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:5120',
        ]);

        $lampiranPath = $cashflow->lampiran;
        if ($request->hasFile('lampiran')) {
            // Hapus file lama jika ada
            if ($cashflow->lampiran && File::exists(public_path($cashflow->lampiran))) {
                File::delete(public_path($cashflow->lampiran));
            }

            $dir = public_path('image/kas');
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true, true);
            }
            $file = $request->file('lampiran');
            $filename = 'kas_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $lampiranPath = 'image/kas/' . $filename;
        }

        // Resolusi satuan (custom atau preset)
        $satuan = $request->satuan;
        if ($satuan === '__custom__' && $request->filled('custom_satuan')) {
            $satuan = trim($request->custom_satuan);
        }

        $nominalDibayar = (float) $rawNominal;
        $isDp = $request->get('skema_bayar') === 'dp' || $request->get('status') === 'dp';

        if ($isDp && $request->tipe === 'masuk') {
            $rawTagihan = $request->filled('total_tagihan') ? (float) $this->cleanNominal($request->total_tagihan) : (float) ($cashflow->total_tagihan ?: $nominalDibayar);
            $totalTagihan = max($rawTagihan, $nominalDibayar);
            $sisaPiutang = $request->filled('sisa_piutang') ? (float) $this->cleanNominal($request->sisa_piutang) : max(0.0, $totalTagihan - $nominalDibayar);
            $status = ($sisaPiutang > 0) ? 'dp' : 'lunas';
            $jatuhTempo = $request->jatuh_tempo ?? $cashflow->jatuh_tempo;
        } else {
            $totalTagihan = $nominalDibayar;
            $sisaPiutang = 0.0;
            $status = $request->status ?? 'lunas';
            $jatuhTempo = null;
        }

        $cashflow->update([
            'kode'              => trim($request->kode),
            'tipe'              => $request->tipe,
            'kode_kategori'     => $request->kode_kategori,
            'kategori'          => trim($request->kategori),
            'judul'             => $request->filled('judul') ? trim($request->judul) : trim($request->kategori),
            'program_id'        => $request->filled('program_id') ? $request->program_id : null,
            'project_id'        => $request->filled('project_id') ? $request->project_id : null,
            'satuan'            => $satuan,
            'volume'            => $volume,
            'harga_satuan'      => $rawHargaSatuan,
            'status'            => $status,
            'nominal'           => $nominalDibayar,
            'total_tagihan'     => $totalTagihan,
            'sisa_piutang'      => $sisaPiutang,
            'tanggal'           => $request->tanggal,
            'jatuh_tempo'       => $jatuhTempo,
            'deskripsi'         => $request->deskripsi,
            'nama_pihak'        => $request->nama_pihak,
            'metode_pembayaran' => $request->metode_pembayaran ?? 'Transfer Bank',
            'lampiran'          => $lampiranPath,
        ]);

        return redirect()->route('backoffice.cashflow.index')
            ->with('success', "Transaksi kas [{$cashflow->kode}] berhasil diperbarui.");
    }

    /**
     * Pelunasan sisa piutang / cicilan DP peserta
     */
    public function pelunasan(Request $request, $id)
    {
        $cashflow = Cashflow::findOrFail($id);

        $rawNominal = $this->cleanNominal($request->nominal_pelunasan);

        $request->validate([
            'nominal_pelunasan' => 'required',
            'tanggal_pelunasan' => 'required|date',
            'metode_pembayaran' => 'nullable|string|max:60',
            'catatan'           => 'nullable|string',
            'lampiran'          => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:5120',
        ]);

        $nominalPelunasan = (float) $rawNominal;
        if ($nominalPelunasan <= 0) {
            return back()->with('error', 'Nominal pelunasan harus lebih dari Rp 0.');
        }

        if ($request->hasFile('lampiran')) {
            $dir = public_path('image/kas');
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true, true);
            }
            $file = $request->file('lampiran');
            $filename = 'pelunasan_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $cashflow->lampiran = 'image/kas/' . $filename;
        }

        // Tambah uang masuk kas
        $cashflow->nominal += $nominalPelunasan;

        // Kurangi sisa piutang
        $sisaLama = (float) $cashflow->sisa_piutang;
        $sisaBaru = max(0.0, $sisaLama - $nominalPelunasan);
        $cashflow->sisa_piutang = $sisaBaru;

        if ($sisaBaru <= 0) {
            $cashflow->status = 'lunas';
        } else {
            $cashflow->status = 'dp';
        }

        $tglFmt = Carbon::parse($request->tanggal_pelunasan)->format('d/m/Y');
        $metode = $request->metode_pembayaran ?? $cashflow->metode_pembayaran;
        $catatanInput = $request->catatan ? " ({$request->catatan})" : '';
        $logText = "[{$tglFmt}] Pelunasan +Rp " . number_format($nominalPelunasan, 0, ',', '.') . " via {$metode}{$catatanInput}";

        $cashflow->catatan_pelunasan = trim(($cashflow->catatan_pelunasan ? $cashflow->catatan_pelunasan . "\n" : "") . $logText);
        $cashflow->save();

        // Sinkronisasi dengan Pendaftaran (Admission) jika ada
        $admission = Admission::where('cashflow_id', $cashflow->id)->first();
        if ($admission) {
            $admission->nominal_pembayaran = $cashflow->nominal;
            $admission->sisa_piutang = $cashflow->sisa_piutang;
            $admission->status_pembayaran = $cashflow->status;
            $admission->save();
        }

        return redirect()->route('backoffice.cashflow.index')
            ->with('success', "Pelunasan sebesar Rp " . number_format($nominalPelunasan, 0, ',', '.') . " untuk [{$cashflow->kode}] berhasil dicatat.");
    }

    /**
     * Hapus transaksi kas
     */
    public function destroy($id)
    {
        $cashflow = Cashflow::findOrFail($id);
        $kode = $cashflow->kode;

        if ($cashflow->lampiran && File::exists(public_path($cashflow->lampiran))) {
            File::delete(public_path($cashflow->lampiran));
        }

        $cashflow->delete();

        return redirect()->route('backoffice.cashflow.index')
            ->with('success', "Transaksi [{$kode}] berhasil dihapus.");
    }

    /**
     * Endpoint API untuk generate kode otomatis saat dropdown berubah
     */
    public function generateKodeApi(Request $request)
    {
        $tipe = $request->get('tipe', 'masuk');
        $kodeKategori = $request->get('kode_kategori');

        $kode = Cashflow::generateKode($tipe, $kodeKategori);

        return response()->json([
            'success' => true,
            'kode'    => $kode,
        ]);
    }

    /**
     * Cetak / Ekspor Laporan Kas (Printable View)
     */
    public function cetak(Request $request)
    {
        $query = Cashflow::with(['creator', 'program.divisi']);

        if ($request->filled('tipe') && in_array($request->tipe, ['masuk', 'keluar'])) {
            $query->where('tipe', $request->tipe);
        }
        if ($request->filled('divisi_id') && $request->divisi_id !== 'all') {
            if ($request->divisi_id === 'none') {
                $query->whereNull('program_id');
            } elseif (!$request->filled('program_id') || $request->program_id === 'all') {
                $divId = (int) $request->divisi_id;
                $query->whereHas('program', function ($pq) use ($divId) {
                    $pq->where('divisi_id', $divId);
                });
            }
        }
        if ($request->filled('program_id') && $request->program_id !== 'all') {
            if ($request->program_id === 'none') {
                $query->whereNull('program_id');
            } else {
                $query->where('program_id', $request->program_id);
            }
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->where('kategori', $request->kategori);
        }
        $periode = $request->get('periode');

        if ($request->filled('tanggal_dari') || $request->filled('tanggal_sampai') || $request->filled('tanggal')) {
            if ($request->filled('tanggal_dari')) {
                $query->whereDate('tanggal', '>=', $request->tanggal_dari);
            }
            if ($request->filled('tanggal_sampai')) {
                $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
            }
            if ($request->filled('tanggal') && !$request->filled('tanggal_dari') && !$request->filled('tanggal_sampai')) {
                $query->whereDate('tanggal', $request->tanggal);
            }
        } elseif ($periode === 'hari_ini') {
            $query->whereDate('tanggal', Carbon::today());
        } elseif ($periode === 'bulan_ini') {
            $query->whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year);
        } elseif ($periode === 'tahun_ini') {
            $query->whereYear('tanggal', Carbon::now()->year);
        } elseif ($periode === 'tahunan') {
            if ($request->filled('tahun') && $request->tahun !== 'all') {
                $query->whereYear('tanggal', $request->tahun);
            }
        } elseif ($periode === 'bulanan') {
            if ($request->filled('bulan_dari') && $request->filled('bulan_sampai')) {
                $query->whereMonth('tanggal', '>=', (int)$request->bulan_dari)
                      ->whereMonth('tanggal', '<=', (int)$request->bulan_sampai);
            }
            if ($request->filled('tahun') && $request->tahun !== 'all') {
                $query->whereYear('tanggal', $request->tahun);
            }
        } elseif ($periode === 'all') {
            // Semua Periode -> Jangan batasi waktu
        } else {
            if ($request->filled('tahun') && $request->tahun !== 'all') {
                $query->whereYear('tanggal', $request->tahun);
            }
            if ($request->filled('bulan_dari') && $request->filled('bulan_sampai')) {
                $query->whereMonth('tanggal', '>=', (int)$request->bulan_dari)
                      ->whereMonth('tanggal', '<=', (int)$request->bulan_sampai);
            }
        }

        $query->orderBy('tanggal', 'asc')->orderBy('id', 'asc');
        $data = $query->get();

        $totalMasuk = (float) $data->where('tipe', 'masuk')->sum('nominal');
        $totalKeluar = (float) $data->where('tipe', 'keluar')->sum('nominal');
        $saldoKas = $totalMasuk - $totalKeluar;

        // Hitung Analisis Persentase Untung & Rugi untuk Laporan Cetak
        $statusUntungRugi = 'impas';
        $persenUntungRugi = 0.0;
        $persenBebanKeluar = 0.0;
        $totalVolume = $totalMasuk + $totalKeluar;
        $porsiMasuk = $totalVolume > 0 ? round(($totalMasuk / $totalVolume) * 100, 1) : 0.0;
        $porsiKeluar = $totalVolume > 0 ? round(($totalKeluar / $totalVolume) * 100, 1) : 0.0;

        if ($totalMasuk > 0) {
            $persenUntungRugi = round(($saldoKas / $totalMasuk) * 100, 1);
            $persenBebanKeluar = round(($totalKeluar / $totalMasuk) * 100, 1);
            if ($saldoKas > 0) {
                $statusUntungRugi = 'untung';
            } elseif ($saldoKas < 0) {
                $statusUntungRugi = 'rugi';
            }
        } elseif ($totalKeluar > 0) {
            $statusUntungRugi = 'rugi';
            $persenUntungRugi = -100.0;
            $persenBebanKeluar = 100.0;
        }

        return view('backoffice.cashflow.cetak', compact(
            'data',
            'totalMasuk',
            'totalKeluar',
            'saldoKas',
            'totalVolume',
            'statusUntungRugi',
            'persenUntungRugi',
            'persenBebanKeluar',
            'porsiMasuk',
            'porsiKeluar'
        ));
    }

    /**
     * Cetak Lembar Invoice / Kuitansi Resmi untuk 1 Transaksi Kas
     */
    public function invoice($id)
    {
        $cashflow = Cashflow::with(['creator', 'program.divisi'])->findOrFail($id);
        $terbilang = $this->penyebut($cashflow->nominal) . ' Rupiah';

        return view('backoffice.cashflow.invoice', compact('cashflow', 'terbilang'));
    }

    /**
     * Helper terbilang bahasa Indonesia untuk nominal kuitansi/invoice
     */
    private function penyebut($nilai)
    {
        $nilai = abs((float) $nilai);
        if ($nilai == 0) {
            return "Nol";
        }
        $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        $temp = "";

        if ($nilai < 12) {
            $temp = " " . $huruf[(int)$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " Belas";
        } else if ($nilai < 100) {
            $sisa = $nilai % 10;
            $temp = $this->penyebut((int)($nilai / 10)) . " Puluh" . ($sisa ? " " . $this->penyebut($sisa) : "");
        } else if ($nilai < 200) {
            $sisa = $nilai - 100;
            $temp = " Seratus" . ($sisa ? " " . $this->penyebut($sisa) : "");
        } else if ($nilai < 1000) {
            $sisa = $nilai % 100;
            $temp = $this->penyebut((int)($nilai / 100)) . " Ratus" . ($sisa ? " " . $this->penyebut($sisa) : "");
        } else if ($nilai < 2000) {
            $sisa = $nilai - 1000;
            $temp = " Seribu" . ($sisa ? " " . $this->penyebut($sisa) : "");
        } else if ($nilai < 1000000) {
            $sisa = fmod($nilai, 1000);
            $temp = $this->penyebut((int)($nilai / 1000)) . " Ribu" . ($sisa ? " " . $this->penyebut($sisa) : "");
        } else if ($nilai < 1000000000) {
            $sisa = fmod($nilai, 1000000);
            $temp = $this->penyebut((int)($nilai / 1000000)) . " Juta" . ($sisa ? " " . $this->penyebut($sisa) : "");
        } else if ($nilai < 1000000000000) {
            $sisa = fmod($nilai, 1000000000);
            $temp = $this->penyebut((int)($nilai / 1000000000)) . " Milyar" . ($sisa ? " " . $this->penyebut($sisa) : "");
        } else if ($nilai < 1000000000000000) {
            $sisa = fmod($nilai, 1000000000000);
            $temp = $this->penyebut((int)($nilai / 1000000000000)) . " Triliun" . ($sisa ? " " . $this->penyebut($sisa) : "");
        }

        return trim(preg_replace('/\s+/', ' ', $temp));
    }

    /**
     * Sanitasi input nominal uang dengan aman (menghapus Rp, spasi, titik ribuan)
     */
    private function cleanNominal($input): float
    {
        $str = preg_replace('/[^0-9,\.]/', '', (string) ($input ?? '0'));
        if (strpos($str, '.') !== false && strpos($str, ',') !== false) {
            $str = str_replace('.', '', $str);
            $str = str_replace(',', '.', $str);
        } elseif (strpos($str, '.') !== false) {
            $str = str_replace('.', '', $str);
        } elseif (strpos($str, ',') !== false) {
            $str = str_replace(',', '.', $str);
        }
        return is_numeric($str) ? (float) $str : 0.0;
    }
}

