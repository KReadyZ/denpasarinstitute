@php
  $isKeunggulan = stripos($section->section_name, 'keunggulan') !== false || stripos($section->section_name, 'unggulan') !== false;
  $isTentang = stripos($section->section_name, 'tentang') !== false;

  // Siapkan foto-foto banyak untuk slider keunggulan divisi
  $keunggulanPhotos = [];
  if ($section->image) {
      $keunggulanPhotos[] = asset('storage/' . $section->image);
  }

  // Tambahan foto-foto dokumentasi & kegiatan spesifik per divisi
  $slug = $divisi->slug ?? '';
  $divisiImgMap = [
      'divisi-riset-dan-inovasi' => ['/image/divisi-01-riset.png', '/image/partner-hero-bg.jpg', '/image/banner-brin.png'],
      'divisi-publikasi-dan-hki' => ['/image/divisi-02-publikasi.png', '/image/partner-hero-bg.jpg', '/image/banner-brin.png'],
      'divisi-pengembangan-sdm' => ['/image/divisi-03-sdm.png', '/image/partner-hero-bg.jpg', '/image/banner-kmd.png'],
      'divisi-vokasi-dan-sertifikasi' => ['/image/divisi-04-vokasi.png', '/image/partner-hero-bg.jpg', '/image/banner-kmd.png'],
      'divisi-sains-data-dan-ti' => ['/image/divisi-05-data.png', '/image/partner-hero-bg.jpg', '/image/banner-brin.png'],
      'divisi-bahasa-seni-dan-budaya' => ['/image/divisi-06-budaya.png', '/image/partner-hero-bg.jpg', '/image/banner-kmd.png'],
      'divisi-kerja-sama-dan-hi' => ['/image/divisi-07-kerjasama.png', '/image/partner-hero-bg.jpg', '/image/banner-brin.png'],
      'divisi-konsultan' => ['/image/divisi-08-konsultan.png', '/image/partner-hero-bg.jpg', '/image/banner-brin.png'],
      'divisi-karir-dan-kewirausahaan' => ['/image/divisi-09-karir.png', '/image/partner-hero-bg.jpg', '/image/banner-kmd.png'],
  ];

  $extraPhotos = $divisiImgMap[$slug] ?? [
      '/image/divisi-01-riset.png',
      '/image/partner-hero-bg.jpg',
      '/image/banner-brin.png',
  ];

  foreach ($extraPhotos as $p) {
      $pAsset = asset($p);
      if (!in_array($pAsset, $keunggulanPhotos)) {
          $keunggulanPhotos[] = $pAsset;
      }
  }

  if (!empty($divisi->background_image)) {
      $bgAsset = asset('storage/' . $divisi->background_image);
      if (!in_array($bgAsset, $keunggulanPhotos)) {
          $keunggulanPhotos[] = $bgAsset;
      }
  }

  $hasImage = $isKeunggulan || !empty($section->image);

  // Tentukan order image/text berdasarkan design
  $imagePosition = in_array($section->design_class, ['section-light', 'section-accent']) 
    ? 'order-image-right' 
    : 'order-image-left';
@endphp

