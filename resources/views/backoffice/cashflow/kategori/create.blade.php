@extends('backoffice.layouts.app')

@section('title', 'Tambah Kategori Keuangan | Backoffice Denpasar Institute')
@section('page-title', 'Tambah Kategori Keuangan')

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
        <i class="fas fa-plus-circle text-danger me-2"></i> Tambah Kategori Keuangan Baru
      </h2>
      <p class="text-muted small mb-0">Tambahkan jenis transaksi kas baru agar otomatis muncul pada pilihan dropdown pencatatan arus kas.</p>
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

  {{-- Form Card --}}
  <div class="row justify-content-center">
    <div class="col-12 col-xl-9">
      <div class="form-cat-card">

        <form action="{{ route('backoffice.cashflow.kategori.store') }}" method="POST">
          @csrf

          <div class="row g-3">

            {{-- 1. Pilihan Kategori (Dropdown) --}}
            <div class="col-12 col-md-6">
              <label for="selectTipe" class="form-label fw-bold text-dark mb-1">
                <span class="text-danger">*</span> Kategori:
              </label>
              <select name="tipe" id="selectTipe" class="form-select fw-semibold" onchange="handleTipeChange(this.value)">
                <option value="masuk" {{ old('tipe', $defaultTipe) === 'masuk' ? 'selected' : '' }}>
                  Pemasukan
                </option>
                <option value="keluar" {{ old('tipe', $defaultTipe) === 'keluar' ? 'selected' : '' }}>
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
                <span class="input-group-text bg-light text-muted font-monospace fw-bold" id="prefixBadge">{{ old('tipe', $defaultTipe) === 'masuk' ? 'KM-' : 'KK-' }}</span>
                <input type="text" name="kode" id="inputKode" value="{{ old('kode', old('tipe', $defaultTipe) === 'masuk' ? 'KM-' : 'KK-') }}" 
                       class="form-control font-monospace fw-bold text-uppercase @error('kode') is-invalid @enderror" 
                       placeholder="Contoh: KM-KRS" required autocomplete="off" oninput="this.value = this.value.toUpperCase()">
              </div>
              <div class="form-text small text-muted">
                Singkatan unik 3-6 karakter. Diawali <strong>KM-</strong> (Masuk) atau <strong>KK-</strong> (Keluar).
              </div>
            </div>

            {{-- 3. Nama Kategori --}}
            <div class="col-12">
              <label for="inputNama" class="form-label fw-bold text-dark mb-1">
                <span class="text-danger">*</span> Nama Kategori Transaksi:
              </label>
              <input type="text" name="nama" id="inputNama" value="{{ old('nama') }}" 
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
                        placeholder="Jelaskan jenis pemasukan atau pengeluaran apa saja yang tercakup dalam kategori ini...">{{ old('deskripsi') }}</textarea>
            </div>

            {{-- 5. Urutan Tampilan & Status Aktif --}}
            <div class="col-12 col-md-6">
              <label for="inputUrutan" class="form-label fw-bold text-dark mb-1">
                Urutan Tampilan di Dropdown:
              </label>
              <input type="number" name="urutan" id="inputUrutan" value="{{ old('urutan', 10) }}" class="form-control" min="0">
              <div class="form-text small text-muted">
                Angka lebih kecil akan tampil lebih atas pada dropdown pilihan.
              </div>
            </div>

            <div class="col-12 col-md-6 d-flex align-items-center pt-md-3">
              <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="checkActive" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                <label class="form-check-label fw-bold text-dark ms-2" for="checkActive">
                  Aktifkan Kategori Ini
                </label>
                <div class="small text-muted">Hanya kategori aktif yang akan muncul di dropdown form input kas.</div>
              </div>
            </div>

          </div>

          <hr class="my-4 text-muted opacity-25">

          {{-- Buttons --}}
          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('backoffice.cashflow.kategori.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            <button type="submit" class="btn btn-danger px-4 fw-bold">
              <i class="fas fa-save me-1"></i> Simpan Kategori Baru
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
    const inputKode = document.getElementById('inputKode');

    if (tipe === 'masuk') {
      prefixBadge.textContent = 'KM-';
      if (inputKode.value.startsWith('KK-')) {
        inputKode.value = 'KM-' + inputKode.value.substring(3);
      } else if (!inputKode.value.startsWith('KM-')) {
        inputKode.value = 'KM-';
      }
    } else {
      prefixBadge.textContent = 'KK-';
      if (inputKode.value.startsWith('KM-')) {
        inputKode.value = 'KK-' + inputKode.value.substring(3);
      } else if (!inputKode.value.startsWith('KK-')) {
        inputKode.value = 'KK-';
      }
    }
  }
</script>
@endpush

