@extends('layouts.app')

@section('title', $konsultan->name . '|Konsultan Denpasar Institute')

@section('extra-style')
/* ===== BANNER PROFIL ===== */
.kd-banner-wrap {
    position: relative;
    width: 100%;
    height: 300px;
    background: linear-gradient(135deg, #CC0000 0%, #8a0000 50%, #1a1a1a 100%);
    overflow: hidden;
}
.kd-banner-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.55;
    display: block;
}
.kd-banner-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.65) 100%);
}
.kd-banner-pattern {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(45deg, rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(-45deg, rgba(255,255,255,0.03) 1px, transparent 1px);
    background-size: 50px 50px;
}

/* ===== FOTO + NAMA SECTION ===== */
.kd-profile-bar {
    background: #fff;
    border-bottom: 1px solid #eee;
    padding-bottom: 28px;
}
.kd-profile-bar-inner {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
.kd-photo-wrap {
    margin-top: -72px;
    position: relative;
    z-index: 2;
    margin-bottom: 16px;
}
.kd-photo {
    width: 144px;
    height: 144px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid #fff;
    box-shadow: 0 8px 28px rgba(0,0,0,0.18);
    background: #f0f0f0;
    display: block;
}
.kd-name {
    font-size: 2rem;
    font-weight: 800;
    color: #1a1a1a;
    margin: 0 0 6px;
    letter-spacing: -0.3px;
}
.kd-inst {
    font-size: 0.92rem;
    color: #CC0000;
    font-weight: 600;
    margin-bottom: 4px;
}
.kd-pos {
    font-size: 0.85rem;
    color: #777;
    margin-bottom: 16px;
}
.kd-social {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
}
.kd-social a {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 16px;
    border-radius: 20px;
    border: 1.5px solid #e0e0e0;
    font-size: 0.77rem;
    font-weight: 600;
    color: #555;
    text-decoration: none;
    transition: all 0.2s;
}
.kd-social a:hover {
    border-color: #CC0000;
    color: #CC0000;
    background: rgba(204,0,0,0.05);
}
.kd-social a i { font-size: 0.85rem; }

/* ===== KONTEN DETAIL ===== */
.kd-content {
    background: #f8f8f8;
    padding: 48px 0 72px;
}
.kd-content-inner {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 28px;
    align-items: start;
}

/* Kolom kiri — data singkat */
.kd-sidebar {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.kd-info-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #ebebeb;
    overflow: hidden;
}
.kd-info-card-header {
    background: #CC0000;
    padding: 12px 18px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.kd-info-card-header h4 {
    margin: 0;
    font-size: 0.82rem;
    font-weight: 700;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.kd-info-card-header i { color: rgba(255,255,255,0.8); font-size: 0.85rem; }
.kd-info-card-body {
    padding: 16px 18px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.kd-info-row {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.kd-info-label {
    font-size: 0.68rem;
    font-weight: 700;
    color: #aaa;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}
.kd-info-value {
    font-size: 0.85rem;
    color: #1a1a1a;
    font-weight: 500;
    line-height: 1.5;
}
.kd-info-divider {
    height: 1px;
    background: #f0f0f0;
}
.kd-badge-active {
    display: inline-block;
    background: rgba(34,197,94,0.1);
    color: #16a34a;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 3px 12px;
    border-radius: 20px;
    border: 1px solid rgba(34,197,94,0.25);
}

/* Kolom kanan — bio & detail */
.kd-main {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.kd-section-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #ebebeb;
    overflow: hidden;
}
.kd-section-header {
    padding: 14px 22px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 10px;
}
.kd-section-header h3 {
    margin: 0;
    font-size: 0.92rem;
    font-weight: 700;
    color: #1a1a1a;
}
.kd-section-header .kd-header-line {
    flex: 1;
    height: 2px;
    background: linear-gradient(to right, #CC0000, transparent);
}
.kd-section-header i {
    color: #CC0000;
    font-size: 0.88rem;
    width: 18px;
    text-align: center;
}
.kd-section-body {
    padding: 20px 22px;
}
.kd-bio-text {
    font-size: 0.88rem;
    color: #555;
    line-height: 1.9;
    margin: 0;
    text-align: justify;
}
.kd-detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.kd-detail-item {
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.kd-detail-label {
    font-size: 0.7rem;
    font-weight: 700;
    color: #aaa;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}
.kd-detail-value {
    font-size: 0.85rem;
    color: #333;
    font-weight: 500;
}

/* Motto khusus */
.kd-motto-box {
    background: linear-gradient(135deg, #fff8f8 0%, #fff3e0 100%);
    border-left: 4px solid #CC0000;
    border-radius: 0 8px 8px 0;
    padding: 16px 20px;
    margin-top: 4px;
}
.kd-motto-box p {
    margin: 0;
    font-size: 0.92rem;
    font-style: italic;
    color: #555;
    line-height: 1.7;
}
.kd-motto-box p::before { content: '"'; color: #CC0000; font-size: 1.4rem; line-height: 0.5; vertical-align: -0.3em; margin-right: 4px; }
.kd-motto-box p::after  { content: '"'; color: #CC0000; font-size: 1.4rem; line-height: 0.5; vertical-align: -0.3em; margin-left: 4px; }

/* Tidak ada data placeholder */
.kd-empty-info {
    font-size: 0.82rem;
    color: #bbb;
    font-style: italic;
}

/* ===== BREADCRUMB ===== */
.k-breadcrumb {
    background: #fff;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}
.k-breadcrumb-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.78rem;
    color: #999;
}
.k-breadcrumb-inner a { color: #CC0000; font-weight: 500; text-decoration: none; }
.k-breadcrumb-inner a:hover { text-decoration: underline; }
.k-breadcrumb-inner i { font-size: 0.6rem; }

/* ===== NAVIGASI ANTAR PROFIL ===== */
.kd-nav-row {
    max-width: 1000px;
    margin: 32px auto 0;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    gap: 12px;
}
.kd-nav-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    border: 1.5px solid #e0e0e0;
    color: #555;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 9px 20px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s;
}
.kd-nav-btn:hover {
    border-color: #CC0000;
    color: #CC0000;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .kd-banner-wrap { height: 200px; }
    .kd-photo { width: 110px; height: 110px; }
    .kd-name { font-size: 1.5rem; }
    .kd-content-inner { grid-template-columns: 1fr; }
    .kd-detail-grid { grid-template-columns: 1fr; }
}
@endsection

@section('content')

<div class="kd-banner-wrap">
    @if($konsultan->background)
        <img src="{{ asset('storage/' . $konsultan->background) }}" class="kd-banner-img" alt="Background">
    @endif
    <div class="kd-banner-pattern"></div>
    <div class="kd-banner-overlay"></div>
</div>

{{-- PROFIL BAR --}}
<div class="kd-profile-bar">
    <div class="kd-profile-bar-inner">
        {{-- Foto --}}
        <div class="kd-photo-wrap">
            @if($konsultan->foto)
                <img src="{{ asset('storage/' . $konsultan->foto) }}" class="kd-photo" alt="{{ $konsultan->name }}">
            @elseif($konsultan->avatar)
                <img src="{{ asset('storage/' . $konsultan->avatar) }}" class="kd-photo" alt="{{ $konsultan->name }}">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($konsultan->name) }}&background=CC0000&color=fff&size=300" class="kd-photo" alt="{{ $konsultan->name }}">
            @endif
        </div>

        <h1 class="kd-name">{{ $konsultan->name }}</h1>
        @if($konsultan->institution)
            <div class="kd-inst">{{ $konsultan->institution }}</div>
        @endif
        @if($konsultan->position)
            <div class="kd-pos">{{ $konsultan->position }}</div>
        @endif

        {{-- Sosial Media --}}
        @if(!empty($konsultan->instagram) || !empty($konsultan->facebook) || !empty($konsultan->youtube) || !empty($konsultan->linkedin) || !empty($konsultan->website))
            <div class="kd-social">
                @if(!empty($konsultan->instagram))
                    <a href="{{ $konsultan->instagram }}" target="_blank"><i class="fab fa-instagram"></i> Instagram</a>
                @endif
                @if(!empty($konsultan->facebook))
                    <a href="{{ $konsultan->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a>
                @endif
                @if(!empty($konsultan->youtube))
                    <a href="{{ $konsultan->youtube }}" target="_blank"><i class="fab fa-youtube"></i> YouTube</a>
                @endif
                @if(!empty($konsultan->linkedin))
                    <a href="{{ $konsultan->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
                @endif
                @if(!empty($konsultan->website))
                    <a href="{{ $konsultan->website }}" target="_blank"><i class="fas fa-globe"></i> Website</a>
                @endif
            </div>
        @endif
    </div>
</div>

{{-- KONTEN UTAMA --}}
<section class="kd-content">
    <div class="kd-content-inner">

        {{-- SIDEBAR KIRI --}}
        <div class="kd-sidebar">
            <div class="kd-info-card">
                <div class="kd-info-card-header">
                    <i class="fas fa-id-card"></i>
                    <h4>Info Keanggotaan</h4>
                </div>
                <div class="kd-info-card-body">
                    <div class="kd-info-row">
                        <span class="kd-info-label">No. Anggota</span>
                        <span class="kd-info-value">{{ $konsultan->no_anggota ?? '-' }}</span>
                    </div>
                    <div class="kd-info-divider"></div>
                    <div class="kd-info-row">
                        <span class="kd-info-label">Tipe Keanggotaan</span>
                        <span class="kd-info-value">{{ ucfirst($konsultan->membership_type ?? 'Regular') }}</span>
                    </div>
                    <div class="kd-info-divider"></div>
                    <div class="kd-info-row">
                        <span class="kd-info-label">Status</span>
                        <span class="kd-badge-active">Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN KANAN --}}
        <div class="kd-main">

            {{-- Bio / Profil --}}
            @if($konsultan->bio ?? $konsultan->deskripsi ?? $konsultan->description ?? null)
                <div class="kd-section-card">
                    <div class="kd-section-header">
                        <i class="fas fa-user"></i>
                        <h3>Profil</h3>
                        <div class="kd-header-line"></div>
                    </div>
                    <div class="kd-section-body">
                        <p class="kd-bio-text">
                            {!! nl2br(e($konsultan->bio ?? $konsultan->deskripsi ?? $konsultan->description)) !!}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Data Pribadi --}}
            <div class="kd-section-card">
                <div class="kd-section-header">
                    <i class="fas fa-info-circle"></i>
                    <h3>Data Diri</h3>
                    <div class="kd-header-line"></div>
                </div>
                <div class="kd-section-body">
                    <div class="kd-detail-grid">
                        <div class="kd-detail-item">
                            <span class="kd-detail-label">Nama Lengkap</span>
                            <span class="kd-detail-value">{{ $konsultan->name }}</span>
                        </div>
                        <div class="kd-detail-item">
                            <span class="kd-detail-label">Institusi</span>
                            <span class="kd-detail-value">{{ $konsultan->institution ?? '-' }}</span>
                        </div>
                        <div class="kd-detail-item">
                            <span class="kd-detail-label">Posisi / Jabatan</span>
                            <span class="kd-detail-value">{{ $konsultan->position ?? '-' }}</span>
                        </div>
                        @if($konsultan->tempat_lahir || $konsultan->tanggal_lahir)
                            <div class="kd-detail-item">
                                <span class="kd-detail-label">Tempat, Tanggal Lahir</span>
                                <span class="kd-detail-value">
                                    {{ $konsultan->tempat_lahir ?? '-' }},
                                    {{ $konsultan->tanggal_lahir ? \Carbon\Carbon::parse($konsultan->tanggal_lahir)->format('d M Y') : '-' }}
                                </span>
                            </div>
                        @endif
                        @if($konsultan->provinsi)
                            <div class="kd-detail-item">
                                <span class="kd-detail-label">Provinsi</span>
                                <span class="kd-detail-value">{{ $konsultan->provinsi }}</span>
                            </div>
                        @endif
                    </div>

                    @if($konsultan->motto_hidup)
                        <div style="margin-top: 20px;">
                            <span class="kd-detail-label" style="display:block;margin-bottom:8px;">Motto Hidup</span>
                            <div class="kd-motto-box">
                                <p>{{ $konsultan->motto_hidup }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <div class="kd-nav-row">
        <a href="{{ route('konsultan.index') }}" class="kd-nav-btn">
            <i class="fas fa-arrow-left"></i> Semua Konsultan
        </a>
        <a href="{{ route('home') }}#konsultan" class="kd-nav-btn">
            <i class="fas fa-home"></i> Beranda
        </a>
    </div>
</section>

@endsection