@extends('layouts.app')

@section('title', 'Partnership, Community & Global Engagement | Denpasar Institute')

@push('styles')
<style>
  .partner-page-hero {
    background: linear-gradient(135deg, rgba(16, 16, 22, 0.88) 0%, rgba(58, 6, 6, 0.84) 50%, rgba(20, 2, 2, 0.92) 100%),
                url('{{ asset('image/partner-hero-bg.jpg') }}') center/cover no-repeat;
    color: #ffffff;
    padding: 175px 20px 115px;
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: inset 0 -30px 40px rgba(0, 0, 0, 0.35);
  }
  .partner-page-hero::before {
    content: '';
    position: absolute;
    width: 450px;
    height: 450px;
    background: radial-gradient(circle, rgba(245, 196, 0, 0.12) 0%, transparent 70%);
    top: -120px;
    right: -80px;
    pointer-events: none;
  }
  .partner-page-hero::after {
    content: '';
    position: absolute;
    width: 350px;
    height: 350px;
    background: radial-gradient(circle, rgba(204, 0, 0, 0.2) 0%, transparent 70%);
    bottom: -80px;
    left: -80px;
    pointer-events: none;
  }
  .partner-hero-inner {
    max-width: 920px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
  }
  .partner-badge-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(245, 196, 0, 0.16);
    border: 1px solid var(--yellow);
    color: var(--yellow);
    font-size: 0.82rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 6px 18px;
    border-radius: 20px;
    margin-bottom: 22px;
    backdrop-filter: blur(4px);
  }
  .partner-hero-title {
    font-size: 2.6rem;
    font-weight: 900;
    line-height: 1.25;
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-shadow: 0 3px 14px rgba(0, 0, 0, 0.6);
  }
  .partner-hero-title span {
    color: var(--yellow);
  }
  .partner-hero-tagline {
    font-size: 1.22rem;
    font-weight: 600;
    color: #ffd84d;
    letter-spacing: 0.3px;
    margin-bottom: 20px;
    display: inline-block;
    font-style: italic;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
  }
  .partner-hero-desc {
    font-size: 1.05rem;
    line-height: 1.85;
    color: rgba(255, 255, 255, 0.92);
    margin: 0 auto;
    max-width: 860px;
    font-weight: 400;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.45);
  }

  /* Wave Divider */
  .partner-hero-wave {
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    z-index: 3;
    pointer-events: none;
  }
  .partner-hero-wave svg {
    position: relative;
    display: block;
    width: 100%;
    height: 70px;
  }

  /* Content Section - Denpasar Institute Merah Putih */
  .partner-content-section {
    padding: 55px 20px 105px;
    background: #ffffff;
    position: relative;
    background-image: 
      radial-gradient(rgba(204, 0, 0, 0.05) 1.5px, transparent 1.5px),
      radial-gradient(circle at 10% 20%, rgba(204, 0, 0, 0.03) 0%, transparent 40%),
      radial-gradient(circle at 90% 80%, rgba(245, 196, 0, 0.04) 0%, transparent 45%);
    background-size: 28px 28px, 100% 100%, 100% 100%;
    min-height: 500px;
    overflow: hidden;
  }
  .partner-container {
    max-width: 1240px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
  }

  /* 6 Pillars Grid */
  .partner-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 36px 30px;
    margin-bottom: 60px;
  }

  .partner-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    border: 1.5px solid #fee2e2;
    border-top: 5px solid var(--red);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    transition: transform 0.32s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.32s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.32s ease;
    position: relative;
  }
  .partner-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 42px rgba(204, 0, 0, 0.14);
    border-color: rgba(204, 0, 0, 0.4);
  }

  .partner-card-media {
    position: relative;
    overflow: hidden;
    aspect-ratio: 16 / 10;
    background: #f1f5f9;
  }
  .partner-card-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .partner-card:hover .partner-card-media img {
    transform: scale(1.07);
  }

  /* Tag Merah Putih Khas DI */
  .partner-card-tag {
    position: absolute;
    top: 0;
    left: 0;
    background: linear-gradient(135deg, #CC0000 0%, #990000 100%);
    color: #ffffff;
    padding: 8px 18px;
    font-weight: 800;
    font-size: 0.92rem;
    letter-spacing: -0.2px;
    z-index: 2;
    border-bottom-right-radius: 14px;
    box-shadow: 0 4px 14px rgba(204, 0, 0, 0.4);
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }
  .partner-card-tag i {
    color: var(--yellow);
    font-size: 0.88rem;
  }

  .partner-card-body {
    padding: 24px 24px 26px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    background: #ffffff;
  }
  .partner-card-header-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
  }
  .partner-card-num {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: rgba(204, 0, 0, 0.08);
    color: var(--red);
    font-size: 0.88rem;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .partner-card-title {
    font-size: 1.22rem;
    font-weight: 800;
    color: #1a1a1a;
    margin: 0;
    line-height: 1.3;
    transition: color 0.2s ease;
  }
  .partner-card:hover .partner-card-title {
    color: var(--red);
  }

  .partner-card-desc {
    font-size: 0.95rem;
    color: #475569;
    line-height: 1.75;
    margin-bottom: 24px;
    flex-grow: 1;
  }

  /* Tombol Learn More Merah Putih */
  .partner-btn-learn {
    display: inline-flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 10px 18px;
    border-radius: 8px;
    background: #fff5f5;
    color: var(--red);
    border: 1.5px solid rgba(204, 0, 0, 0.22);
    font-weight: 700;
    font-size: 0.92rem;
    text-decoration: none !important;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    margin-top: auto;
    font-family: 'Poppins', sans-serif;
  }
  .partner-btn-learn .btn-arrow-circle {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: rgba(204, 0, 0, 0.12);
    color: var(--red);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.78rem;
    transition: all 0.25s ease;
  }
  .partner-card:hover .partner-btn-learn {
    background: var(--red);
    color: #ffffff !important;
    border-color: var(--red);
    box-shadow: 0 6px 18px rgba(204, 0, 0, 0.32);
  }
  .partner-card:hover .partner-btn-learn .btn-arrow-circle {
    background: #ffffff;
    color: var(--red);
    transform: translateX(3px);
  }

  /* Bottom Callout Merah Putih */
  .partner-bottom-cta {
    background: linear-gradient(135deg, #CC0000 0%, #990000 50%, #750000 100%);
    border-radius: 18px;
    padding: 44px 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 28px;
    box-shadow: 0 16px 44px rgba(204, 0, 0, 0.25);
    margin-top: 25px;
    position: relative;
    overflow: hidden;
    color: #ffffff;
  }
  .partner-bottom-cta::before {
    content: '';
    position: absolute;
    width: 320px;
    height: 320px;
    background: radial-gradient(circle, rgba(245, 196, 0, 0.22) 0%, transparent 70%);
    top: -100px;
    right: -80px;
    pointer-events: none;
  }
  .partner-cta-info {
    position: relative;
    z-index: 2;
  }
  .partner-cta-info h3 {
    font-size: 1.6rem;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 8px;
  }
  .partner-cta-info p {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.92);
    margin: 0;
    line-height: 1.65;
  }
  .partner-cta-btns {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-shrink: 0;
    flex-wrap: wrap;
    position: relative;
    z-index: 2;
  }

  .btn-partner-cta-wa {
    background: var(--yellow) !important;
    color: #1a1a1a !important;
    padding: 13px 28px;
    border-radius: 8px;
    font-size: 0.94rem;
    font-weight: 800;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 9px;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
    font-family: 'Poppins', sans-serif;
    white-space: nowrap;
    border: none;
  }
  .btn-partner-cta-wa:hover {
    background: #ffcf10 !important;
    color: #1a1a1a !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
  }
  .btn-partner-cta-back {
    background: rgba(255, 255, 255, 0.15) !important;
    color: #ffffff !important;
    border: 1.5px solid rgba(255, 255, 255, 0.8) !important;
    padding: 13px 26px;
    border-radius: 8px;
    font-size: 0.94rem;
    font-weight: 700;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
    font-family: 'Poppins', sans-serif;
    white-space: nowrap;
  }
  .btn-partner-cta-back:hover {
    background: #ffffff !important;
    color: var(--red) !important;
    border-color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
  }

  @media (max-width: 1024px) and (min-width: 769px) {
    .partner-page-hero { padding: 130px 20px 95px; }
    .partner-hero-title { font-size: 2.15rem; }
    .partner-hero-tagline { font-size: 1.1rem; }
    .partner-hero-wave svg { height: 55px; }
    .partner-grid { grid-template-columns: repeat(2, 1fr); gap: 26px; }
    .partner-bottom-cta { flex-direction: column; text-align: center; }
    .partner-cta-btns { width: 100%; justify-content: center; }
  }

  @media (max-width: 768px) {
    .partner-page-hero { padding: 55px 16px 80px; }
    .partner-hero-title { font-size: 1.7rem !important; line-height: 1.3; }
    .partner-hero-tagline { font-size: 0.98rem; margin-bottom: 16px; }
    .partner-hero-desc { font-size: 0.92rem; line-height: 1.7; text-align: left; }
    .partner-hero-wave svg { height: 42px; }
    .partner-content-section { padding: 40px 16px 70px; }
    .partner-grid { grid-template-columns: 1fr; gap: 28px; }
    .partner-card-tag { font-size: 0.84rem; padding: 6px 14px; }
    .partner-bottom-cta { flex-direction: column; text-align: center; padding: 32px 20px; }
    .partner-cta-info h3 { font-size: 1.35rem; }
    .partner-cta-info p { font-size: 0.92rem; }
    .partner-cta-btns { width: 100%; justify-content: center; }
    .btn-partner-cta-wa, .btn-partner-cta-back { width: 100%; justify-content: center; }
  }
</style>
@endpush

@section('content')
<div class="partner-page-hero">
  <div class="partner-hero-inner">
    <div class="partner-badge-tag">
      <i class="fas fa-handshake"></i> Partners &amp; Collaboration
    </div>
    <h1 class="partner-hero-title">{{ \App\Models\SiteSetting::get('partner_hero_title', 'Partnership, Community & Global Engagement') }}</h1>
    <div class="partner-hero-tagline">
      {{ \App\Models\SiteSetting::get('partner_hero_tagline', 'Connecting Knowledge, Research, Industry, and Communities.') }}
    </div>
    <div class="partner-hero-desc">
      {!! \App\Models\SiteSetting::get('partner_hero_desc', 'Partnership, Community & Global Engagement merupakan wadah pengembangan kerja sama dan kolaborasi Denpasar Institute dengan berbagai institusi pendidikan, pemerintah, dunia usaha, industri, dan komunitas di tingkat nasional maupun internasional. Melalui kemitraan strategis, kami mendorong pertukaran pengetahuan, pengembangan riset, inovasi, dan peningkatan kualitas sumber daya manusia.') !!}
    </div>
  </div>

  <div class="partner-hero-wave" aria-hidden="true">
    <svg viewBox="0 0 1440 110" fill="none" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <!-- Golden Shimmer Gradient -->
        <linearGradient id="goldBeam" x1="0%" y1="0%" x2="100%" y2="0%">
          <stop offset="0%" stop-color="#CC0000" stop-opacity="0.2"/>
          <stop offset="25%" stop-color="#F5C400" stop-opacity="0.9"/>
          <stop offset="50%" stop-color="#FFF3B0" stop-opacity="1"/>
          <stop offset="75%" stop-color="#F5C400" stop-opacity="0.9"/>
          <stop offset="100%" stop-color="#CC0000" stop-opacity="0.2"/>
        </linearGradient>
        <!-- Soft Neon Glow -->
        <filter id="goldGlow" x="-10%" y="-40%" width="120%" height="200%">
          <feGaussianBlur stdDeviation="3" result="blur"/>
          <feComposite in="SourceGraphic" in2="blur" operator="over"/>
        </filter>
      </defs>

      <!-- Layer 1: Ambient Crimson Ribbon (Soft Depth) -->
      <path d="M0,45 C340,12 560,24 760,46 C960,68 1180,78 1440,32 L1440,110 L0,110 Z" fill="rgba(204, 0, 0, 0.28)"/>

      <!-- Layer 2: Main Silk Wave (Solid Clean Transition to #ffffff) -->
      <path d="M0,62 C340,26 560,36 760,58 C960,78 1180,88 1440,44 L1440,110 L0,110 Z" fill="#ffffff"/>

      <!-- Layer 3: Glowing Gold Crest Ribbon -->
      <path d="M0,62 C340,26 560,36 760,58 C960,78 1180,88 1440,44" 
            stroke="url(#goldBeam)" stroke-width="2.5" stroke-linecap="round" fill="none" filter="url(#goldGlow)"/>
    </svg>
  </div>
</div>

<div class="partner-content-section">
  <div class="partner-container">

    {{-- 6 Pillar Cards Grid --}}
    <div class="partner-grid">
      @php
        $pillars = \App\Models\PartnershipPillar::active()->get();
      @endphp
      @forelse($pillars as $p)
        <article class="partner-card">
          <div class="partner-card-media">
            <img src="{{ asset($p->image) }}" alt="{{ $p->title }}" loading="lazy">
            <div class="partner-card-tag">
              <i class="fas {{ $p->icon ?? 'fa-handshake' }}"></i> {{ $p->tag }}
            </div>
          </div>
          <div class="partner-card-body">
            <div class="partner-card-header-row">
              <span class="partner-card-num">{{ $p->number }}</span>
              <h3 class="partner-card-title">{{ $p->title }}</h3>
            </div>
            <div class="partner-card-desc">
              {!! $p->description !!}
            </div>
            <a href="{{ $p->link_url ?? '#' }}" class="partner-btn-learn" {{ (str_starts_with($p->link_url ?? '', 'http') || str_starts_with($p->link_url ?? '', '//')) ? 'target="_blank" rel="noopener noreferrer"' : '' }}>
              <span>{{ $p->link_text ?? 'Learn more' }}</span>
              <span class="btn-arrow-circle"><i class="fas fa-arrow-right"></i></span>
            </a>
          </div>
        </article>
      @empty
        <div class="col-12 text-center text-muted py-5">Belum ada pilar kemitraan.</div>
      @endforelse
    </div>

    {{-- Bottom Action Box (Merah Putih Signature DI) --}}
    <div class="partner-bottom-cta">
      <div class="partner-cta-info">
        <h3>{{ \App\Models\SiteSetting::get('partner_cta_title', 'Siap Berkolaborasi Bersama Denpasar Institute?') }}</h3>
        <div>{!! \App\Models\SiteSetting::get('partner_cta_desc', 'Diskusikan peluang kemitraan strategis, riset bersama, pelatihan institusi, maupun kolaborasi global bersama tim kami.') !!}</div>
      </div>
      <div class="partner-cta-btns">
        @php
          $partnerWa = \App\Models\SiteSetting::get('partner_cta_wa_phone', '6282144814593');
          $partnerWaClean = preg_replace('/[^0-9]/', '', $partnerWa);
        @endphp
        <a href="https://wa.me/{{ $partnerWaClean }}?text=Halo%20Denpasar%20Institute,%20saya%20tertarik%20untuk%20berkolaborasi%20dan%20menjadi%20partner." target="_blank" rel="noopener noreferrer" class="btn-partner-cta-wa">
          <i class="fab fa-whatsapp"></i> Hubungi Tim Kemitraan
        </a>
        <a href="{{ route('home') }}" class="btn-partner-cta-back">
          <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
      </div>
    </div>
</div>
    </div>

  </div>
</div>
@endsection
