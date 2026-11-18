<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Program;
use App\Models\Divisi;
use App\Models\Cashflow;
use App\Models\CashflowCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProjectController extends Controller
{
    /**
     * Tampilkan daftar proyek & program
     */
    /**
     * Tampilkan daftar proyek & program
     * Redesign sesuai Foto 1 (Kategori Cards) dan Foto 3 (Akumulasi Table)
     */
    public function index(Request $request)
    {
        // 1. Ambil 9 Divisi aktif DI beserta program aktifnya (Foto 1)
        $divisis = Divisi::with(['programs' => function ($q) {
            $q->where('is_active', true)->orderBy('nama');
        }])->where('is_active', true)->orderBy('id')->get();

        $divisiSummaries = [];
        $totalAkumulasiMasuk = 0.0;
        $totalAkumulasiKeluar = 0.0;
        $totalAkumulasiTransaksi = 0;

        foreach ($divisis as $d) {
            $progIds = $d->programs->pluck('id')->toArray();
            $projIds = Project::where('divisi_id', $d->id)
                ->orWhereIn('program_id', $progIds)
                ->pluck('id')->toArray();

            $cf = Cashflow::where(function ($q) use ($progIds, $projIds) {
                $q->whereIn('program_id', $progIds)
                  ->orWhereIn('project_id', $projIds);
            })->get();

            $in = (float) $cf->where('tipe', 'masuk')->sum('nominal');
            $out = (float) $cf->where('tipe', 'keluar')->sum('nominal');
            $saldo = $in - $out;
            $count = $cf->count();
            $margin = $in > 0 ? round(($saldo / $in) * 100, 1) : 0.0;

            $divisiSummaries[] = [
                'divisi'          => $d,
                'programs'        => $d->programs,
                'programs_count'  => $d->programs->count(),
                'pemasukan'       => $in,
                'pengeluaran'     => $out,
                'saldo'           => $saldo,
                'margin'          => $margin,
                'transaksi_count' => $count,
            ];

            $totalAkumulasiMasuk += $in;
            $totalAkumulasiKeluar += $out;
            $totalAkumulasiTransaksi += $count;
        }

        // 2. Hitung Akumulasi untuk Umum (Operasional Non-Program) (Foto 3)
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

        $programCashflows = Cashflow::whereNotNull('program_id')->orWhereNotNull('project_id');
        $programPemasukan = (float) (clone $programCashflows)->where('tipe', 'masuk')->sum('nominal');
        $programPengeluaran = (float) (clone $programCashflows)->where('tipe', 'keluar')->sum('nominal');
        $programPiutang = (float) (clone $programCashflows)->where('tipe', 'masuk')->sum('sisa_piutang');
        $programSelisih = $programPemasukan - $programPengeluaran;

        $programPotensi = $programPemasukan + $programPiutang;
        $programPersenMasuk = $programPotensi > 0 ? round(($programPemasukan / $programPotensi) * 100, 1) : 100.0;
        $programPersenPiutang = $programPotensi > 0 ? round(($programPiutang / $programPotensi) * 100, 1) : 0.0;
        $programPersenKeluar = $programPemasukan > 0 ? round(($programPengeluaran / $programPemasukan) * 100, 1) : ($programPengeluaran > 0 ? 100.0 : 0.0);
        $programPersenSelisih = $programPemasukan > 0 ? round(($programSelisih / $programPemasukan) * 100, 1) : ($programPengeluaran > 0 ? -100.0 : 0.0);

        // Data Proyek/Kelas aktif (opsional jika dibutuhkan tab/ringkasan)
        $projects = Project::with(['program.divisi', 'creator'])->latest()->paginate(10);
        $divisiList = Divisi::where('is_active', true)->orderBy('nama')->get();

        return view('backoffice.project.index', compact(
            'divisiSummaries',
            'umumSummary',
            'totalAkumulasiMasuk',
            'totalAkumulasiKeluar',
            'totalAkumulasiSaldo',
            'totalAkumulasiTransaksi',
            'programPemasukan',
            'programPengeluaran',
            'programPiutang',
            'programSelisih',
            'programPersenMasuk',
            'programPersenKeluar',
            'programPersenPiutang',
            'programPersenSelisih',
            'projects',
            'divisiList'
        ));
    }

    /**
     * Halaman Finansial Keuangan per Kategori / Program Kursus (Persis Foto 2)
     */
    public function kategori($id, Request $request)
    {
        $isUmum = ($id === 'umum');
        $divisi = null;
        $programs = collect();

        if ($isUmum) {
            $namaKategori = 'Umum (Operasional Non-Program)';
            $baseQuery = Cashflow::with(['creator', 'program', 'project'])
                ->whereNull('program_id')
                ->whereNull('project_id');
        } else {
            $divisi = Divisi::with(['programs' => function ($q) {
                $q->where('is_active', true)->orderBy('nama');
            }])->findOrFail($id);

            $namaKategori = $divisi->nama;
            $programs = $divisi->programs;
            $progIds = $programs->pluck('id')->toArray();
            $projIds = Project::where('divisi_id', $divisi->id)
                ->orWhereIn('program_id', $progIds)
                ->pluck('id')->toArray();

            $baseQuery = Cashflow::with(['creator', 'program.divisi', 'project'])
                ->where(function ($q) use ($progIds, $projIds) {
                    $q->whereIn('program_id', $progIds)
                      ->orWhereIn('project_id', $projIds);
                });
        }

        // Filter Periode (semua, harian, bulanan, tahunan)
        $filterPeriode = $request->get('periode', 'semua');
        $kpiQuery = clone $baseQuery;

        if ($filterPeriode === 'harian') {
            $kpiQuery->whereDate('tanggal', Carbon::today());
        } elseif ($filterPeriode === 'bulanan') {
            $kpiQuery->whereMonth('tanggal', Carbon::now()->month)
                     ->whereYear('tanggal', Carbon::now()->year);
        } elseif ($filterPeriode === 'tahunan') {
            $kpiQuery->whereYear('tanggal', Carbon::now()->year);
        }

        // Filter Program jika dipilih
        $filterProgramId = $request->get('program_id', 'all');
        if ($filterProgramId && $filterProgramId !== 'all') {
            $kpiQuery->where('program_id', $filterProgramId);
        }

        // 5 KPI Stat Cards (Persis Foto 2)
        $kpiPemasukan = (float) (clone $kpiQuery)->where('tipe', 'masuk')->sum('nominal');
        $kpiPengeluaran = (float) (clone $kpiQuery)->where('tipe', 'keluar')->sum('nominal');
        $kpiSaldo = $kpiPemasukan - $kpiPengeluaran;
        $kpiPiutang = (float) (clone $kpiQuery)->where('tipe', 'masuk')->where(function ($q) {
            $q->where('sisa_piutang', '>', 0)->orWhere('status', 'dp');
        })->sum('sisa_piutang');

        if (!$isUmum && isset($projIds)) {
            $projPiutang = (float) Project::whereIn('id', $projIds)->get()->sum(fn($p) => $p->sisa_tagihan);
            $kpiPiutang = max($kpiPiutang, $projPiutang);
        }

        $kpiMargin = $kpiPemasukan > 0 ? round(($kpiSaldo / $kpiPemasukan) * 100, 1) : 0.0;

        $kpiPotensi = $kpiPemasukan + $kpiPiutang;
        $kpiPersenMasuk = $kpiPotensi > 0 ? round(($kpiPemasukan / $kpiPotensi) * 100, 1) : 100.0;
        $kpiPersenKeluar = $kpiPemasukan > 0 ? round(($kpiPengeluaran / $kpiPemasukan) * 100, 1) : ($kpiPengeluaran > 0 ? 100.0 : 0.0);
        $kpiPersenPiutang = $kpiPotensi > 0 ? round(($kpiPiutang / $kpiPotensi) * 100, 1) : 0.0;
        $kpiPersenSaldo = $kpiPemasukan > 0 ? round(($kpiSaldo / $kpiPemasukan) * 100, 1) : ($kpiPengeluaran > 0 ? -100.0 : 0.0);

        // Query Tabel Transaksi
        $tableQuery = clone $kpiQuery;

        // Filter Tipe (semua, masuk, keluar, piutang)
        $filterTipe = $request->get('tipe', 'all');
        if ($filterTipe === 'masuk') {
            $tableQuery->where('tipe', 'masuk');
        } elseif ($filterTipe === 'keluar') {
            $tableQuery->where('tipe', 'keluar');
        } elseif ($filterTipe === 'piutang') {
            $tableQuery->where('tipe', 'masuk')->where(function ($q) {
                $q->where('sisa_piutang', '>', 0)->orWhere('status', 'dp');
            });
        }

        // Filter Status (semua, lunas, dp)
        $filterStatus = $request->get('status', 'all');
        if ($filterStatus && $filterStatus !== 'all') {
            $tableQuery->where('status', $filterStatus);
        }

        // Filter Pencarian (Keyword)
        $filterKeyword = trim((string) $request->get('q', ''));
        if ($filterKeyword !== '') {
            $tableQuery->where(function ($q) use ($filterKeyword) {
                $q->where('kode', 'like', "%{$filterKeyword}%")
                  ->orWhere('judul', 'like', "%{$filterKeyword}%")
                  ->orWhere('deskripsi', 'like', "%{$filterKeyword}%")
                  ->orWhere('kategori', 'like', "%{$filterKeyword}%")
                  ->orWhere('nama_pihak', 'like', "%{$filterKeyword}%")
                  ->orWhereHas('program', fn($pq) => $pq->where('nama', 'like', "%{$filterKeyword}%"))
                  ->orWhereHas('project', fn($pjq) => $pjq->where('nama_proyek', 'like', "%{$filterKeyword}%"));
            });
        }

        $cashflows = $tableQuery->orderBy('tanggal', 'desc')->orderBy('id', 'desc')->paginate(20)->withQueryString();

        return view('backoffice.project.kategori', compact(
            'divisi',
            'isUmum',
            'namaKategori',
            'programs',
            'kpiPemasukan',
            'kpiPengeluaran',
            'kpiSaldo',
            'kpiPiutang',
            'kpiMargin',
            'kpiPersenMasuk',
            'kpiPersenKeluar',
            'kpiPersenPiutang',
            'kpiPersenSaldo',
            'cashflows',
            'filterPeriode',
            'filterTipe',
            'filterStatus',
            'filterProgramId',
            'filterKeyword'
        ));
    }

    /**
     * Export CSV transaksi per kategori / program
     */
    public function exportKategoriCsv($id, Request $request)
    {
        $isUmum = ($id === 'umum');
        if ($isUmum) {
            $namaKategori = 'Umum (Operasional Non-Program)';
            $baseQuery = Cashflow::with(['creator', 'program', 'project'])
                ->whereNull('program_id')
                ->whereNull('project_id');
            $slug = 'umum';
        } else {
            $divisi = Divisi::with('programs')->findOrFail($id);
            $namaKategori = $divisi->nama;
            $progIds = $divisi->programs->pluck('id')->toArray();
            $projIds = Project::where('divisi_id', $divisi->id)
                ->orWhereIn('program_id', $progIds)
                ->pluck('id')->toArray();

            $baseQuery = Cashflow::with(['creator', 'program.divisi', 'project'])
                ->where(function ($q) use ($progIds, $projIds) {
                    $q->whereIn('program_id', $progIds)
                      ->orWhereIn('project_id', $projIds);
                });
            $slug = \Illuminate\Support\Str::slug($divisi->nama);
        }

        $periode = $request->get('periode', 'semua');
        if ($periode === 'harian') {
            $baseQuery->whereDate('tanggal', Carbon::today());
        } elseif ($periode === 'bulanan') {
            $baseQuery->whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year);
        } elseif ($periode === 'tahunan') {
            $baseQuery->whereYear('tanggal', Carbon::now()->year);
        }

        if ($request->filled('program_id') && $request->program_id !== 'all') {
            $baseQuery->where('program_id', $request->program_id);
        }

        $tipe = $request->get('tipe', 'all');
        if ($tipe === 'masuk') {
            $baseQuery->where('tipe', 'masuk');
        } elseif ($tipe === 'keluar') {
            $baseQuery->where('tipe', 'keluar');
        } elseif ($tipe === 'piutang') {
            $baseQuery->where('tipe', 'masuk')->where(function ($q) {
                $q->where('sisa_piutang', '>', 0)->orWhere('status', 'dp');
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $baseQuery->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $kw = trim($request->q);
            $baseQuery->where(function ($q) use ($kw) {
                $q->where('kode', 'like', "%{$kw}%")
                  ->orWhere('judul', 'like', "%{$kw}%")
                  ->orWhere('deskripsi', 'like', "%{$kw}%")
                  ->orWhere('kategori', 'like', "%{$kw}%")
                  ->orWhere('nama_pihak', 'like', "%{$kw}%");
            });
        }

        $data = $baseQuery->orderBy('tanggal', 'desc')->orderBy('id', 'desc')->get();
        $filename = "keuangan-program-{$slug}-" . date('Ymd_His') . ".csv";

        return response()->streamDownload(function () use ($data) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            $delimiter = ';';
            $escape = function ($value) {
                $value = (string) $value;
                return preg_match('/^[=+@\-\t\r]/', $value) ? "'" . $value : $value;
            };
            fputcsv($handle, ['TANGGAL', 'KODE', 'PROGRAM', 'KATEGORI', 'DESKRIPSI', 'VOL', 'SATUAN', 'HARGA SATUAN', 'TOTAL', 'TIPE', 'STATUS', 'METODE'], $delimiter);

            foreach ($data as $c) {
                fputcsv($handle, array_map($escape, [
                    $c->tanggal ? $c->tanggal->format('Y-m-d') : '',
                    $c->kode,
                    $c->program?->nama ?? ($c->project?->nama_proyek ?? 'Umum'),
                    $c->kategori,
                    $c->deskripsi ?: $c->judul,
                    $c->volume,
                    $c->satuan,
                    $c->harga_satuan,
                    $c->tipe === 'keluar' ? -$c->nominal : $c->nominal,
                    strtoupper($c->tipe),
                    strtoupper($c->status),
                    $c->metode_pembayaran,
                ]), $delimiter);
            }
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Halaman form tambah program kursus baru
     */
    public function createProgram(Request $request)
    {
        if (auth()->check() && auth()->user()->role === 'finance') {
            abort(403, 'Akses terbatas. Role Finance tidak memiliki izin menambah program baru.');
        }

        $divisiList = Divisi::where('is_active', true)->orderBy('nama')->get();
        $selectedDivisiId = $request->get('divisi_id');

        return view('backoffice.project.program-create', compact('divisiList', 'selectedDivisiId'));
    }

    /**
     * Tambah Program Kursus Baru ke Divisi / Kategori DI (Opsi B)
     */
    public function storeProgram(Request $request)
    {
        if (auth()->check() && auth()->user()->role === 'finance') {
            abort(403, 'Akses terbatas. Role Finance tidak memiliki izin menambah program baru.');
        }

        $request->validate([
            'divisi_id'  => 'required|exists:divisis,id',
            'nama'       => 'required|string|max:255',
            'ikon'       => 'nullable|string|max:60',
            'deskripsi'  => 'nullable|string',
        ], [
            'divisi_id.required' => 'Pilih kategori / divisi program penyelenggara.',
            'divisi_id.exists'   => 'Kategori / divisi tidak valid.',
            'nama.required'      => 'Nama program kursus wajib diisi.',
        ]);

        $baseSlug = Str::slug($request->nama);
        $slug = $baseSlug ?: 'program-' . time();
        $counter = 1;
        while (Program::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $divisi = Divisi::findOrFail($request->divisi_id);
        $maxUrutan = Program::where('divisi_id', $divisi->id)->max('urutan') ?? 0;

        $program = Program::create([
            'divisi_id'  => $divisi->id,
            'nama'       => trim($request->nama),
            'slug'       => $slug,
            'ikon'       => $request->ikon ?: 'fas fa-graduation-cap',
            'deskripsi'  => $request->deskripsi ? trim($request->deskripsi) : null,
            'urutan'     => $maxUrutan + 1,
            'is_active'  => true,
        ]);

        $successMsg = "Program kursus \"{$program->nama}\" berhasil ditambahkan ke {$divisi->nama}!";

        if ($request->input('submit_action') === 'save_and_add') {
            $referer = (string) $request->header('referer');
            if (str_contains($referer, 'tambah-program')) {
                return redirect()->route('backoffice.project.program.create')
                    ->with('success', $successMsg . ' Silakan tambah program kursus berikutnya.');
            }
            if (str_contains($referer, 'kategori')) {
                return redirect()->back()
                    ->with('success', $successMsg . ' Silakan tambah program kursus berikutnya.')
                    ->with('open_modal_program', true);
            }
            return redirect()->route('backoffice.project.index')
                ->with('success', $successMsg . ' Silakan tambah program kursus berikutnya.')
                ->with('open_modal_program', true);
        }

        return redirect()->route('backoffice.project.index')
            ->with('success', $successMsg);
    }

    /**
     * Form tambah proyek baru
     */
    public function create()
    {
        $programs = Program::with('divisi')->where('is_active', true)->orderBy('nama')->get();
        $divisiList = Divisi::with(['programs' => fn($q) => $q->where('is_active', true)->orderBy('nama')])->where('is_active', true)->orderBy('nama')->get();
        $defaultKode = Project::generateKode();

        return view('backoffice.project.create', compact('programs', 'divisiList', 'defaultKode'));
    }

    /**
     * Simpan proyek baru
     */
    public function store(Request $request)
    {
        // Auto-generate kode jika belum ada atau sudah dipakai
        $kode = trim((string)$request->kode);
        if (!$kode || Project::where('kode', $kode)->exists()) {
            $kode = Project::generateKode();
        }
        $request->merge(['kode' => $kode]);

        $rawNilai = preg_replace('/[^0-9]/', '', (string)$request->nilai_proyek);
        $request->merge(['nilai_proyek_clean' => $rawNilai ? (float)$rawNilai : 0.0]);

        $request->validate([
            'kode'               => 'required|string|max:60|unique:projects,kode',
            'nama_proyek'        => 'required|string|max:255',
            'nama_peserta'       => 'nullable|string|max:150',
            'pic'                => 'nullable|string|max:150',
            'program_id'         => 'nullable|exists:programs,id',
            'divisi_id'          => 'nullable|exists:divisis,id',
            'tanggal_mulai'      => 'required|date',
            'tanggal_selesai'    => 'nullable|date|after_or_equal:tanggal_mulai',
            'nilai_proyek_clean' => 'required|numeric|min:0',
            'status'             => 'required|in:aktif,selesai,pending,batal',
            'keterangan'         => 'nullable|string',
        ], [
            'kode.required'        => 'Kode proyek wajib diisi.',
            'kode.unique'          => 'Kode proyek sudah digunakan.',
            'nama_proyek.required' => 'Nama proyek / kelas program wajib diisi.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
        ]);

        $divisiId = $request->divisi_id;
        if ($request->program_id) {
            $prog = Program::find($request->program_id);
            if ($prog && $prog->divisi_id) {
                $divisiId = $prog->divisi_id;
            }
        }

        $project = Project::create([
            'kode'            => trim($request->kode),
            'nama_proyek'     => trim($request->nama_proyek),
            'nama_peserta'    => $request->filled('nama_peserta') ? trim($request->nama_peserta) : null,
            'pic'             => $request->filled('pic') ? trim($request->pic) : null,
            'program_id'      => $request->program_id ?: null,
            'divisi_id'       => $divisiId ?: null,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai ?: null,
            'nilai_proyek'    => $request->nilai_proyek_clean,
            'status'          => $request->status,
            'keterangan'      => $request->keterangan,
            'created_by'      => auth()->id(),
        ]);

        $successMsg = "Program kursus [{$project->kode}] {$project->nama_proyek} berhasil didaftarkan.";

        if ($request->input('submit_action') === 'save_and_add') {
            return redirect()->route('backoffice.project.create')
                ->with('success', $successMsg . ' Silakan daftarkan kelas/program kursus berikutnya.');
        }

        return redirect()->route('backoffice.project.show', $project->id)
            ->with('success', $successMsg);
    }

    /**
     * Halaman Detail & Finansial Proyek (Persis Foto 4 & 6)
     */
    public function show($id, ?Request $request = null)
    {
        $project = Project::with(['program.divisi', 'creator', 'cashflows.creator'])->findOrFail($id);

        // Hanya Transaksi Uang Masuk Pembayaran Kursus
        $pemasukanList = $project->cashflows()->where('tipe', 'masuk')->orderBy('tanggal', 'desc')->get();

        // Kategori Options untuk Form Transaksi Masuk
        $kategoriOptions = Cashflow::getKategoriOptions();
        $metodeOptions = Cashflow::getMetodePembayaranOptions();
        $satuanOptions = Cashflow::getSatuanOptions();

        return view('backoffice.project.show', compact(
            'project',
            'pemasukanList',
            'kategoriOptions',
            'metodeOptions',
            'satuanOptions'
        ));
    }

    /**
     * Form edit proyek
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $programs = Program::with('divisi')->where('is_active', true)->orderBy('nama')->get();
        $divisiList = Divisi::with(['programs' => fn($q) => $q->where('is_active', true)->orderBy('nama')])->where('is_active', true)->orderBy('nama')->get();

        return view('backoffice.project.edit', compact('project', 'programs', 'divisiList'));
    }

    /**
     * Perbarui data proyek
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        if (!$request->filled('kode')) {
            $request->merge(['kode' => $project->kode]);
        }

        $rawNilai = preg_replace('/[^0-9]/', '', (string)$request->nilai_proyek);
        $request->merge(['nilai_proyek_clean' => $rawNilai ? (float)$rawNilai : 0.0]);

        $request->validate([
            'kode'               => 'required|string|max:60|unique:projects,kode,' . $project->id,
            'nama_proyek'        => 'required|string|max:255',
            'nama_peserta'       => 'nullable|string|max:150',
            'pic'                => 'nullable|string|max:150',
            'program_id'         => 'nullable|exists:programs,id',
            'divisi_id'          => 'nullable|exists:divisis,id',
            'tanggal_mulai'      => 'required|date',
            'tanggal_selesai'    => 'nullable|date|after_or_equal:tanggal_mulai',
            'nilai_proyek_clean' => 'required|numeric|min:0',
            'status'             => 'required|in:aktif,selesai,pending,batal',
            'keterangan'         => 'nullable|string',
        ]);

        $divisiId = $request->divisi_id;
        if ($request->program_id) {
            $prog = Program::find($request->program_id);
            if ($prog && $prog->divisi_id) {
                $divisiId = $prog->divisi_id;
            }
        }

        $project->update([
            'kode'            => trim($request->kode),
            'nama_proyek'     => trim($request->nama_proyek),
            'nama_peserta'    => $request->filled('nama_peserta') ? trim($request->nama_peserta) : null,
            'pic'             => $request->filled('pic') ? trim($request->pic) : null,
            'program_id'      => $request->program_id ?: null,
            'divisi_id'       => $divisiId ?: null,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai ?: null,
            'nilai_proyek'    => $request->nilai_proyek_clean,
            'status'          => $request->status,
            'keterangan'      => $request->keterangan,
        ]);

        return redirect()->route('backoffice.project.show', $project->id)
            ->with('success', "Data program kursus [{$project->kode}] {$project->nama_proyek} berhasil diperbarui.");
    }

    /**
     * Hapus program kursus
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $kode = $project->kode;
        $nama = $project->nama_proyek;

        // Lepaskan kaitan cashflow agar catatan kas tidak terhapus
        Cashflow::where('project_id', $project->id)->update(['project_id' => null]);

        $project->delete();

        return redirect()->route('backoffice.project.index')
            ->with('success', "Program kursus [{$kode}] {$nama} berhasil dihapus.");
    }

    /**
     * Simpan transaksi Pemasukan atau Pengeluaran langsung di halaman Program Kursus
     * (Persis Formula ChatGPT Foto 2, 3, 6)
     */
    public function storeTransaction(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        // Bersihkan nominal harga satuan dan volume
        $rawHarga = preg_replace('/[^0-9]/', '', (string)$request->harga_satuan);
        $hargaSatuan = $rawHarga ? (float)$rawHarga : 0.0;

        $rawVolume = str_replace(',', '.', (string)$request->volume);
        $volume = is_numeric($rawVolume) && (float)$rawVolume > 0 ? (float)$rawVolume : 1.0;

        // Total Otomatis = Volume x Harga Satuan
        $totalNominal = $volume * $hargaSatuan;
        if ($totalNominal <= 0 && $request->filled('nominal')) {
            $rawNominal = preg_replace('/[^0-9]/', '', (string)$request->nominal);
            $totalNominal = $rawNominal ? (float)$rawNominal : 0.0;
        }

        $request->merge(['tipe' => 'masuk']);

        $request->validate([
            'tanggal'           => 'required|date',
            'kategori'          => 'required|string|max:150',
            'deskripsi'         => 'nullable|string',
            'satuan'            => 'nullable|string|max:50',
            'metode_pembayaran' => 'nullable|string|max:60',
            'lampiran'          => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:5120',
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

        // Ambil prefix kode dari kategori
        $prefix = 'KM';
        $kodeKategori = $prefix;
        if ($cat = CashflowCategory::where('nama', $request->kategori)->first()) {
            $kodeKategori = $cat->kode;
        }

        $kodeTransaksi = Cashflow::generateKode('masuk', $kodeKategori);

        $satuan = $request->satuan ?: 'paket';
        if ($satuan === '__custom__' && $request->filled('custom_satuan')) {
            $satuan = trim($request->custom_satuan);
        }

        $deskripsi = trim($request->deskripsi ?? '');
        if ($request->filled('keterangan')) {
            $deskripsi = $deskripsi ? ($deskripsi . ' (' . trim($request->keterangan) . ')') : trim($request->keterangan);
        }

        Cashflow::create([
            'kode'              => $kodeTransaksi,
            'judul'             => 'Pemasukan: ' . ($deskripsi ?: $project->nama_proyek),
            'tipe'              => 'masuk',
            'kode_kategori'     => $kodeKategori,
            'kategori'          => trim($request->kategori),
            'program_id'        => $project->program_id,
            'project_id'        => $project->id,
            'satuan'            => $satuan,
            'volume'            => $volume,
            'harga_satuan'      => $hargaSatuan,
            'nominal'           => $totalNominal,
            'total_tagihan'     => $project->nilai_proyek,
            'sisa_piutang'      => 0,
            'tanggal'           => $request->tanggal,
            'deskripsi'         => $deskripsi,
            'nama_pihak'        => $project->nama_peserta ?: $project->pic ?: 'Peserta / Siswa',
            'metode_pembayaran' => $request->metode_pembayaran ?? 'Transfer Bank',
            'status'            => 'lunas',
            'lampiran'          => $lampiranPath,
            'created_by'        => auth()->id(),
        ]);

        $msg = "Pembayaran masuk Rp " . number_format($totalNominal, 0, ',', '.') . " berhasil dicatat ke program kursus ini.";

        if ($request->input('submit_action') === 'save_and_add') {
            return redirect()->to(route('backoffice.project.show', $project->id) . '#formTransaksiProyek')
                ->with('success', $msg . ' Silakan catat pembayaran masuk berikutnya.');
        }

        return redirect()->route('backoffice.project.show', $project->id)
            ->with('success', $msg);
    }

    /**
     * Update Biaya Program Kursus secara cepat
     */
    public function updateNilai(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $rawNilai = preg_replace('/[^0-9]/', '', (string)$request->nilai_proyek);
        $nilai = $rawNilai ? (float)$rawNilai : 0.0;

        $project->update(['nilai_proyek' => $nilai]);

        return redirect()->route('backoffice.project.show', $project->id)
            ->with('success', "Biaya program kursus berhasil diubah menjadi Rp " . number_format($nilai, 0, ',', '.'));
    }

    /**
     * Cetak kuitansi / ringkasan proyek
     */
    public function cetak($id)
    {
        $project = Project::with(['program.divisi', 'creator', 'cashflows'])->findOrFail($id);
        $pemasukanList = $project->cashflows()->where('tipe', 'masuk')->orderBy('tanggal', 'asc')->get();
        $pengeluaranList = $project->cashflows()->where('tipe', 'keluar')->orderBy('tanggal', 'asc')->get();

        return view('backoffice.project.cetak', compact('project', 'pemasukanList', 'pengeluaranList'));
    }
}
