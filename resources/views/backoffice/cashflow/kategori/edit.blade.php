@extends('backoffice.layouts.app')

@section('title', 'Edit Kategori Keuangan [' . $category->kode . '] | Backoffice Denpasar Institute')
@section('page-title', 'Edit Kategori Keuangan')

@push('styles')
<style>
  .form-cat-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    padding: 32px;
  }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

  {{-- Page Header --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <a href="{{ route('backoffice.cashflow.kategori.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Kategori
      </a>
      <h2 class="h4 fw-bold text-dark mb-0">
        <i class="fas fa-edit text-danger me-2"></i> Edit Kategori Keuangan: [{{ $category->kode }}]
      </h2>
      <p class="text-muted small mb-0">Perbarui rincian nama, prefix, atau status aktif kategori keuangan.</p>
    </div>
  </div>

  {{-- Error Alerts --}}
  @if(isset($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-1"></i> Periksa kesalahan isian formulir:</div>
      <ul class="mb-0 small ps-3">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if($usageCount > 0)
    <div class="alert alert-info border-0 shadow-sm rounded-3 mb-4">
      <i class="fas fa-info-circle me-1"></i> <strong>Catatan Integritas Data:</strong>
      Kategori ini telah digunakan oleh <strong>{{ $usageCount }} transaksi kas</strong>. Jika Anda mengubah kode kategori, sistem akan secara otomatis menyinkronkan seluruh catatan kas terkait.
    </div>
  @endif

  {{-- Form Card --}}
  <div class="row justify-content-center">
    <div class="col-12 col-xl-9">
      <div class="form-cat-card">

        <form action="{{ route('backoffice.cashflow.kategori.update', $category->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="row g-3">

            {{-- 1. Pilihan Kategori (Dropdown) --}}
            <div class="col-12 col-md-6">
              <label for="selectTipe" class="form-label fw-bold text-dark mb-1">
                <span class="text-danger">*</span> Kategori:
              </label>
              <select name="tipe" id="selectTipe" class="form-select fw-semibold" onchange="handleTipeChange(this.value)">
                <option value="masuk" {{ old('tipe', $category->tipe) === 'masuk' ? 'selected' : '' }}>
                  Pemasukan
                </option>
                <option value="keluar" {{ old('tipe', $category->tipe) === 'keluar' ? 'selected' : '' }}>
                  Pengeluaran
                </option>
              </select>
              <div class="form-text small text-muted">
                Pilih apakah kategori ini untuk pos pemasukan atau pengeluaran kas.
              </div>
            </div>

            {{-- 2. Kode Prefix Kategori --}}
            <div class="col-12 col-md-6">
              <label for="inputKode" class="form-label fw-bold text-dark mb-1">
                <span class="text-danger">*</span> Kode Prefix Kategori:
              </label>
              <div class="input-group">
                <span class="input-group-text bg-light text-muted font-monospace fw-bold" id="prefixBadge">
                  {{ old('tipe', $category->tipe) === 'masuk' ? 'KM-' : 'KK-' }}
                </span>
                <input type="text" name="kode" id="inputKode" value="{{ old('kode', $category->kode) }}" 
                       class="form-control font-monospace fw-bold text-uppercase @error('kode') is-invalid @enderror" 
                       placeholder="Contoh: KM-KRS" required autocomplete="off" oninput="this.value = this.value.toUpperCase()">
              </div>
              <div class="form-text small text-muted">
                Singkatan unik untuk penomoran kode otomatis transaksi.
              </div>
            </div>

            {{-- 3. Nama Kategori --}}
            <div class="col-12">
              <label for="inputNama" class="form-label fw-bold text-dark mb-1">
                <span class="text-danger">*</span> Nama Kategori Transaksi:
              </label>
              <input type="text" name="nama" id="inputNama" value="{{ old('nama', $category->nama) }}" 
                     class="form-control @error('nama') is-invalid @enderror" 
                     placeholder="Contoh: Kursus Bahasa Asing &amp; Budaya" required>
              <div class="form-text small text-muted">
                Nama ini akan muncul pada dropdown formulir pencatatan kas.
              </div>
            </div>

            {{-- 4. Deskripsi Kategori --}}
            <div class="col-12">
              <label for="inputDeskripsi" class="form-label fw-bold text-dark mb-1">
                Deskripsi <span class="badge bg-light text-muted border">Opsional</span>:
              </label>
              <textarea name="deskripsi" id="inputDeskripsi" rows="3" class="form-control" 
                        placeholder="Jelaskan jenis pemasukan atau pengeluaran apa saja yang tercakup dalam kategori ini...">{{ old('deskripsi', $category->deskripsi) }}</textarea>
            </div>

            {{-- 5. Urutan Tampilan & Status Aktif --}}
            <div class="col-12 col-md-6">
              <label for="inputUrutan" class="form-label fw-bold text-dark mb-1">
                Urutan Tampilan di Dropdown:
              </label>
              <input type="number" name="urutan" id="inputUrutan" value="{{ old('urutan', $category->urutan) }}" class="form-control" min="0">
              <div class="form-text small text-muted">
                Angka lebih kecil akan tampil lebih atas pada dropdown pilihan.
              </div>
            </div>

            <div class="col-12 col-md-6 d-flex align-items-center pt-md-3">
              <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="checkActive" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                <label class="form-check-label fw-bold text-dark ms-2" for="checkActive">
                  Aktifkan Kategori Ini
                </label>
                <div class="small text-muted">Kategori aktif dapat langsung dipilih di form pencatatan arus kas.</div>
              </div>
            </div>

          </div>

          <hr class="my-4 text-muted opacity-25">

          {{-- Buttons --}}
          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('backoffice.cashflow.kategori.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            <button type="submit" class="btn btn-danger px-4 fw-bold">
              <i class="fas fa-save me-1"></i> Perbarui Kategori
            </button>
          </div>

        </form>

      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  function handleTipeChange(tipe) {
    const prefixBadge = document.getElementById('prefixBadge');
    if (tipe === 'masuk') {
      prefixBadge.textContent = 'KM-';
    } else {
      prefixBadge.textContent = 'KK-';
    }
  }
</script>
@endpush

