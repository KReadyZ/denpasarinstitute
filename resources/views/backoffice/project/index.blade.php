@extends('backoffice.layouts.app')

@section('title', 'Program Kursus | Backoffice Denpasar Institute')
@section('page-title', 'Program Kursus')

@push('styles')
<style>
  .category-card {
    background: #ffffff;
    border: 1px solid #e9ecef;
    border-radius: 16px;
    padding: 22px 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    position: relative;
    transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease, border-color 0.2s ease;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
  }
  .category-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 28px rgba(15, 23, 42, 0.09);
    border-color: #cbd5e1;
  }
  .category-icon-box {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    flex-shrink: 0;
    transition: transform 0.2s ease;
  }
  .category-card:hover .category-icon-box {
    transform: scale(1.08);
  }
  .category-badge-count {
    font-size: 0.75rem;
    font-weight: 700;
    padding: 4px 11px;
    border-radius: 9999px;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
  }
  .btn-quick-add {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    color: #475569;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .btn-quick-add:hover {
    background: #CC0000;
    border-color: #CC0000;
    color: #ffffff;
    transform: rotate(90deg);
  }
  .program-pill {
    background: #f8fafc;
    color: #334155;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 4px 11px;
    font-size: 0.78rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
    max-width: 100%;
    text-overflow: ellipsis;
    overflow: hidden;
    transition: all 0.15s ease;
  }
  .program-pill:hover {
    background: #ffffff;
    border-color: #94a3b8;
    color: #0f172a;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
  }
  .category-stats-bar {
    background: #f8fafc;
    border-radius: 10px;
    padding: 8px 12px;
    margin-top: 14px;
    margin-bottom: 2px;
    font-size: 0.78rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #f1f5f9;
  }
  .category-link-footer {
    border-top: 1px solid #f1f5f9;
    padding-top: 14px;
    margin-top: 14px;
    font-size: 0.88rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    justify-content: space-between;
    align-items: center;
    text-decoration: none;
    transition: color 0.15s ease;
  }
  .category-link-footer:hover {
    color: #CC0000;
  }
  .category-arrow-circle {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    color: #475569;
    transition: all 0.2s ease;
  }
  .category-card:hover .category-arrow-circle {
    background: #CC0000;
    color: #ffffff;
    transform: translateX(3px);
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

  /* Responsive Mobile Styles */
  .card-stat-value {
    font-size: 1.45rem;
    line-height: 1.15;
    letter-spacing: -0.4px;
    word-break: break-word;
  }
  @media (max-width: 576px) {
    .card-stat-value {
      font-size: 1.05rem !important;
      letter-spacing: -0.2px;
    }
    .category-card {
      padding: 14px 14px;
      border-radius: 14px;
    }
    .category-icon-box {
      width: 36px;
      height: 36px;
      font-size: 0.95rem;
      border-radius: 10px;
    }
    .category-badge-count {
      font-size: 0.68rem;
      padding: 3px 8px;
    }
    .category-stats-bar {
      padding: 6px 10px;
      font-size: 0.72rem;
      margin-top: 10px;
    }
    .category-link-footer {
      padding-top: 10px;
      margin-top: 10px;
      font-size: 0.8rem;
    }
    .program-pill {
      font-size: 0.72rem;
      padding: 3px 8px;
    }
  }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

  {{-- Top Navigation Header --}}
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 w-100">
    <div class="flex-shrink-0">
      <h2 class="h4 fw-bold text-dark mb-1 text-nowrap">
        <i class="fas fa-graduation-cap text-danger me-2"></i> Keuangan Program
      </h2>
      <p class="text-muted small mb-0">Ringkasan keuangan khusus seluruh program kursus Denpasar Institute</p>
    </div>
    <div class="d-flex align-items-center gap-2 ms-sm-auto justify-content-end flex-wrap flex-sm-nowrap">
      <a href="{{ route('backoffice.cashflow.index') }}" class="btn btn-sm btn-outline-secondary fw-semibold" style="height: 38px; display: inline-flex; align-items: center; border-radius: 8px; padding: 0 16px; font-size: 0.84rem; white-space: nowrap;">
        <i class="fas fa-wallet me-1"></i> Keuangan Umum
      </a>
      @if(auth()->check() && auth()->user()->role !== 'finance')
      <a href="{{ route('backoffice.project.program.create') }}" class="btn btn-sm btn-danger fw-bold shadow-sm" style="height: 38px; display: inline-flex; align-items: center; border-radius: 8px; background: #CC0000; border-color: #CC0000; padding: 0 18px; font-size: 0.84rem; white-space: nowrap;">
        <i class="fas fa-plus-circle me-1"></i> Tambah Program
      </a>
      @endif
    </div>
  </div>

  @php
    $pMasuk = $programPemasukan ?? 0;
    $pKeluar = $programPengeluaran ?? 0;
    $pPiutang = $programPiutang ?? 0;
    $pSelisih = $programSelisih ?? ($pMasuk - $pKeluar);
    $pPotensi = $pMasuk + $pPiutang;

    $pctMasuk = isset($programPersenMasuk) ? $programPersenMasuk : ($pPotensi > 0 ? round(($pMasuk / $pPotensi) * 100, 1) : 100.0);
    $pctKeluar = isset($programPersenKeluar) ? $programPersenKeluar : ($pMasuk > 0 ? round(($pKeluar / $pMasuk) * 100, 1) : ($pKeluar > 0 ? 100.0 : 0.0));
    $pctPiutang = isset($programPersenPiutang) ? $programPersenPiutang : ($pPotensi > 0 ? round(($pPiutang / $pPotensi) * 100, 1) : 0.0);
    $pctSelisih = isset($programPersenSelisih) ? $programPersenSelisih : ($pMasuk > 0 ? round(($pSelisih / $pMasuk) * 100, 1) : ($pKeluar > 0 ? -100.0 : 0.0));
  @endphp

  <div class="row g-2 g-md-3 mb-4">
    {{-- 1. Pemasukan --}}
    <div class="col-6 col-md-6 col-xl-3">
      <div class="card border-0 shadow-sm rounded-4 h-100">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="small text-muted fw-semibold" style="font-size: 0.75rem;">Pemasukan</span>
            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1" style="font-size: 0.68rem; font-weight: 700;" title="Realisasi {{ number_format($pctMasuk, 1, ',', '.') }}% dari total potensi pendapatan">
              <i class="fas fa-arrow-up me-1"></i>{{ number_format($pctMasuk, 1, ',', '.') }}%
            </span>
          </div>
          <div class="fw-bold text-success mb-0 card-stat-value">Rp {{ number_format($programPemasukan, 0, ',', '.') }}</div>
        </div>
      </div>
    </div>

    {{-- 2. Pengeluaran --}}
    <div class="col-6 col-md-6 col-xl-3">
      <div class="card border-0 shadow-sm rounded-4 h-100">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="small text-muted fw-semibold" style="font-size: 0.75rem;">Pengeluaran</span>
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-1" style="font-size: 0.68rem; font-weight: 700;" title="Menyerap {{ number_format($pctKeluar, 1, ',', '.') }}% dari pemasukan program">
              <i class="fas fa-arrow-down me-1"></i>{{ number_format($pctKeluar, 1, ',', '.') }}%
            </span>
          </div>
          <div class="fw-bold text-danger mb-0 card-stat-value">Rp {{ number_format($programPengeluaran, 0, ',', '.') }}</div>
        </div>
      </div>
    </div>

    {{-- 3. Piutang --}}
    <div class="col-6 col-md-6 col-xl-3">
      <div class="card border-0 shadow-sm rounded-4 h-100">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="small text-muted fw-semibold" style="font-size: 0.75rem;">Piutang</span>
            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2 py-1" style="font-size: 0.68rem; font-weight: 700;" title="{{ number_format($pctPiutang, 1, ',', '.') }}% sisa tagihan belum lunas dari total potensi omset">
              <i class="fas fa-clock me-1"></i>{{ number_format($pctPiutang, 1, ',', '.') }}%
            </span>
          </div>
          <div class="fw-bold text-warning mb-0 card-stat-value">Rp {{ number_format($programPiutang, 0, ',', '.') }}</div>
        </div>
      </div>
    </div>

    {{-- 4. Selisih --}}
    <div class="col-6 col-md-6 col-xl-3">
      <div class="card border-0 shadow-sm rounded-4 h-100">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="small text-muted fw-semibold" style="font-size: 0.75rem;">Selisih</span>
            <span class="badge {{ $programSelisih >= 0 ? 'bg-primary-subtle text-primary border-primary-subtle' : 'bg-danger-subtle text-danger border-danger-subtle' }} border rounded-pill px-2 py-1" style="font-size: 0.68rem; font-weight: 700;" title="{{ $programSelisih >= 0 ? 'Surplus' : 'Defisit' }} {{ number_format(abs($pctSelisih), 1, ',', '.') }}% dari pemasukan">
              <i class="fas {{ $programSelisih >= 0 ? 'fa-scale-balanced' : 'fa-triangle-exclamation' }} me-1"></i>{{ ($pctSelisih > 0 ? '+' : '') . number_format($pctSelisih, 1, ',', '.') }}%
            </span>
          </div>
          <div class="fw-bold {{ $programSelisih >= 0 ? 'text-primary' : 'text-danger' }} mb-0 card-stat-value">Rp {{ number_format($programSelisih, 0, ',', '.') }}</div>
        </div>
      </div>
    </div>
  </div>

  {{-- BAGIAN 1: Kategori Program Denpasar Institute (Persis FOTO 1) --}}
  @php
    $divisionThemes = [
      11 => ['icon' => 'fas fa-lightbulb',      'color' => '#7c3aed', 'bg' => '#f5f3ff', 'badge_bg' => '#ede9fe', 'badge_text' => '#6d28d9', 'tag' => 'Riset'],
      12 => ['icon' => 'fas fa-book-open',      'color' => '#2563eb', 'bg' => '#eff6ff', 'badge_bg' => '#dbeafe', 'badge_text' => '#1d4ed8', 'tag' => 'Publikasi'],
      13 => ['icon' => 'fas fa-users-cog',      'color' => '#ea580c', 'bg' => '#fff7ed', 'badge_bg' => '#ffedd5', 'badge_text' => '#c2410c', 'tag' => 'SDM'],
      14 => ['icon' => 'fas fa-award',          'color' => '#059669', 'bg' => '#ecfdf5', 'badge_bg' => '#d1fae5', 'badge_text' => '#047857', 'tag' => 'Vokasi'],
      15 => ['icon' => 'fas fa-laptop-code',    'color' => '#0284c7', 'bg' => '#f0f9ff', 'badge_bg' => '#e0f2fe', 'badge_text' => '#0369a1', 'tag' => 'IT & Data'],
      16 => ['icon' => 'fas fa-globe-asia',     'color' => '#e11d48', 'bg' => '#fff1f2', 'badge_bg' => '#ffe4e6', 'badge_text' => '#be123c', 'tag' => 'Bahasa & Seni'],
      17 => ['icon' => 'fas fa-handshake',      'color' => '#0d9488', 'bg' => '#f0fdfa', 'badge_bg' => '#ccfbf1', 'badge_text' => '#0f766e', 'tag' => 'Kerja Sama'],
      18 => ['icon' => 'fas fa-briefcase',      'color' => '#475569', 'bg' => '#f8fafc', 'badge_bg' => '#f1f5f9', 'badge_text' => '#334155', 'tag' => 'Konsultasi'],
      19 => ['icon' => 'fas fa-rocket',         'color' => '#9333ea', 'bg' => '#faf5ff', 'badge_bg' => '#f3e8ff', 'badge_text' => '#7e22ce', 'tag' => 'Karir'],
    ];
    $defaultTheme = ['icon' => 'fas fa-graduation-cap', 'color' => '#dc2626', 'bg' => '#fef2f2', 'badge_bg' => '#fee2e2', 'badge_text' => '#b91c1c', 'tag' => 'Program'];
  @endphp

  <div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white border-0 pt-3 pt-md-4 px-3 px-md-4 pb-2 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
      <div>
        <div class="d-flex align-items-center gap-2">
          <h5 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">Kategori Program Denpasar Institute</h5>
          <span class="badge rounded-pill px-2.5 py-1 fw-bold" style="background: #fee2e2; color: #b91c1c; font-size: 0.72rem;">
            {{ count($divisiSummaries) }} Kategori
          </span>
        </div>
        <p class="text-muted small mb-0 mt-1">Klik kategori di bawah untuk membuka halaman transaksi, daftar program, &amp; input khusus program dalam kategori tersebut</p>
      </div>
    </div>
    <div class="card-body p-2 p-sm-3 p-md-4 pt-2">
      <div class="row g-2 g-md-3 g-lg-4">
        @foreach($divisiSummaries as $item)
          @php
            $theme = $divisionThemes[$item['divisi']->id] ?? $defaultTheme;
          @endphp
          <div class="col-12 col-md-6 col-lg-4">
            <div class="category-card" style="border-top: 4px solid {{ $theme['color'] }};">
              <div>
                {{-- Header Card: Icon Box + Nama Kategori + Badge & Plus --}}
                <div class="d-flex justify-content-between align-items-start gap-2 mb-2 mb-md-3">
                  <div class="d-flex align-items-center gap-2" style="min-width: 0; flex: 1;">
                    <div class="category-icon-box" style="background: {{ $theme['bg'] }}; color: {{ $theme['color'] }};">
                      <i class="{{ $theme['icon'] }}"></i>
                    </div>
                    <div style="min-width: 0; flex: 1;">
                      <h6 class="fw-bold text-dark mb-0 fs-6 lh-sm" style="word-break: break-word;">
                        {{ $item['divisi']->nama }}
                      </h6>
                      <span class="text-muted" style="font-size: 0.72rem;">Divisi Penyelenggara DI</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center gap-1 flex-shrink-0">
                    @if(auth()->check() && auth()->user()->role !== 'finance')
                    <button type="button" class="btn-quick-add" title="Tambah Program ke Kategori Ini" onclick="openTambahProgramModal('{{ $item['divisi']->id }}')">
                      <i class="fas fa-plus"></i>
                    </button>
                    @endif
                    <span class="category-badge-count" style="background: {{ $theme['badge_bg'] }}; color: {{ $theme['badge_text'] }};">
                      {{ $item['programs_count'] }} Program
                    </span>
                  </div>
                </div>

                {{-- Badges Daftar Program Kursus dalam Kategori --}}
                <div class="d-flex flex-wrap gap-1.5 gap-md-2 mb-2" style="min-height: 44px;">
                  @forelse($item['programs']->take(5) as $prog)
                    <span class="program-pill" title="{{ $prog->nama }}">
                      <span class="me-1.5" style="display:inline-block; width:6px; height:6px; border-radius:50%; background: {{ $theme['color'] }}; opacity: 0.85;"></span>
                      {{ $prog->nama }}
                    </span>
                  @empty
                    <span class="text-muted small fst-italic">Belum ada program terdaftar</span>
                  @endforelse

                  @if($item['programs_count'] > 5)
                    <span class="program-pill text-muted fw-bold" style="background: #f1f5f9;" title="Dan {{ $item['programs_count'] - 5 }} program lainnya">
                      +{{ $item['programs_count'] - 5 }} lainnya
                    </span>
                  @endif
                </div>

                {{-- Micro Stats Bar: Transaksi & Pemasukan --}}
                <div class="category-stats-bar">
                  <div class="d-flex align-items-center gap-1.5 text-muted">
                    <i class="fas fa-receipt" style="font-size: 0.72rem;"></i>
                    <span>{{ $item['transaksi_count'] }} Transaksi</span>
                  </div>
                  <div class="fw-bold text-success">
                    <span class="text-muted fw-normal" style="font-size: 0.7rem;">Masuk:</span> Rp {{ number_format($item['pemasukan'], 0, ',', '.') }}
                  </div>
                </div>
              </div>

              {{-- Footer Link: Buka Halaman Kategori -> --}}
              <a href="{{ route('backoffice.project.kategori', $item['divisi']->id) }}" class="category-link-footer">
                <span>Buka Halaman Kategori</span>
                <div class="category-arrow-circle">
                  <i class="fas fa-arrow-right"></i>
                </div>
              </a>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

</div>

{{-- Modal Tambah Program Kursus Baru ke Divisi (Opsi B) --}}
<div class="modal fade" id="modalTambahProgramKursus" tabindex="-1" aria-labelledby="modalTambahProgramKursusLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header bg-light border-bottom py-3">
        <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="modalTambahProgramKursusLabel">
          <i class="fas fa-plus-circle text-danger me-2"></i> Tambah Program Kursus Baru
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('backoffice.project.program.store') }}" method="POST">
        @csrf
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label small fw-bold text-dark mb-1">
              <span class="text-danger">*</span> Kategori / Divisi Penyelenggara:
            </label>
            <select name="divisi_id" id="modalSelectDivisi" class="form-select" required>
              <option value="" disabled selected>-- Pilih Kategori / Divisi DI --</option>
              @foreach($divisiList as $div)
                <option value="{{ $div->id }}">{{ $div->nama }}</option>
              @endforeach
            </select>
            <div class="form-text small text-muted">Pilih divisi yang menaungi program kursus ini.</div>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-bold text-dark mb-1">
              <span class="text-danger">*</span> Nama Program Kursus:
            </label>
            <input type="text" name="nama" class="form-control fw-bold" placeholder="Contoh: Kursus Bahasa Jerman Level A1-B1 / UI-UX Design" required>
            <div class="form-text small text-muted">Nama program kursus yang akan ditampilkan pada kartu kategori.</div>
          </div>

          <div class="mb-0">
            <label class="form-label small fw-bold text-dark mb-1">
              Deskripsi Singkat (Opsional):
            </label>
            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Uraian singkat mengenai program kursus ini..."></textarea>
          </div>
        </div>
        <div class="modal-footer bg-light border-top py-2 px-4 d-flex justify-content-between flex-wrap gap-2">
          <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-dismiss="modal">Batal</button>
          <div class="d-flex gap-2">
            <button type="submit" name="submit_action" value="save_and_add" class="btn btn-sm btn-outline-di px-3">
              <i class="fas fa-plus-circle me-1"></i> Simpan &amp; Tambah
            </button>
            <button type="submit" name="submit_action" value="save" class="btn btn-sm btn-danger fw-bold px-4" style="background: #CC0000; border-color: #CC0000;">
              <i class="fas fa-save me-1"></i> Simpan Program
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
  function openTambahProgramModal(divisiId) {
    const select = document.getElementById('modalSelectDivisi');
    if (select) {
      select.value = divisiId;
    }
    const modal = new bootstrap.Modal(document.getElementById('modalTambahProgramKursus'));
    modal.show();
  }

  @if(session('open_modal_program'))
  document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
      const modalEl = document.getElementById('modalTambahProgramKursus');
      if (modalEl && typeof bootstrap !== 'undefined') {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
      }
    }, 350);
  });
  @endif
</script>
@endpush
@endsection
