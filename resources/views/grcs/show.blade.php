@extends('layouts.app')

@section('title', $member->name . ' — GRCS Club Denpasar Institute')

@section('extra-style')
/* ===== BANNER ===== */
.gd-banner-wrap {
    position: relative;
    width: 100%;
    height: 300px;
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #3a0000 100%);
    overflow: hidden;
}
.gd-banner-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.5;
    display: block;
}
.gd-banner-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.7) 100%);
}
.gd-banner-pattern {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(45deg, rgba(245,196,0,0.03) 1px, transparent 1px),
        linear-gradient(-45deg, rgba(245,196,0,0.03) 1px, transparent 1px);
    background-size: 50px 50px;
}

/* ===== PROFIL BAR (dark) ===== */
.gd-profile-bar {
    background: #1a1a1a;
    border-bottom: 1px solid #2a2a2a;
    padding-bottom: 28px;
}
.gd-profile-bar-inner {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
.gd-photo-wrap {
    margin-top: -72px;
    position: relative;
    z-index: 2;
    margin-bottom: 16px;
}
.gd-photo {
    width: 144px;
    height: 144px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid #1a1a1a;
    box-shadow: 0 8px 28px rgba(0,0,0,0.5);
    background: #333;
    display: block;
}
.gd-name {
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    margin: 0 0 6px;
    letter-spacing: -0.3px;
}
.gd-role {
    font-size: 0.92rem;
    color: #F5C400;
    font-weight: 600;
    margin-bottom: 4px;
}
.gd-inst {
    font-size: 0.85rem;
    color: #888;
    margin-bottom: 16px;
}
.gd-social {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
}
.gd-social a {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 16px;
    border-radius: 20px;
    border: 1.5px solid #3a3a3a;
    font-size: 0.77rem;
    font-weight: 600;
    color: #aaa;
    text-decoration: none;
    transition: all 0.2s;
}
.gd-social a:hover {
    border-color: #F5C400;
    color: #F5C400;
}
.gd-social a i { font-size: 0.85rem; }

/* ===== KONTEN UTAMA ===== */
.gd-content {
    background: #111;
    padding: 48px 0 72px;
}
.gd-content-inner {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 28px;
    align-items: start;
}

/* Sidebar */
.gd-sidebar {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.gd-info-card {
    background: #1e1e1e;
    border-radius: 12px;
    border: 1px solid #2a2a2a;
    overflow: hidden;
}
.gd-info-card-header {
    background: linear-gradient(135deg, #F5C400, #d4a800);
    padding: 12px 18px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.gd-info-card-header h4 {
    margin: 0;
    font-size: 0.82rem;
    font-weight: 700;
    color: #1a1a1a;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.gd-info-card-header i { color: rgba(26,26,26,0.7); font-size: 0.85rem; }
.gd-info-card-body {
    padding: 16px 18px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.gd-info-row { display: flex; flex-direction: column; gap: 2px; }
.gd-info-label {
    font-size: 0.68rem;
    font-weight: 700;
    color: #555;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}
.gd-info-value {
    font-size: 0.85rem;
    color: #ddd;
    font-weight: 500;
    line-height: 1.5;
}
.gd-info-divider { height: 1px; background: #2a2a2a; }
.gd-badge-active {
    display: inline-block;
    background: rgba(34,197,94,0.12);
    color: #4ade80;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 3px 12px;
    border-radius: 20px;
    border: 1px solid rgba(34,197,94,0.25);
}
.gd-badge-type {
    display: inline-block;
    background: rgba(245,196,0,0.12);
    color: #F5C400;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 3px 12px;
    border-radius: 20px;
    border: 1px solid rgba(245,196,0,0.3);
}

/* Main kanan */
.gd-main {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.gd-section-card {
    background: #1e1e1e;
    border-radius: 12px;
    border: 1px solid #2a2a2a;
    overflow: hidden;
}
.gd-section-header {
    padding: 14px 22px;
    border-bottom: 1px solid #2a2a2a;
    display: flex;
    align-items: center;
    gap: 10px;
}
.gd-section-header h3 {
    margin: 0;
    font-size: 0.92rem;
    font-weight: 700;
    color: #fff;
}
.gd-section-header .gd-header-line {
    flex: 1;
    height: 2px;
    background: linear-gradient(to right, #F5C400, transparent);
}
.gd-section-header i { color: #F5C400; font-size: 0.88rem; width: 18px; text-align: center; }
.gd-section-body { padding: 20px 22px; }

.gd-bio-text {
    font-size: 0.88rem;
    color: #aaa;
    line-height: 1.9;
    margin: 0;
    text-align: justify;
}
.gd-detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.gd-detail-item { display: flex; flex-direction: column; gap: 3px; }
.gd-detail-label {
    font-size: 0.7rem;
    font-weight: 700;
    color: #555;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}
.gd-detail-value {
    font-size: 0.85rem;
    color: #ccc;
    font-weight: 500;
}

.gd-motto-box {
    background: rgba(245,196,0,0.06);
    border-left: 4px solid #F5C400;
    border-radius: 0 8px 8px 0;
    padding: 16px 20px;
    margin-top: 4px;
}
.gd-motto-box p {
    margin: 0;
    font-size: 0.92rem;
    font-style: italic;
    color: #aaa;
    line-height: 1.7;
}
.gd-motto-box p::before { content: '"'; color: #F5C400; font-size: 1.4rem; line-height: 0.5; vertical-align: -0.3em; margin-right: 4px; }
.gd-motto-box p::after  { content: '"'; color: #F5C400; font-size: 1.4rem; line-height: 0.5; vertical-align: -0.3em; margin-left: 4px; }

.gd-empty-info { font-size: 0.82rem; color: #555; font-style: italic; }

/* ===== BREADCRUMB ===== */
.g-breadcrumb {
    background: #1a1a1a;
    padding: 12px 0;
    border-bottom: 1px solid #2a2a2a;
}
.g-breadcrumb-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.78rem;
    color: #666;
}
.g-breadcrumb-inner a { color: #F5C400; font-weight: 500; text-decoration: none; }
.g-breadcrumb-inner a:hover { text-decoration: underline; }
.g-breadcrumb-inner i { font-size: 0.6rem; }
.g-breadcrumb-inner span { color: #888; }

/* ===== NAVIGASI ===== */
.gd-nav-row {
    max-width: 1000px;
    margin: 32px auto 0;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    gap: 12px;
}
.gd-nav-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #1e1e1e;
    border: 1.5px solid #3a3a3a;
    color: #888;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 9px 20px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s;
}
.gd-nav-btn:hover { border-color: #F5C400; color: #F5C400; }

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .gd-banner-wrap { height: 200px; }
    .gd-photo { width: 110px; height: 110px; }
    .gd-name { font-size: 1.5rem; }
    .gd-content-inner { grid-template-columns: 1fr; }
    .gd-detail-grid { grid-template-columns: 1fr; }
}
@endsection

@section('content')

<div class="gd-banner-wrap">
    @if($member->background)
        <img src="{{ asset('storage/' . $member->background) }}" class="gd-banner-img" alt="Background">
    @endif
    <div class="gd-banner-pattern"></div>
    <div class="gd-banner-overlay"></div>
</div>

{{-- PROFIL BAR --}}
<div class="gd-profile-bar">
    <div class="gd-profile-bar-inner">
        <div class="gd-photo-wrap">
            @if($member->foto)
                <img src="{{ asset('storage/' . $member->foto) }}" class="gd-photo" alt="{{ $member->name }}">
            @elseif($member->avatar)
                <img src="{{ asset('storage/' . $member->avatar) }}" class="gd-photo" alt="{{ $member->name }}">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=F5C400&color=1a1a1a&size=300" class="gd-photo" alt="{{ $member->name }}">
            @endif
        </div>

        <h1 class="gd-name">{{ $member->name }}</h1>
        @if($member->position)
            <div class="gd-role">{{ $member->position }}</div>
        @endif
        @if($member->institution)
            <div class="gd-inst">{{ $member->institution }}</div>
        @endif

        {{-- Sosial media --}}
        @if(!empty($member->instagram) || !empty($member->facebook) || !empty($member->youtube) || !empty($member->linkedin) || !empty($member->website))
            <div class="gd-social">
                @if(!empty($member->instagram))
                    <a href="{{ $member->instagram }}" target="_blank"><i class="fab fa-instagram"></i> Instagram</a>
                @endif
                @if(!empty($member->facebook))
                    <a href="{{ $member->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a>
                @endif
                @if(!empty($member->youtube))
                    <a href="{{ $member->youtube }}" target="_blank"><i class="fab fa-youtube"></i> YouTube</a>
                @endif
                @if(!empty($member->linkedin))
                    <a href="{{ $member->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
                @endif
                @if(!empty($member->website))
                    <a href="{{ $member->website }}" target="_blank"><i class="fas fa-globe"></i> Website</a>
                @endif
            </div>
        @endif
    </div>
</div>

{{-- KONTEN --}}
<section class="gd-content">
    <div class="gd-content-inner">

        {{-- SIDEBAR --}}
        <div class="gd-sidebar">
            <div class="gd-info-card">
                <div class="gd-info-card-header">
                    <i class="fas fa-id-card"></i>
                    <h4>Info Keanggotaan</h4>
                </div>
                <div class="gd-info-card-body">
                    <div class="gd-info-row">
                        <span class="gd-info-label">No. Anggota</span>
                        <span class="gd-info-value">{{ $member->no_anggota ?? '-' }}</span>
                    </div>
                    <div class="gd-info-divider"></div>
                    <div class="gd-info-row">
                        <span class="gd-info-label">Tipe Keanggotaan</span>
                        <span class="gd-badge-type">{{ ucfirst($member->membership_type ?? 'Regular') }}</span>
                    </div>
                    <div class="gd-info-divider"></div>
                    <div class="gd-info-row">
                        <span class="gd-info-label">Status</span>
                        <span class="gd-badge-active">Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN --}}
        <div class="gd-main">

            @if($member->bio ?? $member->deskripsi ?? $member->description ?? null)
                <div class="gd-section-card">
                    <div class="gd-section-header">
                        <i class="fas fa-user"></i>
                        <h3>Profil</h3>
                        <div class="gd-header-line"></div>
                    </div>
                    <div class="gd-section-body">
                        <p class="gd-bio-text">
                            {!! nl2br(e($member->bio ?? $member->deskripsi ?? $member->description)) !!}
                        </p>
                    </div>
                </div>
            @endif

            <div class="gd-section-card">
                <div class="gd-section-header">
                    <i class="fas fa-info-circle"></i>
                    <h3>Data Diri</h3>
                    <div class="gd-header-line"></div>
                </div>
                <div class="gd-section-body">
                    <div class="gd-detail-grid">
                        <div class="gd-detail-item">
                            <span class="gd-detail-label">Nama Lengkap</span>
                            <span class="gd-detail-value">{{ $member->name }}</span>
                        </div>
                        <div class="gd-detail-item">
                            <span class="gd-detail-label">Institusi</span>
                            <span class="gd-detail-value">{{ $member->institution ?? '-' }}</span>
                        </div>
                        <div class="gd-detail-item">
                            <span class="gd-detail-label">Posisi / Divisi</span>
                            <span class="gd-detail-value">{{ $member->position ?? '-' }}</span>
                        </div>
                        @if($member->tempat_lahir || $member->tanggal_lahir)
                            <div class="gd-detail-item">
                                <span class="gd-detail-label">Tempat, Tanggal Lahir</span>
                                <span class="gd-detail-value">
                                    {{ $member->tempat_lahir ?? '-' }},
                                    {{ $member->tanggal_lahir ? \Carbon\Carbon::parse($member->tanggal_lahir)->format('d M Y') : '-' }}
                                </span>
                            </div>
                        @endif
                        @if($member->provinsi)
                            <div class="gd-detail-item">
                                <span class="gd-detail-label">Provinsi</span>
                                <span class="gd-detail-value">{{ $member->provinsi }}</span>
                            </div>
                        @endif
                    </div>

                    @if($member->motto_hidup)
                        <div style="margin-top: 20px;">
                            <span class="gd-detail-label" style="display:block;margin-bottom:8px;">Motto Hidup</span>
                            <div class="gd-motto-box">
                                <p>{{ $member->motto_hidup }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <div class="gd-nav-row">
        <a href="{{ route('grcs.index') }}" class="gd-nav-btn">
            <i class="fas fa-arrow-left"></i> Semua Anggota GRCS
        </a>
        <a href="{{ route('home') }}#grcs" class="gd-nav-btn">
            <i class="fas fa-home"></i> Beranda
        </a>
    </div>
</section>

@endsection