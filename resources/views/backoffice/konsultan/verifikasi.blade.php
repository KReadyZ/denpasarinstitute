@extends('backoffice.layouts.app')

@section('title', 'Verifikasi Pendaftar Konsultan')
@section('page-title', 'Verifikasi Pendaftar Konsultan')

@section('content')
<div style="margin-bottom: 20px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
    <div>
        <h2 style="font-size:1.4rem; font-weight:700; color:var(--dark); margin:0;">
            <i class="fas fa-clipboard-check" style="color:var(--red);"></i> Antrean Verifikasi Konsultan Baru
        </h2>
        <p style="color:#6b7280; font-size:0.83rem; margin:4px 0 0 0;">
            Tinjau berkas pendaftaran (Foto KTA, CV, Bukti Kontribusi) calon anggota konsultan sebelum diaktifkan.
        </p>
    </div>
    <div>
        <a href="{{ route('backoffice.konsultan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Data Konsultan
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif

@forelse($pendingKonsultans as $pendaftar)
<div class="card mb-4" style="border: 1px solid #fed7aa; box-shadow: 0 4px 14px rgba(245, 158, 11, 0.08); margin-bottom: 20px;">
    <div class="card-header" style="background: #fffbeb; border-bottom: 1px solid #fef3c7; padding: 16px 20px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="width:44px; height:44px; border-radius:50%; background:#CC0000; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1.1rem;">
                {{ strtoupper(substr($pendaftar->name, 0, 1)) }}
            </div>
            <div>
                <h4 style="margin:0; font-size:1.05rem; font-weight:700; color:#111;">{{ $pendaftar->name }}</h4>
                <small style="color:#6b7280; font-size:0.78rem;">
                    Mendaftar pada: <strong style="color:#333;">{{ $pendaftar->created_at ? $pendaftar->created_at->format('d M Y - H:i') : '-' }} WITA</strong>
                    — Role: <span class="badge" style="background:#fee2e2; color:#CC0000;">Konsultan</span>
                </small>
            </div>
        </div>
        <div>
            <span class="badge" style="background:#fef3c7; color:#92400e; font-size:0.78rem; padding:6px 12px; border:1px solid #fcd34d;">
                <i class="fas fa-clock"></i> Menunggu Verifikasi
            </span>
        </div>
    </div>

    <div class="card-body" style="padding: 20px;">
        <div style="display:grid; grid-template-columns: 280px 1fr; gap: 24px;">
            {{-- Info Data Diri --}}
            <div style="background:#fafafa; border:1px solid #f0f0f0; border-radius:8px; padding:16px;">
                <h5 style="margin:0 0 12px 0; font-size:0.88rem; font-weight:700; color:#333; border-bottom:2px solid #CC0000; padding-bottom:6px;">
                    <i class="fas fa-id-card"></i> Identitas Pendaftar
                </h5>
                <div style="font-size:0.82rem; line-height:1.7; color:#444;">
                    <div><strong>Email:</strong> {{ $pendaftar->email }}</div>
                    <div>
                        <strong>No. HP/WA:</strong> 
                        @if($pendaftar->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pendaftar->phone) }}" target="_blank" style="color:#16a34a; text-decoration:none; font-weight:600;">
                                <i class="fab fa-whatsapp"></i> {{ $pendaftar->phone }}
                            </a>
                        @else
                            -
                        @endif
                    </div>
                    <div><strong>Institusi:</strong> {{ $pendaftar->institution ?? '-' }}</div>
                    <div><strong>Jabatan:</strong> {{ $pendaftar->position ?? '-' }}</div>
                    <div>
                        <strong>Tgl Lahir:</strong> 
                        {{ $pendaftar->tanggal_lahir ? \Carbon\Carbon::parse($pendaftar->tanggal_lahir)->format('d-m-Y') : '-' }}
                    </div>
                    <div><strong>Provinsi:</strong> {{ $pendaftar->provinsi ?? '-' }}</div>
                    <div><strong>Alamat:</strong> {{ Str::limit($pendaftar->address ?? '-', 60) }}</div>
                </div>
            </div>

            {{-- Kelengkapan Berkas Dokumen --}}
            <div>
                <h5 style="margin:0 0 12px 0; font-size:0.88rem; font-weight:700; color:#333;">
                    <i class="fas fa-folder-open" style="color:#f59e0b;"></i> Dokumen Lampiran Pendaftaran:
                </h5>

                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:14px;">
                    {{-- 1. Foto KTA --}}
                    <div style="border:1px solid #e5e7eb; border-radius:8px; padding:12px; text-align:center; background:#fff;">
                        <span style="font-size:0.75rem; font-weight:700; color:#555; display:block; margin-bottom:8px;">
                            <i class="fas fa-camera"></i> Foto KTA (350x350)
                        </span>
                        @if($pendaftar->foto)
                            <img src="{{ asset('storage/' . $pendaftar->foto) }}" alt="Foto KTA" style="width:90px; height:90px; object-fit:cover; border-radius:6px; border:1px solid #ddd; margin-bottom:8px;">
                            <br>
                            <a href="{{ asset('storage/' . $pendaftar->foto) }}" target="_blank" class="btn btn-sm btn-secondary" style="font-size:0.72rem; padding:4px 8px;">
                                <i class="fas fa-search-plus"></i> Lihat Foto
                            </a>
                        @else
                            <div style="height:90px; display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:0.78rem;">
                                Tidak ada foto
                            </div>
                        @endif
                    </div>

                    {{-- 2. Dokumen CV --}}
                    <div style="border:1px solid #e5e7eb; border-radius:8px; padding:12px; text-align:center; background:#fff;">
                        <span style="font-size:0.75rem; font-weight:700; color:#555; display:block; margin-bottom:8px;">
                            <i class="fas fa-file-pdf"></i> Curriculum Vitae (CV)
                        </span>
                        @if($pendaftar->cv_path)
                            <div style="height:90px; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px;">
                                <i class="fas fa-file-alt" style="font-size:2.5rem; color:#CC0000;"></i>
                                <span style="font-size:0.7rem; color:#6b7280;">Berkas Terlampir</span>
                            </div>
                            <a href="{{ asset('storage/' . $pendaftar->cv_path) }}" target="_blank" class="btn btn-sm btn-info" style="font-size:0.72rem; padding:4px 8px;">
                                <i class="fas fa-eye"></i> Buka / Unduh CV
                            </a>
                        @else
                            <div style="height:90px; display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:0.78rem;">
                                Belum upload CV
                            </div>
                        @endif
                    </div>

                    {{-- 3. Bukti Kontribusi --}}
                    <div style="border:1px solid #e5e7eb; border-radius:8px; padding:12px; text-align:center; background:#fff;">
                        <span style="font-size:0.75rem; font-weight:700; color:#555; display:block; margin-bottom:8px;">
                            <i class="fas fa-receipt"></i> Bukti Kontribusi KTA
                        </span>
                        @if($pendaftar->bukti_kontribusi)
                            <div style="height:90px; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px;">
                                <i class="fas fa-money-check-alt" style="font-size:2.5rem; color:#16a34a;"></i>
                                <span style="font-size:0.7rem; color:#6b7280;">Struk Terlampir</span>
                            </div>
                            <a href="{{ asset('storage/' . $pendaftar->bukti_kontribusi) }}" target="_blank" class="btn btn-sm btn-success" style="font-size:0.72rem; padding:4px 8px;">
                                <i class="fas fa-search-dollar"></i> Lihat Bukti Transfer
                            </a>
                        @else
                            <div style="height:90px; display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:0.78rem;">
                                Belum upload bukti
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Action Bar --}}
                <div style="margin-top:20px; padding-top:16px; border-top:1px solid #f0f0f0; display:flex; justify-content:flex-end; align-items:center; gap:10px; flex-wrap:wrap;">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $pendaftar->id }}">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                    <a href="{{ route('backoffice.konsultan.verifikasi.show', $pendaftar->id) }}" class="btn btn-primary" style="background:#CC0000; border-color:#CC0000;">
                        <i class="fas fa-tasks"></i> Buka Checklist Verifikasi &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Reject --}}
