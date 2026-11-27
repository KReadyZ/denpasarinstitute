@php
  $bannerActive = \App\Models\SiteSetting::get('popup_banner_active', '1') == '1';
  $bannerImage = \App\Models\SiteSetting::get('popup_banner_image');
  $bannerUrl = \App\Models\SiteSetting::get('popup_banner_url', route('admission.create'));
  $bannerBadge = \App\Models\SiteSetting::get('popup_banner_badge', 'PENGUMUMAN RESMI');
  $bannerSubtitle = \App\Models\SiteSetting::get('popup_banner_subtitle', 'Program Pendidikan, Riset & Kemitraan');
  $bannerTitle = \App\Models\SiteSetting::get('popup_banner_title', 'Pendaftaran & Kolaborasi Denpasar Institute');
  $bannerDesc = \App\Models\SiteSetting::get('popup_banner_desc', 'Bergabunglah dalam program pendidikan vokasi, riset terapan, publikasi ilmiah, serta kemitraan strategis bersama Denpasar Institute. Konsultasikan kebutuhan Anda sekarang bersama tim kami.');
  $bannerBtnText = \App\Models\SiteSetting::get('popup_banner_btn_text', 'Daftar / Pelajari Selengkapnya');
  $bannerDelay = (int)\App\Models\SiteSetting::get('popup_banner_delay', '2');
@endphp

@if($bannerActive)
<div id="diPopupBannerModal" class="popup-banner-overlay" role="dialog" aria-modal="true" aria-labelledby="popupBannerTitle">
  <div class="popup-banner-card">
    {{-- Header Top Bar --}}
    <div class="popup-banner-topbar">
      <div class="popup-banner-brand">
        <img src="{{ \App\Models\SiteSetting::getLogoUrl() }}" alt="Denpasar Institute" class="popup-banner-brand-logo" onerror="this.src='/image/Logo_DI.png';">
        <div class="popup-banner-brand-meta">
          <span class="popup-banner-brand-name">DENPASAR INSTITUTE</span>
          <span class="popup-banner-badge">{{ $bannerBadge }}</span>
        </div>
      </div>
      <button type="button" class="popup-banner-close" onclick="closePopupBanner()" aria-label="Tutup Pop Up" title="Tutup (Esc)">
        <i class="fas fa-times"></i>
      </button>
    </div>

    {{-- Main Body --}}
    <div class="popup-banner-body">
      {{-- Gambar Banner / Poster (Bila Ada) --}}
      @if($bannerImage)
        <div class="popup-banner-media">
          <a href="{{ $bannerUrl }}" class="popup-banner-media-link" target="{{ str_starts_with($bannerUrl, 'http') ? '_blank' : '_self' }}">
            <img src="{{ asset('storage/' . $bannerImage) }}" alt="{{ $bannerTitle }}" class="popup-banner-img" onerror="this.onerror=null;this.src='/image/partner-hero-bg.jpg';">
            <span class="popup-banner-media-hint">
              <i class="fas fa-external-link-alt me-1"></i> Klik untuk Buka Halaman
            </span>
          </a>
        </div>
      @endif

      {{-- Konten Informasi & Tulisan --}}
      <div class="popup-banner-content">
        @if(!empty($bannerSubtitle))
          <div class="popup-banner-subtitle">
            <i class="fas fa-bullhorn me-1.5 text-danger"></i> {{ $bannerSubtitle }}
          </div>
        @endif

        <h3 id="popupBannerTitle" class="popup-banner-heading">
          {{ $bannerTitle }}
        </h3>

        @if(!empty($bannerDesc))
          <p class="popup-banner-text">
            {!! nl2br(e($bannerDesc)) !!}
          </p>
        @endif

        {{-- Highlight Keunggulan / Trust Points --}}
        <div class="popup-banner-highlights">
          <div class="popup-highlight-item">
            <i class="fas fa-certificate text-danger"></i>
            <span>Lembaga Riset &amp; Pendidikan Terverifikasi</span>
          </div>
          <div class="popup-highlight-item">
            <i class="fas fa-user-graduate text-success"></i>
            <span>Bimbingan Ahli &amp; Praktisi Berpengalaman</span>
          </div>
        </div>

        {{-- Tombol Aksi / Call to Action --}}
        <div class="popup-banner-actions">
          <a href="{{ $bannerUrl }}" class="btn-popup-primary" target="{{ str_starts_with($bannerUrl, 'http') ? '_blank' : '_self' }}">
            <span>{{ $bannerBtnText }}</span>
            <i class="fas fa-arrow-right ms-2"></i>
          </a>
          <button type="button" class="btn-popup-secondary" onclick="closePopupBanner()">
            Nanti Saja
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.popup-banner-overlay {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.78);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  z-index: 999999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 18px;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.35s ease, visibility 0.35s ease;
}
.popup-banner-overlay.is-active {
  opacity: 1;
  visibility: visible;
}
.popup-banner-card {
  position: relative;
  width: 100%;
  max-width: 560px;
  background: #ffffff;
  border-radius: 20px;
  box-shadow: 0 25px 65px -12px rgba(0, 0, 0, 0.55), 0 0 0 1px rgba(255, 255, 255, 0.15);
  overflow: hidden;
  transform: translateY(24px) scale(0.96);
  transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
  display: flex;
  flex-direction: column;
}
.popup-banner-overlay.is-active .popup-banner-card {
  transform: translateY(0) scale(1);
}

