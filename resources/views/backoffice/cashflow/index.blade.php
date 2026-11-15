@php
  $isFiltering = request()->anyFilled(['q', 'tipe_kategori', 'divisi_id', 'program_id', 'tipe', 'status', 'periode', 'tahun', 'bulan_dari', 'bulan_sampai', 'metode_pembayaran', 'page', 'sort']);
@endphp

@extends('backoffice.layouts.app')

@section('title', 'Keuangan Umum | Backoffice Denpasar Institute')
@section('page-title', 'Keuangan Umum')

@push('styles')
<style>
  .cash-card-stat {
    border-radius: 14px;
    padding: 18px 20px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    min-height: 105px;
  }
  .cash-card-stat:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
  }
  .cash-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    flex-shrink: 0;
  }
  .cash-filter-box {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    padding: 20px 22px;
    margin-bottom: 24px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
  }
  .table-responsive {
    overflow-x: auto;
    scrollbar-width: thin;
  }
  .table-accumulation th {
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    font-weight: 700;
    color: #64748b;
    background-color: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 14px 16px;
    vertical-align: middle;
  }
  .table-accumulation td {
    padding: 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.9rem;
  }
  .btn-lihat-program {
    border: 1px solid #cbd5e1;
    color: #1e293b;
    background: #ffffff;
    font-size: 0.82rem;
    font-weight: 600;
    border-radius: 9999px;
    padding: 6px 18px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.2s ease;
  }
  .btn-lihat-program:hover {
    background: #1e293b;
    color: #ffffff;
    border-color: #1e293b;
  }
  @media (min-width: 992px) {
    .table-responsive {
      overflow-x: hidden !important;
    }
  }
  .table-cash {
    width: 100% !important;
    table-layout: fixed;
    margin-bottom: 0;
  }
  .table-cash th {
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 700;
    color: #64748b;
    background: #f8fafc;
    border-bottom: 2px solid #e2e8f0;
    vertical-align: middle;
    padding: 10px 8px;
    white-space: nowrap;
  }
  .table-cash td {
    vertical-align: middle;
    padding: 8px 8px;
    font-size: 0.79rem;
  }
  .table-cash th:last-child,
  .table-cash td:last-child {
    padding-right: 14px !important;
    text-align: center;
  }
  .badge-cash-in {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.76rem;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }
  .badge-cash-out {
    background: #fee2e2;
    color: #b91c1c;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.76rem;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }
  .nominal-in {
    color: #16a34a;
    font-weight: 700;
    font-size: 0.95rem;
  }
  .nominal-out {
    color: #dc2626;
    font-weight: 700;
    font-size: 0.95rem;
  }
  .btn-preview-lampiran {
    padding: 4px 10px;
    font-size: 0.78rem;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-weight: 600;
  }

  .btn-cash-header-print {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: #1e293b;
    color: #ffffff !important;
    font-weight: 600;
    font-size: 0.88rem;
    padding: 9px 18px;
    border-radius: 8px;
    border: 1px solid #0f172a;
    text-decoration: none;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.15);
  }
  .btn-cash-header-print:hover {
    background: #0f172a;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(15, 23, 42, 0.25);
  }
  .btn-cash-header-print i {
    color: #38bdf8;
    font-size: 0.95rem;
  }
  .btn-cash-header-create {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: #CC0000;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 0.88rem;
    padding: 9px 20px;
    border-radius: 8px;
    border: 1px solid #CC0000;
    text-decoration: none;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 14px rgba(204, 0, 0, 0.25);
  }
  .btn-cash-header-create:hover {
    background: #b30000;
    color: #ffffff !important;
    border-color: #b30000;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(204, 0, 0, 0.35);
  }
  .btn-cash-header-create i {
    color: #ffffff;
    font-size: 0.95rem;
  }

  @media (max-width: 576px) {
    .cash-card-stat {
      padding: 12px 12px;
      border-radius: 12px;
    }
    .cash-card-stat .fs-4 {
      font-size: 1.05rem !important;
      word-break: break-word;
    }
    .cash-stat-icon {
      width: 30px;
      height: 30px;
      font-size: 0.8rem;
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
    <div class="flex-shrink-0">
      <h2 class="h4 fw-bold text-dark mb-1 text-nowrap">
        <i class="fas fa-wallet text-danger me-2"></i> Keuangan Umum
      </h2>
      <p class="text-muted small mb-0">Pencatatan kas operasional, penerimaan &amp; pengeluaran dana umum</p>
    </div>
    <div class="d-flex align-items-center gap-2 ms-sm-auto justify-content-end flex-wrap flex-sm-nowrap">
      <button type="button" class="btn btn-sm btn-danger fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahTransaksi" style="height: 38px; display: inline-flex; align-items: center; white-space: nowrap; padding: 0 18px; border-radius: 8px; background: #CC0000; border-color: #CC0000; font-size: 0.84rem;">
        <i class="fas fa-plus me-1"></i> Transaksi Baru
      </button>
    </div>
  </div>

  {{-- 4 Stat Cards: Pemasukan, Pengeluaran, Piutang, Selisih --}}
  <div class="row g-2 g-md-3 mb-4">
    {{-- 1. Pemasukan (Uang Masuk) --}}
    <div class="col-6 col-sm-6 col-xl-3">
      <div class="cash-card-stat">
        <div class="d-flex align-items-center justify-content-between mb-1">
          <span class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.3px;">Pemasukan</span>
          <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill" style="font-size: 0.68rem; white-space: nowrap;" title="Realisasi {{ number_format($persenMasuk, 1, ',', '.') }}% dari total potensi omset">
            <i class="fas fa-arrow-up me-1"></i>{{ number_format($persenMasuk, 1, ',', '.') }}%
          </span>
        </div>
        <div class="d-flex align-items-center justify-content-between mt-2 mb-0">
          <div class="fs-4 fw-bold text-success">
            + Rp {{ number_format($totalMasuk, 0, ',', '.') }}
          </div>
          <div class="cash-stat-icon bg-success-subtle text-success">
            <i class="fas fa-hand-holding-usd"></i>
          </div>
        </div>
      </div>
    </div>

    {{-- 2. Pengeluaran (Uang Keluar) --}}
    <div class="col-6 col-sm-6 col-xl-3">
      <div class="cash-card-stat">
        <div class="d-flex align-items-center justify-content-between mb-1">
          <span class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.3px;">Pengeluaran</span>
          <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill" style="font-size: 0.68rem; white-space: nowrap;" title="Menyerap {{ number_format($persenKeluar, 1, ',', '.') }}% dari pemasukan">
            <i class="fas fa-arrow-down me-1"></i>{{ number_format($persenKeluar, 1, ',', '.') }}%
          </span>
        </div>
        <div class="d-flex align-items-center justify-content-between mt-2 mb-0">
          <div class="fs-4 fw-bold text-danger">
            &minus; Rp {{ number_format($totalKeluar, 0, ',', '.') }}
          </div>
          <div class="cash-stat-icon bg-danger-subtle text-danger">
            <i class="fas fa-file-invoice-dollar"></i>
          </div>
        </div>
      </div>
    </div>

    {{-- 3. Piutang (Sisa DP Belum Lunas) --}}
    <div class="col-6 col-sm-6 col-xl-3">
      <div class="cash-card-stat">
        <div class="d-flex align-items-center justify-content-between mb-1">
          <span class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.3px;">Piutang</span>
          <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1 rounded-pill" style="font-size: 0.68rem; white-space: nowrap;" title="{{ number_format($persenPiutang, 1, ',', '.') }}% sisa tagihan DP belum dilunasi dari total omset">
            <i class="fas fa-clock me-1"></i>{{ number_format($persenPiutang, 1, ',', '.') }}%
          </span>
        </div>
        <div class="d-flex align-items-center justify-content-between mt-2 mb-0">
          <div class="fs-4 fw-bold text-dark">
            Rp {{ number_format($totalPiutang, 0, ',', '.') }}
          </div>
          <div class="cash-stat-icon bg-warning-subtle text-warning-emphasis">
            <i class="fas fa-hand-holding-dollar"></i>
          </div>
        </div>
      </div>
    </div>

    {{-- 4. Selisih (Laba / Rugi Kas) --}}
    <div class="col-6 col-sm-6 col-xl-3">
      <div class="cash-card-stat">
        <div class="d-flex align-items-center justify-content-between mb-1">
          <span class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.3px;">Selisih</span>
          <span class="badge {{ $saldoKas >= 0 ? 'bg-primary-subtle text-primary border-primary-subtle' : 'bg-danger-subtle text-danger border-danger-subtle' }} border px-2 py-1 rounded-pill" style="font-size: 0.72rem; white-space: nowrap;" title="{{ $saldoKas >= 0 ? 'Surplus' : 'Defisit' }} {{ number_format(abs($persenKas), 1, ',', '.') }}% dari pemasukan">
            <i class="fas {{ $saldoKas >= 0 ? 'fa-scale-balanced' : 'fa-triangle-exclamation' }} me-1"></i>{{ ($persenKas > 0 ? '+' : '') . number_format($persenKas, 1, ',', '.') }}%
          </span>
        </div>
        <div class="d-flex align-items-center justify-content-between mt-2 mb-0">
          <div class="fs-4 fw-bold {{ $saldoKas >= 0 ? 'text-dark' : 'text-danger' }}">
            Rp {{ number_format($saldoKas, 0, ',', '.') }}
          </div>
          <div class="cash-stat-icon {{ $saldoKas >= 0 ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger' }}">
            <i class="fas fa-scale-balanced"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Filter Bar --}}
  <div class="cash-filter-box bg-white p-3 rounded-4 shadow-sm mb-4 border" style="border-color: #e2e8f0;">
    <form action="{{ route('backoffice.cashflow.index') }}" method="GET" id="filterForm">
      <input type="hidden" name="tab" value="transaksi">

      @php
        // Penentuan Periode Aktif yang bersih dan tidak terkunci bug
        $reqPeriode = request('periode');
        if ($reqPeriode && in_array($reqPeriode, ['all', 'harian', 'bulanan', 'tahunan'])) {
            $activePeriode = $reqPeriode;
        } elseif (request()->filled('tahun') && request('tahun') !== 'all') {
            $activePeriode = 'tahunan';
        } elseif (request()->filled('bulan_dari') || request()->filled('bulan_sampai')) {
            $activePeriode = 'bulanan';
        } elseif (request()->filled('tanggal_dari') || request()->filled('tanggal_sampai') || request()->filled('tanggal')) {
            $activePeriode = 'harian';
        } else {
            $activePeriode = 'all';
        }
      @endphp

      {{-- BARIS 1: PERIODE, TANGGAL/RENTANG, TIPE, STATUS, PROGRAM (PERSIS FOTO 1 & 5) --}}
      <div class="row g-2 mb-3">
        
        {{-- 1. PERIODE (Hanya: Semua Periode, Harian, Bulanan, Tahunan - Sesuai Foto 2) --}}
        <div class="col-12 col-sm-6 col-md-3 col-lg-2">
          <label class="form-label small fw-bold text-secondary text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">PERIODE</label>
          <select name="periode" id="selectPeriode" class="form-select form-select-sm fw-semibold" onchange="handlePeriodeChange(this.value)">
            <option value="all" {{ $activePeriode === 'all' ? 'selected' : '' }}>Semua Periode</option>
            <option value="harian" {{ $activePeriode === 'harian' ? 'selected' : '' }}>Harian</option>
            <option value="bulanan" {{ $activePeriode === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
            <option value="tahunan" {{ $activePeriode === 'tahunan' ? 'selected' : '' }}>Tahunan</option>
          </select>
        </div>

        {{-- 2. TANGGAL / RENTANG WAKTU (MENGGUNAKAN INPUT TANGGAL ASLI) --}}
        <div class="col-12 col-sm-6 col-md-4 col-lg-3" id="boxFilterWaktu">
          {{-- Mode Rentang Tanggal (Selalu Tampil Kecuali Mode Bulanan/Tahunan) --}}
          <div id="subFilterHarian" style="{{ in_array($activePeriode, ['bulanan', 'tahunan']) ? 'display: none;' : '' }}">
            <label class="form-label small fw-bold text-secondary text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">RENTANG TANGGAL</label>
            <div class="input-group input-group-sm">
              <input type="date" name="tanggal_dari" id="inputTglDari" value="{{ request('tanggal_dari', request('tanggal')) }}" class="form-control" title="Tanggal Dari" onchange="document.getElementById('filterForm').submit();">
              <span class="input-group-text bg-light text-muted px-1">s/d</span>
              <input type="date" name="tanggal_sampai" id="inputTglSampai" value="{{ request('tanggal_sampai') }}" class="form-control" title="Tanggal Sampai" onchange="document.getElementById('filterForm').submit();">
            </div>
          </div>

          {{-- Mode Rentang Bulan --}}
          <div id="subFilterBulanan" style="{{ $activePeriode === 'bulanan' ? '' : 'display: none;' }}">
            <label class="form-label small fw-bold text-secondary text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">RENTANG BULAN</label>
            <div class="input-group input-group-sm">
              <select name="bulan_dari" class="form-select form-select-sm" onchange="document.getElementById('filterForm').submit();">
                <option value="">Bulan A</option>
                @foreach($monthNames as $num => $namaBulan)
                  <option value="{{ $num }}" {{ request('bulan_dari') == $num ? 'selected' : '' }}>{{ sprintf('%02d', $num) }} - {{ substr($namaBulan, 0, 3) }}</option>
                @endforeach
              </select>
              <span class="input-group-text bg-light text-muted px-1">s/d</span>
              <select name="bulan_sampai" class="form-select form-select-sm" onchange="document.getElementById('filterForm').submit();">
                <option value="">Bulan B</option>
                @foreach($monthNames as $num => $namaBulan)
                  <option value="{{ $num }}" {{ request('bulan_sampai') == $num ? 'selected' : '' }}>{{ sprintf('%02d', $num) }} - {{ substr($namaBulan, 0, 3) }}</option>
                @endforeach
              </select>
            </div>
          </div>

          {{-- Mode Tahunan --}}
          <div id="subFilterTahunan" style="{{ $activePeriode === 'tahunan' ? '' : 'display: none;' }}">
            <label class="form-label small fw-bold text-secondary text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">TAHUN</label>
            <select name="tahun" class="form-select form-select-sm" onchange="document.getElementById('filterForm').submit();">
              <option value="all" {{ request('tahun') === 'all' || !request('tahun') ? 'selected' : '' }}>Semua Tahun</option>
              @foreach($yearOptions as $yr)
                <option value="{{ $yr }}" {{ (string)request('tahun') === (string)$yr ? 'selected' : '' }}>{{ $yr }}</option>
              @endforeach
            </select>
          </div>
        </div>

        {{-- 3. TRANSAKSI (SEMUA TRANSAKSI, PEMASUKAN, PENGELUARAN, PIUTANG) --}}
        <div class="col-6 col-sm-4 col-md-2 col-lg-2">
          <label class="form-label small fw-bold text-secondary text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">TRANSAKSI</label>
          <select name="tipe" class="form-select form-select-sm fw-semibold" onchange="document.getElementById('filterForm').submit();">
            <option value="all" {{ !request('tipe') || request('tipe') === 'all' ? 'selected' : '' }}>Semua Transaksi</option>
            <option value="masuk" {{ request('tipe') === 'masuk' ? 'selected' : '' }}>Pemasukan</option>
            <option value="keluar" {{ request('tipe') === 'keluar' ? 'selected' : '' }}>Pengeluaran</option>
            <option value="piutang" {{ request('tipe') === 'piutang' ? 'selected' : '' }}>Piutang</option>
          </select>
        </div>

        {{-- 4. STATUS (PERSIS FOTO 1: HANYA SEMUA STATUS, LUNAS, DP PIUTANG) --}}
        <div class="col-6 col-sm-4 col-md-2 col-lg-2">
          <label class="form-label small fw-bold text-secondary text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">STATUS</label>
          <select name="status" class="form-select form-select-sm" onchange="document.getElementById('filterForm').submit();">
            <option value="all">Semua Status</option>
            <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>✓ Lunas</option>
            <option value="dp" {{ request('status') === 'dp' ? 'selected' : '' }}>⏰ DP (Piutang)</option>
          </select>
        </div>

        {{-- 5. PROGRAM (PERSIS FOTO 1: SEMUA PROGRAM TERKELOMPOK DI) --}}
        <div class="col-12 col-sm-4 col-md-3 col-lg-3">
          <label class="form-label small fw-bold text-secondary text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">PROGRAM</label>
          <select name="program_id" class="form-select form-select-sm" onchange="document.getElementById('filterForm').submit();">
            <option value="all">Semua Program</option>
            <option value="none" {{ request('program_id') === 'none' ? 'selected' : '' }}>— Operasional Umum (Tanpa Program) —</option>
            @foreach($divisiList as $div)
              @if($div->programs->count() > 0)
                <optgroup label="📁 {{ $div->nama }}">
                  @foreach($div->programs as $prog)
                    <option value="{{ $prog->id }}" {{ request('program_id') == $prog->id ? 'selected' : '' }}>
                      {{ $prog->nama }}
                    </option>
                  @endforeach
                </optgroup>
              @endif
            @endforeach
          </select>
        </div>

      </div>

      {{-- BARIS 2: SEARCH KATA KUNCI --}}
      <div class="mb-3">
        <label class="form-label small fw-bold text-secondary text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">SEARCH</label>
        <div class="input-group input-group-sm">
          <input type="text" name="q" value="{{ request('q') }}" class="form-control rounded-start" placeholder="Search deskripsi, kode, penerima...">
          <button type="submit" class="btn btn-outline-secondary px-3">
            <i class="fas fa-search text-muted"></i>
          </button>
        </div>
      </div>

      {{-- BARIS 3: TOMBOL RESET (KIRI) & EXPORT CSV (KANAN) (PERSIS FOTO 1) --}}
      <div class="d-flex justify-content-between align-items-center pt-2 border-top">
        <div>
          <a href="{{ route('backoffice.cashflow.index', ['tab' => 'transaksi']) }}" class="btn btn-sm btn-outline-secondary px-3 py-1">
            <i class="fas fa-sync-alt me-1"></i> Reset
          </a>
        </div>

        <div>
          <a href="{{ route('backoffice.cashflow.export.csv', request()->query()) }}" class="btn btn-sm btn-outline-success fw-bold px-3 py-1">
            <i class="fas fa-download me-1"></i> Export CSV
          </a>
          <a href="{{ route('backoffice.cashflow.cetak', request()->query()) }}" target="_blank" class="btn btn-sm btn-outline-danger fw-bold px-3 py-1">
            <i class="fas fa-file-pdf me-1"></i> Cetak / PDF
          </a>
        </div>
      </div>

    </form>
  </div>

    </form>
  </div>

  {{-- Transactions Table Card (Desain Sesuai DI & Screenshot) --}}
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-header bg-white py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
      <div>
        <h5 class="card-title mb-0 fs-6 fw-bold text-dark d-inline">
          Daftar Transaksi
        </h5>
        <span class="text-muted small ms-2" style="font-size: 0.8rem;">
          {{ $cashflows->total() }} transaksi ditemukan
        </span>
      </div>

      {{-- Navigasi Penggeser Cepat Kanan - Kiri --}}
      <div class="d-flex align-items-center gap-2">
        <span class="badge bg-light text-secondary border d-none d-md-inline-flex align-items-center gap-1" style="font-size: 0.72rem; padding: 4px 8px;">
          <i class="fas fa-arrows-left-right text-danger"></i> Bisa drag / geser tabel
        </span>
        <div class="btn-group btn-group-sm" role="group" aria-label="Geser Tabel">
          <button type="button" class="btn btn-scroll-nav" id="btnScrollCashflowLeft" title="Geser tabel ke kiri">
            <i class="fas fa-chevron-left me-1"></i> Geser Kiri
          </button>
          <button type="button" class="btn btn-scroll-nav" id="btnScrollCashflowRight" title="Geser tabel ke kanan">
            Geser Kanan <i class="fas fa-chevron-right ms-1"></i>
          </button>
        </div>
      </div>
    </div>

    {{-- Penggeser Horizontal Atas (Double Scrollbar) --}}
    <div class="table-top-scroll" id="topScrollCashflow" title="Geser horizontal">
      <div id="topScrollCashflowInner" style="height: 1px;"></div>
    </div>

    <div class="table-responsive" id="wrapperTableCashflow">
      <table class="table table-hover table-cash mb-0 align-middle" id="tableCashflowData">
        <thead>
          <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
            <th style="width: 11%; white-space: nowrap;">KODE</th>
            <th style="width: 8%; white-space: nowrap;">TANGGAL</th>
            <th style="width: 8%; white-space: nowrap;">TRANSAKSI</th>
            <th style="width: 20%;">DESKRIPSI</th>
            <th style="width: 12%;">PROGRAM</th>
            <th style="width: 12%; white-space: nowrap;">NOMINAL</th>
            <th style="width: 9%; white-space: nowrap;">METODE</th>
            <th style="width: 10%; white-space: nowrap;" class="text-center">STATUS</th>
            <th style="width: 12%; white-space: nowrap;" class="text-center">AKSI</th>
          </tr>
        </thead>
        <tbody>
          @forelse($cashflows as $item)
            <tr>
              {{-- 1. KODE --}}
              <td style="white-space: nowrap;">
                <span style="color: #991b1b; font-family: 'Consolas', 'Monaco', monospace; font-weight: 700; font-size: 0.76rem;">
                  {{ $item->kode }}
                </span>
              </td>

              {{-- 2. TANGGAL --}}
              <td style="white-space: nowrap;">
                <span style="color: #475569; font-size: 0.78rem;">
                  {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                </span>
              </td>

              {{-- 3. TIPE (Pill Badge) --}}
              <td style="white-space: nowrap;">
                @if($item->tipe === 'masuk')
                  <span style="background-color: #dcfce7; color: #15803d; border-radius: 9999px; padding: 2px 7px; font-weight: 600; font-size: 0.7rem; display: inline-flex; align-items: center; gap: 3px;">
                    <i class="fas fa-arrow-down" style="font-size: 0.65rem;"></i> Masuk
                  </span>
                @else
                  <span style="background-color: #fee2e2; color: #b91c1c; border-radius: 9999px; padding: 2px 7px; font-weight: 600; font-size: 0.7rem; display: inline-flex; align-items: center; gap: 3px;">
                    <i class="fas fa-arrow-up" style="font-size: 0.65rem;"></i> Keluar
                  </span>
                @endif
              </td>

              {{-- 4. DESKRIPSI --}}
              <td>
                @php
                  // Tampilkan nama peserta jelas atau judul transaksi
                  $namaTampil = $item->nama_pihak ? preg_replace('/\s*\(.*?\)\s*/', '', $item->nama_pihak) : null;
                  if (!$namaTampil) {
                      $namaTampil = preg_replace('/^Pendaftaran Peserta:\s*/i', '', $item->judul ?? '');
                  }
                  $namaTampil = $namaTampil ?: ($item->judul ?? $item->kategori);
                @endphp
                <div style="font-weight: 700; color: #1e293b; font-size: 0.81rem; line-height: 1.25; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $item->nama_pihak ? $item->nama_pihak . ' — ' : '' }}{{ $item->judul ?? $item->kategori }}">
                  {{ $namaTampil }}
                </div>
                <div style="color: #64748b; font-size: 0.7rem; margin-top: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $item->kategori }}">
                  {{ $item->kategori }}
                </div>
                @if($item->project)
                  <div class="mt-1">
                    <a href="{{ route('backoffice.project.show', $item->project->id) }}" class="badge bg-primary-subtle text-primary border border-primary-subtle text-decoration-none" style="font-size: 0.68rem;" title="Lihat Rincian Keuangan Program Kursus">
                      <i class="fas fa-graduation-cap me-1"></i>{{ $item->project->nama_proyek }}
                    </a>
                  </div>
                @endif
              </td>

              {{-- 5. PROGRAM (Fokus Program Denpasar Institute) --}}
              <td>
                @if($item->program)
                  <div style="color: #1e293b; font-size: 0.78rem; font-weight: 600; line-height: 1.25; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $item->program->nama }}@if($item->program->divisi) ({{ $item->program->divisi->nama }})@endif">
                    <i class="fas fa-graduation-cap text-danger me-1"></i>{{ $item->program->nama }}
                  </div>
                @else
                  <span class="text-muted" style="font-size: 0.8rem;">—</span>
                @endif
              </td>

              {{-- 6. NOMINAL --}}
              <td style="white-space: nowrap;">
                @if($item->tipe === 'masuk')
                  <span style="color: #16a34a; font-weight: 700; font-size: 0.82rem;">
                    +Rp {{ number_format($item->nominal, 0, ',', '.') }}
                  </span>
                  @if($item->harga_satuan && $item->volume)
                    <div style="font-size: 0.68rem; color: #64748b;">
                      {{ $item->volume }} {{ $item->satuan ?: 'item' }} &times; Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                    </div>
                  @endif
                  @if($item->status === 'dp' || (float)$item->sisa_piutang > 0)
                    <div style="font-size: 0.69rem; color: #b45309; font-weight: 600; margin-top: 2px;" title="Sisa tagihan yang belum dilunasi">
                      Sisa: Rp {{ number_format($item->sisa_piutang, 0, ',', '.') }}
                    </div>
                  @endif
                @else
                  <span style="color: #dc2626; font-weight: 700; font-size: 0.82rem;">
                    -Rp {{ number_format($item->nominal, 0, ',', '.') }}
                  </span>
                  @if($item->harga_satuan && $item->volume)
                    <div style="font-size: 0.68rem; color: #64748b;">
                      {{ $item->volume }} {{ $item->satuan ?: 'item' }} &times; Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                    </div>
                  @endif
                @endif
              </td>

              {{-- 7. METODE --}}
              @php
                $mRaw = $item->metode_pembayaran ?? 'Transfer Bank';
                if (str_starts_with($mRaw, 'Transfer Bank')) {
                    $mLabel = 'Transfer Bank';
                } elseif (str_starts_with($mRaw, 'QRIS')) {
                    $mLabel = 'QRIS';
                } elseif (str_starts_with($mRaw, 'Tunai')) {
                    $mLabel = 'Tunai';
                } else {
                    $mLabel = \Illuminate\Support\Str::limit($mRaw, 14);
                }
              @endphp
              <td style="white-space: nowrap;">
                <span style="color: #475569; font-size: 0.76rem;" title="{{ $mRaw }}">
                  {{ $mLabel }}
                </span>
              </td>

              {{-- 8. STATUS --}}
              <td style="white-space: nowrap;" class="text-center">
                @if(($item->status ?? 'lunas') === 'lunas')
                  <span style="background-color: #dcfce7; color: #15803d; border-radius: 9999px; padding: 3px 9px; font-weight: 600; font-size: 0.7rem; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas fa-check-circle" style="font-size: 0.65rem;"></i> Lunas
                  </span>
                @elseif($item->status === 'dp' || (float)$item->sisa_piutang > 0)
                  <button type="button" class="btn p-0 border-0" onclick="openPelunasanModal({{ $item->id }})" title="Status: Pembayaran DP · Sisa Piutang: Rp {{ number_format($item->sisa_piutang, 0, ',', '.') }} · Klik untuk catat pelunasan">
                    <span style="background-color: #fef3c7; color: #b45309; border-radius: 9999px; padding: 3px 9px; font-weight: 600; font-size: 0.7rem; display: inline-flex; align-items: center; gap: 4px; border: 1px solid #fde68a; cursor: pointer;">
                      <i class="fas fa-clock" style="font-size: 0.65rem;"></i> DP
                    </span>
                  </button>
                @else
                  <span style="background-color: #f1f5f9; color: #475569; border-radius: 9999px; padding: 3px 9px; font-weight: 600; font-size: 0.7rem; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas fa-hourglass-half" style="font-size: 0.65rem;"></i> Pending
                  </span>
                @endif
              </td>

              {{-- 9. AKSI (4 Tombol Standar Selalu Sejajar Sempurna) --}}
              <td class="text-center" style="white-space: nowrap; padding-left: 10px; padding-right: 14px;">
                <div class="d-inline-flex align-items-center justify-content-center flex-nowrap" style="gap: 5px;">
                  {{-- Tombol 1: Detail (Eye) --}}
                  <button type="button" class="btn btn-light border p-0 flex-shrink-0" style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; color: #475569; background: #fff;"
                          title="Lihat Detail Transaksi"
                          onclick="openDetailModal({{ $item->id }})">
                    <i class="fas fa-eye" style="font-size: 0.72rem;"></i>
                  </button>

                  {{-- Tombol 3: Edit --}}
                  <a href="{{ route('backoffice.cashflow.edit', $item->id) }}"
                     class="btn btn-light border p-0 flex-shrink-0" style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; color: #475569; background: #fff;"
                     title="Edit Transaksi">
                    <i class="fas fa-pencil-alt" style="font-size: 0.72rem;"></i>
                  </a>

                  {{-- Tombol 4: Delete --}}
                  <button type="button" class="btn border p-0 flex-shrink-0" style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; background: #fef2f2; border-color: #fee2e2 !important; color: #ef4444;"
                          title="Hapus Transaksi"
                          onclick="confirmDelete('{{ $item->id }}', '{{ $item->kode }}', '{{ number_format($item->nominal, 0, ',', '.') }}')">
                    <i class="fas fa-trash-alt" style="font-size: 0.72rem;"></i>
                  </button>
                </div>

                {{-- Hidden Form Delete --}}
                <form id="delete-form-{{ $item->id }}" action="{{ route('backoffice.cashflow.destroy', $item->id) }}" method="POST" class="d-none">
                  @csrf
                  @method('DELETE')
                </form>

                {{-- Hidden JSON Data Transaksi untuk Modal Detail & Pelunasan --}}
                <script type="application/json" id="trx-data-{{ $item->id }}">
                  {!! json_encode([
                    'id'                => $item->id,
                    'kode'              => $item->kode,
                    'tipe'              => $item->tipe,
                    'status'            => $item->status ?? 'lunas',
                    'tanggal'           => \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y'),
                    'tanggal_lengkap'   => \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y'),
                    'jatuh_tempo'       => $item->jatuh_tempo ? \Carbon\Carbon::parse($item->jatuh_tempo)->format('d/m/Y') : null,
                    'judul'             => $item->judul ?? $item->kategori,
                    'kategori'          => $item->kategori,
                    'kode_kategori'     => $item->kode_kategori,
                    'program'           => $item->program ? $item->program->nama : null,
                    'divisi'            => $item->program && $item->program->divisi ? $item->program->divisi->nama : null,
                    'nominal'           => number_format($item->nominal, 0, ',', '.'),
                    'nominal_raw'       => (float) $item->nominal,
                    'total_tagihan'     => number_format((float) ($item->total_tagihan ?: ($item->nominal + $item->sisa_piutang)), 0, ',', '.'),
                    'total_tagihan_raw' => (float) ($item->total_tagihan ?: ($item->nominal + $item->sisa_piutang)),
                    'sisa_piutang'      => number_format((float) ($item->sisa_piutang ?? 0), 0, ',', '.'),
                    'sisa_piutang_raw'  => (float) ($item->sisa_piutang ?? 0),
                    'catatan_pelunasan' => $item->catatan_pelunasan,
                    'metode_pembayaran' => $item->metode_pembayaran ?? 'Transfer Bank',
                    'nama_pihak'        => $item->nama_pihak,
                    'deskripsi'         => $item->deskripsi,
                    'lampiran'          => $item->lampiran ? asset($item->lampiran) : null,
                    'is_pdf'            => $item->lampiran ? str_ends_with(strtolower($item->lampiran), '.pdf') : false,
                    'creator'           => $item->creator ? $item->creator->name : 'Sistem',
                    'created_at'        => $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-',
                    'invoice_url'       => route('backoffice.cashflow.invoice', $item->id),
                    'edit_url'          => route('backoffice.cashflow.edit', $item->id),
                  ]) !!}
                </script>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-center py-5 text-muted">
                <i class="fas fa-folder-open fs-1 text-secondary mb-3 d-block"></i>
                <h6 class="fw-bold mb-1">Belum Ada Transaksi Kas Ditemukan</h6>
                <p class="small mb-3">Sesuaikan kriteria filter atau catat transaksi kas masuk/keluar baru sekarang.</p>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahTransaksi" style="background: #CC0000; border-color: #CC0000;">
                  <i class="fas fa-plus me-1"></i> Catat Transaksi Baru
                </button>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Footer Pagination --}}
    @if($cashflows->hasPages())
      <div class="card-footer bg-white border-0 py-3 d-flex justify-content-center">
        {{ $cashflows->withQueryString()->links('pagination::bootstrap-5') }}
      </div>
    @endif
  </div>

  {{-- BAGIAN AKUMULASI PER KATEGORI PROGRAM DI (Sesuai FOTO 3 - Paling Bawah Keuangan Umum) --}}
  <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
    <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
      <h5 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">Akumulasi per Kategori Program DI</h5>
      <a href="{{ route('backoffice.project.index') }}" class="text-primary text-decoration-none small fw-semibold">
        Lihat Keuangan per Program <i class="fas fa-arrow-right ms-1"></i>
      </a>
    </div>

    <div class="table-responsive">
      <table class="table table-hover table-accumulation align-middle mb-0">
        <thead>
          <tr>
            <th style="min-width: 260px;">KATEGORI PROGRAM</th>
            <th class="text-end" style="min-width: 140px;">PEMASUKAN</th>
            <th class="text-end" style="min-width: 140px;">PENGELUARAN</th>
            <th class="text-end" style="min-width: 140px;">SALDO</th>
            <th class="text-center" style="min-width: 100px;">MARGIN</th>
            <th class="text-center" style="min-width: 100px;">TRANSAKSI</th>
            <th class="text-center" style="min-width: 140px;">AKSI</th>
          </tr>
        </thead>
        <tbody>
          {{-- Baris per Kategori Divisi Denpasar Institute --}}
          @foreach($divisiSummaries as $item)
            <tr>
              <td>
                <span class="fw-bold text-dark fs-6">{{ $item['divisi']->nama }}</span>
              </td>
              <td class="text-end">
                <span class="fw-bold" style="color: #16a34a;">
                  Rp {{ number_format($item['pemasukan'], 0, ',', '.') }}
                </span>
              </td>
              <td class="text-end">
                <span class="fw-bold" style="color: #dc2626;">
                  Rp {{ number_format($item['pengeluaran'], 0, ',', '.') }}
                </span>
              </td>
              <td class="text-end">
                <span class="fw-bold" style="color: {{ $item['saldo'] >= 0 ? '#2563eb' : '#dc2626' }};">
                  Rp {{ number_format($item['saldo'], 0, ',', '.') }}
                </span>
              </td>
              <td class="text-center">
                <span class="fw-bold" style="color: #7c3aed;">
                  {{ $item['pemasukan'] > 0 ? $item['margin'] . '%' : '-' }}
                </span>
              </td>
              <td class="text-center fw-semibold text-muted">
                {{ $item['transaksi_count'] }}
              </td>
              <td class="text-center">
                <a href="{{ route('backoffice.project.kategori', $item['divisi']->id) }}" class="btn-lihat-program">
                  Lihat Program
                </a>
              </td>
            </tr>
          @endforeach

          {{-- Baris Khusus: Umum (Operasional Non-Program) Sesuai FOTO 3 --}}
          <tr style="background-color: #fafbfc;">
            <td>
              <span class="fw-bold text-dark fs-6">{{ $umumSummary['nama'] }}</span>
            </td>
            <td class="text-end">
              <span class="fw-bold" style="color: #16a34a;">
                Rp {{ number_format($umumSummary['pemasukan'], 0, ',', '.') }}
              </span>
            </td>
            <td class="text-end">
              <span class="fw-bold" style="color: #dc2626;">
                Rp {{ number_format($umumSummary['pengeluaran'], 0, ',', '.') }}
              </span>
            </td>
            <td class="text-end">
              <span class="fw-bold" style="color: {{ $umumSummary['saldo'] >= 0 ? '#2563eb' : '#dc2626' }};">
                Rp {{ number_format($umumSummary['saldo'], 0, ',', '.') }}
              </span>
            </td>
            <td class="text-center">
              <span class="fw-bold" style="color: #7c3aed;">
                {{ $umumSummary['pemasukan'] > 0 ? $umumSummary['margin'] . '%' : '-' }}
              </span>
            </td>
            <td class="text-center fw-semibold text-muted">
              {{ $umumSummary['transaksi_count'] }}
            </td>
            <td class="text-center">
              <a href="{{ route('backoffice.project.kategori', 'umum') }}" class="btn-lihat-program">
                Lihat Program
              </a>
            </td>
          </tr>
        </tbody>
        <tfoot style="background-color: #f1f5f9; border-top: 2px solid #cbd5e1;">
          <tr class="fw-bold">
            <td class="text-dark">TOTAL KESELURUHAN</td>
            <td class="text-end text-success">
              Rp {{ number_format($totalAkumulasiMasuk, 0, ',', '.') }}
            </td>
            <td class="text-end text-danger">
              Rp {{ number_format($totalAkumulasiKeluar, 0, ',', '.') }}
            </td>
            <td class="text-end" style="color: {{ $totalAkumulasiSaldo >= 0 ? '#2563eb' : '#dc2626' }};">
              Rp {{ number_format($totalAkumulasiSaldo, 0, ',', '.') }}
            </td>
            <td class="text-center" style="color: #7c3aed;">
              {{ $totalAkumulasiMasuk > 0 ? round(($totalAkumulasiSaldo / $totalAkumulasiMasuk) * 100, 1) . '%' : '-' }}
            </td>
            <td class="text-center text-muted">
              {{ $totalAkumulasiTransaksi }}
            </td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  {{-- Include Modal Tambah Transaksi (Sesuai Foto 2 & 3) --}}
  @include('backoffice.cashflow.partials.modal-transaksi')

</div>

{{-- Modal Detail Transaksi Lengkap (Eye Button) --}}
<div class="modal fade" id="modalDetailTransaksi" tabindex="-1" aria-labelledby="modalDetailTransaksiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header bg-light border-bottom py-3">
        <div>
          <h5 class="modal-title fw-bold mb-0 text-dark" id="modalDetailTransaksiLabel">
            <i class="fas fa-file-invoice text-danger me-2"></i> Detail Transaksi Kas
          </h5>
          <span class="small text-muted" id="modalDetailSubtitle"></span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        
        {{-- Banner Header: Judul & Nominal --}}
        <div class="p-3 rounded-3 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3" id="modalHeaderBanner">
          <div>
            <div class="d-flex align-items-center gap-2 mb-1">
              <span id="modalBadgeTipe"></span>
              <span id="modalBadgeStatus"></span>
              <span class="badge bg-secondary-subtle text-secondary font-monospace" id="modalKode"></span>
            </div>
            <h4 class="fw-bold text-dark mb-0" id="modalJudul"></h4>
          </div>
          <div class="text-md-end">
            <span class="text-muted small d-block">Nominal Transaksi:</span>
            <h3 class="fw-bold mb-0" id="modalNominal"></h3>
          </div>
        </div>

        {{-- Detail Informasi Grid --}}
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <div class="p-3 bg-light rounded-3 h-100">
              <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                <i class="fas fa-info-circle text-primary me-2"></i> Informasi Utama
              </h6>
              <div class="mb-2">
                <small class="text-muted d-block">Program Denpasar Institute:</small>
                <div class="fw-bold text-dark" id="modalProgram">—</div>
              </div>
              <div class="mb-2">
                <small class="text-muted d-block">Kategori Transaksi:</small>
                <div class="fw-semibold text-dark" id="modalKategori">-</div>
              </div>
              <div class="mb-2">
                <small class="text-muted d-block">Tanggal Transaksi:</small>
                <div class="fw-semibold text-dark" id="modalTanggal">-</div>
              </div>
              <div>
                <small class="text-muted d-block">Metode Pembayaran:</small>
                <div class="fw-semibold text-dark" id="modalMetode">-</div>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-6">
            <div class="p-3 bg-light rounded-3 h-100">
              <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                <i class="fas fa-user-tag text-info me-2"></i> Rekanan &amp; Keterangan
              </h6>
              <div class="mb-2">
                <small class="text-muted d-block">Pihak Terkait / Penerima / Pengirim:</small>
                <div class="fw-bold text-dark" id="modalPihak">—</div>
              </div>
              <div class="mb-2">
                <small class="text-muted d-block">Keterangan / Deskripsi:</small>
                <div class="text-muted small" id="modalDeskripsi" style="white-space: pre-wrap;">—</div>
              </div>
              <div>
                <small class="text-muted d-block">Dicatat Oleh:</small>
                <div class="small text-muted"><span id="modalCreator" class="fw-semibold text-dark"></span> (<span id="modalCreatedAt"></span>)</div>
              </div>
            </div>
          </div>

          {{-- Status Pembayaran & Piutang --}}
          <div class="col-12" id="modalPiutangSection" style="display: none;">
            <div class="p-3 bg-warning-subtle rounded-3 border border-warning-subtle">
              <h6 class="fw-bold text-dark mb-2">
                <i class="fas fa-hand-holding-dollar text-warning-emphasis me-2"></i> Rincian Skema DP &amp; Sisa Piutang
              </h6>
              <div class="row g-2 small">
                <div class="col-6 col-md-3">
                  <span class="text-muted d-block" style="font-size: 0.72rem;">TOTAL BIAYA:</span>
                  <strong class="text-dark fs-6" id="modalTotalTagihan"></strong>
                </div>
                <div class="col-6 col-md-3">
                  <span class="text-muted d-block" style="font-size: 0.72rem;">TELAH DIBAYAR (DP):</span>
                  <strong class="text-success fs-6" id="modalSudahBayar"></strong>
                </div>
                <div class="col-6 col-md-3">
                  <span class="text-muted d-block" style="font-size: 0.72rem;">SISA PIUTANG:</span>
                  <strong class="text-danger fs-6" id="modalSisaPiutang"></strong>
                </div>
                <div class="col-6 col-md-3">
                  <span class="text-muted d-block" style="font-size: 0.72rem;">JATUH TEMPO:</span>
                  <strong class="text-dark" id="modalJatuhTempo">—</strong>
                </div>
              </div>
              <div class="mt-2 pt-2 border-top border-warning-subtle d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                <div class="small text-muted" id="modalCatatanPelunasan" style="font-size: 0.74rem;"></div>
                <button type="button" class="btn btn-sm btn-success fw-bold px-3 flex-shrink-0" id="modalBtnLunaskanDariDetail">
                  <i class="fas fa-hand-holding-dollar me-1"></i> Input Pelunasan
                </button>
              </div>
            </div>
          </div>

          {{-- Lampiran Bukti --}}
          <div class="col-12" id="modalLampiranSection">
            <div class="p-3 bg-light rounded-3">
              <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                <i class="fas fa-paperclip text-danger me-2"></i> Bukti Pembayaran / Lampiran
              </h6>
              <div id="modalLampiranContent" class="text-center py-2"></div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer border-top py-3 d-flex justify-content-between">
        <div>
          <a id="modalBtnEdit" href="#" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-pencil-alt me-1"></i> Edit Data
          </a>
        </div>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal Pelunasan Piutang Peserta --}}