<div class="modal fade" id="rejectModal{{ $pendaftar->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:10px;">
            <div class="modal-header" style="background:#fee2e2; border-bottom:1px solid #fecaca;">
                <h5 class="modal-title" style="font-weight:700; color:#991b1b; font-size:1rem;">
                    <i class="fas fa-exclamation-triangle"></i> Tolak Pendaftaran Konsultan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('backoffice.konsultan.reject', $pendaftar->id) }}" method="POST">
                @csrf
                <div class="modal-body" style="padding:20px;">
                    <p style="font-size:0.83rem; color:#444; margin-bottom:12px;">
                        Anda akan menolak pendaftaran atas nama <strong>{{ $pendaftar->name }}</strong> ({{ $pendaftar->email }}). Masukkan alasan penolakan:
                    </p>
                    <div class="form-group">
                        <label style="font-weight:700; font-size:0.8rem; margin-bottom:6px;">Alasan Penolakan <span style="color:red;">*</span></label>
                        <textarea name="rejection_reason" class="form-control" rows="4" placeholder="Contoh: Bukti kontribusi tidak terbaca, mohon kirim ulang struk transfer yang jelas atau CV belum lengkap..." required style="font-size:0.83rem;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #f0f0f0;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Pendaftaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@empty
<div class="card" style="text-align:center; padding:60px 20px;">
    <div class="card-body">
        <i class="fas fa-check-circle" style="font-size:3.5rem; color:#16a34a; margin-bottom:16px; display:block;"></i>
        <h3 style="color:#333; font-weight:700; margin-bottom:8px;">Tidak Ada Antrean Verifikasi</h3>
        <p style="color:#6b7280; font-size:0.88rem; max-width:500px; margin:0 auto 20px auto;">
            Semua pendaftar anggota konsultan telah diverifikasi dan diproses. Data pendaftar baru akan otomatis muncul di sini saat ada yang mendaftar melalui formulir web.
        </p>
        <a href="{{ route('backoffice.konsultan.index') }}" class="btn btn-primary">
            <i class="fas fa-user-tie"></i> Lihat Semua Data Konsultan
        </a>
    </div>
</div>
@endforelse

@if($pendingKonsultans->hasPages())
<div style="margin-top:20px;">
    {{ $pendingKonsultans->links('pagination::bootstrap-5') }}
</div>
@endif

@endsection
