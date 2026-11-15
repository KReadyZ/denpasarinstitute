@extends('layouts.app')

@section('title', $data['subtitle'] . ' | Denpasar Institute')

@push('styles')
<style>
  :root {
    --pi-red: #CC0000;
    --pi-dark-red: #8B0000;
    --pi-yellow: #F5C400;
    --pi-dark: #121824;
    --pi-gray-bg: #f8fafc;
    --pi-border: #e2e8f0;
  }

  /* Hero Section */
  .pi-hero {
    background: linear-gradient(135deg, rgba(18, 24, 38, 0.94) 0%, rgba(90, 10, 10, 0.88) 50%, rgba(18, 24, 38, 0.96) 100%),
                url('{{ asset('image/partner-hero-bg.jpg') }}') center/cover no-repeat;
    color: #ffffff;
    padding: 160px 20px 85px;
    position: relative;
    overflow: hidden;
  }
  .pi-hero::before {
    content: '';
    position: absolute;
    width: 450px;
    height: 450px;
    background: radial-gradient(circle, rgba(245, 196, 0, 0.15) 0%, transparent 70%);
    top: -120px;
    right: -80px;
    pointer-events: none;
  }
  .pi-hero::after {
    content: '';
    position: absolute;
    width: 350px;
    height: 350px;
    background: radial-gradient(circle, rgba(204, 0, 0, 0.22) 0%, transparent 70%);
    bottom: -80px;
    left: -80px;
    pointer-events: none;
  }
  .pi-hero-inner {
    max-width: 1100px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
  }

  /* Breadcrumb */
  .pi-breadcrumb {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.86rem;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 18px;
    flex-wrap: wrap;
  }
  .pi-breadcrumb a {
    color: rgba(255, 255, 255, 0.85);
    text-decoration: none;
    transition: color 0.2s;
  }
  .pi-breadcrumb a:hover {
    color: var(--pi-yellow);
  }
  .pi-breadcrumb span.sep {
    color: rgba(255, 255, 255, 0.4);
  }
  .pi-breadcrumb span.current {
    color: var(--pi-yellow);
    font-weight: 600;
  }

  /* Hero Tag & Titles */
  .pi-badge-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(245, 196, 0, 0.16);
    border: 1px solid var(--pi-yellow);
    color: var(--pi-yellow);
    font-size: 0.82rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 5px 16px;
    border-radius: 20px;
    margin-bottom: 16px;
  }
  .pi-hero-title {
    font-size: 2.6rem;
    font-weight: 900;
    line-height: 1.25;
    margin-bottom: 12px;
    color: #ffffff;
    letter-spacing: -0.5px;
    text-shadow: 0 3px 12px rgba(0, 0, 0, 0.5);
  }
  .pi-hero-title span {
    color: var(--pi-yellow);
  }
  .pi-hero-sub {
    font-size: 1.08rem;
    line-height: 1.75;
    color: rgba(255, 255, 255, 0.88);
    max-width: 820px;
    margin: 0;
  }

  /* Quick Pillar Switcher Tabs */
  .pi-switcher-nav {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 28px;
    overflow-x: auto;
    padding-bottom: 8px;
    scrollbar-width: thin;
  }
  .pi-switcher-nav::-webkit-scrollbar {
    height: 4px;
  }
  .pi-switcher-nav::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 4px;
  }
  .pi-switch-pill {
    padding: 7px 16px;
    border-radius: 30px;
    font-size: 0.82rem;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.25s ease;
    background: rgba(255, 255, 255, 0.12);
    color: #ffffff;
    border: 1px solid rgba(255, 255, 255, 0.2);
  }
  .pi-switch-pill:hover {
    background: rgba(255, 255, 255, 0.25);
    color: #ffffff;
    transform: translateY(-2px);
  }
  .pi-switch-pill.active {
    background: var(--pi-yellow);
    color: #111827;
    border-color: var(--pi-yellow);
    box-shadow: 0 4px 14px rgba(245, 196, 0, 0.4);
  }

  /* Wave Divider */
  .pi-wave {
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    z-index: 3;
    pointer-events: none;
  }
  .pi-wave svg {
    display: block;
    width: 100%;
    height: 48px;
  }

  /* Main Section */
  .pi-content-wrap {
    background: #fdfdfd;
    padding: 60px 20px 85px;
  }
  .pi-container {
    max-width: 1100px;
    margin: 0 auto;
  }

  /* Primary Showcase Card (Matching Reference Image) */
  .pi-showcase-card {
    background: #ffffff;
    border-radius: 20px;
    border: 1.5px solid var(--pi-border);
    box-shadow: 0 14px 40px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    margin-bottom: 45px;
    position: relative;
    transition: box-shadow 0.3s ease;
  }
  .pi-showcase-card:hover {
    box-shadow: 0 20px 50px rgba(204, 0, 0, 0.09);
  }
  .pi-showcase-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--pi-red) 0%, var(--pi-yellow) 100%);
  }

  /* Header of the Showcase Card */
  .pi-card-header {
    padding: 34px 38px 24px;
    border-bottom: 1px solid #f1f5f9;
    background: linear-gradient(180deg, #ffffff 0%, #fafbfc 100%);
  }
  .pi-section-code {
    font-size: 1.45rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 6px;
    letter-spacing: -0.2px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .pi-section-subtitle {
    font-size: 1.18rem;
    font-weight: 700;
    color: var(--pi-red);
    margin: 0;
    letter-spacing: 0.2px;
  }

  /* Body: 2 Columns (Image + Services List) */
  .pi-card-body {
    padding: 38px 38px 42px;
    display: grid;
    grid-template-columns: 340px 1fr;
    gap: 40px;
    align-items: start;
  }

  /* Left Column: Image */
  .pi-media-col {
    display: flex;
    flex-direction: column;
    gap: 16px;
    position: sticky;
    top: 100px;
  }
  /* Left Column: Alur Kerja Sama Kemitraan Card */
  .pi-side-card {
    background: #ffffff;
    border: 1px solid var(--pi-border);
    border-radius: 14px;
    padding: 18px 20px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
  }
  .pi-side-card-header {
    display: flex;
    align-items: center;
    gap: 9px;
    font-weight: 700;
    font-size: 0.92rem;
    color: #0f172a;
    padding-bottom: 12px;
    border-bottom: 1px solid #f1f5f9;
    margin-bottom: 14px;
  }
  .pi-side-card-header i {
    color: var(--pi-red);
    font-size: 1rem;
  }
  .pi-step-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }
  .pi-step-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
  }
  .pi-step-num {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: rgba(139, 0, 0, 0.08);
    color: var(--pi-red);
    font-weight: 700;
    font-size: 0.76rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
    border: 1px solid rgba(139, 0, 0, 0.18);
  }
  .pi-step-content strong {
    display: block;
    font-size: 0.83rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1.35;
    margin-bottom: 2px;
  }
  .pi-step-content p {
    font-size: 0.77rem;
    color: #64748b;
    line-height: 1.45;
    margin: 0;
  }
  .pi-side-card-footer {
    margin-top: 14px;
    padding-top: 10px;
    border-top: 1px dashed #e2e8f0;
    font-size: 0.74rem;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
  }
  .pi-side-card-footer i {
    color: var(--pi-red);
    font-size: 0.82rem;
  }
  .pi-media-frame {
    position: relative;
    border-radius: 18px;
    overflow: hidden;
    background: #f1f5f9;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    border: 3px solid #ffffff;
    aspect-ratio: 188 / 261;
    max-height: 420px;
  }
  .pi-media-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center 20%;
    display: block;
    transition: transform 0.4s ease;
  }
  .pi-media-frame:hover img {
    transform: scale(1.04);
  }
  .pi-media-tag {
    background: #ffffff;
    border: 1px solid var(--pi-border);
    border-left: 4px solid var(--pi-red);
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 0.88rem;
    color: #334155;
    line-height: 1.5;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
  }
  .pi-media-tag i {
    color: var(--pi-red);
    font-size: 1.15rem;
    flex-shrink: 0;
  }

  /* Right Column: Focus List (Exact 8 items from reference) */
  .pi-list-col {
    display: flex;
    flex-direction: column;
  }
  .pi-list-intro {
    font-size: 1.05rem;
    color: #475569;
    line-height: 1.7;
    margin-bottom: 24px;
  }
  .pi-services-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
  }
  .pi-service-item {
    background: #ffffff;
    border: 1.5px solid #edf2f7;
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    transition: all 0.25s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
  }
  .pi-service-item:hover {
    border-color: rgba(204, 0, 0, 0.35);
    background: #fffdfd;
    transform: translateX(4px);
    box-shadow: 0 6px 18px rgba(204, 0, 0, 0.08);
  }
  .pi-service-bullet {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--pi-red) 0%, #a80000 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.76rem;
    flex-shrink: 0;
    margin-top: 2px;
    box-shadow: 0 4px 10px rgba(204, 0, 0, 0.25);
  }
  .pi-service-info {
    flex: 1;
  }
  .pi-service-title {
    font-size: 1.08rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 4px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .pi-service-desc {
    font-size: 0.92rem;
    color: #64748b;
    margin: 0;
    line-height: 1.6;
  }

  /* Three Highlights */
  .pi-features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-bottom: 45px;
  }
  .pi-feature-box {
    background: #ffffff;
    border: 1px solid var(--pi-border);
    border-radius: 14px;
    padding: 26px 22px;
    text-align: center;
    transition: all 0.25s ease;
  }
  .pi-feature-box:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.06);
    border-color: rgba(204, 0, 0, 0.3);
  }
  .pi-feature-icon {
    width: 56px;
    height: 56px;
    margin: 0 auto 16px;
    border-radius: 14px;
    background: rgba(204, 0, 0, 0.08);
    color: var(--pi-red);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.45rem;
  }
  .pi-feature-title {
    font-size: 1.1rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 8px;
  }
  .pi-feature-desc {
    font-size: 0.9rem;
    color: #64748b;
    line-height: 1.6;
    margin: 0;
  }

  /* Bottom CTA Box */
  .pi-bottom-cta {
    background: linear-gradient(135deg, #111827 0%, #3f0909 55%, #180303 100%);
    border-radius: 18px;
    padding: 40px 44px;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.2);
    position: relative;
    overflow: hidden;
  }
  .pi-bottom-cta::before {
    content: '';
    position: absolute;
    top: -80px;
    right: -80px;
    width: 250px;
    height: 250px;
    background: radial-gradient(circle, rgba(245, 196, 0, 0.2) 0%, transparent 70%);
    pointer-events: none;
  }
  .pi-cta-text h3 {
    font-size: 1.65rem;
    font-weight: 800;
    margin: 0 0 8px;
    color: #ffffff;
  }
  .pi-cta-text p {
    font-size: 0.98rem;
    color: rgba(255, 255, 255, 0.88);
    margin: 0;
    line-height: 1.6;
    max-width: 620px;
  }
  .pi-cta-btns {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    flex-shrink: 0;
    z-index: 2;
  }
  .pi-btn-wa {
    background: var(--pi-yellow);
    color: #111827;
    font-weight: 800;
    font-size: 0.94rem;
    padding: 13px 26px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-family: inherit;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 9px;
    transition: all 0.2s ease;
    box-shadow: 0 4px 14px rgba(245, 196, 0, 0.35);
  }
  .pi-btn-wa:hover {
    background: #ffcf10;
    color: #000;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(245, 196, 0, 0.5);
  }
  .pi-btn-back {
    background: rgba(255, 255, 255, 0.12);
    color: #ffffff;
    font-weight: 700;
    font-size: 0.94rem;
    padding: 13px 22px;
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.4);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
  }
  .pi-btn-back:hover {
    background: #ffffff;
    color: var(--pi-red);
    border-color: #ffffff;
    transform: translateY(-2px);
  }

  /* Responsive Design */
  @media (max-width: 992px) {
    .pi-hero { padding: 130px 20px 75px; }
    .pi-hero-title { font-size: 2.15rem; }
    .pi-card-body {
      grid-template-columns: 1fr;
      gap: 32px;
    }
    .pi-media-col {
      position: static;
    }
    .pi-services-grid {
      grid-template-columns: 1fr;
    }
    .pi-media-frame {
      max-width: 320px;
      margin: 0 auto;
    }
    .pi-features-grid {
      grid-template-columns: 1fr;
      gap: 18px;
    }
    .pi-bottom-cta {
      flex-direction: column;
      text-align: center;
      padding: 34px 24px;
    }
    .pi-cta-btns {
      width: 100%;
      justify-content: center;
    }
    .pi-btn-wa, .pi-btn-back {
      width: 100%;
      justify-content: center;
    }
  }

  @media (max-width: 640px) {
    .pi-hero { padding: 110px 16px 65px; }
    .pi-hero-title { font-size: 1.75rem; }
    .pi-card-header { padding: 24px 20px 18px; }
    .pi-card-body { padding: 24px 20px 28px; }
    .pi-section-code { font-size: 1.25rem; }
    .pi-section-subtitle { font-size: 1.05rem; }
    .pi-service-title { font-size: 0.98rem; }
    .pi-service-desc { font-size: 0.88rem; }
  }
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<section class="pi-hero">
  <div class="pi-hero-inner">
    
    {{-- Breadcrumb --}}
    <nav class="pi-breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}"><i class="fas fa-home"></i> Beranda</a>
      <span class="sep">/</span>
      <a href="{{ route('partners-and-community') }}">Kemitraan &amp; Kolaborasi</a>
      <span class="sep">/</span>
      <span class="current">{{ $data['subtitle'] }}</span>
    </nav>

    <div class="pi-badge-tag">
      {{ $data['badge'] }}
    </div>

    <h1 class="pi-hero-title">
      {!! $data['hero_title'] !!}
    </h1>

    <p class="pi-hero-sub">
      {{ $data['hero_sub'] }}
    </p>

    {{-- Quick Pillar Switcher Tabs --}}
    <div class="pi-switcher-nav" aria-label="Pilih Pilar Lainnya">
      @foreach($allPillarsNav as $nav)
        <a href="{{ route('partner.detail', $nav['slug']) }}" 
           class="pi-switch-pill {{ $nav['active'] ? 'active' : '' }}">
          <i class="fas fa-handshake" style="font-size:0.75rem;"></i> {{ $nav['title'] }}
        </a>
      @endforeach
    </div>

  </div>

  <div class="pi-wave" aria-hidden="true">
    <svg viewBox="0 0 1440 48" fill="none" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0,24 C320,48 540,6 740,24 C960,42 1180,12 1440,28 L1440,48 L0,48 Z" fill="#fdfdfd"/>
    </svg>
  </div>
