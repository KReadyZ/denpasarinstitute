@extends('backoffice.layouts.app')

@section('title', 'Tambah Program Kursus Baru | Backoffice Denpasar Institute')
@section('page-title', 'Tambah Program Kursus')

@section('content')
<div class="container-fluid py-3">

  {{-- Header & Navigasi Kembali --}}
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
    <div>
      <a href="{{ route('backoffice.project.index') }}" class="btn btn-sm btn-outline-secondary mb-2" style="border-radius: 8px;">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Program Kursus
      </a>
      <h2 class="h4 fw-bold text-dark mb-1">
        <i class="fas fa-plus-circle text-danger me-2"></i> Tambah Program Kursus Baru
      </h2>
      <p class="text-muted small mb-0">Tambahkan nama program kursus / pelatihan baru ke salah satu divisi Denpasar Institute</p>
    </div>
  </div>

  @if(isset($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
      <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-1"></i> Terjadi kesalahan input:</div>
      <ul class="mb-0 small ps-3">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="row g-4">
    <div class="col-12 col-lg-8">
      <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border-top: 4px solid #CC0000 !important;">
        <div class="card-header bg-white border-bottom py-3 px-4">
          <h5 class="fw-bold text-dark mb-0 fs-6">
            <i class="fas fa-pen-to-square text-danger me-2"></i> Formulir Program Kursus Baru
          </h5>
        </div>

        <form action="{{ route('backoffice.project.program.store') }}" method="POST">
          @csrf

          <div class="card-body p-4">
            {{-- 1. Kategori / Divisi Penyelenggara --}}
            <div class="mb-4">
              <label class="form-label small fw-bold text-dark mb-1">
                <span class="text-danger">*</span> Kategori / Divisi Penyelenggara:
              </label>
              <select name="divisi_id" id="divisi_id" class="form-select form-select-lg fs-6" required>
                <option value="" disabled {{ old('divisi_id', $selectedDivisiId) ? '' : 'selected' }}>-- Pilih Kategori / Divisi Denpasar Institute --</option>
                @foreach($divisiList as $div)
                  <option value="{{ $div->id }}" {{ old('divisi_id', $selectedDivisiId) == $div->id ? 'selected' : '' }}>
                    {{ $div->nama }}
                  </option>
                @endforeach
              </select>
              <div class="form-text small text-muted mt-1">
                Pilih divisi yang menaungi program pelatihan / kursus ini.
              </div>
            </div>

            {{-- 2. Nama Program Kursus --}}
            <div class="mb-4">
              <label class="form-label small fw-bold text-dark mb-1">
                <span class="text-danger">*</span> Nama Program Kursus:
              </label>
              <input type="text" name="nama" value="{{ old('nama') }}" class="form-control form-control-lg fs-6 fw-bold text-dark" placeholder="Contoh: Kursus Bahasa Jerman Level A1-B1 / UI-UX Design & Web" required>
              <div class="form-text small text-muted mt-1">
                Nama resmi program kursus yang akan ditampilkan pada kartu kategori &amp; formulir pendaftaran.
              </div>
            </div>

            {{-- 3. Deskripsi Singkat (Opsional) --}}
            <div class="mb-2">
              <label class="form-label small fw-bold text-dark mb-1">
                Deskripsi Singkat (Opsional):
              </label>
              <textarea name="deskripsi" class="form-control" rows="4" placeholder="Uraian singkat materi atau tujuan program kursus ini...">{{ old('deskripsi') }}</textarea>
              <div class="form-text small text-muted mt-1">
                Catatan ringkas mengenai silabus atau cakupan program kursus.
              </div>
            </div>
          </div>

          <div class="card-footer bg-light border-top py-3 px-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('backoffice.project.index') }}" class="btn btn-sm btn-outline-secondary px-3" style="border-radius: 8px;">
              Batal
            </a>
            <button type="submit" class="btn btn-sm btn-danger fw-bold px-4 shadow-sm" style="background: #CC0000; border-color: #CC0000; border-radius: 8px; height: 38px;">
              <i class="fas fa-save me-1"></i> Simpan Program Kursus
            </button>
          </div>
        </form>
      </div>
    </div>

    {{-- Kolom Kanan: Panduan & Informasi --}}
    <div class="col-12 col-lg-4">
      <div class="card border-0 shadow-sm rounded-4 p-4 mb-3 bg-white">
        <h6 class="fw-bold text-dark mb-3">
          <i class="fas fa-circle-info text-primary me-2"></i> Informasi Sistem
        </h6>
        <div class="small text-muted d-flex flex-column gap-2.5">
          <div class="d-flex align-items-start gap-2">
            <i class="fas fa-check-circle text-success mt-1"></i>
            <div>
              <strong>Otomatis Tampil:</strong> Program yang baru ditambahkan langsung muncul di kartu kategori divisi terkait.
            </div>
          </div>
          <div class="d-flex align-items-start gap-2">
            <i class="fas fa-check-circle text-success mt-1"></i>
            <div>
              <strong>Terintegrasi Keuangan:</strong> Program ini otomatis tersedia saat staf mencatat pemasukan atau pengeluaran di menu Keuangan Umum.
            </div>
          </div>
          <div class="d-flex align-items-start gap-2">
            <i class="fas fa-check-circle text-success mt-1"></i>
            <div>
              <strong>Formulir Admission:</strong> Calon peserta kursus dapat memilih program ini saat mendaftar.
            </div>
          </div>
        </div>
      </div>

      <div class="card border-0 shadow-sm rounded-4 p-3 bg-light">
        <div class="d-flex align-items-center gap-2">
          <i class="fas fa-lightbulb text-warning fs-5"></i>
          <span class="small text-dark fw-semibold">Tips Cepat</span>
        </div>
        <p class="small text-muted mb-0 mt-2">
          Gunakan nama program yang jelas dan spesifik agar mudah dibedakan oleh peserta maupun bagian keuangan saat membuat kuitansi.
        </p>
      </div>
    </div>
  </div>

</div>
@endsection
