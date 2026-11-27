<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Arus Kas - Denpasar Institute</title>
  <link rel="icon" type="image/png" href="{{ asset('image/Logo_DI.png') }}">
  <link rel="shortcut icon" type="image/png" href="{{ asset('image/Logo_DI.png') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', Arial, sans-serif;
      color: #1e293b;
      background: #f8fafc;
      margin: 0;
      padding: 24px;
      font-size: 12px;
    }
    .print-container {
      max-width: 960px;
      margin: 0 auto;
      background: #ffffff;
      padding: 36px 40px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    .print-actions {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-bottom: 20px;
    }
    .btn {
      padding: 8px 18px;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      border: 1px solid transparent;
    }
    .btn-print {
      background: #CC0000;
      color: #ffffff;
    }
    .btn-close-win {
      background: #e2e8f0;
      color: #334155;
    }
    .kop-surat {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 3px double #0f172a;
      padding-bottom: 16px;
      margin-bottom: 24px;
      gap: 20px;
    }
    .kop-left {
      display: flex;
      align-items: center;
      gap: 18px;
    }
    .kop-logo-img {
      height: 82px;
      width: auto;
      object-fit: contain;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.06));
    }
    .kop-info h1 {
      margin: 0;
      font-size: 22px;
      font-weight: 800;
      color: #CC0000;
      letter-spacing: 0.5px;
      line-height: 1.15;
    }
    .kop-sub {
      font-size: 11px;
      font-weight: 700;
      color: #0f172a;
      letter-spacing: 0.4px;
      margin: 4px 0 2px;
    }
    .kop-alamat, .kop-kontak {
      margin: 2px 0 0;
      font-size: 10.5px;
      color: #475569;
      line-height: 1.35;
    }
    .kop-right {
      text-align: right;
      flex-shrink: 0;
    }
    .doc-badge {
      display: inline-block;
      padding: 4px 10px;
      background: #CC0000;
      color: #ffffff;
      font-size: 10px;
      font-weight: 700;
      border-radius: 4px;
      letter-spacing: 0.5px;
    }
    .doc-ref {
      font-size: 10px;
      font-family: monospace;
      color: #64748b;
      margin-top: 4px;
      font-weight: 600;
    }
    .doc-status {
      font-size: 10px;
      color: #16a34a;
      font-weight: 700;
      margin-top: 3px;
    }
    .report-title {
      text-align: center;
      margin-bottom: 20px;
    }
    .report-title h2 {
      margin: 0 0 6px;
      font-size: 16px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .report-title p {
      margin: 0;
      font-size: 11.5px;
      color: #64748b;
    }
    .stat-summary-box {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 12px;
      margin-bottom: 24px;
    }
    .stat-item {
      padding: 12px 16px;
      border-radius: 8px;
      border: 1px solid #e2e8f0;
      background: #f8fafc;
    }
    .stat-item.in {
      background: #f0fdf4;
      border-color: #bbf7d0;
    }
    .stat-item.out {
      background: #fef2f2;
      border-color: #fecaca;
    }
    .stat-item.balance {
      background: #f1f5f9;
      border-color: #cbd5e1;
    }
    .stat-item span {
      display: block;
      font-size: 11px;
      font-weight: 600;
      color: #64748b;
      margin-bottom: 4px;
      text-transform: uppercase;
    }
    .stat-item strong {
      font-size: 16px;
      font-weight: 800;
    }
    .stat-item.in strong { color: #16a34a; }
    .stat-item.out strong { color: #dc2626; }
    .stat-item.balance strong { color: #0f172a; }

    table.table-report {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }
    table.table-report th, table.table-report td {
      border: 1px solid #cbd5e1;
      padding: 8px 10px;
      font-size: 11px;
    }
    table.table-report th {
      background: #f1f5f9;
      font-weight: 700;
      text-align: left;
    }
    table.table-report tr:nth-child(even) {
      background: #fafafa;
    }
    .badge-masuk {
      color: #15803d;
      font-weight: 700;
    }
    .badge-keluar {
      color: #b91c1c;
      font-weight: 700;
    }
    .ttd-block {
      display: flex;
      justify-content: space-between;
      margin-top: 40px;
      padding: 0 40px;
      page-break-inside: avoid;
    }
    .ttd-col {
      text-align: center;
      width: 200px;
    }
    .ttd-space {
      height: 70px;
    }

    @media print {
      body {
        background: #ffffff;
        padding: 0;
      }
      .print-container {
        box-shadow: none;
        padding: 0;
        max-width: 100%;
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
@endphp

<div class="print-container">

  {{-- Action Buttons --}}
  <div class="print-actions">
    <button class="btn btn-print" onclick="window.print()">
      <i class="fas fa-print"></i> Cetak / Simpan PDF
    </button>
    <button class="btn btn-close-win" onclick="window.close()">
      <i class="fas fa-times"></i> Tutup
    </button>
  </div>

  {{-- Kop Surat Resmi Denpasar Institute --}}
  <div class="kop-surat">
    <div class="kop-left">
      <img src="{{ $logoSrc }}" alt="Logo Denpasar Institute" class="kop-logo-img">
      <div class="kop-info">
        <h1>DENPASAR INSTITUTE</h1>
        <div class="kop-sub">LEMBAGA RISET, VOKASI, SERTIFIKASI &amp; PENGEMBANGAN SDM</div>
        <p class="kop-alamat">
          Jl. Gatot Subroto VI No. 27, Dauh Puri Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali &ndash; 80231
        </p>
        <p class="kop-kontak">
          <span><i class="fas fa-globe"></i> www.denpasarinstitute.com</span> &bull; 
          <span><i class="fas fa-envelope"></i> partner@denpasarinstitute.com</span>
        </p>
      </div>
    </div>
    <div class="kop-right">
      <div class="doc-badge">DOKUMEN KEUANGAN RESMI</div>
      <div class="doc-ref">REF: DI-CASHFLOW/{{ date('Y') }}</div>
      <div class="doc-status"><i class="fas fa-check-circle"></i> TERVERIFIKASI</div>
    </div>
  </div>

  {{-- Judul Laporan --}}
  <div class="report-title">
    <h2>LAPORAN REKAPITULASI ARUS KAS (CASHFLOW)</h2>
    <p>
      Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WITA | Oleh: {{ auth()->user()->name ?? 'Administrator' }}
    </p>
  </div>

  {{-- Summary Cards --}}
  <div class="stat-summary-box">
    <div class="stat-item in">
      <span>Total Uang Masuk</span>
      <strong>+ Rp {{ number_format($totalMasuk, 0, ',', '.') }}</strong>
    </div>
    <div class="stat-item out">
      <span>Total Uang Keluar</span>
      <strong>&minus; Rp {{ number_format($totalKeluar, 0, ',', '.') }}</strong>
    </div>
    <div class="stat-item balance">
      <span>Laba Bersih</span>
      <strong>Rp {{ number_format($saldoKas, 0, ',', '.') }}</strong>
    </div>
    <div class="stat-item {{ $statusUntungRugi === 'untung' ? 'in' : ($statusUntungRugi === 'rugi' ? 'out' : 'balance') }}">
      <span>Status &amp; Laba/Rugi</span>
      <strong style="font-size: 15px;">
        @if($statusUntungRugi === 'untung')
          +{{ number_format(abs($persenUntungRugi), 1, ',', '.') }}% (UNTUNG)
        @elseif($statusUntungRugi === 'rugi')
          &minus;{{ number_format(abs($persenUntungRugi), 1, ',', '.') }}% (RUGI)
        @else
          0% (IMPAS)
        @endif
      </strong>
    </div>
  </div>

  {{-- Data Table --}}
  <table class="table-report">
    <thead>
      <tr>
        <th style="width: 30px; text-align: center;">No</th>
        <th style="width: 85px;">Tanggal</th>
        <th style="width: 110px;">Kode</th>
        <th style="width: 80px;">Tipe</th>
        <th>Kategori / Jenis Transaksi</th>
        <th>Pihak / Keterangan</th>
        <th style="text-align: right; width: 110px;">Masuk (Rp)</th>
        <th style="text-align: right; width: 110px;">Keluar (Rp)</th>
      </tr>
    </thead>
    <tbody>
      @forelse($data as $idx => $d)
        <tr>
          <td style="text-align: center;">{{ $idx + 1 }}</td>
          <td>{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}</td>
          <td style="font-family: monospace; font-weight: 600;">{{ $d->kode }}</td>
          <td>
            @if($d->tipe === 'masuk')
              <span class="badge-masuk">MASUK</span>
            @else
              <span class="badge-keluar">KELUAR</span>
            @endif
          </td>
          <td>
            <strong>{{ $d->judul ?? $d->kategori }}</strong><br>
            <small style="color:#64748b;">{{ $d->kategori }}</small>
            @if($d->program)
              <br><small style="color: #b91c1c; font-weight: 600;">[Program: {{ $d->program->nama }}]</small>
            @endif
          </td>
          <td>
            @if($d->nama_pihak)
              <strong>{{ $d->nama_pihak }}</strong><br>
            @endif
            <small style="color:#64748b;">{{ $d->deskripsi ?? '-' }}</small>
          </td>
          <td style="text-align: right; font-weight: 600; color: #16a34a;">
            {{ $d->tipe === 'masuk' ? number_format($d->nominal, 0, ',', '.') : '-' }}
          </td>
          <td style="text-align: right; font-weight: 600; color: #dc2626;">
            {{ $d->tipe === 'keluar' ? number_format($d->nominal, 0, ',', '.') : '-' }}
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="8" style="text-align: center; padding: 20px; color: #94a3b8;">
            Tidak ada data transaksi kas pada periode yang dipilih.
          </td>
        </tr>
      @endforelse
    </tbody>
    <tfoot>
      <tr style="background: #f8fafc; font-weight: 800;">
        <td colspan="6" style="text-align: right;">TOTAL:</td>
        <td style="text-align: right; color: #16a34a;">+ Rp {{ number_format($totalMasuk, 0, ',', '.') }}</td>
        <td style="text-align: right; color: #dc2626;">&minus; Rp {{ number_format($totalKeluar, 0, ',', '.') }}</td>
      </tr>
      <tr style="background: #e2e8f0; font-weight: 800;">
        <td colspan="6" style="text-align: right;">SALDO AKHIR KAS:</td>
        <td colspan="2" style="text-align: right; font-size: 13px;">
          Rp {{ number_format($saldoKas, 0, ',', '.') }}
        </td>
      </tr>
    </tfoot>
  </table>

  {{-- Tanda Tangan --}}
  <div class="ttd-block">
    <div class="ttd-col">
      <p>Mengetahui,<br><strong>Direktur Denpasar Institute</strong></p>
      <div class="ttd-space"></div>
      <p><strong>( ______________________ )</strong></p>
    </div>

    <div class="ttd-col">
      <p>Denpasar, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br><strong>Bagian Keuangan &amp; Kas</strong></p>
      <div class="ttd-space"></div>
      <p><strong>( {{ auth()->user()->name ?? 'Administrator' }} )</strong></p>
    </div>
  </div>

</div>

</body>
</html>