<div class="modal fade" id="pelunasanModal" tabindex="-1" aria-labelledby="pelunasanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header bg-success text-white py-3">
        <h6 class="modal-title fw-bold" id="pelunasanModalLabel">
          <i class="fas fa-hand-holding-dollar me-2"></i> Form Pelunasan Piutang Peserta
        </h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="pelunasanForm" action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4">
          <div class="p-3 bg-light rounded-3 mb-3 border">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <span class="small text-muted font-monospace fw-bold" id="pelunasanKode"></span>
              <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle" style="font-size: 0.72rem;">
                <i class="fas fa-clock me-1"></i> STATUS: DP
              </span>
            </div>
            <div class="fw-bold text-dark fs-6" id="pelunasanNama"></div>
            <div class="small text-muted mb-2" id="pelunasanProgram"></div>
            <div class="row g-2 pt-2 border-top">
              <div class="col-6">
                <span class="small text-muted d-block" style="font-size: 0.72rem;">TELAH DIBAYAR (DP):</span>
                <span class="fw-bold text-success fs-6" id="pelunasanSudahBayar"></span>
              </div>
              <div class="col-6 text-end">
                <span class="small text-muted d-block" style="font-size: 0.72rem;">SISA PIUTANG:</span>
                <span class="fw-bold text-danger fs-6" id="pelunasanSisaPiutang"></span>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-bold text-dark mb-1">
              <span class="text-danger">*</span> Nominal Pelunasan (Rp):
            </label>
            <div class="input-group">
              <span class="input-group-text bg-white fw-bold">Rp</span>
              <input type="text" name="nominal_pelunasan" id="pelunasanNominalInput" class="form-control fw-bold fs-5 text-dark" required oninput="formatRupiahInput(this)">
              <button type="button" class="btn btn-outline-success btn-sm fw-bold px-3" id="btnPelunasanPenuh" title="Isi dengan seluruh sisa piutang">
                Lunaskan Semua
              </button>
            </div>
            <div class="form-text small text-muted">
              Bisa dilunasi 100% penuh atau dicicil bertahap sesuai pembayaran peserta.
            </div>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label small fw-bold text-dark mb-1">
                <span class="text-danger">*</span> Tanggal Pelunasan:
              </label>
              <input type="date" name="tanggal_pelunasan" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-6">
              <label class="form-label small fw-bold text-dark mb-1">Metode Pembayaran:</label>
              <select name="metode_pembayaran" class="form-select form-select-sm">
                @foreach($metodeOptions as $m)
                  <option value="{{ $m }}">{{ $m }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-bold text-dark mb-1">Bukti Transfer / Struk Pelunasan (Opsional):</label>
            <input type="file" name="lampiran" class="form-control form-control-sm" accept="image/jpeg,image/png,image/jpg,image/webp,application/pdf">
            <div class="form-text small text-muted">Format: JPG, PNG, PDF (Maks. 5MB)</div>
          </div>

          <div class="mb-0">
            <label class="form-label small fw-bold text-dark mb-1">Catatan Tambahan (Opsional):</label>
            <textarea name="catatan" class="form-control form-control-sm" rows="2" placeholder="Contoh: Pelunasan sisa biaya pendaftaran tahap ke-2 via transfer..."></textarea>
          </div>
        </div>
        <div class="modal-footer border-top py-2 d-flex justify-content-between">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-success px-3 fw-bold">
            <i class="fas fa-check-circle me-1"></i> Simpan Pelunasan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

</div>

{{-- Modal Preview Lampiran / Bukti --}}
<div class="modal fade" id="modalPreviewLampiran" tabindex="-1" aria-labelledby="modalPreviewLampiranLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-bottom py-3">
        <h6 class="modal-title fw-bold" id="modalPreviewLampiranLabel">
          <i class="fas fa-receipt text-danger me-2"></i> Bukti Lampiran Transaksi
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-3">
        <img id="previewModalImg" src="" alt="Bukti Kas" class="img-fluid rounded-3 border" style="max-height: 70vh; object-fit: contain;">
      </div>
      <div class="modal-footer border-top py-2 d-flex justify-content-between">
        <a id="btnDownloadBukti" href="" download target="_blank" class="btn btn-sm btn-outline-secondary">
          <i class="fas fa-download me-1"></i> Buka Gambar Penuh
        </a>
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Filter Program in Tab 1 (Rekapitulasi Kas Per Program)
  const filterDivisiData = @json($divisiList);

  function handleFilterDivisiChange(divisiId) {
    const boxProgram = document.getElementById('boxFilterProgramWrapper');
    const colDivisi = document.getElementById('colFilterDivisi');
    const selectProgram = document.getElementById('filterProgram');

    if (!divisiId || divisiId === 'all' || divisiId === 'none') {
      if (boxProgram) boxProgram.style.display = 'none';
      if (colDivisi) {
        colDivisi.classList.remove('col-sm-6');
        colDivisi.classList.add('col-12');
      }
      if (selectProgram) {
        selectProgram.innerHTML = '<option value="all">Semua Program Divisi Ini</option>';
        selectProgram.value = 'all';
      }
      document.getElementById('filterForm').submit();
      return;
    }

    const selectedDiv = filterDivisiData.find(d => String(d.id) === String(divisiId));

    if (selectedDiv && selectedDiv.programs && selectedDiv.programs.length > 0) {
      if (selectProgram) {
        selectProgram.innerHTML = '<option value="all">Semua Program Divisi Ini</option>';
        selectedDiv.programs.forEach(p => {
          const opt = document.createElement('option');
          opt.value = p.id;
          opt.textContent = p.nama;
          selectProgram.appendChild(opt);
        });
        selectProgram.value = 'all';
      }
      if (colDivisi) {
        colDivisi.classList.remove('col-12');
        colDivisi.classList.add('col-sm-6');
      }
      if (boxProgram) {
        boxProgram.style.display = '';
      }
    } else {
      if (boxProgram) boxProgram.style.display = 'none';
      if (colDivisi) {
        colDivisi.classList.remove('col-sm-6');
        colDivisi.classList.add('col-12');
      }
      if (selectProgram) {
        selectProgram.innerHTML = '<option value="all">Semua Program Divisi Ini</option>';
        selectProgram.value = 'all';
      }
    }

    document.getElementById('filterForm').submit();
  }

  const kategoriOptionsData = @json($kategoriOptions);

  function handleFilterTipeKategoriChange(tipeKat) {
    const boxKat = document.getElementById('boxFilterKategoriWrapper');
    const colTipeKat = document.getElementById('colFilterTipeKategori');
    const selectKat = document.getElementById('filterKategori');

    if (!tipeKat || tipeKat === 'all') {
      if (boxKat) boxKat.style.display = 'none';
      if (colTipeKat) {
        colTipeKat.classList.remove('col-sm-6');
        colTipeKat.classList.add('col-12');
      }
      if (selectKat) {
        selectKat.innerHTML = '<option value="all">Semua Kategori</option>';
        selectKat.value = 'all';
      }
      document.getElementById('filterForm').submit();
      return;
    }

    const list = kategoriOptionsData[tipeKat] || {};
    const defaultText = tipeKat === 'masuk' ? 'Semua Kategori Pemasukan' : 'Semua Kategori Pengeluaran';

    if (selectKat) {
      selectKat.innerHTML = `<option value="all">${defaultText}</option>`;
      for (const [code, label] of Object.entries(list)) {
        const opt = document.createElement('option');
        opt.value = label;
        opt.textContent = `[${code}] ${label}`;
        selectKat.appendChild(opt);
      }
      selectKat.value = 'all';
    }

    if (colTipeKat) {
      colTipeKat.classList.remove('col-12');
      colTipeKat.classList.add('col-sm-6');
    }

    if (boxKat) {
      boxKat.style.display = '';
    }

    document.getElementById('filterForm').submit();
  }

  // Jump from Program View to Transaksi View with Program Filter
  // Open Detail Modal
  function openDetailModal(id) {
    const el = document.getElementById('trx-data-' + id);
    if (!el) return;
    const data = JSON.parse(el.textContent);

    document.getElementById('modalDetailSubtitle').textContent = data.kode + ' • ' + data.tanggal_lengkap;
    document.getElementById('modalKode').textContent = data.kode;
    document.getElementById('modalJudul').textContent = data.judul;

    // Header banner & badges
    const banner = document.getElementById('modalHeaderBanner');
    const badgeTipe = document.getElementById('modalBadgeTipe');
    const badgeStatus = document.getElementById('modalBadgeStatus');
    const elNominal = document.getElementById('modalNominal');

    if (data.tipe === 'masuk') {
      banner.style.background = '#f0fdf4';
      banner.style.border = '1px solid #bbf7d0';
      badgeTipe.className = 'badge bg-success-subtle text-success px-2 py-1 fw-bold';
      badgeTipe.innerHTML = '<i class="fas fa-arrow-down me-1"></i> UANG MASUK';
      elNominal.className = 'fw-bold mb-0 text-success';
      elNominal.textContent = '+Rp ' + data.nominal;
    } else {
      banner.style.background = '#fef2f2';
      banner.style.border = '1px solid #fecaca';
      badgeTipe.className = 'badge bg-danger-subtle text-danger px-2 py-1 fw-bold';
      badgeTipe.innerHTML = '<i class="fas fa-arrow-up me-1"></i> UANG KELUAR';
      elNominal.className = 'fw-bold mb-0 text-danger';
      elNominal.textContent = '-Rp ' + data.nominal;
    }

    if (data.status === 'lunas') {
      badgeStatus.className = 'badge bg-success-subtle text-success px-2 py-1';
      badgeStatus.innerHTML = '<i class="fas fa-check-circle me-1"></i> LUNAS';
    } else if (data.status === 'dp' || (data.sisa_piutang_raw && data.sisa_piutang_raw > 0)) {
      badgeStatus.className = 'badge bg-warning-subtle text-warning-emphasis px-2 py-1';
      badgeStatus.innerHTML = '<i class="fas fa-clock me-1"></i> DP / PIUTANG';
    } else {
      badgeStatus.className = 'badge bg-secondary-subtle text-secondary px-2 py-1';
      badgeStatus.innerHTML = '<i class="fas fa-clock me-1"></i> PENDING';
    }

    // Detail fields
    if (data.program) {
      document.getElementById('modalProgram').innerHTML = '<span class="text-danger fw-bold"><i class="fas fa-graduation-cap me-1"></i> ' + data.program + '</span>' + (data.divisi ? ' <span class="text-muted small">(' + data.divisi + ')</span>' : '');
    } else {
      document.getElementById('modalProgram').innerHTML = '<span class="text-muted">— Operasional Umum (Tanpa Program) —</span>';
    }

    document.getElementById('modalKategori').textContent = (data.kode_kategori ? '[' + data.kode_kategori + '] ' : '') + data.kategori;
    document.getElementById('modalTanggal').textContent = data.tanggal_lengkap;
    document.getElementById('modalMetode').textContent = data.metode_pembayaran;
    document.getElementById('modalPihak').textContent = data.nama_pihak ? data.nama_pihak : '—';
    document.getElementById('modalDeskripsi').innerHTML = data.deskripsi ? data.deskripsi : 'Tidak ada keterangan tambahan.';
    document.getElementById('modalCreator').textContent = data.creator;
    document.getElementById('modalCreatedAt').textContent = data.created_at;

    // Piutang section
    const piutangSec = document.getElementById('modalPiutangSection');
    if (data.sisa_piutang_raw && data.sisa_piutang_raw > 0) {
      piutangSec.style.display = 'block';
      document.getElementById('modalTotalTagihan').textContent = 'Rp ' + data.total_tagihan;
      document.getElementById('modalSudahBayar').textContent = 'Rp ' + data.nominal;
      document.getElementById('modalSisaPiutang').textContent = 'Rp ' + data.sisa_piutang;
      document.getElementById('modalJatuhTempo').textContent = data.jatuh_tempo ? data.jatuh_tempo : '—';
      document.getElementById('modalCatatanPelunasan').textContent = data.catatan_pelunasan ? data.catatan_pelunasan : '';

      const btnLunaskan = document.getElementById('modalBtnLunaskanDariDetail');
      btnLunaskan.style.display = 'inline-block';
      btnLunaskan.onclick = function() {
        bootstrap.Modal.getInstance(document.getElementById('modalDetailTransaksi')).hide();
        openPelunasanModal(data.id);
      };
    } else {
      piutangSec.style.display = 'none';
    }

    // Lampiran
    const lampiranSec = document.getElementById('modalLampiranContent');
    if (data.lampiran) {
      if (data.is_pdf) {
        lampiranSec.innerHTML = '<a href="' + data.lampiran + '" target="_blank" class="btn btn-outline-danger btn-sm"><i class="fas fa-file-pdf me-1"></i> Buka Dokumen PDF Lampiran</a>';
      } else {
        lampiranSec.innerHTML = '<a href="' + data.lampiran + '" target="_blank"><img src="' + data.lampiran + '" class="img-fluid rounded border shadow-sm" style="max-height: 260px; object-fit: contain;"></a><div class="small text-muted mt-1"><i class="fas fa-search-plus me-1"></i> Klik gambar untuk melihat ukuran penuh</div>';
      }
    } else {
      lampiranSec.innerHTML = '<span class="text-muted small fst-italic"><i class="fas fa-info-circle me-1"></i> Tidak ada file bukti atau lampiran yang diunggah.</span>';
    }

    if (document.getElementById('modalBtnEdit')) {
      document.getElementById('modalBtnEdit').href = data.edit_url;
    }

    const modal = new bootstrap.Modal(document.getElementById('modalDetailTransaksi'));
    modal.show();
  }

  // Handle dynamic switcher for periode (Hanya: Semua Periode, Harian, Bulanan, Tahunan - Sesuai Foto 2)
  function handlePeriodeChange(val) {
    const boxHarian = document.getElementById('subFilterHarian');
    const boxBulanan = document.getElementById('subFilterBulanan');
    const boxTahunan = document.getElementById('subFilterTahunan');

    const inputTglDari = document.getElementById('inputTglDari');
    const inputTglSampai = document.getElementById('inputTglSampai');
    const selectBulanDari = document.querySelector('select[name="bulan_dari"]');
    const selectBulanSampai = document.querySelector('select[name="bulan_sampai"]');
    const selectTahun = document.querySelector('select[name="tahun"]');

    if (boxHarian) boxHarian.style.display = 'none';
    if (boxBulanan) boxBulanan.style.display = 'none';
    if (boxTahunan) boxTahunan.style.display = 'none';

    if (val === 'bulanan') {
      if (boxBulanan) boxBulanan.style.display = 'block';
      if (inputTglDari) inputTglDari.value = '';
      if (inputTglSampai) inputTglSampai.value = '';
      if (selectTahun) selectTahun.value = 'all';
    } else if (val === 'tahunan') {
      if (boxTahunan) boxTahunan.style.display = 'block';
      if (inputTglDari) inputTglDari.value = '';
      if (inputTglSampai) inputTglSampai.value = '';
      if (selectBulanDari) selectBulanDari.value = '';
      if (selectBulanSampai) selectBulanSampai.value = '';
      if (selectTahun && (selectTahun.value === 'all' || !selectTahun.value)) {
        selectTahun.value = '{{ date('Y') }}';
      }
      document.getElementById('filterForm').submit();
    } else if (val === 'all') {
      if (boxHarian) boxHarian.style.display = 'block';
      if (inputTglDari) inputTglDari.value = '';
      if (inputTglSampai) inputTglSampai.value = '';
      if (selectBulanDari) selectBulanDari.value = '';
      if (selectBulanSampai) selectBulanSampai.value = '';
      if (selectTahun) selectTahun.value = 'all';
      document.getElementById('filterForm').submit();
    } else {
      // harian / pilih rentang tanggal
      if (boxHarian) boxHarian.style.display = 'block';
    }
  }

  // Open Pelunasan Modal
  function openPelunasanModal(id) {
    const el = document.getElementById('trx-data-' + id);
    if (!el) return;
    const data = JSON.parse(el.textContent);

    document.getElementById('pelunasanForm').action = '/backoffice/cashflow/' + id + '/pelunasan';
    document.getElementById('pelunasanKode').textContent = data.kode;
    document.getElementById('pelunasanNama').textContent = data.nama_pihak || data.judul;
    document.getElementById('pelunasanProgram').textContent = data.program ? ('Program: ' + data.program) : data.kategori;
    document.getElementById('pelunasanSudahBayar').textContent = 'Rp ' + data.nominal;
    document.getElementById('pelunasanSisaPiutang').textContent = 'Rp ' + data.sisa_piutang;

    const sisaRaw = data.sisa_piutang_raw || 0;
    const inputNominal = document.getElementById('pelunasanNominalInput');
    inputNominal.value = new Intl.NumberFormat('id-ID').format(sisaRaw);

    document.getElementById('btnPelunasanPenuh').onclick = function() {
      inputNominal.value = new Intl.NumberFormat('id-ID').format(sisaRaw);
    };

    const modal = new bootstrap.Modal(document.getElementById('pelunasanModal'));
    modal.show();
  }

  function formatRupiahInput(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    if (value) {
      input.value = new Intl.NumberFormat('id-ID').format(value);
    } else {
      input.value = '';
    }
  }

  // Modal Preview Image
  function previewModal(imgUrl, title) {
    document.getElementById('previewModalImg').src = imgUrl;
    document.getElementById('btnDownloadBukti').href = imgUrl;
    document.getElementById('modalPreviewLampiranLabel').innerHTML = '<i class="fas fa-receipt text-danger me-2"></i> Bukti Kas: ' + title;
    var myModal = new bootstrap.Modal(document.getElementById('modalPreviewLampiran'));
    myModal.show();
  }

  // Delete Confirmation with SweetAlert2
  function confirmDelete(id, kode, nominal) {
    Swal.fire({
      title: 'Hapus Transaksi Kas?',
      html: `Apakah Anda yakin ingin menghapus transaksi <b>${kode}</b> senilai <b>Rp ${nominal}</b>?<br><small class="text-danger">Tindakan ini tidak dapat dibatalkan.</small>`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc2626',
      cancelButtonColor: '#6b7280',
      confirmButtonText: '<i class="fas fa-trash me-1"></i> Ya, Hapus',
      cancelButtonText: 'Batal',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('delete-form-' + id).submit();
      }
    });
  }

  // Penggeser Cepat & Drag Table Scroll
  document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('wrapperTableCashflow');
    const topScroll = document.getElementById('topScrollCashflow');
    const topInner = document.getElementById('topScrollCashflowInner');
    const btnLeft = document.getElementById('btnScrollCashflowLeft');
    const btnRight = document.getElementById('btnScrollCashflowRight');
    const table = document.getElementById('tableCashflowData');

    if (!wrapper || !topScroll || !topInner || !table) return;

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

    let isDown = false;
    let startX = 0;
    let scrollStart = 0;

    wrapper.classList.add('table-grab');

    wrapper.addEventListener('mousedown', function (e) {
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
      const walk = (x - startX) * 1.5;
      wrapper.scrollLeft = scrollStart - walk;
    });
  });
</script>
@endpush

