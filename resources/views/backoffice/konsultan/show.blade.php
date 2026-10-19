@extends('backoffice.layouts.app')

@section('title', 'Detail Anggota Konsultan')
@section('page-title', 'Detail Anggota Konsultan')

@section('content')
<style>
    .profile-custom-wrapper {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto 40px auto;
        padding: 0 15px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .profile-banner-wrap {
        position: relative;
        background: #eef3ff;
        border-radius: 16px;
        border: 2px solid #CC0000;
        overflow: visible;
        margin-bottom: 110px;
        margin-top: 30px;
        min-height: 280px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    /* --- BACKGROUND BANNER --- */
    .profile-banner {
        width: 100%;
        height: 280px;
        object-fit: cover;
        display: block;
        background: linear-gradient(135deg, #eaf2ff, #d6e6ff);
        padding: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #888;
        border-radius: 14px 14px 0 0;
    }

    /* --- TOMBOL KEMBALI & UBAH PASS --- */
    .profile-banner-actions {
        position: absolute;
        top: 18px;
        right: 20px;
        display: flex;
        gap: 12px;
        z-index: 10;
    }
    .profile-banner-actions .btn {
        background-color: #fff !important;
        border: 1px solid #ddd !important;
        color: #333 !important;
        font-weight: 600 !important;
        font-size: 0.85rem !important;
        padding: 8px 18px !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08) !important;
    }

    /* --- FOTO PROFIL --- */
    .profile-photo-wrap {
        position: absolute;
        left: 50%;
        top: 260px;
        transform: translate(-50%, -50%);
        z-index: 5;
    }
    .profile-photo {
        width: 160px;
        height: 160px;
        border-radius: 50%;
        object-fit: cover;
        background-color: #fff;
        border: 6px solid #fff;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }

    /* --- NAMA & LOGOUT --- */
    .profile-bottom-block {
        position: relative;
        padding: 0 20px 25px 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .profile-name-area {
        text-align: center;
    }
    .profile-name-area h2 {
        margin: 0;
        font-size: 2.2rem;
        font-weight: 700;
        color: #000;
        letter-spacing: 0.5px;
    }
    .profile-name-area .sub-title {
        color: #555;
        font-size: 0.95rem;
        margin-top: 4px;
    }

    /* --- LOGOUT BIRU DI KANAN BAWAH --- */
    .logout-container {
        position: absolute;
        right: 0;
        bottom: 25px;
    }
    .btn-logout {
        background-color: #0d3b66 !important;
        color: #fff !important;
        border: none !important;
        padding: 10px 28px !important;
        border-radius: 8px !important;
        font-weight: 600 !important;
    }

    /* --- KARTU DETAIL (BAWAH) --- */
    .profile-detail-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e0e0e0;
        padding: 0;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        margin-top: 20px;
        margin-bottom: 30px;
    }
    .profile-detail-header {
        padding: 18px 24px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .profile-detail-header h4 { margin: 0; font-weight: 700; font-size: 1.1rem; color: #333; }

    .profile-detail-body {
        display: flex;
        flex-wrap: wrap;
        padding: 30px 24px;
        gap: 30px;
    }
    .profile-left-col {
        display: none;
    }
    .profile-right-col {
        flex: 1;
        min-width: 250px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .profile-item { display: flex; align-items: baseline; font-size: 0.95rem; color: #222; line-height: 1.6; }
    .profile-item strong { font-weight: 700; min-width: 140px; color: #111; }

    .divider-red { margin: 20px 0 15px 0; border-bottom: 2px solid #cc0000; width: 100%; }
    .section-title-red { color: #cc0000; font-weight: 700; font-size: 1rem; margin-bottom: 8px; display: block; }

    @media (max-width: 768px) {
        .profile-banner { height: 200px; }
        .profile-banner-actions { top: 10px; right: 10px; flex-direction: column; gap: 6px; }
        .profile-photo-wrap { top: 180px; }
        .profile-photo { width: 130px; height: 130px; border-width: 5px; }
        .profile-bottom-block { flex-direction: column; align-items: center; padding-bottom: 90px; }
        .profile-name-area h2 { font-size: 1.6rem; }
        .logout-container { position: relative; right: auto; bottom: auto; margin-top: 15px; }
        .profile-item { flex-direction: column; align-items: flex-start; margin-bottom: 8px; }
        .profile-item strong { min-width: auto; margin-bottom: 3px; }
    }
</style>

<div class="profile-custom-wrapper">

   <div class="profile-banner-wrap">
        @if($konsultan->background)
            <img src="{{ asset('storage/' . $konsultan->background) }}" class="profile-banner" alt="Background">
        @else
            <div class="profile-banner">(Upload background lebar di menu Edit)</div>
        @endif

        <div class="profile-banner-actions">
            <a href="{{ route('backoffice.konsultan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('backoffice.profile.edit') }}" class="btn btn-warning">
                <i class="fas fa-key"></i> Ubah Password
            </a>
        </div>

        <div class="profile-photo-wrap">
            @if($konsultan->foto)
                <img src="{{ asset('storage/' . $konsultan->foto) }}" class="profile-photo" alt="{{ $konsultan->name }}">
            @elseif($konsultan->avatar)
                <img src="{{ asset('storage/' . $konsultan->avatar) }}" class="profile-photo" alt="{{ $konsultan->name }}">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($konsultan->name) }}&background=CC0000&color=fff&size=200" class="profile-photo">
            @endif
        </div>
    </div>

    <div class="profile-bottom-block">
        <div class="profile-name-area">
            <h2>{{ $konsultan->name }}</h2>
            @if($konsultan->no_anggota)
                <div class="sub-title">
                    No. Anggota: {{ $konsultan->no_anggota }} — {{ ucfirst($konsultan->role) }}
                </div>
            @endif
        </div>

        <div class="logout-container">
            <form method="POST" action="{{ route('backoffice.logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- 3. DETAIL PROFIL -->
    <div class="profile-detail-card">
        <div class="profile-detail-header">
            <h4><i class="fas fa-user"></i> Detail Anggota Konsultan</h4>
            <a href="{{ route('backoffice.konsultan.edit', $konsultan->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>

        <div class="profile-detail-body">
            <div class="profile-left-col"></div>

            <div class="profile-right-col">
                <div class="profile-item"><strong>No. Anggota:</strong> <span>{{ $konsultan->no_anggota ?? '-' }}</span></div>
                <div class="profile-item"><strong>Email:</strong> <span>{{ $konsultan->email }}</span></div>
                <div class="profile-item"><strong>No. HP/WA:</strong> <span>{{ $konsultan->phone ?? '-' }}</span></div>
                <div class="profile-item"><strong>Institusi:</strong> <span>{{ $konsultan->institution ?? '-' }}</span></div>
                <div class="profile-item"><strong>Posisi:</strong> <span>{{ $konsultan->position ?? '-' }}</span></div>
                <div class="profile-item"><strong>Membership:</strong> <span>{{ ucfirst($konsultan->membership_type ?? 'Regular') }}</span></div>
                <div class="profile-item">
                    <strong>Status:</strong>
                    <span style="font-weight:600; color:{{ $konsultan->is_active ? 'green' : 'red' }};">
                        {{ $konsultan->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>

                <div class="divider-red"></div>
                <span class="section-title-red">Data Pribadi</span>

                <div class="profile-item">
                    <strong>Tempat, Tanggal Lahir:</strong>
                    <span>
                        {{ $konsultan->tempat_lahir ?? '-' }},
                        {{ $konsultan->tanggal_lahir ? \Carbon\Carbon::parse($konsultan->tanggal_lahir)->format('d-m-Y') : '-' }}
                    </span>
                </div>
                <div class="profile-item"><strong>Provinsi:</strong> <span>{{ $konsultan->provinsi ?? '-' }}</span></div>
                <div class="profile-item"><strong>Motto Hidup:</strong> <span>{{ $konsultan->motto_hidup ?? '-' }}</span></div>

                <div class="divider-red"></div>
                <span class="section-title-red">Dokumen Pendaftaran & Verifikasi</span>

                <div class="profile-item">
                    <strong>Status Verifikasi:</strong>
                    @if($konsultan->verification_status === 'approved' || ($konsultan->is_active && empty($konsultan->verification_status)))
                        <span class="badge" style="background:#dcfce7; color:#166534; font-size:0.75rem;">
                            <i class="fas fa-check-circle"></i> Terverifikasi (Disetujui)
                        </span>
                    @elseif($konsultan->verification_status === 'rejected')
                        <span class="badge" style="background:#fee2e2; color:#991b1b; font-size:0.75rem;">
                            <i class="fas fa-times-circle"></i> Ditolak: {{ $konsultan->rejection_reason }}
                        </span>
                    @else
                        <span class="badge" style="background:#fef3c7; color:#92400e; font-size:0.75rem;">
                            <i class="fas fa-clock"></i> Menunggu Verifikasi
                        </span>
                        @if(Auth::user()->role === 'superadmin')
                            <a href="{{ route('backoffice.konsultan.verifikasi.show', $konsultan->id) }}" class="btn btn-sm btn-primary" style="margin-left:8px; padding:3px 10px; font-size:0.72rem;">
                                <i class="fas fa-tasks"></i> Buka Ceklist Verifikasi
                            </a>
                        @endif
                    @endif
                </div>

                <div class="profile-item">
                    <strong>Berkas CV:</strong>
                    @if($konsultan->cv_path)
                        <a href="{{ asset('storage/' . $konsultan->cv_path) }}" target="_blank" class="btn btn-sm btn-info" style="padding:3px 10px; font-size:0.75rem;">
                            <i class="fas fa-file-pdf"></i> Lihat / Unduh CV
                        </a>
                    @else
                        <span style="color:#888;">Tidak ada file CV</span>
                    @endif
                </div>

                <div class="profile-item">
                    <strong>Bukti Kontribusi:</strong>
                    @if($konsultan->bukti_kontribusi)
                        <a href="{{ asset('storage/' . $konsultan->bukti_kontribusi) }}" target="_blank" class="btn btn-sm btn-success" style="padding:3px 10px; font-size:0.75rem;">
                            <i class="fas fa-receipt"></i> Lihat Bukti Kontribusi
                        </a>
                    @else
                        <span style="color:#888;">Tidak ada bukti kontribusi</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('backoffice.partials.ecard_gd', ['user' => $konsultan])

</div>
@endsection