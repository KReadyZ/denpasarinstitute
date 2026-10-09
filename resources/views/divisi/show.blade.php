@extends('layouts.app')

@section('title', $divisi->header . ' | Denpasar Institute')

@section('content')

<section class="divisi-hero" style="background-image: url('{{ $divisi->background_image ? asset('storage/' . $divisi->background_image) : asset('images/default-hero.jpg') }}');">
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <h1 class="hero-title reveal">{{ $divisi->header ?: $divisi->nama }}</h1>
    
    @if($divisi->deskripsi)
    <div class="hero-description reveal reveal-delay-1">
      {!! $divisi->deskripsi !!}
    </div>
    @endif
    
    @if($divisi->stats && count($divisi->stats) > 0)
    <div class="hero-stats reveal reveal-delay-2">
      @foreach($divisi->stats as $stat)
        @if(!empty($stat['number']) && !empty($stat['label']))
        <div class="stat-item">
          <div class="stat-number">{{ $stat['number'] }}</div>
          <div class="stat-label">{{ $stat['label'] }}</div>
        </div>
        @endif
      @endforeach
    </div>
    @endif

    <div class="hero-buttons reveal reveal-delay-3">
      <a href="#program" class="btn-hero btn-primary">
        <i class="fas fa-list"></i> Lihat Program
      </a>
      <a href="#kolaborasi" class="btn-hero btn-secondary">
        <i class="fas fa-handshake"></i> Kolaborasi
      </a>
    </div>
  </div>
</section>

@if($sectionsByPosition['before_program'] && $sectionsByPosition['before_program']->count() > 0)
  @foreach($sectionsByPosition['before_program'] as $section)
    @include('divisi.section-item')
  @endforeach
@endif

@if($programs && $programs->count() > 0)
<section class="program-section" id="program">
  <div class="section-wrap">
    <div class="section-eyebrow reveal">
      <span>Program Aktif</span>
    </div>
    <h2 class="section-title reveal reveal-delay-1">Program <em>Pilihan</em></h2>
    <p class="section-sub reveal reveal-delay-2">{{ $programs->count() }} program unggulan yang dapat diakses oleh akademisi, peneliti, dan institusi mitra.</p>

    <div class="program-grid">
      @foreach($programs as $program)
        @php
          $ikonRaw = trim($program->ikon ?: 'fa-layer-group');
          $ikonClass = preg_match('/\b(fas|far|fal|fab|fad)\b/', $ikonRaw)
                        ? $ikonRaw
                        : 'fas ' . $ikonRaw;
        @endphp
        <div class="prog-card reveal"
             role="button"
             tabindex="0"
             onclick="openProgramModal(this)"
             onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();openProgramModal(this);}"
             data-nama="{{ $program->nama }}"
             data-ikon="{{ $ikonClass }}"
             data-target="prog-desc-{{ $program->id }}"
             style="--i: {{ $loop->index }};">
          <span class="prog-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
          <div class="prog-icon"><i class="{{ $ikonClass }}"></i></div>
          <span class="prog-name">{{ $program->nama }}</span>
        </div>
      @endforeach
    </div>
  </div>
</section>

@foreach($programs as $program)
  <template id="prog-desc-{{ $program->id }}">
    {!! $program->deskripsi ?: '<p>Deskripsi program ini belum tersedia.</p>' !!}
  </template>
@endforeach

<div class="prog-modal-backdrop" id="progModalBackdrop" onclick="closeProgramModal(event)">
  <div class="prog-modal" role="dialog" aria-modal="true" aria-labelledby="progModalTitle">
    <button type="button" class="prog-modal-close" onclick="closeProgramModal(event)" aria-label="Tutup">
      <i class="fas fa-times"></i>
    </button>
    <div class="prog-modal-head">
      <div class="prog-modal-icon" id="progModalIcon"><i class="fas fa-layer-group"></i></div>
      <h3 class="prog-modal-title" id="progModalTitle"></h3>
    </div>
    <div class="prog-modal-body">
      <div class="prog-modal-desc" id="progModalDesc"></div>
    </div>
  </div>
</div>
@endif

@if($sectionsByPosition['after_program'] && $sectionsByPosition['after_program']->count() > 0)
  @foreach($sectionsByPosition['after_program'] as $section)
    @include('divisi.section-item')
  @endforeach
@endif

