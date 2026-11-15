@extends('backoffice.layouts.app')

@section('title', 'Keuangan per Program: ' . $namaKategori . ' | Backoffice Denpasar Institute')
@section('page-title', 'Keuangan per Program: ' . $namaKategori)

@push('styles')
<style>
  .kpi-card {
    position: relative;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    padding: 20px 22px;
    box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
    transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.2s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.2s ease;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .kpi-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(15, 23, 42, 0.07);
    border-color: #cbd5e1;
  }
  .kpi-card::before {
    content: "";
    position: absolute;
    top: 14px;
    bottom: 14px;
    left: 0;
    width: 5px;
    border-radius: 0 6px 6px 0;
  }
  .kpi-card.kpi-pemasukan {
    background: linear-gradient(145deg, #ffffff 65%, #ecfdf5 100%);
  }
  .kpi-card.kpi-pemasukan::before { background: #10b981; }

  .kpi-card.kpi-pengeluaran {
    background: linear-gradient(145deg, #ffffff 65%, #fef2f2 100%);
  }
  .kpi-card.kpi-pengeluaran::before { background: #ef4444; }

  .kpi-card.kpi-saldo {
    background: linear-gradient(145deg, #ffffff 65%, #eff6ff 100%);
  }
  .kpi-card.kpi-saldo::before { background: #3b82f6; }

  .kpi-card.kpi-piutang {
    background: linear-gradient(145deg, #ffffff 65%, #fffbeb 100%);
  }
  .kpi-card.kpi-piutang::before { background: #f59e0b; }

  .kpi-card.kpi-margin {
    background: linear-gradient(145deg, #ffffff 65%, #faf5ff 100%);
  }
  .kpi-card.kpi-margin::before { background: #8b5cf6; }

  .kpi-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
  }
  .kpi-label {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #64748b;
    margin-bottom: 0;
  }
  .kpi-icon-box {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
  }
  .kpi-value {
    font-size: 1.55rem;
    font-weight: 800;
    line-height: 1.15;
    letter-spacing: -0.5px;
    margin-bottom: 4px;
  }
  .kpi-footer-note {
    font-size: 0.76rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: 10px;
  }
  .kpi-action-link {
    font-size: 0.75rem;
    color: #92400e;
    background: #fef3c7;
    border: 1px solid #fde68a;
    padding: 3px 10px;
    border-radius: 8px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 10px;
    font-weight: 600;
    transition: all 0.15s ease;
  }
  .kpi-action-link:hover {
    background: #fde68a;
    color: #78350f;
  }
  .filter-panel {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    padding: 22px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
  }
  .table-kategori th {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    background-color: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 13px 14px;
    vertical-align: middle;
  }
  .table-kategori td {
    padding: 14px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.88rem;
  }
  .program-chip {
    padding: 5px 14px;
    border-radius: 9999px;
    font-size: 0.78rem;
    font-weight: 600;
    text-decoration: none;
    border: 1px solid #e2e8f0;
    color: #475569;
    background: #ffffff;
    transition: all 0.15s ease;
  }
  .program-chip:hover, .program-chip.active {
    background: #1e293b;
    color: #ffffff;
    border-color: #1e293b;
    box-shadow: 0 2px 8px rgba(30, 41, 59, 0.15);
  }

  @media (max-width: 576px) {
    .kpi-card {
      padding: 12px 12px;
      border-radius: 12px;
    }
    .kpi-value {
      font-size: 1.05rem !important;
      word-break: break-word;
    }
    .kpi-icon-box {
      width: 28px;
      height: 28px;
      font-size: 0.8rem;
    }
    .kpi-label {
      font-size: 0.65rem;
    }
    .kpi-footer-note {
      font-size: 0.7rem;
      margin-top: 6px;
    }
  }

  /* Dual Scrollbar & Drag to Scroll */
  .table-top-scroll {
    overflow-x: auto;
    overflow-y: hidden;
    height: 14px;
    background: #f1f5f9;
    border-bottom: 1px solid #e2e8f0;
  }
  .table-top-scroll::-webkit-scrollbar,
  .table-responsive::-webkit-scrollbar {
    height: 10px;
  }
  .table-top-scroll::-webkit-scrollbar-track,
  .table-responsive::-webkit-scrollbar-track {
    background: #f8fafc;
  }
  .table-top-scroll::-webkit-scrollbar-thumb,
  .table-responsive::-webkit-scrollbar-thumb {
    background: #94a3b8;
    border-radius: 6px;
  }
  .table-top-scroll::-webkit-scrollbar-thumb:hover,
  .table-responsive::-webkit-scrollbar-thumb:hover {
    background: #64748b;
  }
  .table-grab {
    cursor: grab;
    user-select: none;
  }
  .table-grab.table-grabbing {
    cursor: grabbing !important;
    user-select: none;
  }
  .btn-scroll-nav {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.76rem;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 6px;
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    color: #334155;
    transition: all 0.15s ease;
  }
  .btn-scroll-nav:hover {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
  }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

  {{-- Page Header --}}
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 w-100">
    <div>
      <h2 class="h4 fw-bold text-dark mb-1">
        <i class="fas fa-graduation-cap text-danger me-2"></i> Keuangan per Program: {{ $namaKategori }}
      </h2>
      <p class="text-muted small mb-0">
        Ringkasan arus kas, monitoring piutang, dan rekapitulasi transaksi program ini
      </p>
    </div>
    <div class="d-flex align-items-center gap-2 ms-sm-auto justify-content-end flex-wrap flex-sm-nowrap">
      <a href="{{ route('backoffice.project.index') }}" class="btn btn-sm btn-outline-secondary fw-semibold" style="height: 38px; display: inline-flex; align-items: center; white-space: nowrap; padding: 0 16px; border-radius: 8px; font-size: 0.84rem;">
        <i class="fas fa-arrow-left me-2"></i> Program Kursus
      </a>
      <a href="{{ route('backoffice.cashflow.create') }}?divisi_id={{ $isUmum ? 'none' : $divisi->id }}" class="btn btn-sm btn-danger fw-bold shadow-sm" style="height: 38px; display: inline-flex; align-items: center; white-space: nowrap; padding: 0 18px; border-radius: 8px; background: #CC0000; border-color: #CC0000; font-size: 0.84rem;">
        <i class="fas fa-plus me-1"></i> Transaksi Baru
      </a>
    </div>
  </div>

  {{-- Quick Filter Chip Program dalam Kategori Ini (Jika Ada Program) --}}
  @if(!$isUmum)
    <div class="d-flex align-items-center flex-wrap gap-2 mb-4 p-3 bg-white rounded-4 border shadow-sm">
      <span class="small fw-bold text-dark me-1 d-flex align-items-center">
        <i class="fas fa-layer-group text-danger me-2"></i> Filter Program:
      </span>
      <a href="{{ request()->fullUrlWithQuery(['program_id' => 'all']) }}" class="program-chip {{ (!$filterProgramId || $filterProgramId === 'all') ? 'active' : '' }}">
        Semua Program ({{ $programs->count() }})
      </a>
      @foreach($programs as $p)
        <a href="{{ request()->fullUrlWithQuery(['program_id' => $p->id]) }}" class="program-chip {{ $filterProgramId == $p->id ? 'active' : '' }}">
          {{ $p->nama }}
        </a>
      @endforeach
      @if(auth()->check() && auth()->user()->role !== 'finance')
      <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-bold ms-auto" data-bs-toggle="modal" data-bs-target="#modalTambahProgramKategori">
        <i class="fas fa-plus me-1"></i> Tambah Program
      </button>
      @endif
    </div>
  @endif

  @php
    $kpiPot = ($kpiPemasukan ?? 0) + ($kpiPiutang ?? 0);
    $kpiPersenMasuk = isset($kpiPersenMasuk) ? $kpiPersenMasuk : ($kpiPot > 0 ? round(($kpiPemasukan / $kpiPot) * 100, 1) : 100.0);
    $kpiPersenKeluar = isset($kpiPersenKeluar) ? $kpiPersenKeluar : (($kpiPemasukan ?? 0) > 0 ? round(($kpiPengeluaran / $kpiPemasukan) * 100, 1) : (($kpiPengeluaran ?? 0) > 0 ? 100.0 : 0.0));
    $kpiPersenPiutang = isset($kpiPersenPiutang) ? $kpiPersenPiutang : ($kpiPot > 0 ? round(($kpiPiutang / $kpiPot) * 100, 1) : 0.0);
    $kpiPersenSaldo = isset($kpiPersenSaldo) ? $kpiPersenSaldo : (($kpiPemasukan ?? 0) > 0 ? round(($kpiSaldo / $kpiPemasukan) * 100, 1) : (($kpiPengeluaran ?? 0) > 0 ? -100.0 : 0.0));
  @endphp

  {{-- 4 KPI STAT CARDS (Pemasukan, Pengeluaran, Piutang, Selisih) --}}
  <div class="row g-2 g-md-3 mb-4">
    {{-- Card 1: PEMASUKAN --}}
    <div class="col-6 col-sm-6 col-xl-3">
      <div class="kpi-card kpi-pemasukan">
        <div>
          <div class="kpi-header">
            <span class="kpi-label">PEMASUKAN</span>
            <div class="d-flex align-items-center gap-1">
              <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0" style="font-size: 0.68rem; font-weight: 700;" title="Realisasi {{ number_format($kpiPersenMasuk, 1, ',', '.') }}% dari total potensi omset">
                <i class="fas fa-arrow-up me-1"></i>{{ number_format($kpiPersenMasuk, 1, ',', '.') }}%
              </span>
              <div class="kpi-icon-box" style="background: rgba(16, 185, 129, 0.15); color: #059669;">
                <i class="fas fa-hand-holding-usd"></i>
              </div>
            </div>
          </div>
          <div class="kpi-value" style="color: #047857;">
            Rp {{ number_format($kpiPemasukan, 0, ',', '.') }}
          </div>
        </div>
        <div class="kpi-footer-note text-success">
          <i class="fas fa-arrow-down-left"></i>
          <span>Total Kas Masuk</span>
        </div>
      </div>
    </div>

    {{-- Card 2: PENGELUARAN --}}
    <div class="col-6 col-sm-6 col-xl-3">
      <div class="kpi-card kpi-pengeluaran">
        <div>
          <div class="kpi-header">
            <span class="kpi-label">PENGELUARAN</span>
            <div class="d-flex align-items-center gap-1">
              <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-0" style="font-size: 0.68rem; font-weight: 700;" title="Menyerap {{ number_format($kpiPersenKeluar, 1, ',', '.') }}% dari pemasukan">
                <i class="fas fa-arrow-down me-1"></i>{{ number_format($kpiPersenKeluar, 1, ',', '.') }}%
              </span>
              <div class="kpi-icon-box" style="background: rgba(239, 68, 68, 0.15); color: #dc2626;">
                <i class="fas fa-receipt"></i>
              </div>
            </div>
          </div>
          <div class="kpi-value text-danger">
            Rp {{ number_format($kpiPengeluaran, 0, ',', '.') }}
          </div>
        </div>
        <div class="kpi-footer-note text-danger">
          <i class="fas fa-arrow-trend-down"></i>
          <span>Beban Operasional</span>
        </div>
      </div>
    </div>

    {{-- Card 3: PIUTANG --}}
    <div class="col-6 col-sm-6 col-xl-3">
      <div class="kpi-card kpi-piutang">
        <div>
          <div class="kpi-header">
            <span class="kpi-label">PIUTANG</span>
            <div class="d-flex align-items-center gap-1">
              <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2 py-0" style="font-size: 0.68rem; font-weight: 700;" title="{{ number_format($kpiPersenPiutang, 1, ',', '.') }}% sisa tagihan DP belum dilunasi dari total omset">
                <i class="fas fa-clock me-1"></i>{{ number_format($kpiPersenPiutang, 1, ',', '.') }}%
              </span>
              <div class="kpi-icon-box" style="background: rgba(245, 158, 11, 0.15); color: #d97706;">
                <i class="fas fa-hourglass-half"></i>
              </div>
            </div>
          </div>
          <div class="kpi-value" style="color: #b45309;">
            Rp {{ number_format($kpiPiutang, 0, ',', '.') }}
          </div>
        </div>
        <div>
          <a href="{{ request()->fullUrlWithQuery(['tipe' => 'piutang']) }}" class="kpi-action-link w-100" title="Klik untuk menyaring transaksi piutang">
            <span><i class="fas fa-filter me-1"></i> Saring Piutang</span>
            <i class="fas fa-arrow-right" style="font-size: 0.65rem;"></i>
          </a>
        </div>
      </div>
    </div>

    {{-- Card 4: SELISIH --}}
    <div class="col-6 col-sm-6 col-xl-3">
      <div class="kpi-card kpi-saldo">
        <div>
          <div class="kpi-header">
            <span class="kpi-label">SELISIH</span>
            <div class="d-flex align-items-center gap-1">
              <span class="badge {{ $kpiSaldo >= 0 ? 'bg-primary-subtle text-primary border-primary-subtle' : 'bg-danger-subtle text-danger border-danger-subtle' }} border rounded-pill px-2 py-0" style="font-size: 0.68rem; font-weight: 700;" title="Rasio selisih kas terhadap pemasukan">
                <i class="fas {{ $kpiSaldo >= 0 ? 'fa-scale-balanced' : 'fa-triangle-exclamation' }} me-1"></i>{{ ($kpiPersenSaldo > 0 ? '+' : '') . number_format($kpiPersenSaldo, 1, ',', '.') }}%
              </span>
              <div class="kpi-icon-box" style="background: rgba(59, 130, 246, 0.15); color: #2563eb;">
                <i class="fas fa-scale-balanced"></i>
              </div>
            </div>
          </div>
          <div class="kpi-value" style="color: {{ $kpiSaldo >= 0 ? '#1d4ed8' : '#dc2626' }};">
            Rp {{ number_format($kpiSaldo, 0, ',', '.') }}
          </div>
        </div>
        <div class="kpi-footer-note {{ $kpiSaldo >= 0 ? 'text-primary' : 'text-danger' }}">
          <i class="fas fa-coins"></i>
          <span>{{ $kpiSaldo >= 0 ? 'Surplus Kas' : 'Defisit Kas' }}</span>
        </div>
      </div>
    </div>
  </div>

  {{-- FILTER BOX (Persis FOTO 2) --}}
  <div class="filter-panel mb-4">
    <form action="{{ route('backoffice.project.kategori', $isUmum ? 'umum' : $divisi->id) }}" method="GET" id="kategoriFilterForm">
      @if($filterProgramId && $filterProgramId !== 'all')
        <input type="hidden" name="program_id" value="{{ $filterProgramId }}">
      @endif

      {{-- Baris 1: Dropdown Filters --}}
      <div class="row g-3 mb-3">
        <div class="col-12 col-md-4">
          <label class="form-label small fw-bold text-dark mb-1">PERIODE</label>
          <select name="periode" class="form-select form-select-sm" onchange="document.getElementById('kategoriFilterForm').submit()">
            <option value="semua" {{ $filterPeriode === 'semua' ? 'selected' : '' }}>Semua Periode</option>
            <option value="harian" {{ $filterPeriode === 'harian' ? 'selected' : '' }}>Harian</option>
            <option value="bulanan" {{ $filterPeriode === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
            <option value="tahunan" {{ $filterPeriode === 'tahunan' ? 'selected' : '' }}>Tahunan</option>
          </select>
        </div>

        <div class="col-12 col-md-4">
          <label class="form-label small fw-bold text-dark mb-1">TRANSAKSI</label>
          <select name="tipe" class="form-select form-select-sm" onchange="document.getElementById('kategoriFilterForm').submit()">
            <option value="all" {{ $filterTipe === 'all' ? 'selected' : '' }}>Semua Transaksi</option>
            <option value="masuk" {{ $filterTipe === 'masuk' ? 'selected' : '' }}>Pemasukan</option>
            <option value="keluar" {{ $filterTipe === 'keluar' ? 'selected' : '' }}>Pengeluaran</option>
            <option value="piutang" {{ $filterTipe === 'piutang' ? 'selected' : '' }}>Piutang</option>
          </select>
        </div>

        <div class="col-12 col-md-4">
          <label class="form-label small fw-bold text-dark mb-1">STATUS</label>
          <select name="status" class="form-select form-select-sm" onchange="document.getElementById('kategoriFilterForm').submit()">
            <option value="all" {{ $filterStatus === 'all' ? 'selected' : '' }}>Semua Status</option>
            <option value="lunas" {{ $filterStatus === 'lunas' ? 'selected' : '' }}>✓ Lunas</option>
            <option value="dp" {{ $filterStatus === 'dp' ? 'selected' : '' }}>⏰ DP (Piutang)</option>
          </select>
        </div>
      </div>

      {{-- Baris 2: Input Pencarian --}}
      <div class="mb-3">
        <label class="form-label small fw-bold text-dark mb-1">SEARCH</label>
        <div class="input-group input-group-sm">
          <input type="text" name="q" value="{{ $filterKeyword }}" class="form-control" placeholder="Search deskripsi, kode, PIC...">
          <button class="btn btn-outline-secondary" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>

      {{-- Baris 3: Tombol Aksi (Reset & Export CSV) --}}
      <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('backoffice.project.kategori', $isUmum ? 'umum' : $divisi->id) }}" class="text-decoration-none text-muted small fw-semibold">
          <i class="fas fa-undo me-1"></i> Reset
        </a>
        <a href="{{ route('backoffice.project.kategori.export-csv', array_merge(['id' => $isUmum ? 'umum' : $divisi->id], request()->all())) }}" class="btn btn-sm btn-outline-success fw-bold" style="border-radius: 6px;">
          <i class="fas fa-download me-1"></i> Export CSV
        </a>
      </div>
    </form>
  </div>

  {{-- TABEL TRANSAKSI (Persis FOTO 2) --}}
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-header bg-white py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
      <div class="d-flex align-items-center gap-2">
        <h6 class="fw-bold text-dark mb-0">
          <i class="fas fa-receipt text-danger me-2"></i> Riwayat Transaksi Finansial
        </h6>
        <span class="text-muted small">
          (Menampilkan {{ $cashflows->firstItem() ?? 0 }}-{{ $cashflows->lastItem() ?? 0 }} dari {{ $cashflows->total() }} transaksi)
        </span>
      </div>

      {{-- Navigasi Penggeser Cepat Kanan - Kiri --}}
      <div class="d-flex align-items-center gap-2">
        <span class="badge bg-light text-secondary border d-none d-md-inline-flex align-items-center gap-1" style="font-size: 0.72rem; padding: 4px 8px;">
          <i class="fas fa-arrows-left-right text-danger"></i> Bisa drag / geser tabel
        </span>
        <div class="btn-group btn-group-sm" role="group" aria-label="Geser Tabel">
          <button type="button" class="btn btn-scroll-nav" id="btnScrollKategoriLeft" title="Geser tabel ke kiri">
            <i class="fas fa-chevron-left me-1"></i> Geser Kiri
          </button>
          <button type="button" class="btn btn-scroll-nav" id="btnScrollKategoriRight" title="Geser tabel ke kanan">
            Geser Kanan <i class="fas fa-chevron-right ms-1"></i>
          </button>
        </div>
      </div>
    </div>

    {{-- Penggeser Horizontal Atas (Double Scrollbar) --}}
    <div class="table-top-scroll" id="topScrollKategori" title="Geser horizontal">
      <div id="topScrollKategoriInner" style="height: 1px;"></div>
    </div>

    <div class="table-responsive" id="wrapperTableKategori">
      <table class="table table-hover table-kategori align-middle mb-0" id="tableKategoriData">
        <thead>
          <tr>
            <th style="min-width: 110px;">TANGGAL</th>
            <th style="min-width: 140px;">KODE</th>
            <th style="min-width: 180px;">PROGRAM</th>
            <th style="min-width: 220px;">DESKRIPSI</th>
            <th style="min-width: 110px;">VOL &amp; SATUAN</th>
            <th class="text-end" style="min-width: 120px;">HARGA SATUAN</th>
            <th class="text-end" style="min-width: 130px;">TOTAL</th>
            <th class="text-center" style="min-width: 120px;">TRANSAKSI</th>
            <th class="text-center" style="width: 70px;">BUKTI</th>
            <th class="text-center" style="width: 110px;">AKSI</th>
          </tr>
        </thead>
        <tbody>
          @forelse($cashflows as $c)
            <tr>
              {{-- 1. Tanggal --}}
              <td class="text-nowrap text-muted">
                {{ $c->tanggal ? $c->tanggal->format('d M Y') : '-' }}
              </td>

              {{-- 2. Kode --}}
              <td>
                <span class="badge bg-light text-dark font-monospace border">
                  {{ $c->kode }}
                </span>
              </td>

              {{-- 3. Program --}}
              <td>
                <span class="fw-bold text-dark d-block">
                  {{ $c->program?->nama ?? ($c->project?->nama_proyek ?? 'Umum (Non-Program)') }}
                </span>
                @if($c->project && $c->project->nama_peserta)
                  <small class="text-muted">Peserta: {{ $c->project->nama_peserta }}</small>
                @endif
              </td>

              {{-- 4. Deskripsi --}}
              <td>
                <div class="fw-bold text-dark">{{ $c->kategori }}</div>
                <small class="text-muted d-block">
                  {{ $c->deskripsi ?: ($c->nama_pihak ?: '-') }}
                </small>
              </td>

              {{-- 5. Volume & Satuan --}}
              <td class="text-nowrap">
                {{ (float)$c->volume == (int)$c->volume ? (int)$c->volume : number_format($c->volume, 2) }} {{ ucfirst($c->satuan ?? 'Paket') }}
              </td>

              {{-- 6. Harga Satuan --}}
              <td class="text-end text-muted">
                Rp {{ number_format($c->harga_satuan > 0 ? $c->harga_satuan : $c->nominal, 0, ',', '.') }}
              </td>

              {{-- 7. Total Nominal (+ / -) --}}
              <td class="text-end fw-bold">
                @if($c->tipe === 'masuk')
                  <span style="color: #16a34a;">+ Rp {{ number_format($c->nominal, 0, ',', '.') }}</span>
                  @if($c->sisa_piutang > 0 || $c->status === 'dp')
                    <div class="small text-danger fw-semibold" style="font-size: 0.72rem;">
                      Sisa: Rp {{ number_format($c->sisa_piutang, 0, ',', '.') }}
                    </div>
                  @endif
                @else
                  <span style="color: #dc2626;">- Rp {{ number_format($c->nominal, 0, ',', '.') }}</span>
                @endif
              </td>

              {{-- 8. Tipe & Status Badge --}}
              <td class="text-center">
                @if($c->tipe === 'masuk')
                  <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill" style="font-size: 0.72rem;">
                    PEMASUKAN
                  </span>
                  @if($c->sisa_piutang > 0 || $c->status === 'dp')
                    <div class="mt-1">
                      <span class="badge bg-warning text-dark border border-warning-subtle rounded-pill px-2" style="font-size: 0.65rem; font-weight: 700;">
                        ⏰ DP (Piutang)
                      </span>
                    </div>
                  @else
                    <div class="mt-1">
                      <span class="badge bg-success-subtle text-success border border-success rounded-pill px-2" style="font-size: 0.65rem; font-weight: 600;">
                        ✓ Lunas
                      </span>
                    </div>
                  @endif
                @else
                  <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill" style="font-size: 0.72rem;">
                    PENGELUARAN
                  </span>
                @endif
              </td>

              {{-- 9. Bukti Transaksi --}}
              <td class="text-center">
                @if($c->lampiran)
                  <a href="{{ asset($c->lampiran) }}" target="_blank" class="text-primary fs-5" title="Buka Bukti Transaksi">
                    <i class="far fa-file-image"></i>
                  </a>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>

              {{-- 10. Aksi (Detail/Invoice, Edit, Hapus) --}}
              <td class="text-center">
                <div class="d-inline-flex gap-1">
                  <a href="{{ route('backoffice.cashflow.edit', $c->id) }}" class="btn btn-sm btn-light border py-1 px-2 text-secondary" title="Edit Transaksi">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('backoffice.cashflow.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-light border py-1 px-2 text-danger" title="Hapus Transaksi">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="10" class="text-center py-5 text-muted">
                <i class="fas fa-inbox fs-2 text-secondary mb-3 d-block"></i>
                <h6 class="fw-bold">Tidak Ada Transaksi Ditemukan</h6>
                <p class="small text-muted mb-3">Belum ada catatan keuangan yang cocok dengan filter yang dipilih.</p>
                <a href="{{ route('backoffice.cashflow.create') }}?divisi_id={{ $isUmum ? 'none' : $divisi->id }}" class="btn btn-sm btn-danger px-3">
                  <i class="fas fa-plus me-1"></i> Catat Transaksi Baru
                </a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($cashflows->hasPages())
      <div class="card-footer bg-white py-3 px-4">
        {{ $cashflows->links() }}
      </div>
    @endif
  </div>

</div>

@if(!$isUmum)
{{-- Modal Tambah Program Kursus ke Kategori Ini --}}
<div class="modal fade" id="modalTambahProgramKategori" tabindex="-1" aria-labelledby="modalTambahProgramKategoriLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header bg-light border-bottom py-3">
        <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="modalTambahProgramKategoriLabel">
          <i class="fas fa-plus-circle text-danger me-2"></i> Tambah Program ke {{ $namaKategori }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('backoffice.project.program.store') }}" method="POST">
        @csrf
        <input type="hidden" name="divisi_id" value="{{ $divisi->id }}">

        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label small fw-bold text-dark mb-1">
              Kategori / Divisi Penyelenggara:
            </label>
            <input type="text" class="form-control bg-light fw-bold text-dark" value="{{ $namaKategori }}" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-bold text-dark mb-1">
              <span class="text-danger">*</span> Nama Program Kursus:
            </label>
            <input type="text" name="nama" class="form-control fw-bold" placeholder="Contoh: Kursus Bahasa Jerman Level A1-B1 / UI-UX Design" required>
            <div class="form-text small text-muted">Nama program kursus yang akan ditambahkan ke kategori ini.</div>
          </div>

          <div class="mb-0">
            <label class="form-label small fw-bold text-dark mb-1">
              Deskripsi Singkat (Opsional):
            </label>
            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Uraian singkat mengenai program kursus ini..."></textarea>
          </div>
        </div>
        <div class="modal-footer bg-light border-top py-2 px-4 d-flex justify-content-between">
          <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-danger fw-bold px-4" style="background: #CC0000; border-color: #CC0000;">
            <i class="fas fa-save me-1"></i> Simpan Program
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('wrapperTableKategori');
    const topScroll = document.getElementById('topScrollKategori');
    const topInner = document.getElementById('topScrollKategoriInner');
    const btnLeft = document.getElementById('btnScrollKategoriLeft');
    const btnRight = document.getElementById('btnScrollKategoriRight');
    const table = document.getElementById('tableKategoriData');

    if (!wrapper || !topScroll || !topInner || !table) return;

    // 1. Sync Lebar Top Scrollbar dengan Table
    function syncTableWidth() {
      const scrollWidth = table.scrollWidth;
      topInner.style.width = scrollWidth + 'px';
      if (scrollWidth <= wrapper.clientWidth) {
        topScroll.style.display = 'none';
      } else {
        topScroll.style.display = 'block';
      }
    }

    syncTableWidth();
    window.addEventListener('resize', syncTableWidth);

    // 2. Sinkronisasi Posisi Scroll Antara Atas dan Bawah
    let isSyncingTop = false;
    let isSyncingWrapper = false;

    topScroll.addEventListener('scroll', function () {
      if (!isSyncingTop) {
        isSyncingWrapper = true;
        wrapper.scrollLeft = topScroll.scrollLeft;
      }
      isSyncingTop = false;
    });

    wrapper.addEventListener('scroll', function () {
      if (!isSyncingWrapper) {
        isSyncingTop = true;
        topScroll.scrollLeft = wrapper.scrollLeft;
      }
      isSyncingWrapper = false;
    });

    // 3. Tombol Geser Kiri / Kanan
    if (btnLeft) {
      btnLeft.addEventListener('click', function () {
        wrapper.scrollBy({ left: -320, behavior: 'smooth' });
      });
    }

    if (btnRight) {
      btnRight.addEventListener('click', function () {
        wrapper.scrollBy({ left: 320, behavior: 'smooth' });
      });
    }

    // 4. Mouse Drag-to-Scroll (Klik dan geser tabel ke kanan/kiri langsung dengan kursor)
    let isDown = false;
    let startX = 0;
    let scrollStart = 0;

    wrapper.classList.add('table-grab');

    wrapper.addEventListener('mousedown', function (e) {
      // Abaikan jika klik tombol, link, atau form control
      if (e.target.closest('a, button, input, select, textarea, label')) return;
      isDown = true;
      wrapper.classList.add('table-grabbing');
      startX = e.pageX - wrapper.offsetLeft;
      scrollStart = wrapper.scrollLeft;
    });

    document.addEventListener('mouseup', function () {
      if (isDown) {
        isDown = false;
        wrapper.classList.remove('table-grabbing');
      }
    });

    wrapper.addEventListener('mousemove', function (e) {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - wrapper.offsetLeft;
      const walk = (x - startX) * 1.5; // multiplier geser
      wrapper.scrollLeft = scrollStart - walk;
    });
  });
</script>
@endpush

@endsection
