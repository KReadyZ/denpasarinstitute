@extends('backoffice.layouts.app')

@section('title', 'Edit Transaksi Kas #' . $cashflow->kode . ' | Backoffice Denpasar Institute')

@push('styles')
<style>
  .form-cash-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    padding: 32px;
  }
  .tipe-selector-card {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 16px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
    background: #ffffff;
  }
  .tipe-selector-card:hover {
    border-color: #cbd5e1;
    transform: translateY(-2px);
  }
  .tipe-selector-card.active-in {
    border-color: #16a34a;
    background: #f0fdf4;
    box-shadow: 0 4px 14px rgba(22, 163, 74, 0.15);
  }
  .tipe-selector-card.active-out {
    border-color: #dc2626;
    background: #fef2f2;
    box-shadow: 0 4px 14px rgba(220, 38, 38, 0.15);
  }
  .nominal-input-group .form-control {
    font-size: 1.35rem;
    font-weight: 700;
    color: #1e293b;
    letter-spacing: 0.5px;
  }
  .preview-upload-box {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    background: #f8fafc;
    cursor: pointer;
    transition: border-color 0.2s;
  }
  .preview-upload-box:hover {
    border-color: #94a3b8;
  }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

  {{-- Page Header --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <a href="{{ route('backoffice.cashflow.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Buku Kas
      </a>
      <h2 class="h4 fw-bold text-dark mb-0">
        <i class="fas fa-edit text-danger me-2"></i> Edit Transaksi Kas #{{ $cashflow->kode }}
      </h2>
    </div>
  </div>

  {{-- Error Alerts --}}
  @if(isset($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-1"></i> Terdapat kesalahan pada isian form:</div>
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
    <div class="col-12 col-xl-10">
      <div class="form-cash-card">

        <form action="{{ route('backoffice.cashflow.update', $cashflow->id) }}" method="POST" enctype="multipart/form-data" id="cashflowForm">
          @csrf
          @method('PUT')

          <div class="row g-3">

            {{-- 1. Pilihan Tipe: Masuk vs Keluar & Tanggal Transaksi --}}
            <div class="col-12 col-md-6">
              <label for="selectTipe" class="form-label fw-bold text-dark mb-1">
                <span class="text-danger">*</span> Jenis Aliran Kas:
              </label>
              <select name="tipe" id="selectTipe" class="form-select fw-semibold" onchange="selectTipe(this.value)">
                <option value="masuk" {{ old('tipe', $cashflow->tipe) === 'masuk' ? 'selected' : '' }}>
                  Uang Masuk (Pemasukan)
                </option>
                <option value="keluar" {{ old('tipe', $cashflow->tipe) === 'keluar' ? 'selected' : '' }}>
                  Uang Keluar (Pengeluaran)
                </option>
              </select>
              <input type="hidden" id="inputTipe" value="{{ old('tipe', $cashflow->tipe) }}">
            </div>

            <div class="col-12 col-md-6">
              <label for="inputTanggal" class="form-label fw-bold text-dark mb-1">
                <span class="text-danger">*</span> Tanggal Transaksi:
              </label>
              <input type="date" name="tanggal" id="inputTanggal" 
                     value="{{ old('tanggal', $cashflow->tanggal ? $cashflow->tanggal->format('Y-m-d') : '') }}" 
                     class="form-control" required>
            </div>

            {{-- Judul Transaksi --}}
            <div class="col-12">
              <label for="inputJudul" class="form-label fw-bold text-dark mb-1">
                <span class="text-danger">*</span> Judul Transaksi:
              </label>
              <input type="text" name="judul" id="inputJudul" value="{{ old('judul', $cashflow->judul ?? $cashflow->kategori) }}" 
                     class="form-control" required placeholder="Contoh: Pembayaran DP Jasa Konsultasi Hukum / Pendaftaran Siswa Baru / Langganan WiFi">
              <div class="form-text small text-muted">
                Tuliskan judul transaksi secara singkat dan jelas untuk pencatatan laporan keuangan.
              </div>
            </div>

            {{-- Divisi (Denpasar Institute) --}}
            <div class="col-12 col-md-7">
              <label for="selectDivisi" class="form-label fw-bold text-dark mb-1">
                <i class="fas fa-sitemap text-danger me-1"></i> Divisi (Denpasar Institute):
              </label>
              <select name="divisi_id" id="selectDivisi" class="form-select" onchange="handleDivisiChange(this.value)">
                <option value="">-- Tidak Terkait Program Khusus (Operasional Umum) --</option>
                @foreach($divisiList as $div)
                  <option value="{{ $div->id }}" {{ (isset($selectedDivisiId) && $selectedDivisiId == $div->id) || old('divisi_id') == $div->id ? 'selected' : '' }}>
                    {{ $div->nama }} ({{ $div->programs->count() }} Program)
                  </option>
                @endforeach
              </select>
              <div class="form-text small text-muted">
                Pilih divisi lembaga terlebih dahulu untuk memunculkan program terkait.
              </div>
            </div>

            {{-- Status Transaksi --}}
            <div class="col-12 col-md-5">
              <label for="selectStatus" class="form-label fw-bold text-dark mb-1">
                Status Transaksi:
              </label>
              <select name="status" id="selectStatus" class="form-select">
                <option value="lunas" {{ old('status', $cashflow->status ?? 'lunas') === 'lunas' ? 'selected' : '' }}>✓ Lunas (Diterima / Terbayar)</option>
                <option value="pending" {{ old('status', $cashflow->status) === 'pending' ? 'selected' : '' }}>⏳ Pending (Menunggu Pembayaran / Verifikasi)</option>
              </select>
              <div class="form-text small text-muted">
                Status penyelesaian kas saat ini.
              </div>
            </div>

            {{-- Hubungkan ke Program Kursus / Kelas (Opsional) --}}
            <div class="col-12">
              <label for="selectProject" class="form-label fw-bold text-dark mb-1">
                <i class="fas fa-graduation-cap text-primary me-1"></i> Pilih Program Kursus Terkait (Opsional):
              </label>
              <select name="project_id" id="selectProject" class="form-select">
                <option value="">-- Transaksi Kas Umum Lembaga (Tanpa Kelas Kursus Khusus) --</option>
                @foreach($projects as $pj)
                  <option value="{{ $pj->id }}" {{ old('project_id', $cashflow->project_id) == $pj->id ? 'selected' : '' }}>
                    [{{ $pj->kode }}] {{ $pj->nama_proyek }} @if($pj->nama_peserta) • Peserta: {{ $pj->nama_peserta }} @endif @if($pj->program) • Program: {{ $pj->program->nama }} @endif
                  </option>
                @endforeach
              </select>
              <div class="form-text small text-muted">
                Hubungkan transaksi ini ke buku keuangan kelas atau program kursus tertentu jika ada.
              </div>
            </div>

            {{-- Dropdown Program Terkait (Muncul setelah Divisi dipilih) --}}
            <div class="col-12" id="boxProgramWrapper" style="display: none;">
              <div class="p-3 bg-light rounded-3 border">
                <label for="selectProgram" class="form-label fw-bold text-dark mb-1">
                  <i class="fas fa-graduation-cap text-danger me-1"></i> Pilih Program (<span id="labelNamaDivisi" class="text-danger fw-bold"></span>):
                </label>
                <select name="program_id" id="selectProgram" class="form-select">
                  <option value="">-- Pilih Program Terkait --</option>
                </select>
                <div class="form-text small text-muted">
                  Pilih program spesifik di bawah divisi yang Anda pilih.
                </div>
              </div>
            </div>

            {{-- 2. Dropdown Kategori --}}
            <div class="col-12 col-md-7">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="selectKategori" class="form-label fw-bold text-dark mb-0">
                  <span class="text-danger">*</span> Kategori:
                </label>
                <a href="{{ route('backoffice.cashflow.kategori.index') }}" target="_blank" class="small text-danger text-decoration-none fw-semibold">
                  <i class="fas fa-cog me-1"></i> Kelola &amp; Tambah Kategori
                </a>
              </div>
              <select name="kategori" id="selectKategori" class="form-select" required onchange="handleKategoriChange()">
                <option value="">-- Pilih Kategori --</option>
              </select>
              <div class="form-text small text-muted">
                Pilih kategori yang sesuai, atau klik <em>Kelola &amp; Tambah Kategori</em> untuk menambah pilihan baru.
              </div>
            </div>

            {{-- 3. Kode Transaksi --}}
            <div class="col-12 col-md-5">
              <label for="inputKode" class="form-label fw-bold text-dark mb-1">
                <span class="text-danger">*</span> Kode Transaksi:
              </label>
              <div class="input-group">
                <span class="input-group-text bg-light text-muted fw-bold font-monospace" id="addonKodeKategori">
                  {{ $cashflow->kode_kategori ?? 'KM' }}
                </span>
                <input type="text" name="kode" id="inputKode" value="{{ old('kode', $cashflow->kode) }}" 
                       class="form-control font-monospace fw-bold" required>
              </div>
              <input type="hidden" name="kode_kategori" id="inputKodeKategori" value="{{ old('kode_kategori', $cashflow->kode_kategori) }}">
            </div>

            @php
              $isEditDp = old('skema_bayar', ($cashflow->status === 'dp' || (float)$cashflow->sisa_piutang > 0 ? 'dp' : 'lunas')) === 'dp';
              $initTotalTagihan = old('total_tagihan', $cashflow->total_tagihan ? number_format($cashflow->total_tagihan, 0, ',', '.') : number_format($cashflow->nominal + $cashflow->sisa_piutang, 0, ',', '.'));
              $initSisaPiutang = old('sisa_piutang', number_format($cashflow->sisa_piutang ?? 0, 0, ',', '.'));
            @endphp

            {{-- Skema Pembayaran & Piutang --}}
            <div class="col-12" id="boxSkemaPembayaranWrapper">
              <div class="p-3 bg-light rounded-3 border">
                <label class="form-label fw-bold text-dark mb-2">
                  <i class="fas fa-hand-holding-dollar text-danger me-1"></i> Skema Pembayaran:
                </label>
                <div class="d-flex flex-wrap gap-4 mb-2">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="skema_bayar" id="skemaLunas" value="lunas" {{ !$isEditDp ? 'checked' : '' }} onchange="toggleSkemaBayar()">
                    <label class="form-check-label fw-semibold text-dark" for="skemaLunas">
                      <i class="fas fa-check-circle text-success me-1"></i> Pembayaran Lunas Penuh (100%)
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="skema_bayar" id="skemaDp" value="dp" {{ $isEditDp ? 'checked' : '' }} onchange="toggleSkemaBayar()">
                    <label class="form-check-label fw-semibold text-dark" for="skemaDp">
                      <i class="fas fa-clock text-warning me-1"></i> Uang Muka / DP (Ada Sisa Piutang)
                    </label>
                  </div>
                </div>

                {{-- Detail Tambahan Khusus DP --}}
                <div id="sectionDpInputs" style="{{ $isEditDp ? 'display: block;' : 'display: none;' }}" class="pt-3 mt-2 border-top">
                  <div class="row g-3">
                    <div class="col-12 col-md-5">
                      <label class="form-label small fw-bold text-dark mb-1">
                        <span class="text-danger">*</span> Total Biaya Program Penuh (Rp):
                      </label>
                      <div class="input-group">
                        <span class="input-group-text bg-white fw-bold">Rp</span>
                        <input type="text" name="total_tagihan" id="inputTotalTagihan" 
                               value="{{ $initTotalTagihan }}" 
                               class="form-control fw-bold" placeholder="Contoh: 7.000.000" oninput="formatRupiahInput(this); hitungPiutang();">
                      </div>
                    </div>
                    <div class="col-12 col-md-3">
                      <label class="form-label small fw-bold text-dark mb-1">Pilihan Cepat DP:</label>
                      <div class="d-flex gap-1">
                        <button type="button" class="btn btn-sm btn-outline-secondary flex-fill" onclick="setPresetDp(30)">30%</button>
                        <button type="button" class="btn btn-sm btn-outline-primary flex-fill fw-bold" onclick="setPresetDp(50)">50%</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary flex-fill" onclick="setPresetDp(70)">70%</button>
                      </div>
                    </div>
                    <div class="col-12 col-md-4">
                      <label class="form-label small fw-bold text-dark mb-1">Jatuh Tempo Pelunasan:</label>
                      <input type="date" name="jatuh_tempo" id="inputJatuhTempo" value="{{ old('jatuh_tempo', $cashflow->jatuh_tempo ? $cashflow->jatuh_tempo->format('Y-m-d') : '') }}" class="form-control">
                    </div>
                    <div class="col-12">
                      <div class="p-2 px-3 bg-white rounded border d-flex justify-content-between align-items-center">
                        <span class="small text-muted"><i class="fas fa-calculator text-muted me-1"></i> Sisa Piutang yang Harus Dilunasi:</span>
                        <strong class="text-danger fs-6" id="labelSisaPiutang">Rp {{ $initSisaPiutang }}</strong>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- Satuan & Volume (Format Formula ChatGPT Foto 2 & 3) --}}
            <div class="col-6 col-md-3">
              <label for="selectSatuan" class="form-label fw-bold text-dark mb-1">
                Satuan:
              </label>
              <select name="satuan" id="selectSatuan" class="form-select" onchange="checkCustomSatuan(this)">
                @foreach($satuanOptions as $sat)
                  <option value="{{ $sat }}" {{ old('satuan', $cashflow->satuan ?? 'paket') === $sat ? 'selected' : '' }}>{{ $sat }}</option>
                @endforeach
                <option value="__custom__">+ Tambah Satuan Lain...</option>
              </select>
              <input type="text" name="custom_satuan" id="inputCustomSatuan" class="form-control form-control-sm mt-1" placeholder="Ketik satuan baru..." style="display: none;">
            </div>

            <div class="col-6 col-md-3">
              <label for="inputVolume" class="form-label fw-bold text-dark mb-1">
                Volume (Jumlah):
              </label>
              <input type="number" step="any" min="0.01" name="volume" id="inputVolume" value="{{ old('volume', $cashflow->volume ?? 1) }}" class="form-control text-center fw-bold" oninput="hitungFormulaTotal()">
            </div>

            {{-- Harga Satuan (Rp) --}}
            <div class="col-12 col-md-6">
              <label for="inputHargaSatuan" class="form-label fw-bold text-dark mb-1">
                Harga Satuan (Rp):
              </label>
              <div class="input-group">
                <span class="input-group-text bg-white fw-bold">Rp</span>
                <input type="text" name="harga_satuan" id="inputHargaSatuan" 
                       value="{{ old('harga_satuan', $cashflow->harga_satuan ? number_format($cashflow->harga_satuan, 0, ',', '.') : '') }}" 
                       class="form-control fw-bold" placeholder="Contoh: 500.000" oninput="formatRupiahInput(this); hitungFormulaTotal();">
              </div>
              <div class="form-text small text-muted">Isi untuk menghitung total otomatis (Volume &times; Harga Satuan).</div>
            </div>

            {{-- 4. Nominal Harga (Dengan Format Titik) --}}
            <div class="col-12 col-md-7">
              <label for="inputNominal" class="form-label fw-bold text-dark mb-1">
                <span class="text-danger">*</span> <span id="labelNominalText">{{ $isEditDp ? 'Nominal DP yang Diterima (Rp):' : 'Total Transaksi / Nominal yang Diterima (Rp):' }}</span>
              </label>
              <div class="input-group nominal-input-group">
                <span class="input-group-text bg-light fw-bold text-dark">Rp</span>
                <input type="text" name="nominal" id="inputNominal" 
                       value="{{ old('nominal', number_format($cashflow->nominal, 0, ',', '.')) }}" 
                       class="form-control" placeholder="0" required autocomplete="off" oninput="formatRupiahInput(this); hitungPiutang();">
              </div>
              <div class="form-text small text-muted">
                Otomatis dihitung dari <strong>Volume &times; Harga Satuan</strong>, atau ketik nominal langsung.
              </div>
            </div>

            {{-- 5. Metode Pembayaran --}}
            <div class="col-12 col-md-5">
              <label for="selectMetode" class="form-label fw-bold text-dark mb-1">
                Metode Pembayaran:
              </label>
              <select name="metode_pembayaran" id="selectMetode" class="form-select">
                @foreach($metodeOptions as $m)
                  <option value="{{ $m }}" {{ old('metode_pembayaran', $cashflow->metode_pembayaran) === $m ? 'selected' : '' }}>{{ $m }}</option>
                @endforeach
              </select>
            </div>

            {{-- 6. Pihak Terkait --}}
            <div class="col-12">
              <label for="inputNamaPihak" class="form-label fw-bold text-dark mb-1" id="labelNamaPihak">
                Nama Siswa / Pembayar / Mitra / Pegawai:
              </label>
              <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                <input type="text" name="nama_pihak" id="inputNamaPihak" value="{{ old('nama_pihak', $cashflow->nama_pihak) }}" 
                       class="form-control" placeholder="Contoh: I Made Arya (Siswa) / PT PLN">
              </div>
            </div>

            {{-- 8. Deskripsi --}}
            <div class="col-12">
              <label for="inputDeskripsi" class="form-label fw-bold text-dark mb-1">
                Deskripsi:
              </label>
              <textarea name="deskripsi" id="inputDeskripsi" rows="4" class="form-control summernote" 
                        placeholder="Tuliskan rincian deskripsi transaksi kas...">{{ old('deskripsi', $cashflow->deskripsi) }}</textarea>
            </div>

            {{-- 9. Unggah Gambar Lampiran (Opsional) --}}
            <div class="col-12">
              <label class="form-label fw-bold text-dark mb-1">
                Lampiran Bukti / Kwitansi / Nota <span class="badge bg-light text-muted border ms-1">Opsional</span>:
              </label>

              @if($cashflow->lampiran)
                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 mb-2 border">
                  @php
                    $isPdf = str_ends_with(strtolower($cashflow->lampiran), '.pdf');
                  @endphp
                  @if($isPdf)
                    <i class="fas fa-file-pdf fs-2 text-danger"></i>
                    <div>
                      <div class="fw-semibold text-dark small">File Dokumen PDF Terlampir</div>
                      <a href="{{ asset($cashflow->lampiran) }}" target="_blank" class="small text-primary">
                        <i class="fas fa-external-link-alt"></i> Buka File PDF
                      </a>
                    </div>
                  @else
                    <img src="{{ asset($cashflow->lampiran) }}" alt="Lampiran Kas" class="img-thumbnail" style="width: 70px; height: 70px; object-fit: cover;">
                    <div>
                      <div class="fw-semibold text-dark small">Foto Bukti Terlampir Saat Ini</div>
                      <a href="{{ asset($cashflow->lampiran) }}" target="_blank" class="small text-primary">
                        <i class="fas fa-search-plus"></i> Lihat Gambar Penuh
                      </a>
                    </div>
                  @endif
                </div>
              @endif

              <div class="preview-upload-box" onclick="document.getElementById('fileLampiran').click()">
                <i class="fas fa-cloud-upload-alt fs-2 text-muted mb-2 d-block"></i>
                <div class="fw-semibold text-dark mb-1">
                  {{ $cashflow->lampiran ? 'Klik untuk Mengganti Bukti Transaksi' : 'Klik untuk Memilih File Bukti Transaksi' }}
                </div>
                <div class="small text-muted mb-2">Mendukung format JPG, PNG, WEBP, atau PDF (Maksimal 5MB)</div>
                <input type="file" name="lampiran" id="fileLampiran" class="d-none" 
                       accept="image/png,image/jpeg,image/webp,application/pdf" onchange="previewUploadFile(this)">
                <div id="previewFileName" class="badge bg-primary px-3 py-2 d-none"></div>
              </div>
              <div id="previewImgContainer" class="mt-2 text-center d-none">
                <img id="previewImg" src="" alt="Pratinjau Bukti Baru" class="img-thumbnail rounded-3" style="max-height: 200px;">
              </div>
            </div>

          </div>

          <hr class="my-4 text-muted opacity-25">

          {{-- Buttons --}}
          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('backoffice.cashflow.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            <button type="submit" class="btn btn-danger px-4 fw-bold">
              <i class="fas fa-save me-1"></i> Simpan Perubahan
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
  function toggleSkemaBayar() {
    const isDp = document.getElementById('skemaDp').checked;
    const boxDp = document.getElementById('sectionDpInputs');
    const labelNominal = document.getElementById('labelNominalText');

    if (isDp) {
      boxDp.style.display = 'block';
      labelNominal.textContent = 'Nominal DP yang Diterima (Rp):';
      hitungPiutang();
    } else {
      boxDp.style.display = 'none';
      labelNominal.textContent = 'Nominal Harga yang Diterima (Rp):';
      document.getElementById('inputTotalTagihan').value = '';
      document.getElementById('labelSisaPiutang').textContent = 'Rp 0';
    }
  }

  function hitungPiutang() {
    const isDp = document.getElementById('skemaDp').checked;
    if (!isDp) return;

    const rawTagihan = document.getElementById('inputTotalTagihan').value.replace(/[^0-9]/g, '');
    const rawNominal = document.getElementById('inputNominal').value.replace(/[^0-9]/g, '');

    const tagihan = parseInt(rawTagihan) || 0;
    const dibayar = parseInt(rawNominal) || 0;
    const sisa = Math.max(0, tagihan - dibayar);

    document.getElementById('labelSisaPiutang').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(sisa);
  }

  function setPresetDp(pct) {
    const rawTagihan = document.getElementById('inputTotalTagihan').value.replace(/[^0-9]/g, '');
    const tagihan = parseInt(rawTagihan) || 0;
    if (tagihan <= 0) {
      alert('Silakan isi Total Biaya Program Penuh terlebih dahulu.');
      document.getElementById('inputTotalTagihan').focus();
      return;
    }

    const dpNominal = Math.round(tagihan * (pct / 100));
    const inputNominal = document.getElementById('inputNominal');
    inputNominal.value = new Intl.NumberFormat('id-ID').format(dpNominal);
    hitungPiutang();
  }

  const kategoriData = @json($kategoriOptions);

  // Data Program per Divisi dari Controller
  const divisiProgramsMap = @json($divisiList->mapWithKeys(fn($d) => [$d->id => ['nama' => $d->nama, 'programs' => $d->programs->map(fn($p) => ['id' => $p->id, 'nama' => $p->nama])]]));

  // Handler Perubahan Divisi: Menampilkan & Memfilter Program Terkait
  function handleDivisiChange(divisiId, selectedProgId = null) {
    const boxProg = document.getElementById('boxProgramWrapper');
    const selectProg = document.getElementById('selectProgram');
    const labelDivisi = document.getElementById('labelNamaDivisi');

    if (!divisiId || !divisiProgramsMap[divisiId]) {
      if (boxProg) boxProg.style.display = 'none';
      if (selectProg) selectProg.value = '';
      return;
    }

    const divData = divisiProgramsMap[divisiId];
    if (labelDivisi) labelDivisi.textContent = divData.nama;

    selectProg.innerHTML = '<option value="">-- Pilih Program Terkait (' + divData.nama + ') --</option>';

    if (divData.programs && divData.programs.length > 0) {
      divData.programs.forEach(prog => {
        const opt = document.createElement('option');
        opt.value = prog.id;
        opt.textContent = prog.nama;
        if (selectedProgId && String(selectedProgId) === String(prog.id)) {
          opt.selected = true;
        }
        selectProg.appendChild(opt);
      });
      if (boxProg) boxProg.style.display = 'block';
    } else {
      const opt = document.createElement('option');
      opt.value = '';
      opt.textContent = 'Belum ada program terdaftar pada divisi ini';
      selectProg.appendChild(opt);
      if (boxProg) boxProg.style.display = 'block';
    }
  }

  function selectTipe(tipe) {
    const inputTipe = document.getElementById('inputTipe');
    if (inputTipe) inputTipe.value = tipe;

    const selectTipeElem = document.getElementById('selectTipe');
    if (selectTipeElem && selectTipeElem.value !== tipe) {
      selectTipeElem.value = tipe;
    }

    const labelPihak = document.getElementById('labelNamaPihak');
    if (labelPihak) {
      if (tipe === 'masuk') {
        labelPihak.innerHTML = 'Nama Siswa / Pembayar / Instansi Mitra:';
      } else {
        labelPihak.innerHTML = 'Nama Pegawai / Penerima / Vendor:';
      }
    }

    const boxSkema = document.getElementById('boxSkemaPembayaranWrapper');
    if (boxSkema) {
      boxSkema.style.display = (tipe === 'masuk') ? 'block' : 'none';
    }

    renderKategoriOptions(tipe);
  }

  function renderKategoriOptions(tipe, selectedLabel = null) {
    const select = document.getElementById('selectKategori');
    select.innerHTML = '<option value="">-- Pilih Jenis Transaksi --</option>';

    const options = kategoriData[tipe] || {};
    let matched = false;

    for (const [code, label] of Object.entries(options)) {
      const opt = document.createElement('option');
      opt.value = label;
      opt.textContent = `[${code}] ${label}`;
      opt.dataset.code = code;
      if (selectedLabel && selectedLabel === label) {
        opt.selected = true;
        matched = true;
      }
      select.appendChild(opt);
    }

    // Jika custom kategori lama
    if (selectedLabel && !matched) {
      const customOpt = document.createElement('option');
      customOpt.value = selectedLabel;
      customOpt.textContent = selectedLabel;
      customOpt.selected = true;
      select.appendChild(customOpt);
    }

    handleKategoriChange();
  }

  function handleKategoriChange() {
    const select = document.getElementById('selectKategori');
    const selectedOption = select.options[select.selectedIndex];
    if (selectedOption && selectedOption.dataset.code) {
      const code = selectedOption.dataset.code;
      document.getElementById('inputKodeKategori').value = code;
      document.getElementById('addonKodeKategori').textContent = code;
    }
  }

  // Handle Custom Satuan & Live Formula Total
  function checkCustomSatuan(sel) {
    const inputCustom = document.getElementById('inputCustomSatuan');
    if (sel.value === '__custom__') {
      inputCustom.style.display = 'block';
      inputCustom.focus();
    } else {
      inputCustom.style.display = 'none';
    }
  }

  function hitungFormulaTotal() {
    const vol = parseFloat(document.getElementById('inputVolume').value) || 1;
    const rawHarga = (document.getElementById('inputHargaSatuan').value || '').replace(/[^0-9]/g, '');
    const harga = parseFloat(rawHarga) || 0;
    if (harga > 0) {
      const total = vol * harga;
      const inputNom = document.getElementById('inputNominal');
      inputNom.value = new Intl.NumberFormat('id-ID').format(total);
      if (typeof hitungPiutang === 'function') {
        hitungPiutang();
      }
    }
  }

  function formatRupiahInput(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    if (!value) {
      input.value = '';
      return;
    }
    input.value = new Intl.NumberFormat('id-ID').format(value);
  }

  function previewUploadFile(input) {
    if (input.files && input.files[0]) {
      const file = input.files[0];
      const previewText = document.getElementById('previewFileName');
      previewText.textContent = `File baru terpilih: ${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
      previewText.classList.remove('d-none');

      if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('previewImg').src = e.target.result;
          document.getElementById('previewImgContainer').classList.remove('d-none');
        };
        reader.readAsDataURL(file);
      } else {
        document.getElementById('previewImgContainer').classList.add('d-none');
      }
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    const currentTipe = document.getElementById('inputTipe').value || 'masuk';
    const oldKategori = @json(old('kategori', $cashflow->kategori));
    renderKategoriOptions(currentTipe, oldKategori);

    const initDivisiElem = document.getElementById('selectDivisi');
    if (initDivisiElem && initDivisiElem.value) {
      handleDivisiChange(initDivisiElem.value, @json(old('program_id', $cashflow->program_id)));
    }
  });
</script>
@endpush