/* Header Top Bar */
.popup-banner-topbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 20px;
  background: #ffffff;
  border-bottom: 1px solid #f1f5f9;
}
.popup-banner-brand {
  display: flex;
  align-items: center;
  gap: 12px;
}
.popup-banner-brand-logo {
  height: 34px;
  width: auto;
  object-fit: contain;
}
.popup-banner-brand-meta {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
}
.popup-banner-brand-name {
  font-size: 0.8rem;
  font-weight: 800;
  letter-spacing: 0.8px;
  color: #0f172a;
}
.popup-banner-badge {
  font-size: 0.65rem;
  font-weight: 800;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  background: linear-gradient(135deg, #cc0000 0%, #990000 100%);
  color: #ffffff;
  padding: 3px 9px;
  border-radius: 999px;
  box-shadow: 0 2px 6px rgba(204, 0, 0, 0.25);
}
.popup-banner-close {
  width: 34px;
  height: 34px;
  border-radius: 50%;
  background: #f1f5f9;
  color: #64748b;
  border: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  font-size: 0.95rem;
  transition: all 0.2s ease;
  flex-shrink: 0;
}
.popup-banner-close:hover {
  background: #cc0000;
  color: #ffffff;
  border-color: #cc0000;
  transform: rotate(90deg);
}

/* Main Body */
.popup-banner-body {
  position: relative;
  width: 100%;
  overflow-y: auto;
  max-height: calc(88vh - 70px);
}

/* Media Banner */
.popup-banner-media {
  position: relative;
  background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
  border-bottom: 1px solid #e2e8f0;
  overflow: hidden;
  text-align: center;
  padding: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.popup-banner-media-link {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  position: relative;
  text-decoration: none;
}
.popup-banner-img {
  max-width: 100%;
  width: auto;
  height: auto;
  max-height: 250px;
  object-fit: contain;
  border-radius: 10px;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
  display: block;
  margin: 0 auto;
  transition: transform 0.3s ease;
}
.popup-banner-media-link:hover .popup-banner-img {
  transform: scale(1.02);
}
.popup-banner-media-hint {
  position: absolute;
  bottom: 8px;
  right: 10px;
  background: rgba(15, 23, 42, 0.75);
  color: #ffffff;
  font-size: 0.7rem;
  font-weight: 600;
  padding: 3px 8px;
  border-radius: 6px;
  backdrop-filter: blur(4px);
  opacity: 0;
  transition: opacity 0.2s ease;
}
.popup-banner-media-link:hover .popup-banner-media-hint {
  opacity: 1;
}

/* Content Area */
.popup-banner-content {
  padding: 22px 24px 24px;
  background: #ffffff;
}
.popup-banner-subtitle {
  font-size: 0.74rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.8px;
  color: #cc0000;
  margin-bottom: 6px;
  display: flex;
  align-items: center;
}
.popup-banner-heading {
  font-size: 1.28rem;
  font-weight: 800;
  color: #0f172a;
  line-height: 1.35;
  margin-bottom: 10px;
  letter-spacing: -0.3px;
}
.popup-banner-text {
  font-size: 0.88rem;
  color: #475569;
  line-height: 1.6;
  margin-bottom: 16px;
}

/* Highlights */
.popup-banner-highlights {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
  margin-bottom: 20px;
}
.popup-highlight-item {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  padding: 7px 10px;
  font-size: 0.74rem;
  font-weight: 600;
  color: #334155;
  display: flex;
  align-items: center;
  gap: 7px;
  line-height: 1.3;
}

/* Action Buttons */
.popup-banner-actions {
  display: flex;
  align-items: center;
  gap: 10px;
}
.btn-popup-primary {
  flex: 1;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #cc0000 0%, #a80000 100%);
  color: #ffffff !important;
  font-weight: 700;
  font-size: 0.88rem;
  padding: 11px 20px;
  border-radius: 999px;
  text-decoration: none !important;
  box-shadow: 0 4px 14px rgba(204, 0, 0, 0.35);
  transition: all 0.25s ease;
}
.btn-popup-primary:hover {
  background: linear-gradient(135deg, #e60000 0%, #b30000 100%);
  box-shadow: 0 6px 20px rgba(204, 0, 0, 0.45);
  transform: translateY(-1.5px);
  color: #ffffff !important;
}
.btn-popup-secondary {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: #f1f5f9;
  color: #475569;
  border: 1px solid #e2e8f0;
  font-weight: 600;
  font-size: 0.85rem;
  padding: 11px 18px;
  border-radius: 999px;
  cursor: pointer;
  transition: all 0.2s ease;
}
.btn-popup-secondary:hover {
  background: #e2e8f0;
  color: #0f172a;
}

@media (max-width: 576px) {
  .popup-banner-card {
    max-width: 100%;
    border-radius: 16px;
  }
  .popup-banner-topbar {
    padding: 12px 16px;
  }
  .popup-banner-brand-logo {
    height: 28px;
  }
  .popup-banner-brand-name {
    font-size: 0.72rem;
  }
  .popup-banner-img {
    max-height: 180px;
  }
  .popup-banner-content {
    padding: 16px 16px 20px;
  }
  .popup-banner-heading {
    font-size: 1.1rem;
  }
  .popup-banner-text {
    font-size: 0.82rem;
  }
  .popup-banner-highlights {
    grid-template-columns: 1fr;
    gap: 6px;
  }
  .popup-banner-actions {
    flex-direction: column;
    gap: 8px;
  }
  .btn-popup-primary, .btn-popup-secondary {
    width: 100%;
  }
}
</style>

<script>
(function() {
  function checkAndShowPopupBanner() {
    var modal = document.getElementById('diPopupBannerModal');
    if (!modal) return;

    var delaySec = {{ $bannerDelay }};
    setTimeout(function() {
      modal.classList.add('is-active');
      document.body.style.overflow = 'hidden';
    }, Math.max(400, delaySec * 1000));
  }

  window.closePopupBanner = function() {
    var modal = document.getElementById('diPopupBannerModal');
    if (modal) {
      modal.classList.remove('is-active');
      document.body.style.overflow = '';
      try { sessionStorage.removeItem('di_banner_dismissed'); } catch(e) {}
    }
  };

  document.addEventListener('DOMContentLoaded', checkAndShowPopupBanner);
  if (document.readyState === 'interactive' || document.readyState === 'complete') {
    checkAndShowPopupBanner();
  }

  // Tutup dengan tombol Escape di keyboard
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' || e.key === 'Esc') {
      window.closePopupBanner();
    }
  });

  // Klik di luar card untuk menutup
  var modalEl = document.getElementById('diPopupBannerModal');
  if (modalEl) {
    modalEl.addEventListener('click', function(e) {
      if (e.target === modalEl) {
        window.closePopupBanner();
      }
    });
  }
})();
</script>
@endif