@if($sectionsByPosition['after_section'] && $sectionsByPosition['after_section']->count() > 0)
  @foreach($sectionsByPosition['after_section'] as $section)
    @include('divisi.section-item')
  @endforeach
@endif

<section class="kolaborasi-section" id="kolaborasi">
  <div class="section-wrap">
    <div class="section-eyebrow reveal">
      <span>Kolaborasi</span>
    </div>
    <h2 class="section-title reveal reveal-delay-1">Bergabung <em>Bersama Kami</em></h2>
    <p class="section-sub reveal reveal-delay-2">{{ $divisi->nama }} membuka peluang bagi akademisi, peneliti independen, maupun praktisi industri untuk bergabung sebagai konsultan, narasumber, atau peneliti mitra.</p>

    <div class="kolaborasi-grid">
      <div class="kol-types">
        <div class="kol-type reveal">
          <div class="kol-type-icon"><i class="fas fa-user-tie"></i></div>
          <div class="kol-type-text">
            <h4>Konsultan Riset</h4>
            <p>Berkontribusi sebagai konsultan ahli dalam program riset Denpasar Institute.</p>
          </div>
        </div>

        <div class="kol-type reveal reveal-delay-1">
          <div class="kol-type-icon"><i class="fas fa-chalkboard-teacher"></i></div>
          <div class="kol-type-text">
            <h4>Narasumber &amp; Akademisi</h4>
            <p>Berbagi pengetahuan sebagai narasumber dalam seminar, workshop, dan pelatihan riset.</p>
          </div>
        </div>

        <div class="kol-type reveal reveal-delay-2">
          <div class="kol-type-icon"><i class="fas fa-users"></i></div>
          <div class="kol-type-text">
            <h4>Peneliti Mitra</h4>
            <p>Ikut serta dalam program riset kolaboratif lintas institusi dan disiplin ilmu.</p>
          </div>
        </div>
      </div>

      <div class="contact-card reveal reveal-delay-1">
        <h3>Hubungi Tim Kami</h3>
        <p>Siap berdiskusi tentang kebutuhan riset dan pengembangan Anda. Tim kami akan merespons dengan cepat dan profesional.</p>

        <div class="contact-card-info">
          <div class="cc-item"><i class="fab fa-whatsapp"></i><span>+62 878-6530-9966</span></div>
          <div class="cc-item"><i class="fas fa-envelope"></i><span>info@denpasarinstitute.id</span></div>
          <div class="cc-item"><i class="fas fa-map-marker-alt"></i><span>Denpasar, Bali — Indonesia</span></div>
        </div>

        <a href="https://wa.me/6287865309966" target="_blank" rel="noopener noreferrer" class="btn-wa-card">
          <i class="fab fa-whatsapp"></i> Kirim Pesan WhatsApp
        </a>
      </div>
    </div>
  </div>
</section>

<div class="divisi-nav-section">
  <div class="section-wrap">
    <div class="divisi-nav-grid">
      <div>
        @if($prevDivisi)
          <a href="{{ route('divisi.show', $prevDivisi->slug) }}" class="divisi-nav-link">
            <div class="divisi-nav-direction">
              <i class="fas fa-arrow-left"></i> Divisi Sebelumnya
            </div>
            <div class="divisi-nav-name">{{ $prevDivisi->nama }}</div>
          </a>
        @endif
      </div>

      <div class="divisi-nav-center">
        <a href="{{ route('home') }}#our-divisions">
          <i class="fas fa-th-large"></i> Semua Divisi
        </a>
      </div>

      <div style="text-align:right;">
        @if($nextDivisi)
          <a href="{{ route('divisi.show', $nextDivisi->slug) }}" class="divisi-nav-link">
            <div class="divisi-nav-direction" style="justify-content:flex-end;">
              Divisi Berikutnya <i class="fas fa-arrow-right"></i>
            </div>
            <div class="divisi-nav-name">{{ $nextDivisi->nama }}</div>
          </a>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection

