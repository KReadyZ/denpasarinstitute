@extends('backoffice.layouts.app')

@section('title', 'Keuangan ' . ($project->program ? $project->program->nama : 'Program Kursus') . ' | Backoffice Denpasar Institute')
@section('page-title', 'Keuangan Program Kursus')

@push('styles')
<style>
  .kpi-card {
    border-radius: 12px;
    padding: 18px 20px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    height: 100%;
    position: relative;
    overflow: hidden;
  }
  .kpi-card.kpi-border-green {
    border-bottom: 3px solid #16a34a;
  }
  .kpi-card.kpi-border-red {
    border-bottom: 3px solid #dc2626;
  }
  .kpi-card.kpi-border-orange {
    border-bottom: 3px solid #f97316;
  }
  .kpi-card.kpi-border-blue {
    border-bottom: 3px solid #2563eb;
  }
  .kpi-badge {
    font-size: 0.72rem;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
  }
  .project-header-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.02);
  }

  .form-transaksi-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    padding: 24px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.03);
  }
  .total-live-box {
    background: #f8fafc;
    border: 1.5px dashed #cbd5e1;
    border-radius: 10px;
    padding: 14px 18px;
  }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

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

  {{-- Breadcrumb & Title (Sesuai Denpasar Institute) --}}
  <div class="mb-3">
    <div class="d-flex align-items-center gap-2 small text-muted mb-2">
      <a href="{{ route('backoffice.project.index') }}" class="text-decoration-none text-muted">Daftar Program &amp; Kursus</a>
      <i class="fas fa-chevron-right" style="font-size: 0.65rem;"></i>
      <span>Keuangan Program #{{ $project->kode }}</span>
    </div>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
      <div>
        <h2 class="h4 fw-bold text-dark mb-1">
          Keuangan {{ $project->program ? $project->program->nama : $project->nama_proyek }}
        </h2>
        <div class="text-muted small">
          <strong>{{ $project->nama_proyek }}</strong>
          • {{ $project->tanggal_mulai ? $project->tanggal_mulai->format('d M Y') : '-' }} 
          @if($project->tanggal_selesai) s/d {{ $project->tanggal_selesai->format('d M Y') }} @endif
          • PIC / Instruktur: <span class="fw-semibold text-dark">{{ $project->pic ?: '-' }}</span>
          @if($project->keterangan) • <span class="fst-italic text-secondary">{{ Str::limit($project->keterangan, 70) }}</span> @endif
        </div>
      </div>

      <div class="d-flex align-items-center gap-2 ms-sm-auto justify-content-end flex-wrap flex-sm-nowrap">
        <a href="{{ route('backoffice.project.edit', $project->id) }}" class="btn btn-sm btn-outline-secondary px-3" style="height: 38px; display: inline-flex; align-items: center; border-radius: 8px; white-space: nowrap;">
          <i class="fas fa-edit me-1"></i> Edit Info Kursus
        </a>
        <a href="{{ route('backoffice.project.cetak', $project->id) }}" target="_blank" class="btn btn-sm btn-success fw-bold px-3" style="height: 38px; display: inline-flex; align-items: center; border-radius: 8px; white-space: nowrap;">
          <i class="fas fa-print me-1"></i> Cetak Kuitansi / Laporan
        </a>
      </div>
    </div>
  </div>

  {{-- Program Header Card Info (Format KELAS #...) --}}
  <div class="project-header-box mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3 pb-3 border-bottom">
      <div class="d-flex align-items-center gap-2 flex-wrap">
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace px-2 py-1">
          KELAS #{{ $project->kode }}
        </span>
        <h5 class="mb-0 fw-bold text-dark">{{ $project->nama_proyek }}</h5>
        @if($project->nama_peserta)
          <span class="badge bg-light text-muted border">Peserta: {{ $project->nama_peserta }}</span>
        @endif
      </div>

      <div>
        @if($project->sisa_tagihan <= 0 && $project->nilai_proyek > 0)
          <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-bold">
            <i class="fas fa-check-circle me-1"></i> Status Bayar: Lunas
          </span>
        @else
          <span class="badge bg-warning-subtle text-danger border border-warning-subtle px-3 py-2 rounded-pill fw-bold">
            <i class="fas fa-clock me-1"></i> Status Bayar: Belum Lunas (Piutang)
          </span>
        @endif
      </div>
    </div>

    {{-- Form Edit Cepat Nilai Biaya Kursus --}}
    <form action="{{ route('backoffice.project.update-nilai', $project->id) }}" method="POST" class="row g-2 align-items-center">
      @csrf
      <div class="col-12 col-md-4">
        <label class="form-label small fw-bold text-dark mb-0">BIAYA KURSUS / PROGRAM:</label>
        <div class="small text-muted" style="font-size: 0.75rem;">Target nilai biaya kursus peserta untuk menghitung status pelunasan &amp; sisa piutang.</div>
      </div>
      <div class="col-8 col-md-5">
        <div class="input-group input-group-sm">
          <span class="input-group-text bg-white fw-bold">Rp</span>
          <input type="text" name="nilai_proyek" class="form-control fw-bold" 
                 value="{{ number_format($project->nilai_proyek, 0, ',', '.') }}" 
                 oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')">
        </div>
      </div>
      <div class="col-4 col-md-3">
        <button type="submit" class="btn btn-sm btn-dark fw-bold w-100">
          <i class="fas fa-save me-1"></i> Simpan Biaya
        </button>
      </div>
    </form>
  </div>

  {{-- 3 KPI CARDS: BIAYA KURSUS, UANG MASUK (TERBAYAR), PIUTANG (BELUM LUNAS) --}}
  <div class="row g-3 mb-4">
    {{-- 1. Biaya Kursus (Target) --}}
    <div class="col-12 col-md-4">
      <div class="kpi-card">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <span class="text-muted small fw-bold text-uppercase" style="font-size: 0.72rem;">BIAYA KURSUS</span>
          <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-2 py-1" style="font-size: 0.72rem; font-weight: 700;">Target Biaya</span>
        </div>
        <div class="fs-4 fw-bold text-dark my-1">
          Rp {{ number_format($project->nilai_proyek, 0, ',', '.') }}
        </div>
        <div class="small text-muted" style="font-size: 0.72rem;">Target Tagihan Biaya Kursus Peserta</div>
      </div>
    </div>

    {{-- 2. Uang Masuk (Total Terbayar) --}}
    <div class="col-12 col-md-4">
      <div class="kpi-card kpi-border-green">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <span class="text-muted small fw-bold text-uppercase" style="font-size: 0.72rem;">UANG MASUK (TERBAYAR)</span>
          <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1" style="font-size: 0.72rem; font-weight: 700;">
            <i class="fas fa-arrow-up me-1"></i>{{ $project->persen_terbayar }}% Terbayar
          </span>
        </div>
        <div class="fs-4 fw-bold text-success my-1">
          + Rp {{ number_format($project->pemasukan, 0, ',', '.') }}
        </div>
        <div class="small text-muted" style="font-size: 0.72rem;">Total Setoran Pembayaran Diterima</div>
      </div>
    </div>

    {{-- 3. Piutang (Belum Lunas) --}}
    <div class="col-12 col-md-4">
      <div class="kpi-card {{ $project->sisa_tagihan > 0 ? 'kpi-border-red' : 'kpi-border-green' }}">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <span class="text-muted small fw-bold text-uppercase" style="font-size: 0.72rem;">PIUTANG (BELUM LUNAS)</span>
          <span class="badge {{ $project->sisa_tagihan > 0 ? 'bg-danger-subtle text-danger border border-danger-subtle' : 'bg-success-subtle text-success border border-success-subtle' }} rounded-pill px-2 py-1" style="font-size: 0.72rem; font-weight: 700;">
            <i class="fas {{ $project->sisa_tagihan > 0 ? 'fa-clock' : 'fa-check-circle' }} me-1"></i>{{ $project->sisa_tagihan > 0 ? $project->persen_sisa . '% Belum Lunas' : '100% Lunas' }}
          </span>
        </div>
        <div class="fs-4 fw-bold {{ $project->sisa_tagihan > 0 ? 'text-danger' : 'text-success' }} my-1">
          Rp {{ number_format($project->sisa_tagihan, 0, ',', '.') }}
        </div>
        <div class="small text-muted" style="font-size: 0.72rem;">
          {{ $project->sisa_tagihan <= 0 ? '✓ Pembayaran Kursus Telah Lunas' : '⏰ Sisa Tagihan yang Masih Harus Dibayar' }}
        </div>
      </div>
    </div>
  </div>

  {{-- FORM TRANSAKSI PEMBAYARAN MASUK --}}
  <div class="form-transaksi-card mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
      <div>
        <h5 class="fw-bold mb-0 text-dark">
          <i class="fas fa-plus-circle text-success me-1"></i> Catat Pembayaran Kursus Peserta
        </h5>
        <small class="text-muted">
          Input uang masuk pembayaran DP, cicilan biaya program, atau pelunasan dari peserta / siswa kursus.
        </small>
      </div>

      <div class="text-end">
        <span class="badge bg-success px-3 py-2 fs-6">
          Total Terbayar: Rp {{ number_format($project->pemasukan, 0, ',', '.') }}
        </span>
      </div>
    </div>

    <form action="{{ route('backoffice.project.transaksi.store', $project->id) }}" method="POST" enctype="multipart/form-data" id="formTransaksiProyek">
      @csrf
      <input type="hidden" name="tipe" value="masuk">

      <div class="row g-3">
        {{-- Tanggal Transaksi --}}
        <div class="col-12 col-md-4">
          <label class="form-label small fw-bold text-dark mb-1">
            <span class="text-danger">*</span> Tanggal Pembayaran:
          </label>
          <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="form-control" required>
        </div>

        {{-- Kategori Kas --}}
        <div class="col-12 col-md-8">
          <label class="form-label small fw-bold text-dark mb-1">
            <span class="text-danger">*</span> Kategori Pembayaran:
          </label>
          <select name="kategori" class="form-select" required>
            <option value="">-- Pilih Pos Kategori Pembayaran --</option>
            @foreach($kategoriOptions['masuk'] ?? [] as $code => $name)
              <option value="{{ $name }}" {{ str_contains(strtolower($name), 'pendaftaran') || str_contains(strtolower($name), 'pelatihan') ? 'selected' : '' }}>[{{ $code }}] {{ $name }}</option>
            @endforeach
          </select>
        </div>

        {{-- Deskripsi / Uraian --}}
        <div class="col-12">
          <label class="form-label small fw-bold text-dark mb-1">
            <span class="text-danger">*</span> Uraian / Keterangan Pembayaran:
          </label>
          <input type="text" name="deskripsi" class="form-control" 
                 placeholder="Contoh: Pembayaran DP 50% Kelas Kursus / Pelunasan Biaya Program" required>
        </div>

        {{-- Satuan & Volume (Formula ChatGPT Foto 2 & 3) --}}
        <div class="col-6 col-md-3">
          <label class="form-label small fw-bold text-dark mb-1">
            <span class="text-danger">*</span> Satuan:
          </label>
          <div class="input-group">
            <select name="satuan" id="selectSatuan" class="form-select" onchange="checkCustomSatuan(this)">
              @foreach($satuanOptions as $sat)
                <option value="{{ $sat }}" {{ $sat === 'paket' || $sat === 'orang' ? 'selected' : '' }}>{{ $sat }}</option>
              @endforeach
              <option value="__custom__">+ Tambah Satuan Lain...</option>
            </select>
          </div>
          <input type="text" name="custom_satuan" id="inputCustomSatuan" class="form-control form-control-sm mt-1" placeholder="Ketik satuan baru..." style="display: none;" oninput="document.getElementById('selectSatuan').value = this.value">
        </div>

        <div class="col-6 col-md-3">
          <label class="form-label small fw-bold text-dark mb-1">
            <span class="text-danger">*</span> Volume (Jumlah):
          </label>
          <input type="number" step="any" min="0.01" name="volume" id="inputVolume" value="1" class="form-control text-center fw-bold" required oninput="hitungTotalOtomatis()">
        </div>

        {{-- Harga Satuan (Rp) --}}
        <div class="col-12 col-md-6">
          <label class="form-label small fw-bold text-dark mb-1">
            <span class="text-danger">*</span> Harga Satuan (Rp):
          </label>
          <div class="input-group">
            <span class="input-group-text bg-white fw-bold">Rp</span>
            <input type="text" name="harga_satuan" id="inputHargaSatuan" class="form-control fw-bold" placeholder="Contoh: 500.000" required oninput="formatRupiahInput(this); hitungTotalOtomatis()">
          </div>
        </div>

        {{-- Total Transaksi (Otomatis) --}}
        <div class="col-12">
          <div class="total-live-box d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
            <div>
              <span class="small text-muted d-block">TOTAL PEMBAYARAN MASUK (OTOMATIS = VOLUME &times; HARGA SATUAN):</span>
              <strong class="fs-4 text-success" id="labelTotalOtomatis">
                Rp 0
              </strong>
            </div>
            <div class="text-muted small mt-2 mt-sm-0">
              <span id="formulaText">1 paket &times; Rp 0</span>
            </div>
          </div>
        </div>

        {{-- Deskripsi --}}
        <div class="col-12">
          <label class="form-label small fw-bold text-dark mb-1">Deskripsi (Opsional):</label>
          <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Bukti transfer via BCA / cicilan ke-2">
        </div>

        {{-- Metode Pembayaran --}}
        <div class="col-12 col-md-6">
          <label class="form-label small fw-bold text-dark mb-1">Metode Pembayaran:</label>
          <select name="metode_pembayaran" class="form-select">
            @foreach($metodeOptions as $m)
              <option value="{{ $m }}">{{ $m }}</option>
            @endforeach
          </select>
        </div>

        {{-- Upload Bukti Transaksi --}}
        <div class="col-12 col-md-6">
          <label class="form-label small fw-bold text-dark mb-1">Bukti Pembayaran (Struk / Slip Transfer):</label>
          <input type="file" name="lampiran" class="form-control" accept="image/jpeg,image/png,image/jpg,application/pdf">
          <div class="form-text small text-muted">Format: JPG, PNG, PDF (Maks. 5MB).</div>
        </div>

        <div class="col-12 d-flex justify-content-end pt-2">
          <button type="submit" class="btn btn-success fw-bold px-4">
            <i class="fas fa-save me-1"></i> Simpan Pembayaran Masuk
          </button>
        </div>
      </div>
    </form>
  </div>

  {{-- TABEL RIWAYAT PEMBAYARAN MASUK PESERTA --}}
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
      <h6 class="fw-bold mb-0 text-dark">
        <i class="fas fa-hand-holding-dollar text-success me-2"></i>
        Riwayat Pembayaran Masuk Peserta
      </h6>
      <span class="badge bg-success-subtle text-success border border-success-subtle">
        {{ $pemasukanList->count() }} pembayaran tercatat
      </span>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
        <thead class="table-light">
          <tr>
            <th class="text-center" style="width: 50px;">NO</th>
            <th style="width: 120px;">TANGGAL</th>
            <th>DESKRIPSI</th>
            <th>RINCIAN</th>
            <th>METODE</th>
            <th class="text-end">NOMINAL (RP)</th>
            <th class="text-center" style="width: 100px;">BUKTI</th>
            <th class="text-center" style="width: 60px;">AKSI</th>
          </tr>
        </thead>
        <tbody>
          @forelse($pemasukanList as $idx => $trx)
            <tr>
              <td class="text-center text-muted fw-bold">{{ $idx + 1 }}</td>
              <td>
                <span class="fw-semibold">{{ $trx->tanggal ? $trx->tanggal->format('d M Y') : '-' }}</span>
                <small class="d-block text-muted font-monospace" style="font-size: 0.72rem;">{{ $trx->kode }}</small>
              </td>
              <td>
                <div class="fw-bold text-dark">{{ $trx->deskripsi ?: $trx->judul }}</div>
                <small class="text-muted">Kategori: {{ $trx->kategori }}</small>
              </td>
              <td>
                <span class="badge bg-light text-dark border">
                  {{ (float)$trx->volume }} {{ $trx->satuan ?: 'paket' }}
                </span>
                @if($trx->harga_satuan)
                  <small class="text-muted d-block">@ Rp {{ number_format($trx->harga_satuan, 0, ',', '.') }}</small>
                @endif
              </td>
              <td>
                <small class="text-dark">{{ $trx->metode_pembayaran ?: 'Transfer Bank' }}</small>
              </td>
              <td class="text-end fw-bold text-success">
                + Rp {{ number_format($trx->nominal, 0, ',', '.') }}
              </td>
              <td class="text-center">
                @if($trx->lampiran)
                  <a href="{{ asset($trx->lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 0.75rem;" title="Lihat Bukti Transfer">
                    <i class="fas fa-file-invoice"></i> Nota
                  </a>
                @else
                  <span class="text-muted" style="font-size: 0.8rem;">—</span>
                @endif
              </td>
              <td class="text-center">
                <form action="{{ route('backoffice.cashflow.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Hapus catatan pembayaran ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" title="Hapus Pembayaran">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-4 text-muted">
                <i class="fas fa-receipt fs-3 text-secondary mb-2 d-block"></i>
                Belum ada transaksi pembayaran masuk yang dicatat untuk kelas kursus peserta ini.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

@push('scripts')
<script>
function formatRupiahInput(el) {
  let val = el.value.replace(/[^0-9]/g, '');
  if (!val) {
    el.value = '';
    return;
  }
  el.value = new Intl.NumberFormat('id-ID').format(val);
}

function hitungTotalOtomatis() {
  const volEl = document.getElementById('inputVolume');
  const hargaEl = document.getElementById('inputHargaSatuan');
  const satEl = document.getElementById('selectSatuan');
  const labelTotal = document.getElementById('labelTotalOtomatis');
  const formulaText = document.getElementById('formulaText');

  const vol = parseFloat(volEl.value) || 0;
  const rawHarga = hargaEl.value.replace(/[^0-9]/g, '');
  const harga = parseFloat(rawHarga) || 0;

  const total = vol * harga;
  const satuan = satEl.value === '__custom__' ? (document.getElementById('inputCustomSatuan').value || 'item') : satEl.value;

  labelTotal.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
  formulaText.innerText = vol + ' ' + satuan + ' × Rp ' + new Intl.NumberFormat('id-ID').format(harga);
}

function checkCustomSatuan(selectEl) {
  const customInput = document.getElementById('inputCustomSatuan');
  if (selectEl.value === '__custom__') {
    customInput.style.display = 'block';
    customInput.focus();
  } else {
    customInput.style.display = 'none';
  }
  hitungTotalOtomatis();
}
</script>
@endpush

@endsection
