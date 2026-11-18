@extends('backoffice.layouts.app')

@section('title', 'Tambah Transaksi | Backoffice Denpasar Institute')

@push('styles')
<style>
  .form-transaksi-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    padding: 32px;
  }
  .form-label {
    font-size: 0.88rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 6px;
  }
  .form-control, .form-select {
    border-radius: 8px;
    border-color: #cbd5e1;
    font-size: 0.92rem;
    padding: 10px 14px;
    transition: all 0.2s ease;
  }
  .form-control:focus, .form-select:focus {
    border-color: #CC0000;
    box-shadow: 0 0 0 3px rgba(204, 0, 0, 0.12);
  }
  .custom-radio-box .form-check-input:checked {
    background-color: #CC0000;
    border-color: #CC0000;
  }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

  {{-- Breadcrumb & Back --}}
  <div class="mb-3">
    <a href="{{ route('backoffice.cashflow.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
      <i class="fas fa-arrow-left me-1"></i> Kembali ke Keuangan Umum
    </a>
  </div>

  {{-- Error Alerts --}}
  @if(isset($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-1"></i> Terjadi kesalahan input:</div>
      <ul class="mb-0 small ps-3">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- Form Card (Sesuai Foto 2 & 3: Form 2. Input transaksi keuangan - Tambah Transaksi) --}}
  <div class="row justify-content-center">
    <div class="col-12 col-lg-8 col-xl-7">
      <div class="form-transaksi-card">
        
        <div class="mb-4 pb-3 border-bottom">
          <span class="badge bg-danger-subtle text-danger font-monospace px-2 py-1 mb-1" style="font-size: 0.75rem;">
            Form 2. Input transaksi keuangan
          </span>
          <h4 class="fw-bold text-dark mb-0">Tambah Transaksi</h4>
        </div>

        <form action="{{ route('backoffice.cashflow.store') }}" method="POST" enctype="multipart/form-data" id="cashflowForm">
          @csrf

          <div class="row g-3">

            {{-- 1. Pilih Program --}}
            <div class="col-12">
              <label class="form-label">
                Pilih Program
              </label>
              <select name="program_id" id="selectProgram" class="form-select">
                <option value="">Pilih program</option>
                <option value="">-- Operasional Umum Lembaga (Non-Program) --</option>
                @foreach($programs as $prog)
                  <option value="{{ $prog->id }}" {{ old('program_id') == $prog->id ? 'selected' : '' }}>
                    {{ $prog->nama }}
                  </option>
                @endforeach
              </select>
            </div>

            {{-- 2. Tanggal Transaksi --}}
            <div class="col-12">
              <label class="form-label">
                <span class="text-danger">*</span> Tanggal Transaksi
              </label>
              <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted">
                  <i class="far fa-calendar-alt"></i>
                </span>
                <input type="date" name="tanggal" id="inputTanggal" 
                       value="{{ old('tanggal', date('Y-m-d')) }}" class="form-control border-start-0 ps-1" required>
              </div>
            </div>

            {{-- 3. Transaksi (Radio: Pemasukan vs Pengeluaran) --}}
            <div class="col-12">
              <label class="form-label d-block">
                <span class="text-danger">*</span> Transaksi
              </label>
              <div class="d-flex align-items-center gap-4 pt-1 pb-1">
                <div class="form-check custom-radio-box">
                  <input class="form-check-input" type="radio" name="tipe" id="tipeMasuk" value="masuk" 
                         {{ old('tipe', 'masuk') === 'masuk' ? 'checked' : '' }} onchange="switchJenisTransaksi('masuk')">
                  <label class="form-check-label fw-semibold text-dark ps-1" for="tipeMasuk" style="cursor: pointer;">
                    Pemasukan
                  </label>
                </div>
                <div class="form-check custom-radio-box">
                  <input class="form-check-input" type="radio" name="tipe" id="tipeKeluar" value="keluar" 
                         {{ old('tipe') === 'keluar' ? 'checked' : '' }} onchange="switchJenisTransaksi('keluar')">
                  <label class="form-check-label fw-semibold text-dark ps-1" for="tipeKeluar" style="cursor: pointer;">
                    Pengeluaran
                  </label>
                </div>
              </div>
            </div>

            {{-- 4. Kategori --}}
            <div class="col-12">
              <label class="form-label">
                <span class="text-danger">*</span> Kategori
              </label>
              <select name="kategori" id="selectKategori" class="form-select" required>
                <option value="">Pilih kategori</option>
              </select>
            </div>

            {{-- 5. Deskripsi --}}
            <div class="col-12">
              <label class="form-label">
                Deskripsi
              </label>
              <textarea name="deskripsi" id="inputDeskripsi" class="form-control summernote" placeholder="Uraian transaksi / rincian kegiatan..." rows="4">{{ old('deskripsi') }}</textarea>
            </div>

            {{-- 6 & 7. Satuan & Volume (Side by Side) --}}
            <div class="col-12 col-md-6">
              <label class="form-label">
                <span class="text-danger">*</span> Satuan
              </label>
              <select name="satuan" id="selectSatuan" class="form-select" onchange="checkCustomSatuan(this)">
                <option value="">Pilih</option>
                @foreach($satuanOptions ?? [] as $sat)
                  <option value="{{ $sat }}" {{ old('satuan', 'paket') === $sat ? 'selected' : '' }}>{{ $sat }}</option>
                @endforeach
                <option value="__custom__">+ Satuan Baru...</option>
              </select>
              <input type="text" name="custom_satuan" id="inputCustomSatuan" class="form-control form-control-sm mt-1" 
                     placeholder="Ketik satuan baru..." style="display: none;" oninput="document.getElementById('selectSatuan').value = this.value">
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label">
                <span class="text-danger">*</span> Volume
              </label>
              <input type="number" step="any" min="0.01" name="volume" id="inputVolume" 
                     value="{{ old('volume', 1) }}" class="form-control text-center fw-bold" required oninput="recalcTotal()">
            </div>

            {{-- 8. Harga Satuan (Rp) --}}
            <div class="col-12">
              <label class="form-label">
                <span class="text-danger">*</span> Harga Satuan (Rp)
              </label>
              <div class="input-group">
                <span class="input-group-text bg-white fw-bold">Rp</span>
                <input type="text" name="harga_satuan" id="inputHargaSatuan" value="{{ old('harga_satuan') }}" 
                       class="form-control fw-bold" placeholder="Harga Satuan (Rp)" required oninput="formatRupiah(this); recalcTotal()">
              </div>
            </div>

            {{-- 9. Total Transaksi (Kalkulasi Otomatis = Volume x Harga Satuan) --}}
            <div class="col-12">
              <div class="p-3 bg-light rounded-3 border d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                <div>
                  <span class="small text-muted d-block fw-bold" style="font-size: 0.75rem;">
                    TOTAL TRANSAKSI (VOLUME &times; HARGA SATUAN):
                  </span>
                  <strong class="fs-4 text-success" id="liveTotalText">
                    Rp 0
                  </strong>
                </div>
                <div class="text-muted small mt-1 mt-sm-0">
                  <span id="liveFormulaText">1 paket &times; Rp 0</span>
                </div>
              </div>
              <input type="hidden" name="nominal" id="inputTotalNominalHidden">
            </div>

            {{-- 10. Metode Pembayaran & Bukti Lampiran --}}
            <div class="col-12 col-md-6">
              <label class="form-label">
                Metode Pembayaran
              </label>
              <select name="metode_pembayaran" class="form-select">
                @foreach($metodeOptions ?? [] as $m)
                  <option value="{{ $m }}" {{ old('metode_pembayaran') === $m ? 'selected' : '' }}>{{ $m }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label">
                Bukti Transaksi (Struk / Nota / Transfer)
              </label>
              <input type="file" name="lampiran" class="form-control" accept="image/jpeg,image/png,image/jpg,application/pdf">
              <div class="form-text text-muted" style="font-size: 0.72rem;">Opsional (JPG, PNG, PDF maks. 5MB)</div>
            </div>

            {{-- Action Buttons --}}
            <div class="col-12 d-flex justify-content-end gap-2 pt-3 border-top mt-4 flex-wrap">
              <a href="{{ route('backoffice.cashflow.index') }}" class="btn btn-outline-secondary px-4">
                Batal
              </a>
              <button type="submit" name="submit_action" value="save_and_add" class="btn btn-outline-di px-3">
                <i class="fas fa-plus-circle me-1"></i> Simpan &amp; Tambah
              </button>
              <button type="submit" name="submit_action" value="save" class="btn btn-danger fw-bold px-4" style="background: #CC0000; border-color: #CC0000;">
                <i class="fas fa-save me-1"></i> Simpan Transaksi
              </button>
            </div>

          </div>

        </form>

      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
(function() {
  const katOptions = @json($kategoriOptions ?? []);
  const oldKategori = @json(old('kategori'));
  const currentTipe = document.querySelector('input[name="tipe"]:checked')?.value || 'masuk';

  window.switchJenisTransaksi = function(tipe) {
    const sel = document.getElementById('selectKategori');
    if (!sel) return;
    sel.innerHTML = '<option value="">Pilih kategori</option>';

    const opts = katOptions[tipe] || {};
    Object.keys(opts).forEach(code => {
      const name = opts[code];
      const optEl = document.createElement('option');
      optEl.value = name;
      optEl.textContent = `[${code}] ${name}`;
      if (oldKategori && oldKategori === name) {
        optEl.selected = true;
      }
      sel.appendChild(optEl);
    });
  };

  window.checkCustomSatuan = function(sel) {
    const custom = document.getElementById('inputCustomSatuan');
    if (!custom) return;
    if (sel.value === '__custom__') {
      custom.style.display = 'block';
      custom.focus();
    } else {
      custom.style.display = 'none';
    }
    recalcTotal();
  };

  window.formatRupiah = function(el) {
    let val = el.value.replace(/[^0-9]/g, '');
    if (!val) {
      el.value = '';
      return;
    }
    el.value = new Intl.NumberFormat('id-ID').format(val);
  };

  window.recalcTotal = function() {
    const volEl = document.getElementById('inputVolume');
    const hargaEl = document.getElementById('inputHargaSatuan');
    const satEl = document.getElementById('selectSatuan');
    const totalTextEl = document.getElementById('liveTotalText');
    const formulaTextEl = document.getElementById('liveFormulaText');
    const hiddenTotalEl = document.getElementById('inputTotalNominalHidden');

    if (!volEl || !hargaEl || !totalTextEl) return;

    const vol = parseFloat(volEl.value) || 0;
    const rawHarga = hargaEl.value.replace(/[^0-9]/g, '');
    const harga = parseFloat(rawHarga) || 0;
    const total = Math.round(vol * harga);

    const satuan = satEl && satEl.value === '__custom__'
      ? (document.getElementById('inputCustomSatuan').value || 'item')
      : (satEl ? (satEl.value || 'paket') : 'paket');

    totalTextEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    if (formulaTextEl) {
      formulaTextEl.innerText = vol + ' ' + satuan + ' × Rp ' + new Intl.NumberFormat('id-ID').format(harga);
    }
    if (hiddenTotalEl) {
      hiddenTotalEl.value = total;
    }
  };

  document.addEventListener('DOMContentLoaded', function() {
    switchJenisTransaksi(currentTipe);
    recalcTotal();
  });
})();
</script>
@endpush
