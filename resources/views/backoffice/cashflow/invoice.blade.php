<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice Kuitansi Kas {{ $cashflow->kode }} - Denpasar Institute</title>
  <link rel="icon" type="image/png" href="{{ asset('image/Logo_DI.png') }}">
  <link rel="shortcut icon" type="image/png" href="{{ asset('image/Logo_DI.png') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      font-family: 'Poppins', Arial, sans-serif;
      color: #1e293b;
      background: #f1f5f9;
      margin: 0;
      padding: 30px 15px;
      font-size: 13px;
    }
    .invoice-wrapper {
      max-width: 820px;
      margin: 0 auto;
      background: #ffffff;
      padding: 42px 48px;
      border-radius: 14px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      position: relative;
    }

    /* Print Controls */
    .print-actions {
      display: flex;
      justify-content: flex-end;
      gap: 12px;
      margin-bottom: 24px;
    }
    .btn {
      padding: 9px 20px;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border: none;
      transition: all 0.2s ease;
    }
    .btn-print {
      background: #CC0000;
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(204, 0, 0, 0.25);
    }
    .btn-print:hover {
      background: #a30000;
      transform: translateY(-1px);
    }
    .btn-close {
      background: #e2e8f0;
      color: #334155;
    }
    .btn-close:hover {
      background: #cbd5e1;
    }

    /* Kop Surat */
    .kop-surat {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 3px double #0f172a;
      padding-bottom: 18px;
      margin-bottom: 24px;
      gap: 20px;
    }
    .kop-brand {
      display: flex;
      align-items: center;
      gap: 18px;
    }
    .kop-logo {
      height: 82px;
      width: auto;
      object-fit: contain;
      filter: drop-shadow(0 2px 6px rgba(0,0,0,0.06));
    }
    .kop-text h1 {
      margin: 0;
      font-size: 22px;
      font-weight: 800;
      color: #CC0000;
      letter-spacing: 0.5px;
      line-height: 1.15;
    }
    .kop-text .tagline {
      font-size: 11px;
      font-weight: 700;
      color: #0f172a;
      letter-spacing: 0.3px;
      margin: 4px 0 2px;
    }
    .kop-text .alamat, .kop-text .kontak {
      margin: 2px 0 0;
      font-size: 10.5px;
      color: #475569;
      line-height: 1.35;
    }
    .kop-meta {
      text-align: right;
      flex-shrink: 0;
    }
    .kop-meta .doc-badge {
      display: inline-block;
      padding: 5px 12px;
      background: {{ $cashflow->tipe === 'masuk' ? '#15803d' : '#b91c1c' }};
      color: #ffffff;
      font-size: 11px;
      font-weight: 700;
      border-radius: 6px;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }
    .kop-meta .doc-no {
      font-family: monospace;
      font-size: 12px;
      font-weight: 700;
      color: #0f172a;
      margin-top: 6px;
    }
    .kop-meta .doc-date {
      font-size: 11px;
      color: #64748b;
      margin-top: 2px;
    }

    /* Title Block */
    .invoice-header {
      text-align: center;
      margin-bottom: 28px;
      position: relative;
    }
    .invoice-header h2 {
      margin: 0 0 6px;
      font-size: 20px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #0f172a;
    }
    .invoice-header p {
      margin: 0;
      font-size: 12px;
      color: #64748b;
    }

    /* Paid Stamp */
    .stamp-paid {
      position: absolute;
      top: -10px;
      right: 20px;
      font-weight: 900;
      font-size: 13px;
      padding: 6px 16px;
      border-radius: 8px;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      transform: rotate(-7deg);
      background: rgba(255, 255, 255, 0.95);
      box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .stamp-paid.stamp-dp {
      border: 3px dashed #d97706;
      color: #b45309;
    }
    .stamp-paid.stamp-lunas {
      border: 3px dashed #16a34a;
      color: #15803d;
    }
    .stamp-paid.stamp-keluar {
      border: 3px dashed #2563eb;
      color: #1d4ed8;
    }

    /* Receipt Rows */
    .kuitansi-box {
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 24px;
      background: #fafafa;
    }
    .kuitansi-row {
      display: flex;
      border-bottom: 1px solid #e2e8f0;
      padding: 12px 18px;
      align-items: flex-start;
    }
    .kuitansi-row:last-child {
      border-bottom: none;
    }
    .kuitansi-label {
      width: 200px;
      flex-shrink: 0;
      font-weight: 600;
      color: #475569;
      font-size: 12.5px;
    }
    .kuitansi-dots {
      width: 15px;
      color: #94a3b8;
      font-weight: bold;
    }
    .kuitansi-value {
      flex: 1;
      font-size: 13px;
      color: #0f172a;
    }
    .kuitansi-value.terbilang-text {
      background: #f1f5f9;
      padding: 8px 12px;
      border-radius: 6px;
      font-style: italic;
      font-weight: 600;
      color: #1e293b;
      border-left: 3px solid #CC0000;
    }

    /* Big Amount Ribbon */
    .nominal-ribbon {
      background: #f8fafc;
      border: 2px solid #cbd5e1;
      border-radius: 10px;
      padding: 16px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 28px;
    }
    .nominal-ribbon .nominal-title {
      font-size: 12px;
      font-weight: 700;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .nominal-ribbon .nominal-amount {
      font-size: 26px;
      font-weight: 800;
      color: {{ $cashflow->tipe === 'masuk' ? '#16a34a' : '#dc2626' }};
      font-family: 'Poppins', monospace;
    }

    /* Attachment Preview */
    .lampiran-box {
      margin-bottom: 24px;
      padding: 14px 18px;
      border: 1px dashed #cbd5e1;
      border-radius: 8px;
      background: #ffffff;
      display: flex;
      align-items: center;
      gap: 14px;
    }
    .lampiran-box img {
      max-height: 70px;
      max-width: 100px;
      border-radius: 4px;
      border: 1px solid #e2e8f0;
      object-fit: cover;
    }

    /* Signature Section */
    .signature-grid {
      display: flex;
      justify-content: space-between;
      margin-top: 36px;
      padding: 0 20px;
      page-break-inside: avoid;
    }
    .sig-col {
      text-align: center;
      width: 220px;
    }
    .sig-col .sig-title {
      font-size: 12px;
      color: #475569;
      margin-bottom: 4px;
    }
    .sig-col .sig-space {
      height: 75px;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .stamp-watermark {
      position: absolute;
      width: 80px;
      height: 80px;
      border: 2px dashed rgba(204, 0, 0, 0.45);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      font-size: 8px;
      font-weight: 800;
      color: rgba(204, 0, 0, 0.6);
      transform: rotate(-12deg);
      text-transform: uppercase;
      padding: 6px;
      pointer-events: none;
    }
    .sig-col .sig-name {
      font-weight: 700;
      font-size: 13px;
      border-top: 1px solid #0f172a;
      padding-top: 6px;
      margin: 0;
      color: #0f172a;
    }
    .sig-col .sig-role {
      font-size: 11px;
      color: #64748b;
      margin-top: 2px;
    }

    /* Footer Note */
    .invoice-footer {
      margin-top: 36px;
      padding-top: 14px;
      border-top: 1px dashed #cbd5e1;
      font-size: 10.5px;
      color: #94a3b8;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    @media print {
      body {
        background: #ffffff;
        padding: 0;
      }
      .invoice-wrapper {
        box-shadow: none;
        padding: 0;
        max-width: 100%;
        border-radius: 0;
      }
      .print-actions {
        display: none !important;
      }
    }
  </style>
</head>
<body>

@php
    $logoFile = public_path('image/Logo_DI.png');
    if (!file_exists($logoFile)) {
        $logoFile = public_path('image/logo-di.png');
    }
    $logoSrc = file_exists($logoFile)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoFile))
        : asset('image/Logo_DI.png');

    $isDp = ($cashflow->status === 'dp' || (float)$cashflow->sisa_piutang > 0);
    $totalBiaya = (float) ($cashflow->total_tagihan ?: ($cashflow->nominal + (float)$cashflow->sisa_piutang));
@endphp

<div class="invoice-wrapper">

  {{-- Print & Action Controls --}}
  <div class="print-actions">
    <button class="btn btn-print" onclick="window.print()">
      <i class="fas fa-print"></i> Cetak Kuitansi / Simpan PDF
    </button>
    <button class="btn btn-close" onclick="window.close()">
      <i class="fas fa-times"></i> Tutup
    </button>
  </div>

  {{-- Kop Surat Resmi Denpasar Institute --}}
  <div class="kop-surat">
    <div class="kop-brand">
      <img src="{{ $logoSrc }}" alt="Logo Denpasar Institute" class="kop-logo">
      <div class="kop-text">
        <h1>DENPASAR INSTITUTE</h1>
        <div class="tagline">LEMBAGA RISET, VOKASI, SERTIFIKASI &amp; PENGEMBANGAN SDM</div>
        <p class="alamat">Jl. Gatot Subroto VI No. 27, Dauh Puri Kaja, Denpasar Utara, Bali &ndash; 80231</p>
        <p class="kontak">
          <span><i class="fas fa-globe"></i> www.denpasarinstitute.com</span> &bull; 
          <span><i class="fas fa-envelope"></i> info@denpasarinstitute.com</span>
        </p>
      </div>
    </div>
    <div class="kop-meta">
      @if($isDp)
        <div class="doc-badge" style="background: #b45309;">Kuitansi Pembayaran DP</div>
      @elseif($cashflow->tipe === 'masuk')
        <div class="doc-badge" style="background: #15803d;">Kuitansi Pelunasan</div>
      @else
        <div class="doc-badge" style="background: #b91c1c;">Bukti Kas Keluar</div>
      @endif
      <div class="doc-no">{{ $cashflow->kode }}</div>
      <div class="doc-date">{{ \Carbon\Carbon::parse($cashflow->tanggal)->translatedFormat('d F Y') }}</div>
    </div>
  </div>

  {{-- Header Judul Kuitansi --}}
  <div class="invoice-header">
    <h2>
      @if($cashflow->tipe === 'masuk')
        {{ $isDp ? 'KUITANSI PEMBAYARAN UANG MUKA (DP)' : 'KUITANSI RESMI PENERIMAAN KAS' }}
      @else
        BUKTI PENGELUARAN KAS (PAYMENT VOUCHER)
      @endif
    </h2>
    <p>Dokumen bukti transaksi keuangan resmi yang sah &amp; diakui oleh Denpasar Institute</p>
    @if($isDp)
      <div class="stamp-paid stamp-dp">
        <i class="fas fa-clock"></i> PEMBAYARAN DP (BELUM LUNAS)
      </div>
    @elseif($cashflow->tipe === 'masuk')
      <div class="stamp-paid stamp-lunas">
        <i class="fas fa-check-circle"></i> LUNAS / DITERIMA
      </div>
    @else
      <div class="stamp-paid stamp-keluar">
        <i class="fas fa-check-circle"></i> TERBAYARKAN
      </div>
    @endif
  </div>

  {{-- Form Kuitansi --}}
  <div class="kuitansi-box">
    
    {{-- Nomor Transaksi --}}
    <div class="kuitansi-row">
      <div class="kuitansi-label">Nomor Transaksi (Kode)</div>
      <div class="kuitansi-dots">:</div>
      <div class="kuitansi-value">
        <strong style="font-family: monospace; font-size: 14px; letter-spacing: 0.5px;">{{ $cashflow->kode }}</strong>
      </div>
    </div>

    {{-- Tanggal --}}
    <div class="kuitansi-row">
      <div class="kuitansi-label">Tanggal Transaksi</div>
      <div class="kuitansi-dots">:</div>
      <div class="kuitansi-value">
        {{ \Carbon\Carbon::parse($cashflow->tanggal)->translatedFormat('l, d F Y') }}
      </div>
    </div>

    {{-- Nama Pihak --}}
    <div class="kuitansi-row">
      <div class="kuitansi-label">
        {{ $cashflow->tipe === 'masuk' ? 'Telah Diterima Dari' : 'Dibayarkan Kepada' }}
      </div>
      <div class="kuitansi-dots">:</div>
      <div class="kuitansi-value">
        <strong style="font-size: 14px; color: #CC0000;">
          {{ $cashflow->nama_pihak ?? '-' }}
        </strong>
      </div>
    </div>

    {{-- Terbilang --}}
    <div class="kuitansi-row">
      <div class="kuitansi-label">Uang Sejumlah</div>
      <div class="kuitansi-dots">:</div>
      <div class="kuitansi-value terbilang-text">
        # {{ $terbilang }} #
      </div>
    </div>

    {{-- Judul Transaksi --}}
    @if($cashflow->judul)
    <div class="kuitansi-row">
      <div class="kuitansi-label">Peruntukan Transaksi</div>
      <div class="kuitansi-dots">:</div>
      <div class="kuitansi-value">
        <strong style="color: #0f172a; font-size: 13.5px;">{{ $cashflow->judul }}</strong>
      </div>
    </div>
    @endif

    {{-- Program Denpasar Institute --}}
    @if($cashflow->program)
    <div class="kuitansi-row">
      <div class="kuitansi-label">Program Terkait (DI)</div>
      <div class="kuitansi-dots">:</div>
      <div class="kuitansi-value">
        <strong style="color: #CC0000;"><i class="fas fa-graduation-cap"></i> {{ $cashflow->program->nama }}</strong>
        @if($cashflow->program->divisi)
          <span style="color: #64748b; font-size: 12px; margin-left: 6px;">({{ $cashflow->program->divisi->nama }})</span>
        @endif
      </div>
    </div>
    @endif

    {{-- Kategori & Jenis --}}
    <div class="kuitansi-row">
      <div class="kuitansi-label">Jenis / Kategori</div>
      <div class="kuitansi-dots">:</div>
      <div class="kuitansi-value">
        <strong>{{ $cashflow->kategori }}</strong>
        <span style="color: #64748b; font-size: 12px; margin-left: 6px;">({{ $cashflow->kode_kategori }})</span>
      </div>
    </div>

    {{-- Untuk Keperluan / Deskripsi --}}
    <div class="kuitansi-row">
      <div class="kuitansi-label">Untuk Pembayaran</div>
      <div class="kuitansi-dots">:</div>
      <div class="kuitansi-value">
        {{ $cashflow->deskripsi ?? 'Transaksi keuangan kas resmi.' }}
      </div>
    </div>

    {{-- Status Pembayaran & Rincian Piutang jika DP --}}
    @if($isDp)
    <div class="kuitansi-row" style="background: #fffdf5;">
      <div class="kuitansi-label" style="color: #92400e; font-weight: 700;">Status Pembayaran</div>
      <div class="kuitansi-dots">:</div>
      <div class="kuitansi-value">
        <span style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-weight: 700; font-size: 11.5px; padding: 3px 10px; border-radius: 6px; display: inline-flex; align-items: center; gap: 5px;">
          <i class="fas fa-clock"></i> PEMBAYARAN DP (UANG MUKA) &bull; BELUM LUNAS
        </span>
      </div>
    </div>

    <div class="kuitansi-row" style="background: #fffdf5;">
      <div class="kuitansi-label" style="color: #92400e; font-weight: 700;">Total Biaya Program</div>
      <div class="kuitansi-dots">:</div>
      <div class="kuitansi-value">
        <strong style="color: #0f172a; font-size: 14px;">Rp {{ number_format($totalBiaya, 0, ',', '.') }},-</strong>
      </div>
    </div>

    <div class="kuitansi-row" style="background: #fffdf5;">
      <div class="kuitansi-label" style="color: #92400e; font-weight: 700;">Sisa Tagihan (Piutang)</div>
      <div class="kuitansi-dots">:</div>
      <div class="kuitansi-value">
        <strong style="color: #dc2626; font-size: 14px;">Rp {{ number_format($cashflow->sisa_piutang, 0, ',', '.') }},-</strong>
        <span style="color: #b45309; font-size: 11px; margin-left: 6px; font-style: italic;">(Sisa tagihan yang harus dilunasi kemudian)</span>
      </div>
    </div>
    @else
    <div class="kuitansi-row">
      <div class="kuitansi-label">Status Pembayaran</div>
      <div class="kuitansi-dots">:</div>
      <div class="kuitansi-value">
        <span style="background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; font-weight: 700; font-size: 11.5px; padding: 3px 10px; border-radius: 6px; display: inline-flex; align-items: center; gap: 5px;">
          <i class="fas fa-check-circle"></i> LUNAS (100%)
        </span>
      </div>
    </div>
    @endif

    {{-- Metode Pembayaran --}}
    <div class="kuitansi-row">
      <div class="kuitansi-label">Metode Pembayaran</div>
      <div class="kuitansi-dots">:</div>
      <div class="kuitansi-value">
        <span style="display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
          <i class="fas fa-credit-card text-muted"></i> {{ $cashflow->metode_pembayaran }}
        </span>
      </div>
    </div>

  </div>

  {{-- Ribbon Jumlah Nominal --}}
  <div class="nominal-ribbon" style="{{ $isDp ? 'border-color: #fde68a; background: #fffdf5;' : '' }}">
    <div>
      <div class="nominal-title">{{ $isDp ? 'Jumlah Uang Muka (DP) yang Diterima' : 'Jumlah Pembayaran Bersih' }}</div>
      <small style="color: #64748b;">Mata uang resmi Rupiah (IDR)</small>
      @if($isDp)
        <div style="color: #dc2626; font-size: 12px; font-weight: 700; margin-top: 4px;">
          <i class="fas fa-exclamation-circle me-1"></i> Sisa Piutang: Rp {{ number_format($cashflow->sisa_piutang, 0, ',', '.') }},- (Belum Lunas)
        </div>
      @endif
    </div>
    <div class="nominal-amount" style="{{ $isDp ? 'color: #b45309;' : '' }}">
      Rp {{ number_format($cashflow->nominal, 0, ',', '.') }},-
    </div>
  </div>

  {{-- Lampiran Bukti Fisik jika ada --}}
  @if($cashflow->lampiran)
    @php
      $isPdf = str_ends_with(strtolower($cashflow->lampiran), '.pdf');
    @endphp
    <div class="lampiran-box">
      @if(!$isPdf)
        <img src="{{ asset($cashflow->lampiran) }}" alt="Bukti Lampiran">
      @else
        <i class="fas fa-file-pdf fa-2x text-danger"></i>
      @endif
      <div>
        <strong style="display:block; font-size: 12px;">Lampiran Bukti Transaksi Fisik / Transfer</strong>
        <small style="color: #64748b;">{{ basename($cashflow->lampiran) }}</small>
        <div style="margin-top: 4px;">
          <a href="{{ asset($cashflow->lampiran) }}" target="_blank" style="color: #CC0000; font-weight: 600; text-decoration: none; font-size: 11.5px;">
            <i class="fas fa-external-link-alt"></i> Buka Lampiran Asli
          </a>
        </div>
      </div>
    </div>
  @endif

  {{-- Area Tanda Tangan --}}
  <div class="signature-grid">
    <div class="sig-col">
      <div class="sig-title">
        {{ $cashflow->tipe === 'masuk' ? 'Penyetor / Yang Membayar' : 'Penerima Pembayaran' }}
      </div>
      <div class="sig-space"></div>
      <p class="sig-name">
        {{ $cashflow->nama_pihak ?? '( ................................... )' }}
      </p>
      <div class="sig-role">Pihak Terkait</div>
    </div>

    <div class="sig-col">
      <div class="sig-title">
        Denpasar, {{ \Carbon\Carbon::parse($cashflow->tanggal)->translatedFormat('d F Y') }}<br>
        <strong>Bagian Keuangan / Kasir</strong>
      </div>
      <div class="sig-space">
        <div class="stamp-watermark">
          Denpasar<br>Institute<br>KEUANGAN
        </div>
      </div>
      <p class="sig-name">
        {{ $cashflow->creator->name ?? auth()->user()->name ?? 'Administrator Kas' }}
      </p>
      <div class="sig-role">Petugas Otorisasi Kas</div>
    </div>
  </div>

  {{-- Catatan Kaki --}}
  <div class="invoice-footer">
    <div>
      <i class="fas fa-info-circle"></i> Kuitansi ini dicetak melalui Sistem Informasi Manajemen Kas Denpasar Institute pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} WITA.
    </div>
    <div>
      Halaman 1 / 1
    </div>
  </div>

</div>

</body>
</html>