<section class="custom-section {{ $section->design_class }}" id="section-{{ $section->id }}">
  <div class="section-wrap @if($hasImage) has-image {{ $imagePosition }} @else no-image @endif">
    
    @if($isKeunggulan)
      {{-- Slider Foto Otomatis Keunggulan Divisi (Slide Sendiri & Banyak Foto) --}}
      <div class="section-image-wrap reveal keunggulan-slider-wrap" id="slider-sec-{{ $section->id }}">
        <div class="keunggulan-slider-track">
          @foreach($keunggulanPhotos as $idx => $photoUrl)
            <div class="keunggulan-slide {{ $idx === 0 ? 'is-active' : '' }}">
              <img src="{{ $photoUrl }}" alt="{{ $section->section_name }} - Foto {{ $idx + 1 }}" class="section-image" loading="lazy">
              <span class="keunggulan-slide-badge">
                <i class="fas fa-camera mr-1"></i> Keunggulan Divisi ({{ $idx + 1 }}/{{ count($keunggulanPhotos) }})
              </span>
            </div>
          @endforeach
        </div>
        <div class="keunggulan-slider-nav">
          <button type="button" class="ks-prev" aria-label="Foto Sebelumnya"><i class="fas fa-chevron-left"></i></button>
          <div class="ks-dots">
            @foreach($keunggulanPhotos as $idx => $photoUrl)
              <span class="ks-dot {{ $idx === 0 ? 'is-active' : '' }}"></span>
            @endforeach
          </div>
          <button type="button" class="ks-next" aria-label="Foto Berikutnya"><i class="fas fa-chevron-right"></i></button>
        </div>
      </div>
    @elseif($section->image)
      <div class="section-image-wrap reveal">
        <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->section_name }}" class="section-image" loading="lazy">
      </div>
    @endif

    <div class="section-content reveal">
      <h2 class="custom-section-title">{{ $section->section_name }}</h2>
      <div class="section-body">
        {!! $section->content !!}
      </div>

      @if($isTentang || $isKeunggulan)
        <div class="section-readmore-bar mt-4 pt-3 border-top" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
          <a href="{{ route('home') }}#divisi-detail" class="btn-sec-all-divisi" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700; font-size: 0.88rem; background: var(--red); color: #fff; padding: 9px 20px; border-radius: 6px; text-decoration: none; box-shadow: 0 4px 12px rgba(204,0,0,0.2); transition: transform 0.2s, background 0.2s;">
            <i class="fas fa-th-large"></i> Read More Semua Divisi
          </a>
          <a href="#program" class="btn-sec-program" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700; font-size: 0.88rem; background: #f8fafc; color: #1e293b; padding: 9px 20px; border-radius: 6px; text-decoration: none; border: 1px solid #cbd5e1; transition: background 0.2s;">
            <i class="fas fa-graduation-cap text-danger"></i> Program Pilihan Divisi
          </a>
        </div>
      @endif
    </div>

  </div>
</section>

