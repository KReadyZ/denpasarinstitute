@extends('backoffice.layouts.app')

@section('title', 'Edit Program Kursus: ' . $project->nama_proyek . ' | Backoffice Denpasar Institute')
@section('page-title', 'Edit Program Kursus')

@section('content')
<div class="container-fluid py-2">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <a href="{{ route('backoffice.project.show', $project->id) }}" class="btn btn-outline-secondary btn-sm mb-2">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Detail Keuangan Kursus
      </a>
      <h2 class="h4 fw-bold text-dark mb-0">
        <i class="fas fa-edit text-danger me-2"></i> Edit Data Program Kursus: {{ $project->nama_proyek }}
      </h2>
    </div>
  </div>

  @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-1"></i> Terjadi kesalahan input:</div>
      <ul class="mb-0 small ps-3">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="row justify-content-center">
    <div class="col-12 col-xl-10">
      <div class="card border-0 shadow-sm rounded-4 p-4">
        <form action="{{ route('backoffice.project.update', $project->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="row g-3">
            {{-- Kode Program Kursus (Terkunci) --}}
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold small text-dark mb-1">
                Kode Program Kursus:
                <span class="badge bg-secondary-subtle text-secondary ms-1 fw-normal" style="font-size: 0.72rem;">
                  <i class="fas fa-lock me-1"></i>Terkunci
                </span>
              </label>
              <div class="input-group">
                <span class="input-group-text bg-light text-muted"><i class="fas fa-barcode"></i></span>
                <input type="text" name="kode" value="{{ old('kode', $project->kode) }}" class="form-control font-monospace fw-bold bg-light text-dark" readonly>
              </div>
              <div class="form-text small text-muted">Kode identifikasi unik program kursus.</div>
            </div>

            {{-- Nama Program Kursus / Kelas --}}
            <div class="col-12 col-md-8">
              <label class="form-label fw-bold small text-dark mb-1">
                <span class="text-danger">*</span> Nama Program Kursus / Kelas:
              </label>
              <input type="text" name="nama_proyek" value="{{ old('nama_proyek', $project->nama_proyek) }}" class="form-control fw-bold" required>
            </div>

            {{-- Program DI --}}
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold small text-dark mb-1">
                <i class="fas fa-graduation-cap text-danger me-1"></i> Program Terkait (Denpasar Institute):
              </label>
              <select name="program_id" id="selectProgram" class="form-select" onchange="syncDivisi(this)">
                <option value="" data-divisi="" data-divisi-nama="">-- Pilih Program DI (Opsional) --</option>
                @foreach($programs as $prog)
                  <option value="{{ $prog->id }}" 
                          data-divisi="{{ $prog->divisi_id }}" 
                          data-divisi-nama="{{ $prog->divisi?->nama ?? 'Denpasar Institute' }}"
                          {{ old('program_id', $project->program_id) == $prog->id ? 'selected' : '' }}>
                    {{ $prog->nama }} ({{ $prog->divisi?->nama ?? 'DI' }})
                  </option>
                @endforeach
              </select>
              <div class="form-text small text-muted">Pilih program untuk mengaitkan kelas dengan divisi penyelenggara.</div>
            </div>

            {{-- Divisi DI (Otomatis & Terkunci) --}}
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold small text-dark mb-1">
                <i class="fas fa-sitemap text-danger me-1"></i> Divisi Penyelenggara:
                <span class="badge bg-secondary-subtle text-secondary ms-1 fw-normal" style="font-size: 0.72rem;"><i class="fas fa-lock me-1"></i>Otomatis</span>
              </label>
              <input type="hidden" name="divisi_id" id="hiddenDivisiId" value="{{ old('divisi_id', $project->divisi_id) }}">
              <div class="input-group">
                <span class="input-group-text bg-light text-muted"><i class="fas fa-building text-secondary"></i></span>
                <input type="text" id="displayDivisiNama" class="form-control bg-light text-dark fw-bold" readonly 
                       placeholder="— Otomatis terisi saat memilih Program —"
                       value="{{ $project->divisi?->nama ?? '' }}">
              </div>
              <div class="form-text small text-muted">Divisi otomatis terisi dan terkunci sesuai program kursus yang dipilih.</div>
            </div>

            {{-- Nama Peserta / Siswa Kursus --}}
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold small text-dark mb-1">
                <i class="fas fa-user-graduate text-muted me-1"></i> Nama Peserta / Siswa Kursus:
              </label>
              <input type="text" name="nama_peserta" value="{{ old('nama_peserta', $project->nama_peserta) }}" class="form-control">
            </div>

            {{-- PIC / Instruktur Penanggung Jawab --}}
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold small text-dark mb-1">
                <i class="fas fa-user-tie text-muted me-1"></i> PIC / Instruktur Penanggung Jawab:
              </label>
              <input type="text" name="pic" value="{{ old('pic', $project->pic) }}" class="form-control">
            </div>

            {{-- Jadwal Mulai --}}
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold small text-dark mb-1">
                <span class="text-danger">*</span> Jadwal Mulai Kursus:
              </label>
              <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $project->tanggal_mulai ? $project->tanggal_mulai->format('Y-m-d') : '') }}" class="form-control" required>
            </div>

            {{-- Jadwal Selesai --}}
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold small text-dark mb-1">
                Jadwal Selesai Kursus:
              </label>
              <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $project->tanggal_selesai ? $project->tanggal_selesai->format('Y-m-d') : '') }}" class="form-control">
            </div>

            {{-- Status --}}
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold small text-dark mb-1">
                <span class="text-danger">*</span> Status Program Kursus:
              </label>
              <select name="status" class="form-select">
                <option value="aktif" {{ old('status', $project->status) === 'aktif' ? 'selected' : '' }}>Aktif (Sedang Berjalan)</option>
                <option value="selesai" {{ old('status', $project->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="pending" {{ old('status', $project->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="batal" {{ old('status', $project->status) === 'batal' ? 'selected' : '' }}>Dibatalkan</option>
              </select>
            </div>

            {{-- Biaya Kursus / Program --}}
            <div class="col-12">
              <label class="form-label fw-bold small text-dark mb-1">
                <span class="text-danger">*</span> Total Tarif Biaya Kursus / Program (Rp):
              </label>
              <div class="input-group">
                <span class="input-group-text bg-white fw-bold">Rp</span>
                <input type="text" name="nilai_proyek" id="inputNilaiProyek" 
                       value="{{ number_format((float)old('nilai_proyek', $project->nilai_proyek), 0, ',', '.') }}" 
                       class="form-control fs-5 fw-bold" required oninput="formatRupiah(this)">
              </div>
            </div>

            {{-- Deskripsi --}}
            <div class="col-12">
              <label class="form-label fw-bold small text-dark mb-1">Deskripsi:</label>
              <textarea name="keterangan" rows="3" class="form-control">{{ old('keterangan', $project->keterangan) }}</textarea>
            </div>

            <div class="col-12 pt-3 border-top d-flex justify-content-end gap-2">
              <a href="{{ route('backoffice.project.show', $project->id) }}" class="btn btn-secondary px-3">Batal</a>
              <button type="submit" class="btn btn-primary fw-bold px-4">
                <i class="fas fa-save me-1"></i> Simpan Perubahan
              </button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>

</div>

@push('scripts')
<script>
function formatRupiah(el) {
  let val = el.value.replace(/[^0-9]/g, '');
  if (!val) {
    el.value = '';
    return;
  }
  el.value = new Intl.NumberFormat('id-ID').format(val);
}

function syncDivisi(selectEl) {
  const opt = selectEl.options[selectEl.selectedIndex];
  const divId = opt ? opt.getAttribute('data-divisi') : '';
  const divNama = opt ? opt.getAttribute('data-divisi-nama') : '';
  
  const hiddenInput = document.getElementById('hiddenDivisiId');
  const displayInput = document.getElementById('displayDivisiNama');
  
  if (hiddenInput) hiddenInput.value = divId || '';
  if (displayInput) {
    if (divNama) {
      displayInput.value = divNama;
    } else if (!divId) {
      displayInput.value = '';
    }
  }
}

document.addEventListener('DOMContentLoaded', function() {
  const selectProg = document.getElementById('selectProgram');
  if (selectProg) {
    syncDivisi(selectProg);
  }
});
</script>
@endpush

@endsection

