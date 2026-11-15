@extends('layouts.app')

@section('title', 'Mitra & Klien | Denpasar Institute')

@push('styles')
<style>
  /* ===== HERO SECTION WITH PHOTO BACKGROUND ===== */
  .mitra-hero-section {
    background: linear-gradient(135deg, rgba(16, 16, 22, 0.90) 0%, rgba(68, 6, 6, 0.85) 50%, rgba(20, 2, 2, 0.93) 100%),
                url('{{ asset('image/partner-hero-bg.jpg') }}') center/cover no-repeat;
    color: #ffffff;
    padding: 175px 20px 110px;
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: inset 0 -30px 40px rgba(0, 0, 0, 0.35);
  }
  .mitra-hero-section::before {
    content: '';
    position: absolute;
    width: 450px;
    height: 450px;
    background: radial-gradient(circle, rgba(245, 196, 0, 0.14) 0%, transparent 70%);
    top: -100px;
    right: -80px;
    pointer-events: none;
  }
  .mitra-hero-section::after {
    content: '';
    position: absolute;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(204, 0, 0, 0.22) 0%, transparent 70%);
    bottom: -80px;
    left: -80px;
    pointer-events: none;
  }
  .mitra-hero-inner {
    max-width: 960px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
  }
  .mitra-badge-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(245, 196, 0, 0.16);
    border: 1px solid #F5C400;
    color: #F5C400;
    font-size: 0.82rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 7px 20px;
    border-radius: 30px;
    margin-bottom: 22px;
    backdrop-filter: blur(6px);
  }
  .mitra-hero-title {
    font-size: 2.8rem;
    font-weight: 900;
    line-height: 1.25;
    margin: 0 0 16px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #ffffff;
    text-shadow: 0 3px 14px rgba(0, 0, 0, 0.6);
  }
  .mitra-hero-title span {
    color: #F5C400;
  }
  .mitra-hero-tagline {
    font-size: 1.15rem;
    color: #ffd700;
    font-weight: 600;
    margin-bottom: 16px;
    letter-spacing: 0.3px;
  }
  .mitra-hero-desc {
    font-size: 0.98rem;
    line-height: 1.8;
    color: rgba(255, 255, 255, 0.92);
    max-width: 820px;
    margin: 0 auto 32px;
  }
  .mitra-hero-actions {
    display: flex;
    justify-content: center;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 40px;
  }
  .btn-mitra-primary {
    background: #F5C400;
    color: #111827;
    font-weight: 800;
    font-size: 0.95rem;
    padding: 13px 30px;
    border-radius: 30px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(245, 196, 0, 0.4);
    transition: all 0.25s ease;
    text-decoration: none;
  }
  .btn-mitra-primary:hover {
    background: #e0b000;
    transform: translateY(-2px);
    box-shadow: 0 6px 22px rgba(245, 196, 0, 0.55);
    color: #000;
  }
  .btn-mitra-outline {
    background: rgba(255, 255, 255, 0.12);
    color: #ffffff;
    font-weight: 600;
    font-size: 0.95rem;
    padding: 13px 26px;
    border-radius: 30px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: 1.5px solid rgba(255, 255, 255, 0.4);
    text-decoration: none;
    transition: all 0.25s ease;
  }
  .btn-mitra-outline:hover {
    background: #ffffff;
    color: #8B0000;
    border-color: #ffffff;
    transform: translateY(-2px);
  }

  /* Metric Counter Strip */
  .mitra-stats-strip {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    max-width: 820px;
    margin: 0 auto;
    padding: 16px 20px;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.15);
  }
  .mitra-stat-item {
    text-align: center;
  }
  .mitra-stat-num {
    font-size: 1.8rem;
    font-weight: 900;
    color: #F5C400;
    line-height: 1.1;
    margin-bottom: 4px;
  }
  .mitra-stat-label {
    font-size: 0.76rem;
    color: rgba(255, 255, 255, 0.85);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
  }

  /* Wave transition */
  .mitra-hero-wave {
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    z-index: 1;
    pointer-events: none;
  }
  .mitra-hero-wave svg {
    position: relative;
    display: block;
    width: 100%;
    height: 60px;
  }

  .mitra-section-header {
    text-align: center;
    max-width: 720px;
    margin: 0 auto 36px;
  }
  .mitra-section-tag {
    color: #CC0000;
    font-weight: 800;
    font-size: 0.82rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 8px;
    display: inline-block;
  }
  .mitra-section-title {
    font-size: 1.85rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.3;
    margin: 0 0 10px;
  }
  .mitra-section-sub {
    font-size: 0.92rem;
    color: #64748b;
    margin: 0;
    line-height: 1.6;
  }

  /* ===== MAIN MITRA & KLIEN LOGO GRID SECTION ===== */
  .mitra-content-section {
    padding: 60px 0 80px;
    background: #f8fafc;
    min-height: 500px;
  }
  .mitra-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
  }

  /* Filter toolbar */
  .mitra-toolbar {
    background: #ffffff;
    padding: 18px 24px;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    border: 1px solid #e2e8f0;
    margin-bottom: 36px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
  }
  .mitra-search-form {
    flex: 1;
    min-width: 260px;
    max-width: 420px;
    position: relative;
  }
  .mitra-search-input {
    width: 100%;
    padding: 10px 16px 10px 42px;
    border: 1.5px solid #e2e8f0;
    border-radius: 30px;
    font-size: 0.9rem;
    font-family: inherit;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
  }
  .mitra-search-input:focus {
    border-color: #cc0000;
    box-shadow: 0 0 0 3px rgba(204, 0, 0, 0.1);
  }
  .mitra-search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.95rem;
  }
  .mitra-category-pills {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    align-items: center;
  }
  .mitra-cat-pill {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.84rem;
    font-weight: 600;
    color: #475569;
    background: #f1f5f9;
    text-decoration: none;
    transition: all 0.2s;
    border: 1px solid transparent;
  }
  .mitra-cat-pill:hover {
    background: #fee2e2;
    color: #cc0000;
  }
  .mitra-cat-pill.active {
    background: #cc0000;
    color: #ffffff;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(204, 0, 0, 0.25);
  }

  /* Grid layout matching image 2 reference */
  .mitra-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 28px;
  }
  .mitra-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 24px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    text-decoration: none;
    color: inherit;
    cursor: pointer;
    transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.28s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.28s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    position: relative;
    overflow: hidden;
  }
  .mitra-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: transparent;
    transition: background 0.25s ease;
  }
  .mitra-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 30px rgba(15, 23, 42, 0.09);
    border-color: #cbd5e1;
    color: inherit;
    text-decoration: none;
  }
  .mitra-card:hover::before {
    background: #cc0000;
  }
  .mitra-card:hover .mitra-name {
    color: #cc0000;
  }
  .mitra-card:hover .mitra-link-btn {
    background: #cc0000;
    color: #ffffff;
    border-color: #cc0000;
  }
  .mitra-logo-box {
    width: 100%;
    height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
    margin-bottom: 14px;
    background: #ffffff;
    border-radius: 12px;
  }
  .mitra-logo-img {
    max-width: 90%;
    max-height: 115px;
    object-fit: contain;
    transition: transform 0.28s ease;
    user-select: none;
    -webkit-user-drag: none;
  }
  .mitra-card:hover .mitra-logo-img {
    transform: scale(1.06);
  }
  .mitra-name {
    font-size: 0.98rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1.4;
    margin: 0 0 8px;
    min-height: 46px;
    display: flex;
    align-items: center;
    justify-content: center;
    word-break: break-word;
  }
  .mitra-category-badge {
    font-size: 0.74rem;
    font-weight: 600;
    color: #64748b;
    background: #f1f5f9;
    padding: 3px 10px;
    border-radius: 12px;
    margin-bottom: 10px;
  }
  .mitra-verified-tag {
    font-size: 0.72rem;
    color: #16a34a;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    margin-bottom: 8px;
  }
  .mitra-links {
    margin-top: auto;
    display: flex;
    gap: 8px;
    justify-content: center;
    padding-top: 10px;
    border-top: 1px dashed #f1f5f9;
    width: 100%;
  }
  .mitra-link-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.78rem;
    color: #0284c7;
    text-decoration: none;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 6px;
    transition: background 0.18s, color 0.18s;
  }
  .mitra-link-btn:hover {
    background: #e0f2fe;
    color: #0369a1;
  }
  .mitra-link-gmap {
    color: #cc0000;
  }
  .mitra-link-gmap:hover {
    background: #fee2e2;
    color: #990000;
  }

  /* ===== MODERN PRESTIGE PAGINATION ===== */
  .mitra-pagination-wrapper {
    margin-top: 48px;
    display: flex;
    justify-content: center;
    width: 100%;
  }
  .custom-pagination-nav {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 16px;
    width: 100%;
    max-width: 650px;
    margin: 0 auto;
    padding: 16px 24px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
  }
  @media (min-width: 576px) {
    .custom-pagination-nav {
      flex-direction: row;
      justify-content: space-between;
    }
  }
  .pagination-info-box {
    display: inline-flex;
    align-items: center;
  }
  .pagination-info-text {
    font-size: 0.88rem;
    color: #64748b;
    font-weight: 500;
  }
  .pagination-info-text strong {
    color: #0f172a;
    font-weight: 700;
  }
  ul.pagination, .custom-pagination, .pagination {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 6px !important;
    list-style: none !important;
    list-style-type: none !important;
    padding: 0 !important;
    margin: 0 !important;
    flex-wrap: wrap !important;
  }
  .pagination li, li.page-item, .page-item {
    display: inline-block !important;
    list-style: none !important;
    list-style-type: none !important;
    margin: 0 !important;
    padding: 0 !important;
  }
  .pagination li::marker, li.page-item::marker {
    display: none !important;
    content: '' !important;
  }
  .pagination .page-link, .page-item .page-link {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    min-width: 38px !important;
    height: 38px !important;
    padding: 0 12px !important;
    border-radius: 10px !important;
    font-size: 0.9rem !important;
    font-weight: 600 !important;
    color: #334155 !important;
    background: #ffffff !important;
    border: 1.5px solid #e2e8f0 !important;
    text-decoration: none !important;
    transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1) !important;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02) !important;
    cursor: pointer !important;
    user-select: none !important;
  }
  .pagination .page-item:not(.active):not(.disabled) .page-link:hover,
  .pagination a.page-link:hover {
    background: #fef2f2 !important;
    border-color: #fca5a5 !important;
    color: #cc0000 !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 12px rgba(204, 0, 0, 0.15) !important;
  }
  .pagination .page-item.active .page-link,
  .page-item.active .page-link {
    background: linear-gradient(135deg, #cc0000 0%, #b30000 100%) !important;
    border-color: #cc0000 !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    box-shadow: 0 4px 14px rgba(204, 0, 0, 0.35) !important;
    transform: translateY(-1px) !important;
  }
  .pagination .page-item.disabled .page-link,
  .page-item.disabled .page-link {
    color: #cbd5e1 !important;
    background: #f8fafc !important;
    border-color: #f1f5f9 !important;
    cursor: not-allowed !important;
    box-shadow: none !important;
    transform: none !important;
  }
  .pagination .page-link.dots {
    border: none !important;
    background: transparent !important;
    box-shadow: none !important;
    color: #94a3b8 !important;
    cursor: default !important;
    min-width: 28px !important;
  }

  /* Empty state */
  .mitra-empty {
    text-align: center;
    padding: 70px 20px;
    background: #ffffff;
    border-radius: 16px;
    border: 1px dashed #cbd5e1;
  }
  .mitra-empty i {
    font-size: 3.5rem;
    color: #cbd5e1;
    margin-bottom: 16px;
  }

  /* Bottom CTA Banner with Photo Background */
  .mitra-bottom-cta {
    background: linear-gradient(135deg, rgba(16, 16, 22, 0.92) 0%, rgba(139, 0, 0, 0.88) 100%),
                url('{{ asset('image/partner-hero-bg.jpg') }}') center/cover no-repeat;
    border-radius: 24px;
    padding: 50px 40px;
    margin-top: 60px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 24px;
    color: #ffffff;
    box-shadow: 0 12px 36px rgba(0, 0, 0, 0.15);
    position: relative;
    overflow: hidden;
  }
  .mitra-cta-text h3 {
    font-size: 1.6rem;
    font-weight: 900;
    color: #ffffff;
    margin: 0 0 10px;
  }
  .mitra-cta-text p {
    font-size: 0.95rem;
    color: rgba(255, 255, 255, 0.88);
    margin: 0;
    max-width: 640px;
    line-height: 1.7;
  }

  /* Responsive */
  @media (max-width: 1024px) {
    .mitra-hero-section { padding: 160px 20px 90px; }
    .mitra-hero-title { font-size: 2.3rem; }
    .mitra-grid { grid-template-columns: repeat(3, 1fr); gap: 20px; }
  }
  @media (max-width: 768px) {
    .mitra-hero-section { padding: 130px 16px 80px; }
    .mitra-hero-title { font-size: 1.85rem !important; }
    .mitra-hero-tagline { font-size: 1rem; }
    .mitra-hero-desc { font-size: 0.9rem; }
    .mitra-stats-strip { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .mitra-stat-num { font-size: 1.5rem; }
    .mitra-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
    .mitra-logo-box { height: 110px; }
    .mitra-name { font-size: 0.88rem; min-height: 40px; }
    .mitra-toolbar { padding: 14px; }
    .mitra-bottom-cta { padding: 32px 20px; text-align: center; justify-content: center; }
  }
  @media (max-width: 480px) {
    .mitra-grid { grid-template-columns: 1fr; }
  }
</style>
@endpush

@section('content')

{{-- 1. Hero Section dengan Foto Background & Gradient Elegan --}}
<section class="mitra-hero-section">
  <div class="mitra-hero-inner">
    <div class="mitra-badge-tag">
      <i class="fas fa-handshake"></i>
      <span>Jejaring Kolaborasi &amp; Kemitraan Strategis</span>
    </div>

    <h1 class="mitra-hero-title">
      Mitra &amp; Klien <span>Denpasar Institute</span>
    </h1>

    <div class="mitra-hero-tagline">
      Membangun Sinergi Berkelanjutan dalam Riset, Pendidikan &amp; Transformasi SDM
    </div>

    <p class="mitra-hero-desc">
      Denpasar Institute telah menjalin kerja sama strategis dengan berbagai perguruan tinggi terkemuka, badan usaha milik negara (BUMN), korporasi industri global, dan instansi pemerintah di tingkat nasional maupun internasional untuk mendorong keunggulan riset, publikasi, sertifikasi, dan daya saing sumber daya manusia.
    </p>

    <div class="mitra-hero-actions">
      <button type="button" class="btn-mitra-primary" onclick="openPartnerModal('', 'Kemitraan Strategis Denpasar Institute')" title="Ajukan Formulir Kemitraan Baru">
        <i class="fas fa-file-signature"></i> Ajukan Kemitraan
      </button>
      <a href="{{ route('partners-and-community') }}" class="btn-mitra-outline">
        <i class="fas fa-cubes"></i> 6 Pilar Kemitraan
      </a>
      <a href="{{ route('home') }}" class="btn-mitra-outline" title="Kembali ke Beranda">
        <i class="fas fa-arrow-left"></i> Beranda
      </a>
    </div>

    {{-- Quick Metric Counter Strip --}}
    <div class="mitra-stats-strip">
      <div class="mitra-stat-item">
        <div class="mitra-stat-num">{{ $totalApproved }}+</div>
        <div class="mitra-stat-label">Mitra Terverifikasi</div>
      </div>
      <div class="mitra-stat-item">
        <div class="mitra-stat-num">100+</div>
        <div class="mitra-stat-label">Proyek &amp; Riset</div>
      </div>
      <div class="mitra-stat-item">
        <div class="mitra-stat-num">6</div>
        <div class="mitra-stat-label">Pilar Sinergi</div>
      </div>
      <div class="mitra-stat-item">
        <div class="mitra-stat-num">98%</div>
        <div class="mitra-stat-label">Rekomendasi Mitra</div>
      </div>
    </div>
  </div>

  {{-- Wave Ribbon Transition --}}
  <div class="mitra-hero-wave" aria-hidden="true">
    <svg viewBox="0 0 1440 100" fill="none" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0,45 C360,15 620,25 820,48 C1020,70 1240,78 1440,35 L1440,100 L0,100 Z" fill="#f8fafc"/>
    </svg>
  </div>
</section>



{{-- 3. Main Grid: Mitra & Klien (Sesuai Referensi Gambar ke-2) --}}
<section class="mitra-content-section">
  <div class="mitra-container">

    <div class="mitra-section-header" style="margin-bottom: 28px;">
      <span class="mitra-section-tag"><i class="fas fa-certificate"></i> Verified Partners</span>
      <h2 class="mitra-section-title">Daftar Mitra &amp; Klien Terverifikasi</h2>
      <p class="mitra-section-sub">Logo dan profil institusi yang telah resmi terdaftar dan diverifikasi dalam ekosistem kemitraan Denpasar Institute.</p>
    </div>

    {{-- Toolbar Filter & Search --}}
    <div class="mitra-toolbar">
      <form action="{{ route('mitra-dan-klien') }}" method="GET" class="mitra-search-form">
        <i class="fas fa-search mitra-search-icon"></i>
        <input type="text" name="q" value="{{ request('q') }}" class="mitra-search-input" placeholder="Cari nama institusi atau perusahaan..." autocomplete="off">
        @if(request('kategori'))
          <input type="hidden" name="kategori" value="{{ request('kategori') }}">
        @endif
      </form>

      <div class="mitra-category-pills">
        <a href="{{ route('mitra-dan-klien', array_merge(request()->except('kategori', 'page'), ['kategori' => 'all'])) }}" 
           class="mitra-cat-pill {{ (!request('kategori') || request('kategori') === 'all') ? 'active' : '' }}">
          Semua ({{ $totalApproved }})
        </a>
        @foreach($categories as $cat)
          <a href="{{ route('mitra-dan-klien', array_merge(request()->except('kategori', 'page'), ['kategori' => $cat])) }}" 
             class="mitra-cat-pill {{ request('kategori') === $cat ? 'active' : '' }}">
            {{ $cat }}
          </a>
        @endforeach
      </div>
    </div>

    {{-- Grid Mitra & Klien Cards --}}
    @if($partners->count() > 0)
      <div class="mitra-grid">
        @foreach($partners as $p)
          @php
            $targetUrl = $p->website ? (str_starts_with($p->website, 'http') ? $p->website : 'https://' . $p->website) : ($p->link_gmap ?? '#');
            $hasLink = !empty($p->website) || !empty($p->link_gmap);
          @endphp
          <a href="{{ $targetUrl }}" 
             @if($hasLink) target="_blank" rel="noopener noreferrer" @endif
             class="mitra-card" 
             title="{{ $hasLink ? 'Kunjungi Website Resmi ' . $p->institusi : $p->institusi }}">
            <div class="mitra-logo-box">
              @if($p->logo && file_exists(public_path($p->logo)))
                <img src="{{ asset($p->logo) }}" alt="Logo {{ $p->institusi }}" class="mitra-logo-img" loading="lazy"
                     onerror="this.onerror=null;this.parentElement.innerHTML='<div style=\'font-size:2rem;color:#cbd5e1;font-weight:800;\'><i class=\'fas fa-building\'></i></div>'">
              @else
                <div style="width:75px;height:75px;border-radius:50%;background:#fef2f2;color:#cc0000;display:flex;align-items:center;justify-content:center;font-size:1.8rem;font-weight:800;border:1px solid #fecaca;">
                  <i class="fas fa-building"></i>
                </div>
              @endif
            </div>

            <h3 class="mitra-name" title="{{ $p->institusi }}">
              {{ $p->institusi }}
            </h3>

            @if($p->kategori)
              <span class="mitra-category-badge">{{ $p->kategori }}</span>
            @endif

            <div class="mitra-verified-tag">
              <i class="fas fa-check-circle"></i> Mitra Resmi DI
            </div>

            @if($hasLink)
              <div class="mitra-links">
                @if($p->website)
                  <span class="mitra-link-btn">
                    <i class="fas fa-external-link-alt"></i> Kunjungi Website
                  </span>
                @elseif($p->link_gmap)
                  <span class="mitra-link-btn mitra-link-gmap">
                    <i class="fas fa-map-marker-alt"></i> Buka Lokasi
                  </span>
                @endif
              </div>
            @endif
          </a>
        @endforeach
      </div>

      {{-- Pagination jika banyak --}}
      @if($partners->hasPages())
        <div class="mitra-pagination-wrapper">
          {{ $partners->links() }}
        </div>
      @endif
    @else
      <div class="mitra-empty">
        <i class="fas fa-search"></i>
        <h4 style="font-weight:700;color:#1e293b;margin-bottom:8px;">Mitra Tidak Ditemukan</h4>
        <p style="color:#64748b;margin-bottom:20px;">
          @if(request('q') || request('kategori'))
            Tidak ditemukan mitra dengan kata kunci atau kategori yang Anda pilih.
          @else
            Belum ada mitra terverifikasi yang ditampilkan saat ini.
          @endif
        </p>
        <a href="{{ route('mitra-dan-klien') }}" class="btn-mitra-primary" style="font-size:0.86rem;padding:9px 22px;">
          <i class="fas fa-undo"></i> Tampilkan Semua Mitra
        </a>
      </div>
    @endif



  </div>
</section>

{{-- Pop-up Modal Form Kemitraan (Reusable) --}}
@include('partials.modal-form-kemitraan')

@endsection