@once
@push('styles')
<style>
  /* ================= CUSTOM DIVISION SECTION ================= */
  .custom-section {
    padding: 85px 0;
    position: relative;
  }

  .section-light {
    background: #ffffff;
  }

  .section-dark {
    background: #f8fafc;
    border-top: 1px solid #edf2f7;
    border-bottom: 1px solid #edf2f7;
  }

  .section-accent {
    background: linear-gradient(180deg, #fff7f7 0%, #ffffff 100%);
    border-top: 1px solid rgba(204, 0, 0, 0.08);
    border-bottom: 1px solid rgba(204, 0, 0, 0.08);
  }

  /* Grid layout untuk section dengan image */
  .custom-section .section-wrap.has-image {
    display: grid;
    grid-template-columns: 1.08fr 0.92fr;
    gap: 60px;
    align-items: center;
  }

  /* Image di kiri */
  .custom-section .section-wrap.has-image.order-image-left {
    grid-template-columns: 0.92fr 1.08fr;
  }

  .custom-section .section-wrap.has-image.order-image-left .section-image-wrap {
    order: 1;
  }

  .custom-section .section-wrap.has-image.order-image-left .section-content {
    order: 2;
  }

  /* Image di kanan */
  .custom-section .section-wrap.has-image.order-image-right {
    grid-template-columns: 1.08fr 0.92fr;
  }

  .custom-section .section-wrap.has-image.order-image-right .section-image-wrap {
    order: 2;
  }

  .custom-section .section-wrap.has-image.order-image-right .section-content {
    order: 1;
  }

  /* Layout tanpa image: tampil di tengah dalam card elegan dengan lebar baca ideal */
  .custom-section .section-wrap.no-image {
    display: block;
    max-width: 960px;
    margin: 0 auto;
  }

  .custom-section .section-wrap.no-image .section-content {
    background: #ffffff;
    padding: 48px 52px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    border: 1px solid #eef2f6;
  }

  .section-accent .section-wrap.no-image .section-content {
    border-left: 4px solid var(--red);
  }

  /* Section Image Styling */
  .custom-section .section-image-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.06);
    background: #f8fafc;
  }

  .custom-section .section-image {
    width: 100%;
    max-width: 100%;
    height: auto;
    max-height: 480px;
    object-fit: contain;
    background: #ffffff;
    border-radius: 18px;
    display: block;
    transition: transform 0.4s ease;
  }

  .custom-section .section-image-wrap:hover .section-image {
    transform: scale(1.02);
  }

  /* Judul Seksi Khusus Divisi */
  .custom-section-title {
    display: block;
    width: 100%;
    font-size: 2.2rem;
    font-weight: 800;
    color: #111827;
    margin: 0 0 16px;
    line-height: 1.25;
    letter-spacing: -0.5px;
    position: relative;
  }

  .custom-section-title::after {
    content: '';
    display: block;
    width: 48px;
    height: 4px;
    background: var(--red);
    border-radius: 2px;
    margin-top: 14px;
    margin-bottom: 24px;
  }

  /* Normalisasi konten Summernote agar tidak bertabrakan, tidak mepet, dan sangat nyaman dibaca */
  .custom-section .section-body {
    font-size: 1.02rem;
    color: #334155;
    line-height: 1.9;
    font-family: 'Poppins', sans-serif;
  }

  .custom-section .section-body p,
  .custom-section .section-body span,
  .custom-section .section-body div {
    font-family: 'Poppins', sans-serif !important;
    font-size: 1.02rem !important;
    line-height: 1.9 !important;
    color: #334155 !important;
    text-align: left !important; /* Mencegah justify kaku bawaan WYSIWYG yang membuat kata-kata mepet & renggang aneh */
  }

  .custom-section .section-body p {
    margin-bottom: 20px !important;
  }

  .custom-section .section-body p:last-child {
    margin-bottom: 0 !important;
  }

  .custom-section .section-body strong,
  .custom-section .section-body b {
    color: #0f172a !important;
    font-weight: 700 !important;
  }

  .custom-section .section-body em,
  .custom-section .section-body i {
    font-style: italic;
  }

  .custom-section .section-body ul,
  .custom-section .section-body ol {
    margin: 20px 0 !important;
    padding-left: 26px !important;
  }

  .custom-section .section-body li {
    font-family: 'Poppins', sans-serif !important;
    font-size: 1.02rem !important;
    line-height: 1.8 !important;
    color: #334155 !important;
    margin-bottom: 12px !important;
    padding-left: 6px;
    text-align: left !important;
  }

  .custom-section .section-body li::marker {
    color: var(--red);
    font-weight: 700;
  }

  .custom-section .section-body h3,
  .custom-section .section-body h4 {
    font-size: 1.3rem !important;
    font-weight: 700 !important;
    color: #111827 !important;
    margin: 28px 0 14px !important;
    line-height: 1.35 !important;
  }

  .custom-section .section-body a {
    color: var(--red) !important;
    text-decoration: underline !important;
    font-weight: 600 !important;
    transition: 0.2s;
  }

  .custom-section .section-body a:hover {
    color: #990000 !important;
  }

  .custom-section .section-body table {
    width: 100%;
    border-collapse: collapse;
    margin: 24px 0;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
  }

  .custom-section .section-body td,
  .custom-section .section-body th {
    border: 1px solid #e5e7eb;
    padding: 14px 16px;
    text-align: left;
    font-size: 0.95rem;
  }

  .custom-section .section-body th {
    background: #f8fafc;
    font-weight: 700;
    color: #111827;
  }

  /* Responsif Tablet & Mobile */
  @media (max-width: 992px) {
    .custom-section {
      padding: 60px 0;
    }
    .custom-section .section-wrap.has-image {
      grid-template-columns: 1fr;
      gap: 36px;
    }
    .custom-section .section-wrap.has-image.order-image-left,
    .custom-section .section-wrap.has-image.order-image-right {
      grid-template-columns: 1fr;
    }
    .custom-section .section-wrap.has-image .section-image-wrap {
      order: 1 !important;
      max-width: 580px;
      margin: 0 auto;
    }
    .custom-section .section-wrap.has-image .section-content {
      order: 2 !important;
    }
    .custom-section-title {
      font-size: 1.85rem;
    }
  }

  @media (max-width: 768px) {
    .custom-section {
      padding: 48px 0;
    }
    .custom-section .section-wrap.no-image .section-content {
      padding: 30px 22px;
      border-radius: 14px;
    }
    .custom-section-title {
      font-size: 1.55rem;
      margin-bottom: 14px;
    }
    .custom-section-title::after {
      width: 36px;
      height: 3px;
      margin-top: 10px;
      margin-bottom: 18px;
    }
    .custom-section .section-body,
    .custom-section .section-body p,
    .custom-section .section-body span,
    .custom-section .section-body li {
      font-size: 0.95rem !important;
      line-height: 1.75 !important;
    }
    .custom-section .section-body p {
      margin-bottom: 16px !important;
    }
    .custom-section .section-image-wrap {
      border-radius: 14px;
    }
    .custom-section .section-image {
      border-radius: 14px;
      max-height: 340px;
    }
  }

  /* ================= SLIDER FOTO OTOMATIS KEUNGGULAN DIVISI ================= */
  .keunggulan-slider-wrap {
    position: relative;
    width: 100%;
    min-height: 380px;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.12);
    background: #0f172a;
  }
  .keunggulan-slider-track {
    position: relative;
    width: 100%;
    height: 100%;
    min-height: 380px;
  }
  .keunggulan-slide {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.65s ease-in-out, visibility 0.65s ease-in-out;
  }
  .keunggulan-slide.is-active {
    position: relative;
    opacity: 1;
    visibility: visible;
  }
  .keunggulan-slide .section-image {
    width: 100%;
    height: 380px;
    object-fit: contain;
    background: #ffffff;
    display: block;
    border-radius: 16px;
    padding: 8px;
  }
  .keunggulan-slide-badge {
    position: absolute;
    bottom: 14px;
    left: 14px;
    background: rgba(15, 23, 42, 0.82);
    backdrop-filter: blur(4px);
    color: #ffffff;
    font-size: 0.76rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    z-index: 2;
  }
  .keunggulan-slider-nav {
    position: absolute;
    bottom: 14px;
    right: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(4px);
    padding: 5px 10px;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    z-index: 3;
  }
  .keunggulan-slider-nav button {
    background: transparent;
    border: none;
    color: #ffffff;
    cursor: pointer;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    transition: color 0.2s, transform 0.2s;
  }
  .keunggulan-slider-nav button:hover {
    color: var(--yellow);
    transform: scale(1.15);
  }
  .ks-dots {
    display: flex;
    align-items: center;
    gap: 5px;
  }
  .ks-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.4);
    cursor: pointer;
    transition: all 0.25s;
  }
  .ks-dot.is-active {
    width: 18px;
    border-radius: 10px;
    background: var(--yellow);
  }
  .btn-sec-all-divisi:hover {
    background: #b30000 !important;
    transform: translateY(-2px);
  }
  .btn-sec-program:hover {
    background: #e2e8f0 !important;
  }
