@extends('backoffice.layouts.app')

@section('title', 'Buka Kelas / Program Kursus Baru | Backoffice Denpasar Institute')
@section('page-title', 'Buka Program Kursus Baru')

@section('content')
<div class="container-fluid py-2">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <a href="{{ route('backoffice.project.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Program &amp; Kursus
      </a>
      <h2 class="h4 fw-bold text-dark mb-0">
        <i class="fas fa-plus-circle text-danger me-2"></i> Buka Kelas / Program Kursus Baru
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
        <form action="{{ route('backoffice.project.store') }}" method="POST">
          @csrf

          <div class="row g-3">
            {{-- Kode Program Kursus (Otomatis & Terkunci) --}}
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold small text-dark mb-1">
                Kode Program Kursus:
                <span class="badge bg-secondary-subtle text-secondary ms-1 fw-normal" style="font-size: 0.72rem;">
                  <i class="fas fa-lock me-1"></i>Otomatis
                </span>
              </label>
              <div class="input-group">
                <span class="input-group-text bg-light text-muted"><i class="fas fa-barcode"></i></span>
                <input type="text" name="kode" value="{{ old('kode', $defaultKode) }}" class="form-control font-monospace fw-bold bg-light text-dark" readonly>
              </div>
              <div class="form-text small text-muted">Kode identifikasi unik otomatis digenerate oleh sistem.</div>
            </div>

            {{-- Nama Program Kursus / Kelas --}}
            <div class="col-12 col-md-8">
              <label class="form-label fw-bold small text-dark mb-1">
                <span class="text-danger">*</span> Nama Program Kursus / Kelas:
              </label>
              <input type="text" name="nama_proyek" value="{{ old('nama_proyek') }}" class="form-control fw-bold" placeholder="Contoh: 25_Bagas - Ausbildung Jerman Batch 1 / Kursus Digital Marketing Intensif" required>
              <div class="form-text small text-muted">Tulis nama kelas program kursus peserta.</div>
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
                          {{ old('program_id') == $prog->id ? 'selected' : '' }}>
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
              <input type="hidden" name="divisi_id" id="hiddenDivisiId" value="{{ old('divisi_id') }}">
              <div class="input-group">
                <span class="input-group-text bg-light text-muted"><i class="fas fa-building text-secondary"></i></span>
                <input type="text" id="displayDivisiNama" class="form-control bg-light text-dark fw-bold" readonly 
                       placeholder="— Otomatis terisi saat memilih Program —"
                       value="">
              </div>
              <div class="form-text small text-muted">Divisi otomatis terisi dan terkunci sesuai program kursus yang dipilih.</div>
            </div>

            {{-- Nama Peserta / Siswa Kursus --}}
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold small text-dark mb-1">
                <i class="fas fa-user-graduate text-muted me-1"></i> Nama Peserta / Siswa Kursus:
              </label>
              <input type="text" name="nama_peserta" value="{{ old('nama_peserta') }}" class="form-control" placeholder="Contoh: Bagas Praditya / Rombongan Mahasiswa Riset">
              <div class="form-text small text-muted">Nama siswa/peserta individu atau rombongan program.</div>
            </div>

            {{-- PIC / Instruktur Penanggung Jawab --}}
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold small text-dark mb-1">
                <i class="fas fa-user-tie text-muted me-1"></i> PIC / Instruktur Penanggung Jawab:
              </label>
              <input type="text" name="pic" value="{{ old('pic') }}" class="form-control" placeholder="Contoh: Dr. I Nyoman Laba, M.Pd. / Instruktur Bahasa">
              <div class="form-text small text-muted">Staf pengajar atau koordinator instruktur yang mengawal kelas kursus.</div>
            </div>

            {{-- Jadwal Mulai --}}
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold small text-dark mb-1">
                <span class="text-danger">*</span> Jadwal Mulai Kursus:
              </label>
              <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" class="form-control" required>
            </div>

            {{-- Jadwal Selesai --}}
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold small text-dark mb-1">
                Jadwal Selesai Kursus:
              </label>
              <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="form-control">
            </div>

            {{-- Status --}}
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold small text-dark mb-1">
                <span class="text-danger">*</span> Status Program Kursus:
              </label>
              <select name="status" class="form-select">
                <option value="aktif" {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif (Sedang Berjalan)</option>
                <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="batal" {{ old('status') === 'batal' ? 'selected' : '' }}>Dibatalkan</option>
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
                       value="{{ old('nilai_proyek') ? number_format((float)preg_replace('/[^0-9]/', '', old('nilai_proyek')), 0, ',', '.') : '' }}" 
                       class="form-control fs-5 fw-bold" placeholder="Contoh: 7.500.000" required oninput="formatRupiah(this)">
              </div>
              <div class="form-text small text-muted">
                Ketik angka saja, titik ribuan terformat otomatis. Nilai ini menjadi target penerimaan biaya kursus dari peserta.
              </div>
            </div>

            {{-- Deskripsi --}}
            <div class="col-12">
              <label class="form-label fw-bold small text-dark mb-1">Deskripsi:</label>
              <textarea name="keterangan" rows="3" class="form-control" placeholder="Tuliskan deskripsi kelas, jadwal batch, kesepakatan termin cicilan, dsb...">{{ old('keterangan') }}</textarea>
            </div>

            <div class="col-12 pt-3 border-top d-flex justify-content-end gap-2 flex-wrap">
              <a href="{{ route('backoffice.project.index') }}" class="btn btn-secondary px-3">Batal</a>
              <button type="submit" name="submit_action" value="save_and_add" class="btn btn-outline-di px-3">
                <i class="fas fa-plus-circle me-1"></i> Simpan &amp; Tambah
              </button>
              <button type="submit" name="submit_action" value="save" class="btn btn-danger fw-bold px-4" style="background: #CC0000; border-color: #CC0000;">
                <i class="fas fa-check me-1"></i> Simpan Program Kursus
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
    displayInput.value = divNama || '';
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

