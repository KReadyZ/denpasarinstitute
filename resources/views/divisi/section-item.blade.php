@php
  // Tentukan order image/text berdasarkan design
  // light, accent (red) → image kanan (order-2)
  // dark (grey) → image kiri (order-1)
  $imagePosition = in_array($section->design_class, ['section-light', 'section-accent']) 
    ? 'order-image-right' 
    : 'order-image-left';
@endphp

<section class="custom-section {{ $section->design_class }}" id="section-{{ $section->id }}">
  <div class="section-wrap @if($section->image) has-image {{ $imagePosition }} @else no-image @endif">
    
    @if($section->image)
      <div class="section-image-wrap reveal">
        <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->section_name }}" class="section-image" loading="lazy">
      </div>
    @endif

    <div class="section-content reveal">
      <h2 class="custom-section-title">{{ $section->section_name }}</h2>
      <div class="section-body">
        {!! $section->content !!}
      </div>
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
    object-fit: cover;
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
</style>
@endpush
@endonce