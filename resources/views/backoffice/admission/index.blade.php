@extends('backoffice.layouts.app')

@section('title', 'Pendaftaran Peserta Program (Admission)')
@section('page-title', 'Pendaftaran Peserta Program')

@section('content')

<div class="alert alert-info" style="margin-bottom: 20px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; background:#eff6ff; border:1px solid #bfdbfe; color:#1e40af; padding:12px 18px; border-radius:6px; font-size:0.85rem;">
  <div>
    <i class="fas fa-info-circle" style="color:#2563eb; margin-right:6px;"></i>
    <strong>Catatan:</strong> Halaman ini khusus untuk data calon peserta yang mendaftar <strong>Program Kursus/Pelatihan</strong>.
  </div>
  <div>
    Verifikasi calon konsultan baru? 
    <a href="{{ route('backoffice.konsultan.verifikasi') }}" style="color:#CC0000; font-weight:700; text-decoration:underline;">Ke Verifikasi Konsultan &rarr;</a>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3><i class="fas fa-graduation-cap"></i> Data Pendaftaran Peserta Program (Admission)</h3>
    <a href="{{ route('backoffice.admission.create') }}" class="btn btn-primary">
      <i class="fas fa-plus"></i> Tambah Peserta Program
    </a>
  </div>
  <div class="card-body table-wrap">
    <table>
      <thead>
        <tr>
          <th>Nama Peserta</th>
          <th><i class="fab fa-whatsapp text-success me-1"></i> No. WA / HP</th>
          <th>Program Pilihan</th>
          <th>Pembayaran &amp; Bukti</th>
          <th>Status &amp; Kas</th>
          <th>Tanggal Daftar</th>
          <th style="min-width: 140px; text-align: center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($admissions as $admission)
        @php
          $bukti = $admission->bukti_bayar_pendaftaran ?? $admission->bukti_bayar_program;

          // Siapkan Link WhatsApp Otomatis dengan template pesan ramah & resmi
          $rawPhone = preg_replace('/[^0-9]/', '', (string)$admission->hp_wa);
          if (str_starts_with($rawPhone, '0')) {
              $waPhone = '62' . substr($rawPhone, 1);
          } elseif (!str_starts_with($rawPhone, '62') && strlen($rawPhone) > 7) {
              $waPhone = '62' . $rawPhone;
          } else {
              $waPhone = $rawPhone;
          }

          $progList = $admission->programs->pluck('nama')->implode(', ') ?: 'Program Kursus Denpasar Institute';
          if ($admission->status === 'approved') {
              $waMsg = "Halo kak {$admission->nama_lengkap}, selamat!\n\n"
                     . "Pendaftaran Anda di *Denpasar Institute* untuk program:\n"
                     . "🎓 *{$progList}*\n\n"
                     . "telah *RESMI DISETUJUI & DIVERIFIKASI*.\n"
                     . "• Nominal: Rp " . number_format($admission->nominal_pembayaran ?? 250000, 0, ',', '.') . "\n"
                     . "• Status: Terverifikasi Disetujui\n\n"
                     . ($admission->catatan_admin ? "Catatan: {$admission->catatan_admin}\n\n" : "")
                     . "Surat konfirmasi resmi juga telah dikirimkan ke email Anda ({$admission->email}). Tim kami akan segera menginformasikan jadwal kelas & orientasi. Terima kasih!";
          } else {
              $waMsg = "Halo kak {$admission->nama_lengkap},\n\n"
                     . "Kami dari Sekretariat *Denpasar Institute* mengonfirmasi pendaftaran Anda untuk program:\n"
                     . "🎓 *{$progList}*\n\n"
                     . "Apakah ada pertanyaan seputar verifikasi data atau pembayaran pendaftaran Anda? Kami siap membantu. Terima kasih!";
          }
          $waUrl = 'https://api.whatsapp.com/send?phone=' . $waPhone . '&text=' . rawurlencode($waMsg);
        @endphp
        <tr>
          <td>
            <div style="font-weight:700; color:#1e293b; font-size:0.95rem;">{{ $admission->nama_lengkap }}</div>
            <small class="text-muted"><i class="fas fa-envelope me-1"></i>{{ $admission->email }}</small>
          </td>
          <td>
            @if($admission->hp_wa)
              <div style="font-weight:700; color:#1e293b; font-size:0.92rem; white-space:nowrap;">
                <i class="fab fa-whatsapp text-success me-1" style="font-size:1rem;"></i>{{ $admission->hp_wa }}
              </div>
              <div class="mt-1 d-flex gap-1 align-items-center">
                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="badge" style="background:#25D366; color:#fff; text-decoration:none; font-size:0.72rem; padding: 3px 8px; font-weight:600; display:inline-flex; align-items:center; gap:4px;" title="Chat WhatsApp Calon Peserta">
                  <i class="fab fa-whatsapp"></i> Chat WA
                </a>
              </div>
            @else
              <span class="text-muted">-</span>
            @endif
          </td>
          <td>
            @forelse($admission->programs as $program)
              <span class="badge badge-regular" style="display:inline-block; margin-bottom:2px;">{{ $program->nama }}</span>
            @empty
              <span class="text-muted">-</span>
            @endforelse
          </td>
          <td>
            <div style="font-weight:700; color:#16a34a; font-size:0.95rem;">
              Rp {{ number_format($admission->nominal_pembayaran ?? 250000, 0, ',', '.') }}
            </div>
            <small class="text-muted d-block" style="font-size:0.75rem;">{{ $admission->metode_pembayaran ?? 'Transfer Bank' }}</small>
            @if(($admission->status_pembayaran ?? '') === 'dp' || str_contains($admission->metode_pembayaran ?? '', 'DP'))
              <span class="badge" style="background:#fef3c7; color:#b45309; border:1px solid #fde68a; font-size:0.7rem; padding:2px 6px; margin-top:2px; display:inline-block;">
                <i class="fas fa-hand-holding-usd me-1"></i> DP / Uang Muka
              </span>
            @endif
            @if($bukti)
              <a href="{{ asset('storage/' . $bukti) }}" target="_blank" class="btn btn-sm btn-outline-primary" style="padding: 2px 8px; font-size:0.75rem; margin-top:4px; display:inline-block;" title="Lihat Bukti Transfer">
                <i class="fas fa-receipt me-1"></i> Bukti Transfer
              </a>
            @else
              <span class="text-muted d-block" style="font-size:0.75rem; margin-top:2px;">Tanpa Lampiran</span>
            @endif
          </td>
          <td>
            @if($admission->status == 'approved')
              <span class="badge badge-approved" style="background:#16a34a; color:#fff; display:inline-block; margin-bottom:4px;">
                <i class="fas fa-check-circle"></i> Terverifikasi Lunas
              </span>
              @if($admission->cashflow_id && $admission->cashflow)
                <div>
                  <a href="{{ route('backoffice.cashflow.index', ['search' => $admission->cashflow->kode]) }}" target="_blank" class="badge" style="background:#0f172a; color:#f8fafc; text-decoration:none; font-family:monospace; padding:4px 6px;" title="Lihat di Buku Kas">
                    <i class="fas fa-wallet text-warning me-1"></i> {{ $admission->cashflow->kode }}
                  </a>
                </div>
              @endif
            @elseif($admission->status == 'rejected')
              <span class="badge badge-rejected" style="background:#dc2626; color:#fff;">Ditolak</span>
            @else
              <span class="badge badge-pending" style="background:#d97706; color:#fff;">Menunggu Verifikasi</span>
            @endif
          </td>
          <td>
            <span style="font-size:0.85rem;">{{ $admission->created_at->format('d M Y') }}</span><br>
            <small class="text-muted" style="font-size:0.75rem;">{{ $admission->created_at->format('H:i') }} WITA</small>
          </td>
          <td style="text-align: center;">
            <div class="action-group" style="justify-content: center; gap: 4px;">
              {{-- Tombol Kirim Konfirmasi WhatsApp --}}
              @if($admission->hp_wa)
                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-icon" style="background:#25D366; color:#fff;" title="Kirim Konfirmasi via WhatsApp">
                  <i class="fab fa-whatsapp"></i>
                </a>
              @endif

              <a href="{{ route('backoffice.admission.edit', $admission->id) }}" class="btn btn-secondary btn-icon" title="Edit Data">
                <i class="fas fa-pen"></i>
              </a>

              @if($admission->status != 'approved')
              <button type="button" class="btn btn-success btn-icon" data-bs-toggle="modal" data-bs-target="#approveModal{{ $admission->id }}" title="Verifikasi &amp; Masukkan ke Buku Kas">
                <i class="fas fa-check"></i>
              </button>
              @endif

              @if($admission->status != 'rejected')
              <button type="button" class="btn btn-warning btn-icon" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $admission->id }}" title="Tolak">
                <i class="fas fa-ban"></i>
              </button>
              @endif

              <form action="{{ route('backoffice.admission.destroy', $admission->id) }}" method="POST" onsubmit="return confirmDelete(event, this, 'Hapus pendaftaran ini beserta riwayat kas terkait?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-icon" title="Hapus">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>

        {{-- Modal Approve & Sync Cashflow --}}
        <div class="modal fade" id="approveModal{{ $admission->id }}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
              <form action="{{ route('backoffice.admission.approve', $admission->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header border-bottom py-3" style="background:#f8fafc;">
                  <h5 class="modal-title fs-6 fw-bold text-dark">
                    <i class="fas fa-check-circle text-success me-2"></i> Verifikasi Pembayaran &amp; Catat Kas
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-start">
                  
                  {{-- Info Ringkas Pendaftar --}}
                  <div class="p-3 bg-light rounded-3 border mb-3">
                    <div class="fw-bold text-dark fs-6">{{ $admission->nama_lengkap }}</div>
                    <div class="small text-muted mb-1">{{ $admission->hp_wa }} &bull; {{ $admission->email }}</div>
                    <div class="small">
                      <strong>Program:</strong>
                      {{ $admission->programs->pluck('nama')->implode(', ') ?: '-' }}
                    </div>

                    @if($admission->deskripsi_pembayaran)
                      <div class="small mt-2 pt-2 border-top">
                        <strong class="text-danger"><i class="fas fa-file-invoice-dollar me-1"></i> Rincian / Deskripsi Pembayaran:</strong>
                        <div class="p-2 mt-1 rounded-2 bg-white border text-dark" style="font-size: 0.82rem;">
                          {!! $admission->deskripsi_pembayaran !!}
                        </div>
                      </div>
                    @endif
                  </div>

                  {{-- Preview Bukti Bayar jika ada --}}
                  @if($bukti)
                    <div class="mb-3 p-2 border rounded-3 text-center" style="background:#fdfdfd;">
                      <span class="d-block small fw-bold text-muted mb-2">Lampiran Bukti Transfer Calon Siswa:</span>
                      <a href="{{ asset('storage/' . $bukti) }}" target="_blank" class="d-inline-block">
                        <img src="{{ asset('storage/' . $bukti) }}" alt="Bukti Transfer" style="max-height:120px; max-width:100%; object-fit:contain; border-radius:4px; border:1px solid #e2e8f0;">
                      </a>
                      <div class="mt-1">
                        <a href="{{ asset('storage/' . $bukti) }}" target="_blank" class="small text-decoration-none text-primary fw-semibold">
                          <i class="fas fa-external-link-alt"></i> Buka Gambar Penuh
                        </a>
                      </div>
                    </div>
                  @endif

                  {{-- Input Nominal Diterima --}}
                  <div class="mb-3">
                    <label class="form-label fw-bold text-dark small mb-1">
                      <span class="text-danger">*</span> Nominal Pembayaran Diterima (Rp):
                    </label>
                    <div class="input-group">
                      <span class="input-group-text bg-white fw-bold">Rp</span>
                      <input type="text" name="nominal_pembayaran" 
                             value="{{ number_format($admission->nominal_pembayaran ?? 250000, 0, ',', '.') }}" 
                             class="form-control fw-bold fs-6" required 
                             oninput="let v = this.value.replace(/[^0-9]/g, ''); if(v) this.value = new Intl.NumberFormat('id-ID').format(v);">
                    </div>
                    <small class="text-muted" style="font-size:0.75rem;">Titik otomatis terformat saat mengetik.</small>
                  </div>

                  {{-- Input Metode Pembayaran --}}
                  <div class="mb-3">
                    <label class="form-label fw-bold text-dark small mb-1">Metode Pembayaran:</label>
                    <select name="metode_pembayaran" class="form-select form-select-sm">
                      <optgroup label="-- Pelunasan Penuh --">
                        <option value="Transfer Bank (BCA / Mandiri / BNI / BRI)" {{ ($admission->metode_pembayaran ?? '') === 'Transfer Bank (BCA / Mandiri / BNI / BRI)' ? 'selected' : '' }}>Transfer Bank (BCA / Mandiri / BNI / BRI)</option>
                        <option value="QRIS / E-Wallet" {{ ($admission->metode_pembayaran ?? '') === 'QRIS / E-Wallet' ? 'selected' : '' }}>QRIS / E-Wallet</option>
                        <option value="Tunai (Cash)" {{ ($admission->metode_pembayaran ?? '') === 'Tunai (Cash)' ? 'selected' : '' }}>Tunai di Kampus</option>
                      </optgroup>
                      <optgroup label="-- Pembayaran DP / Uang Muka --">
                        <option value="DP (Uang Muka) - Transfer Bank" {{ ($admission->metode_pembayaran ?? '') === 'DP (Uang Muka) - Transfer Bank' ? 'selected' : '' }}>DP (Uang Muka) - Transfer Bank</option>
                        <option value="DP (Uang Muka) - QRIS / E-Wallet" {{ ($admission->metode_pembayaran ?? '') === 'DP (Uang Muka) - QRIS / E-Wallet' ? 'selected' : '' }}>DP (Uang Muka) - QRIS / E-Wallet</option>
                        <option value="DP (Uang Muka) - Tunai di Kampus" {{ ($admission->metode_pembayaran ?? '') === 'DP (Uang Muka) - Tunai di Kampus' ? 'selected' : '' }}>DP (Uang Muka) - Tunai di Kampus</option>
                      </optgroup>
                    </select>
                  </div>

                  {{-- Checkbox Otomatis Kas --}}
                  <div class="form-check p-3 bg-success-subtle rounded-3 border border-success-subtle mb-3">
                    <input class="form-check-input" type="checkbox" name="sync_cashflow" value="1" id="syncCash{{ $admission->id }}" checked>
                    <label class="form-check-label fw-bold text-success small" for="syncCash{{ $admission->id }}">
                      <i class="fas fa-wallet me-1"></i> Otomatis catat sebagai Uang Masuk di Buku Kas
                    </label>
                  </div>

                  {{-- Catatan untuk Peserta & Notifikasi Email --}}
                  <div class="mb-3">
                    <label class="form-label small text-muted mb-1">Catatan untuk peserta (otomatis disertakan dalam email konfirmasi):</label>
                    <textarea name="catatan_admin" rows="2" class="form-control form-control-sm" placeholder="Contoh: Pembayaran pendaftaran telah kami verifikasi. Selamat bergabung di Denpasar Institute.">{{ $admission->catatan_admin }}</textarea>
                  </div>

                  <div class="alert alert-info py-2 px-3 small mb-0 d-flex align-items-center gap-2" style="font-size:0.78rem; background:#eff6ff; border-color:#bfdbfe; color:#1e40af;">
                    <i class="fas fa-paper-plane text-primary"></i>
                    <div>
                      Saat disetujui, sistem akan <strong>otomatis mengirim email konfirmasi</strong> ke <code>{{ $admission->email }}</code>. Anda juga dapat mengirim pesan instan via tombol WhatsApp.
                    </div>
                  </div>

                </div>
                <div class="modal-footer border-top py-2">
                  <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-sm btn-success fw-bold px-3">
                    <i class="fas fa-check-circle me-1"></i> Setujui &amp; Catat Kas Masuk
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="modal fade" id="rejectModal{{ $admission->id }}" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="{{ route('backoffice.admission.reject', $admission->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                  <h5 class="modal-title">Tolak Pendaftaran</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Alasan penolakan (opsional)</label>
                    <textarea name="catatan_admin" rows="4">{{ $admission->catatan_admin }}</textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-warning">Tolak</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        @empty
        <tr>
          <td colspan="7">
            <div class="empty-state">
              <i class="fas fa-inbox"></i>
              <h3>Belum ada data</h3>
              <p>Data pendaftaran akan muncul di sini.</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>

    <div class="pagination-info">
      {{ $admissions->links() }}
    </div>
  </div>
</div>

@endsection