@push('styles')
<style>
  /* ================= GLOBAL SECTION WRAPPER & CONTAINER ================= */
  .section-wrap {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 28px;
    box-sizing: border-box;
  }

  .section-eyebrow {
    display: block;
    width: 100%;
    margin-bottom: 12px;
  }

  .section-eyebrow span {
    display: inline-block;
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--red);
    background: rgba(204, 0, 0, 0.08);
    padding: 5px 14px;
    border-radius: 20px;
  }

  .section-title {
    display: block;
    width: 100%;
    font-size: 2.25rem;
    font-weight: 800;
    color: #111827;
    margin: 0 0 16px 0;
    line-height: 1.25;
    letter-spacing: -0.5px;
  }

  .section-title em {
    font-style: normal;
    color: var(--red);
  }

  .section-sub {
    display: block;
    width: 100%;
    font-size: 1.05rem;
    color: #64748b;
    line-height: 1.7;
    max-width: 720px;
    margin: 0 0 36px 0;
  }

  .divisi-hero {
    position: relative;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    min-height: 700px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 0 60px;
    overflow: hidden;
  }

  .hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.5) 0%, rgba(204,0,0,0.3) 100%);
  }

  .hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: #fff;
    width: 100%;
    max-width: 900px;
    padding: 0 20px;
  }

  .hero-title {
    font-size: 3rem;
    font-weight: 900;
    margin: 0 0 12px;
    line-height: 1.2;
    text-shadow: 0 2px 8px rgba(0,0,0,0.3);
  }

  .hero-subtitle {
    font-size: 1.2rem;
    font-weight: 300;
    margin: 0 0 20px;
    text-shadow: 0 1px 4px rgba(0,0,0,0.3);
  }

  .hero-description {
    font-size: 1rem;
    line-height: 1.7;
    margin: 0 0 30px;
    text-shadow: 0 1px 4px rgba(0,0,0,0.3);
    color: rgba(255, 255, 255, 0.95);
  }

  .hero-description * {
    color: rgba(255, 255, 255, 0.95);
    font-size: 1rem;
  }

  .hero-description p {
    margin: 0;
  }

  .hero-stats {
    display: flex;
    gap: 40px;
    justify-content: center;
    margin: 40px 0;
    flex-wrap: wrap;
  }

  .stat-item {
    text-align: center;
    color: #fff;
  }

  .stat-number {
    font-size: 2.5rem;
    font-weight: 900;
    line-height: 1;
    margin-bottom: 8px;
    text-shadow: 0 2px 8px rgba(0,0,0,0.3);
    color: var(--yellow);
  }

  .stat-label {
    font-size: 0.9rem;
    font-weight: 500;
    text-shadow: 0 1px 4px rgba(0,0,0,0.3);
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .hero-buttons {
    display: flex;
    gap: 16px;
    justify-content: center;
    margin-top: 30px;
    flex-wrap: wrap;
  }

  .btn-hero {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 32px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    transition: 0.3s;
    border: 2px solid transparent;
  }

  .btn-hero.btn-primary {
    background: var(--red);
    color: #fff;
  }

  .btn-hero.btn-primary:hover {
    background: #b30000;
    transform: translateY(-2px);
  }

  .btn-hero.btn-secondary {
    background: transparent;
    color: #fff;
    border-color: #fff;
  }

  .btn-hero.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: var(--yellow);
    color: var(--yellow);
  }

  /* ================= PROGRAM SECTION (FIXED) ================= */

  .program-section {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #1a1a1a 100%);
    padding: 70px 0;
  }

  .program-section .section-eyebrow span {
    color: var(--yellow);
  }

  .program-section .section-title {
    color: #fff;
  }

  .program-section .section-title em {
    color: var(--yellow);
  }

  .program-section .section-sub {
    color: rgba(255, 255, 255, 0.8);
  }

  .program-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1px;
    margin-top: 48px;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
    overflow: hidden;
  }

  .program-section .prog-card {
    position: relative;
    background: #1c1c1c;
    padding: 40px 24px 32px;
    cursor: pointer;
    outline: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 14px;
    transition: background 0.35s ease;
    overflow: hidden;
    isolation: isolate;
  }

  .program-section .prog-num {
    position: absolute;
    top: 8px;
    right: 16px;
    font-size: 3.2rem;
    font-weight: 900;
    color: rgba(255, 255, 255, 0.04);
    line-height: 1;
    z-index: 0;
    transition: color 0.35s ease, transform 0.35s ease;
    user-select: none;
  }

  .program-section .prog-card:hover .prog-num {
    color: rgba(245, 196, 0, 0.08);
    transform: scale(1.1);
  }

  .prog-icon {
    position: relative;
    z-index: 1;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: var(--yellow);
    flex-shrink: 0;
    transition: background 0.35s ease, transform 0.35s ease, border-color 0.35s ease, box-shadow 0.35s ease;
  }

  .program-section .prog-card:hover .prog-icon {
    background: var(--yellow);
    color: #1a1a1a;
    border-color: var(--yellow);
    transform: scale(1.1);
    box-shadow: 0 8px 24px rgba(245, 196, 0, 0.35);
  }

  .program-section .prog-name {
    position: relative;
    z-index: 1;
    font-size: 0.98rem;
    font-weight: 700;
    color: #fff;
    line-height: 1.4;
  }

  .program-section .prog-card:hover {
    background: #232323;
  }

  .prog-card:focus-visible {
    outline: 2px solid var(--red);
    outline-offset: -2px;
  }

  @media (max-width: 900px) {
    .program-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 768px) {
    .program-section .prog-card {
      padding: 32px 18px 26px;
    }

    .program-section .prog-num {
      font-size: 2.4rem;
    }
  }

  /* ================= END PROGRAM SECTION ================= */

  .prog-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    z-index: 3000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    opacity: 0;
    transition: opacity 0.25s ease;
  }

  .prog-modal-backdrop.is-active {
    display: flex;
    opacity: 1;
  }

  .prog-modal {
    background: #fff;
    width: 100%;
    max-width: 760px;
    border-radius: 10px;
    border-top: 4px solid var(--red);
    padding: 40px 48px 44px;
    position: relative;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    transform: translateY(16px) scale(0.97);
    opacity: 0;
    transition: transform 0.25s ease, opacity 0.25s ease;
    max-height: 88vh;
    overflow-y: auto;
  }

  .prog-modal-backdrop.is-active .prog-modal {
    transform: translateY(0) scale(1);
    opacity: 1;
  }

  .prog-modal-close {
    position: absolute;
    top: 18px;
    right: 18px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: none;
    background: var(--gray);
    color: var(--dark);
    font-size: 0.85rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s;
    z-index: 2;
  }

  .prog-modal-close:hover {
    background: var(--red);
    color: #fff;
  }

  .prog-modal-head {
    display: flex;
    align-items: center;
    gap: 18px;
    margin-bottom: 24px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border);
  }

  .prog-modal-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #fff5f5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--red);
    flex-shrink: 0;
  }

  .prog-modal-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--dark);
    margin: 0;
    line-height: 1.3;
  }

  .prog-modal-body {
    columns: 1;
  }

  .prog-modal-desc {
    font-size: 0.88rem;
    color: #555;
    line-height: 1.8;
    font-family: 'Poppins', sans-serif;
  }

  .prog-modal-desc * {
    font-family: 'Poppins', sans-serif;
    font-size: 0.88rem;
    color: #555;
    max-width: 100%;
  }

  .prog-modal-desc p {
    margin: 0 0 12px;
  }

  .prog-modal-desc p:last-child {
    margin-bottom: 0;
  }

  .prog-modal-desc strong, .prog-modal-desc b {
    font-weight: 700;
  }

  .prog-modal-desc em, .prog-modal-desc i {
    font-style: italic;
  }

  .prog-modal-desc ul, .prog-modal-desc ol {
    margin: 0 0 12px;
    padding-left: 20px;
  }

  .prog-modal-desc li {
    margin-bottom: 6px;
  }

  .prog-modal-desc a {
    color: var(--red);
    text-decoration: underline;
  }

  .prog-modal-desc img {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
    margin: 10px 0;
  }

  .prog-modal-desc table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 12px;
  }

  .prog-modal-desc td, .prog-modal-desc th {
    border: 1px solid var(--border);
    padding: 6px 8px;
  }

  .kolaborasi-section {
    padding: 85px 0;
    background: #fff;
    border-top: 1px solid #f1f5f9;
  }

  .kolaborasi-grid {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 48px;
    align-items: start;
  }

  .kol-types {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .kol-type {
    display: flex;
    gap: 18px;
    padding: 20px 22px;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #edf2f7;
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
  }

  .kol-type:hover {
    transform: translateX(4px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
    border-color: rgba(204, 0, 0, 0.25);
  }

  .kol-type-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #fff5f5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: var(--red);
    flex-shrink: 0;
  }

  .kol-type-text h4 {
    font-size: 0.95rem;
    font-weight: 800;
    color: var(--dark);
    margin: 0 0 6px;
  }

  .kol-type-text p {
    font-size: 0.85rem;
    color: #666;
    line-height: 1.6;
    margin: 0;
  }

  .contact-card {
    background: #f9f9f9;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 32px;
  }

  .contact-card h3 {
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--dark);
    margin: 0 0 12px;
  }

  .contact-card > p {
    font-size: 0.9rem;
    color: #666;
    line-height: 1.6;
    margin: 0 0 20px;
  }

  .contact-card-info {
    margin-bottom: 20px;
  }

  .cc-item {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.9rem;
    color: #555;
    margin-bottom: 10px;
  }

  .cc-item i {
    color: var(--red);
    width: 20px;
    text-align: center;
  }

  .btn-wa-card {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: #25D366;
    color: #fff;
    padding: 12px 24px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: 0.3s;
    width: 100%;
  }

  .btn-wa-card:hover {
    background: #20ba5c;
    transform: translateY(-2px);
  }

  .divisi-nav-section {
    padding: 60px 0;
    background: #f9f9f9;
    border-top: 1px solid var(--border);
  }

  .divisi-nav-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 20px;
    align-items: center;
  }

  .divisi-nav-link {
    display: block;
    padding: 16px;
    border: 1px solid var(--border);
    border-radius: 8px;
    text-decoration: none;
    color: inherit;
    transition: 0.3s;
  }

  .divisi-nav-link:hover {
    background: #fff;
    border-color: var(--red);
    box-shadow: 0 4px 12px rgba(204, 0, 0, 0.1);
  }

  .divisi-nav-direction {
    font-size: 0.8rem;
    color: #999;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .divisi-nav-name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--dark);
  }

  .divisi-nav-center {
    text-align: center;
  }

  .divisi-nav-center a {
    display: inline-block;
    padding: 12px 24px;
    background: var(--red);
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: 0.3s;
  }

  .divisi-nav-center a:hover {
    background: #b30000;
  }

  @media (max-width: 768px) {
    .divisi-hero {
      min-height: 500px;
    }

    .hero-title {
      font-size: 1.8rem;
    }

    .hero-subtitle {
      font-size: 1rem;
    }

    .hero-description {
      font-size: 0.9rem;
    }

    .hero-stats {
      gap: 20px;
    }

    .stat-number {
      font-size: 1.8rem;
    }

    .stat-label {
      font-size: 0.8rem;
    }

    .btn-hero {
      padding: 10px 24px;
      font-size: 0.85rem;
    }

    .kolaborasi-grid {
      grid-template-columns: 1fr;
    }

    .divisi-nav-grid {
      grid-template-columns: 1fr;
    }

    .divisi-nav-direction {
      justify-content: center;
    }
  }
