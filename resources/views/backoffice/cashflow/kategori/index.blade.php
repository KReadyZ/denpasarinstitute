@extends('backoffice.layouts.app')

@section('title', 'Kategori Keuangan | Backoffice Denpasar Institute')
@section('page-title', 'Kategori Keuangan')

@push('styles')
<style>
  .cat-card-stat {
    background: #ffffff;
    border-radius: 14px;
    padding: 20px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .cat-icon-box {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
  }
  .badge-km {
    background: #f0fdf4;
    color: #15803d;
    border: 1px solid #bbf7d0;
    font-family: monospace;
    font-weight: 700;
    font-size: 0.8rem;
    padding: 4px 8px;
    border-radius: 6px;
  }
  .badge-kk {
    background: #fef2f2;
    color: #b91c1c;
    border: 1px solid #fecaca;
    font-family: monospace;
    font-weight: 700;
    font-size: 0.8rem;
    padding: 4px 8px;
    border-radius: 6px;
  }
  .table-cat th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 0.82rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 14px;
  }
  .table-cat td {
    padding: 14px;
    vertical-align: middle;
  }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

  {{-- Page Header --}}
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 w-100">
    <div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
          <li class="breadcrumb-item"><a href="{{ route('backoffice.cashflow.index') }}" class="text-decoration-none">Manajemen Keuangan</a></li>
          <li class="breadcrumb-item active" aria-current="page">Kategori Keuangan</li>
        </ol>
      </nav>
      <h2 class="h4 fw-bold text-dark mb-1">
        <i class="fas fa-tags text-danger me-2"></i> Manajemen Kategori Keuangan
      </h2>
      <p class="text-muted small mb-0">Kelola dan tambahkan opsi jenis uang masuk serta uang keluar yang tampil pada formulir pencatatan kas.</p>
    </div>
    <div class="d-flex align-items-center gap-2 ms-sm-auto justify-content-end flex-wrap flex-sm-nowrap">
      <a href="{{ route('backoffice.cashflow.index') }}" class="btn btn-sm btn-outline-secondary fw-semibold" style="height: 38px; display: inline-flex; align-items: center; border-radius: 8px; padding: 0 16px; font-size: 0.84rem; white-space: nowrap;">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Buku Kas
      </a>
      <a href="{{ route('backoffice.cashflow.kategori.create') }}" class="btn btn-sm btn-danger fw-bold shadow-sm" style="height: 38px; display: inline-flex; align-items: center; border-radius: 8px; background: #CC0000; border-color: #CC0000; padding: 0 18px; font-size: 0.84rem; white-space: nowrap;">
        <i class="fas fa-plus-circle me-1"></i> Tambah Kategori Baru
      </a>
    </div>
  </div>

  {{-- Flash Alerts --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
      <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
      <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- Summary Stat Cards --}}
  <div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
      <div class="cat-card-stat">
        <div>
          <div class="text-muted small fw-semibold text-uppercase">Total Kategori</div>
          <div class="fs-4 fw-bold text-dark mt-1">{{ $countTotal }} Kategori</div>
          <small class="text-muted">Tercatat di sistem</small>
        </div>
        <div class="cat-icon-box bg-light text-secondary">
          <i class="fas fa-folder"></i>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="cat-card-stat">
        <div>
          <div class="text-muted small fw-semibold text-uppercase">Kategori Uang Masuk</div>
          <div class="fs-4 fw-bold text-success mt-1">{{ $countMasuk }} Pilihan</div>
          <small class="text-muted">Pendaftaran, Diklat, Riset, dll</small>
        </div>
        <div class="cat-icon-box bg-success-subtle text-success">
          <i class="fas fa-arrow-circle-down"></i>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="cat-card-stat">
        <div>
          <div class="text-muted small fw-semibold text-uppercase">Kategori Uang Keluar</div>
          <div class="fs-4 fw-bold text-danger mt-1">{{ $countKeluar }} Pilihan</div>
          <small class="text-muted">Gaji, Operasional, PLN, dll</small>
        </div>
        <div class="cat-icon-box bg-danger-subtle text-danger">
          <i class="fas fa-arrow-circle-up"></i>
        </div>
      </div>
    </div>
  </div>

  {{-- Filter & Search Card --}}
  <div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
      <form action="{{ route('backoffice.cashflow.kategori.index') }}" method="GET" class="row g-2 align-items-center">
        
        {{-- Filter Transaksi --}}
        <div class="col-12 col-md-3">
          <div class="btn-group w-100" role="group">
            <a href="{{ route('backoffice.cashflow.kategori.index', array_merge(request()->except('tipe'), ['tipe' => 'all'])) }}" 
               class="btn btn-sm {{ !request('tipe') || request('tipe') === 'all' ? 'btn-dark' : 'btn-outline-secondary' }}">
              Semua ({{ $countTotal }})
            </a>
            <a href="{{ route('backoffice.cashflow.kategori.index', array_merge(request()->except('tipe'), ['tipe' => 'masuk'])) }}" 
               class="btn btn-sm {{ request('tipe') === 'masuk' ? 'btn-success' : 'btn-outline-success' }}">
              Pemasukan ({{ $countMasuk }})
            </a>
            <a href="{{ route('backoffice.cashflow.kategori.index', array_merge(request()->except('tipe'), ['tipe' => 'keluar'])) }}" 
               class="btn btn-sm {{ request('tipe') === 'keluar' ? 'btn-danger' : 'btn-outline-danger' }}">
              Pengeluaran ({{ $countKeluar }})
            </a>
          </div>
        </div>

        {{-- Filter Status --}}
        <div class="col-12 col-sm-6 col-md-3">
          <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="">Semua Status (Aktif &amp; Non-Aktif)</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Hanya Aktif</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Hanya Non-Aktif</option>
          </select>
        </div>

        {{-- Search Input --}}
        <div class="col-12 col-sm-6 col-md-6">
          <div class="input-group input-group-sm">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search nama kategori / kode prefix...">
            @if(request()->anyFilled(['q', 'tipe', 'status']))
              <a href="{{ route('backoffice.cashflow.kategori.index') }}" class="btn btn-outline-secondary" title="Reset">
                <i class="fas fa-times"></i>
              </a>
            @endif
            <button type="submit" class="btn btn-dark"><i class="fas fa-search me-1"></i> Search</button>
          </div>
        </div>

      </form>
    </div>
  </div>

  {{-- Categories Table Card --}}
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
      <table class="table table-hover table-cat mb-0 align-middle">
        <thead>
          <tr>
            <th style="width: 50px;" class="text-center">No</th>
            <th style="width: 130px;">Transaksi</th>
            <th style="width: 140px;">Kode Prefix</th>
            <th>Nama Kategori Transaksi</th>
            <th>Deskripsi</th>
            <th style="width: 110px;" class="text-center">Transaksi</th>
            <th style="width: 100px;" class="text-center">Status</th>
            <th style="width: 120px;" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($categories as $index => $item)
            <tr class="{{ !$item->is_active ? 'opacity-75 bg-light' : '' }}">
              {{-- No --}}
              <td class="text-center text-muted fw-semibold">
                {{ $index + 1 }}
              </td>

              {{-- Tipe --}}
              <td>
                @if($item->tipe === 'masuk')
                  <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                    <i class="fas fa-arrow-down me-1"></i> Uang Masuk
                  </span>
                @else
                  <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                    <i class="fas fa-arrow-up me-1"></i> Uang Keluar
                  </span>
                @endif
              </td>

              {{-- Kode --}}
              <td>
                <span class="{{ $item->tipe === 'masuk' ? 'badge-km' : 'badge-kk' }}">
                  {{ $item->kode }}
                </span>
              </td>

              {{-- Nama Kategori --}}
              <td>
                <div class="fw-bold text-dark">{{ $item->nama }}</div>
                @if($item->urutan > 0)
                  <small class="text-muted">Urutan tampilan: #{{ $item->urutan }}</small>
                @endif
              </td>

              {{-- Deskripsi --}}
              <td class="small text-muted" style="max-width: 320px;">
                {{ $item->deskripsi ?? '-' }}
              </td>

              {{-- Jumlah Transaksi Menggunakan --}}
              <td class="text-center">
                @php
                  $used = $usageCounts[$item->kode] ?? 0;
                @endphp
                @if($used > 0)
                  <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1" title="{{ $used }} catatan transaksi kas memakai kategori ini">
                    {{ $used }} catatan
                  </span>
                @else
                  <span class="text-muted small">0</span>
                @endif
              </td>

              {{-- Status & Toggle --}}
              <td class="text-center">
                <form action="{{ route('backoffice.cashflow.kategori.toggle', $item->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('PATCH')
                  @if($item->is_active)
                    <button type="submit" class="btn btn-sm btn-outline-success py-0 px-2" title="Klik untuk nonaktifkan">
                      <i class="fas fa-check-circle me-1"></i> Aktif
                    </button>
                  @else
                    <button type="submit" class="btn btn-sm btn-outline-secondary py-0 px-2" title="Klik untuk aktifkan">
                      <i class="fas fa-ban me-1"></i> Nonaktif
                    </button>
                  @endif
                </form>
              </td>

              {{-- Aksi --}}
              <td class="text-center">
                <div class="btn-group btn-group-sm" role="group">
                  <a href="{{ route('backoffice.cashflow.kategori.edit', $item->id) }}" class="btn btn-outline-secondary" title="Edit Kategori">
                    <i class="fas fa-edit"></i>
                  </a>
                  <button type="button" class="btn btn-outline-danger" title="Hapus Kategori" 
                          onclick="confirmDelete('{{ $item->id }}', '{{ $item->kode }}', '{{ addslashes($item->nama) }}', {{ $used }})">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
                <form id="delete-form-{{ $item->id }}" action="{{ route('backoffice.cashflow.kategori.destroy', $item->id) }}" method="POST" class="d-none">
                  @csrf
                  @method('DELETE')
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-5 text-muted">
                <i class="fas fa-tags fs-1 text-secondary mb-3 d-block"></i>
                <h6 class="fw-bold mb-1">Tidak Ada Kategori Ditemukan</h6>
                <p class="small mb-3">Kategori belum dibuat atau tidak cocok dengan filter pencarian.</p>
                <a href="{{ route('backoffice.cashflow.kategori.create') }}" class="btn btn-danger btn-sm">
                  <i class="fas fa-plus me-1"></i> Tambah Kategori Baru
                </a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-bottom py-3">
        <h6 class="modal-title fw-bold text-danger">
          <i class="fas fa-exclamation-triangle me-2"></i> Konfirmasi Hapus Kategori
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <p class="mb-2">Apakah Anda yakin ingin menghapus kategori berikut?</p>
        <div class="p-3 bg-light rounded-3 border mb-3">
          <span class="badge bg-secondary font-monospace" id="modalDelKode"></span>
          <strong class="d-block mt-1 text-dark fs-6" id="modalDelNama"></strong>
        </div>
        <div id="modalDelWarning" class="alert alert-warning small d-none mb-0">
          <i class="fas fa-info-circle me-1"></i> Kategori ini memiliki <strong id="modalDelUsage"></strong> data transaksi terkait. Menghapusnya tidak diizinkan demi integritas buku kas. Silakan non-aktifkan kategori saja.
        </div>
      </div>
      <div class="modal-footer border-top py-2">
        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" id="btnConfirmDeleteAction" class="btn btn-sm btn-danger fw-bold">Ya, Hapus Kategori</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  let targetDeleteId = null;

  function confirmDelete(id, kode, nama, usageCount) {
    targetDeleteId = id;
    document.getElementById('modalDelKode').textContent = kode;
    document.getElementById('modalDelNama').textContent = nama;

    const warnBox = document.getElementById('modalDelWarning');
    const deleteBtn = document.getElementById('btnConfirmDeleteAction');

    if (usageCount > 0) {
      warnBox.classList.remove('d-none');
      document.getElementById('modalDelUsage').textContent = usageCount;
      deleteBtn.disabled = true;
      deleteBtn.classList.add('opacity-50');
    } else {
      warnBox.classList.add('d-none');
      deleteBtn.disabled = false;
      deleteBtn.classList.remove('opacity-50');
    }

    const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
    modal.show();
  }

  document.getElementById('btnConfirmDeleteAction').addEventListener('click', function() {
    if (targetDeleteId) {
      document.getElementById('delete-form-' + targetDeleteId).submit();
    }
  });
</script>
@endpush