</section>

{{-- Content Section --}}
<section class="pi-content-wrap">
  <div class="pi-container">

    {{-- Main Showcase Card matching Reference Layout --}}
    <article class="pi-showcase-card">
      
      {{-- Card Header: Clean Pillar Title & Subtitle (Pilar & Huruf dihilangkan sesuai permintaan) --}}
      <div class="pi-card-header">
        <h2 class="pi-section-code">
          <span>{{ $data['section_code'] }}</span>
        </h2>
        <p class="pi-section-subtitle">
          {{ $data['subtitle'] }}
        </p>
      </div>

      {{-- Card Body: 2 Columns Layout --}}
      <div class="pi-card-body">
        
        {{-- Left: Exact Photo from Reference --}}
        <div class="pi-media-col">
          <div class="pi-media-frame">
            <img src="{{ asset($data['image']) }}" 
                 alt="{{ $data['subtitle'] }} - Denpasar Institute" 
                 loading="lazy"
                 onerror="this.src='{{ asset($data['fallback_image']) }}';">
          </div>
          <div class="pi-media-tag">
            <i class="fas fa-check-circle"></i>
            <div>
              <strong>{{ $data['image_tag'] }}</strong>
              <div style="font-size:0.8rem;color:#64748b;">{{ $data['image_sub'] }}</div>
            </div>
          </div>

          {{-- Alur Kolaborasi Kemitraan Card (Informative, non-redundant) --}}
          <div class="pi-side-card">
            <div class="pi-side-card-header">
              <i class="fas fa-clipboard-check"></i>
              <span>Alur Kerja Sama Kemitraan</span>
            </div>
            <div class="pi-step-list">
              <div class="pi-step-item">
                <div class="pi-step-num">1</div>
                <div class="pi-step-content">
                  <strong>Konsultasi &amp; Asesmen</strong>
                  <p>Pemetaan kebutuhan spesifik institusi dan perumusan sasaran program bersama tim ahli.</p>
                </div>
              </div>
              <div class="pi-step-item">
                <div class="pi-step-num">2</div>
                <div class="pi-step-content">
                  <strong>Penyusunan MoU &amp; PKS</strong>
                  <p>Perumusan silabus, jadwal kerja sama, serta legalitas kelembagaan yang transparan.</p>
                </div>
              </div>
              <div class="pi-step-item">
                <div class="pi-step-num">3</div>
                <div class="pi-step-content">
                  <strong>Eksekusi &amp; Pendampingan</strong>
                  <p>Implementasi program intensif dipandu pakar akademisi dan praktisi tersertifikasi.</p>
                </div>
              </div>
              <div class="pi-step-item">
                <div class="pi-step-num">4</div>
                <div class="pi-step-content">
                  <strong>Evaluasi &amp; Luaran Terukur</strong>
                  <p>Pengukuran dampak, penerbitan sertifikat/luaran riil, dan laporan komprehensif.</p>
                </div>
              </div>
            </div>
            <div class="pi-side-card-footer">
              <i class="fas fa-shield-alt"></i>
              <span>Standar Mutu &amp; Integritas Denpasar Institute</span>
            </div>
          </div>
        </div>

        {{-- Right: The 8 Focus Points from Reference --}}
        <div class="pi-list-col">
          <p class="pi-list-intro">
            {!! $data['intro'] !!}
          </p>

          <div class="pi-services-grid">
            @foreach($data['services'] as $svc)
              <div class="pi-service-item">
                <div class="pi-service-bullet"><i class="fas {{ $svc['icon'] }}"></i></div>
                <div class="pi-service-info">
                  <h4 class="pi-service-title">{{ $svc['title'] }}</h4>
                  <p class="pi-service-desc">{{ $svc['desc'] }}</p>
                </div>
              </div>
            @endforeach
          </div>
        </div>

      </div>

    </article>

    {{-- Value Proposition / Highlights --}}
    <div class="pi-features-grid">
      @foreach($data['highlights'] as $hl)
        <div class="pi-feature-box">
          <div class="pi-feature-icon"><i class="fas {{ $hl['icon'] }}"></i></div>
          <h4 class="pi-feature-title">{{ $hl['title'] }}</h4>
          <p class="pi-feature-desc">{{ $hl['desc'] }}</p>
        </div>
      @endforeach
    </div>

    {{-- Bottom Action Box --}}
    <div class="pi-bottom-cta">
      <div class="pi-cta-text">
        <h3>{{ $data['cta_title'] }}</h3>
        <p>{{ $data['cta_sub'] }}</p>
      </div>
      <div class="pi-cta-btns">
        <button type="button" class="pi-btn-wa" onclick="openPartnerModal('{{ $slug }}', '{{ $data['section_code'] }}')" title="Buka Formulir Kemitraan">
          <i class="fas fa-file-signature"></i> {{ $data['wa_btn'] ?? 'Form Kemitraan' }}
        </button>
        <a href="{{ route('partners-and-community') }}" class="pi-btn-back">
          <i class="fas fa-arrow-left"></i> Seluruh Pilar Kemitraan
        </a>
      </div>
    </div>

  </div>
</section>

{{-- Pop-up Modal Form Kemitraan --}}
@include('partials.modal-form-kemitraan')

@endsection