</style>
@endpush

@push('scripts')
<script>
  window.addEventListener('beforeunload', function() {
    if (window.revealObserver) {
      try {
        window.revealObserver.disconnect();
      } catch (e) {
        console.warn('[Cleanup] Observer error:', e.message);
      }
    }
  });

  var revealObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(e) {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
      }
    });
  }, { threshold: 0.1 });

  window.revealObserver = revealObserver;

  document.querySelectorAll('.reveal').forEach(function(el) {
    revealObserver.observe(el);
  });

  setTimeout(function() {
    document.querySelectorAll('.reveal:not(.visible)').forEach(function(el) {
      el.classList.add('force-visible');
    });
  }, 1500);

  function openProgramModal(card) {
    var backdrop = document.getElementById('progModalBackdrop');
    if (!backdrop) return;

    document.getElementById('progModalTitle').textContent = card.dataset.nama || '';
    document.getElementById('progModalIcon').innerHTML = '<i class="' + (card.dataset.ikon || 'fas fa-layer-group') + '"></i>';

    var descEl = document.getElementById('progModalDesc');
    var tpl = document.getElementById(card.dataset.target);
    descEl.innerHTML = tpl ? tpl.innerHTML : '<p>Deskripsi program ini belum tersedia.</p>';

    backdrop.classList.add('is-active');
    document.body.style.overflow = 'hidden';
  }

  function closeProgramModal(evt) {
    if (evt && evt.target && evt.target.closest('.prog-modal') && !evt.target.closest('.prog-modal-close')) {
      return;
    }
    var backdrop = document.getElementById('progModalBackdrop');
    if (!backdrop) return;
    backdrop.classList.remove('is-active');
    document.body.style.overflow = '';
  }

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeProgramModal();
  });
</script>
@endpush