</style>
@endpush

@push('scripts')
<script>
(function() {
  function initKeunggulanSliders() {
    var sliders = document.querySelectorAll('.keunggulan-slider-wrap');
    sliders.forEach(function(slider) {
      var slides = slider.querySelectorAll('.keunggulan-slide');
      var dots = slider.querySelectorAll('.ks-dot');
      if (slides.length <= 1) return;
      var cur = 0;
      var timer = null;

      function show(idx) {
        cur = (idx + slides.length) % slides.length;
        slides.forEach(function(s, i) {
          s.classList.toggle('is-active', i === cur);
        });
        dots.forEach(function(d, i) {
          d.classList.toggle('is-active', i === cur);
        });
      }

      function next() { show(cur + 1); }
      function prev() { show(cur - 1); }

      function start() {
        if (!timer) timer = setInterval(next, 3500);
      }
      function stop() {
        if (timer) { clearInterval(timer); timer = null; }
      }

      slider.addEventListener('mouseenter', stop);
      slider.addEventListener('mouseleave', start);

      var prevBtn = slider.querySelector('.ks-prev');
      var nextBtn = slider.querySelector('.ks-next');
      if (prevBtn) prevBtn.addEventListener('click', function(e) { e.preventDefault(); prev(); });
      if (nextBtn) nextBtn.addEventListener('click', function(e) { e.preventDefault(); next(); });

      dots.forEach(function(dot, i) {
        dot.addEventListener('click', function(e) { e.preventDefault(); show(i); });
      });

      start();
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initKeunggulanSliders);
  } else {
    initKeunggulanSliders();
  }
})();
</script>
@endpush
@endonce