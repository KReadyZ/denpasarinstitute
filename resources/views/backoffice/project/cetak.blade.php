<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Keuangan Program Kursus {{ $project->kode }} - Denpasar Institute</title>
  <link rel="icon" type="image/png" href="{{ asset('image/Logo_DI.png') }}">
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
      max-width: 900px;
      margin: 0 auto;
      background: #ffffff;
      padding: 36px 40px;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .header-logo {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid #CC0000;
      padding-bottom: 16px;
      margin-bottom: 24px;
    }
    .logo-img {
      height: 52px;
    }
    .kpi-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 12px;
      margin-bottom: 24px;
    }
    .kpi-box {
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 12px;
      text-align: center;
      background: #f8fafc;
    }
    .kpi-box .lbl {
      font-size: 10px;
      color: #64748b;
      text-transform: uppercase;
      font-weight: 700;
    }
    .kpi-box .val {
      font-size: 14px;
      font-weight: 800;
      margin-top: 4px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 24px;
      font-size: 11.5px;
    }
    th {
      background: #f1f5f9;
      color: #334155;
      font-weight: 700;
      text-align: left;
      padding: 8px 10px;
      border-bottom: 1.5px solid #cbd5e1;
    }
    td {
      padding: 8px 10px;
      border-bottom: 1px solid #e2e8f0;
    }
    .text-end { text-align: right; }
    .text-center { text-align: center; }
    .text-success { color: #16a34a; }
    .text-danger { color: #dc2626; }
    @media print {
      body { background: #fff; padding: 0; }
      .print-container { box-shadow: none; padding: 0; }
      .no-print { display: none !important; }
    }
  </style>
</head>
<body>

<div class="print-container">
  <div class="no-print" style="margin-bottom: 20px; text-align: right;">
    <button onclick="window.print()" style="background: #CC0000; color: #fff; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer;">
      <i class="fas fa-print"></i> Cetak Laporan / PDF
    </button>
  </div>

  <div class="header-logo">
    <div>
      <img src="{{ asset('image/Logo_DI.png') }}" class="logo-img" alt="Logo DI">
      <h3 style="margin: 6px 0 0; color: #CC0000; font-size: 18px;">DENPASAR INSTITUTE</h3>
      <p style="margin: 2px 0 0; color: #64748b; font-size: 11px;">Pusat Pendidikan, Riset, Pelatihan &amp; Kemitraan Lembaga</p>
    </div>
    <div style="text-align: right;">
      <h4 style="margin: 0; font-size: 16px; color: #1e293b;">LAPORAN KEUANGAN PROGRAM KURSUS</h4>
      <div style="font-family: monospace; font-size: 13px; font-weight: bold; color: #CC0000; margin-top: 4px;">{{ $project->kode }}</div>
      <small style="color: #64748b;">Dicetak: {{ date('d/m/Y H:i') }}</small>
    </div>
  </div>

  <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; margin-bottom: 20px;">
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
      <div>
        <span style="color: #64748b; font-size: 11px;">NAMA KELAS / PROGRAM KURSUS:</span>
        <div style="font-weight: bold; font-size: 13px; color: #0f172a;">{{ $project->nama_proyek }}</div>
        <div style="color: #CC0000; font-weight: 600; font-size: 11.5px;">{{ $project->program?->nama ?? 'Program Kursus Denpasar Institute' }}</div>
      </div>
      <div>
        <span style="color: #64748b; font-size: 11px;">PESERTA / SISWA KURSUS:</span>
        <div style="font-weight: bold; font-size: 13px; color: #0f172a;">{{ $project->nama_peserta ?: '-' }}</div>
        <small style="color: #64748b;">Instruktur/PIC: {{ $project->pic ?: '-' }} • Jadwal: {{ $project->tanggal_mulai ? $project->tanggal_mulai->format('d/m/Y') : '-' }} s/d {{ $project->tanggal_selesai ? $project->tanggal_selesai->format('d/m/Y') : 'Selesai' }}</small>
      </div>
    </div>
  </div>

  {{-- 3 KPI BOX: BIAYA KURSUS, TOTAL UANG MASUK, PIUTANG (BELUM LUNAS) --}}
  <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 24px;">
    <div class="kpi-box">
      <div class="lbl">Biaya Kursus</div>
      <div class="val">Rp {{ number_format($project->nilai_proyek, 0, ',', '.') }}</div>
    </div>
    <div class="kpi-box">
      <div class="lbl">Total Uang Masuk</div>
      <div class="val text-success">Rp {{ number_format($project->pemasukan, 0, ',', '.') }}</div>
    </div>
    <div class="kpi-box">
      <div class="lbl">Piutang (Belum Lunas)</div>
      <div class="val {{ $project->sisa_tagihan > 0 ? 'text-danger' : 'text-success' }}">
        Rp {{ number_format($project->sisa_tagihan, 0, ',', '.') }}
        <div style="font-size: 10px; font-weight: normal; margin-top: 2px;">{{ $project->sisa_tagihan <= 0 ? '(Sudah Lunas)' : '(Belum Lunas)' }}</div>
      </div>
    </div>
  </div>

  <h4 style="border-bottom: 1.5px solid #e2e8f0; padding-bottom: 6px; margin-bottom: 10px; color: #0f172a;">
    Rincian Pembayaran Masuk Peserta ({{ $pemasukanList->count() }} Transaksi)
  </h4>
  <table>
    <thead>
      <tr>
        <th style="width: 30px;" class="text-center">No</th>
        <th>Tanggal</th>
        <th>Uraian / Keterangan</th>
        <th>Rincian (Vol &times; Satuan)</th>
        <th>Metode</th>
        <th class="text-end">Nominal (Rp)</th>
      </tr>
    </thead>
    <tbody>
      @forelse($pemasukanList as $idx => $in)
        <tr>
          <td class="text-center">{{ $idx + 1 }}</td>
          <td>{{ $in->tanggal ? $in->tanggal->format('d/m/Y') : '-' }}</td>
          <td><strong>{{ $in->deskripsi ?: $in->judul }}</strong><br><small style="color: #64748b;">{{ $in->kategori }}</small></td>
          <td>{{ (float)$in->volume }} {{ $in->satuan ?: 'paket' }} @ Rp {{ number_format($in->harga_satuan, 0, ',', '.') }}</td>
          <td>{{ $in->metode_pembayaran ?: 'Transfer Bank' }}</td>
          <td class="text-end text-success" style="font-weight: bold;">+ Rp {{ number_format($in->nominal, 0, ',', '.') }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center" style="color: #94a3b8; padding: 12px;">Tidak ada transaksi pembayaran masuk</td>
        </tr>
      @endforelse
    </tbody>
    <tfoot>
      <tr style="background: #f8fafc; font-weight: bold;">
        <td colspan="5" class="text-end">TOTAL PEMBAYARAN DITERIMA:</td>
        <td class="text-end text-success" style="font-size: 13px;">+ Rp {{ number_format($project->pemasukan, 0, ',', '.') }}</td>
      </tr>
    </tfoot>
  </table>

  {{-- Signatures --}}
  <div style="margin-top: 40px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 40px; text-align: center;">
    <div>
      <p style="color: #64748b; margin-bottom: 60px;">Instruktur / PIC Program Kursus,</p>
      <strong style="color: #0f172a; text-decoration: underline;">( {{ $project->pic ?: '..........................................' }} )</strong>
    </div>
    <div>
      <p style="color: #64748b; margin-bottom: 60px;">Bagian Keuangan Denpasar Institute,</p>
      <strong style="color: #0f172a; text-decoration: underline;">( I Made Laba, S.E. / Tim Keuangan )</strong>
    </div>
  </div>
</div>

</body>
</html>

