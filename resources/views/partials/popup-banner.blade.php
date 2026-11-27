@php
  $bannerActive = \App\Models\SiteSetting::get('popup_banner_active', '1') == '1';
  $bannerImage = \App\Models\SiteSetting::get('popup_banner_image');
  $bannerUrl = \App\Models\SiteSetting::get('popup_banner_url', route('admission.create'));
  $bannerTitle = \App\Models\SiteSetting::get('popup_banner_title', 'Pendaftaran & Kolaborasi Denpasar Institute');
  $bannerDelay = (int)\App\Models\SiteSetting::get('popup_banner_delay', '2');
@endphp

@if($bannerActive)
<div id="diPopupBannerModal" class="popup-banner-overlay" role="dialog" aria-modal="true" aria-labelledby="popupBannerTitle">
  <div class="popup-banner-card">
    <button type="button" class="popup-banner-close" onclick="closePopupBanner()" aria-label="Tutup Banner">
      <i class="fas fa-times"></i>
    </button>
    <div class="popup-banner-body">
      @if($bannerUrl)
        <a href="{{ $bannerUrl }}" class="popup-banner-link" target="{{ str_starts_with($bannerUrl, 'http') ? '_blank' : '_self' }}">
      @endif

      @if($bannerImage)
        <img src="{{ asset('storage/' . $bannerImage) }}" alt="{{ $bannerTitle }}" class="popup-banner-img">
      @else
        <div class="popup-banner-default">
          <div class="popup-banner-header-default">
            <img src="{{ \App\Models\SiteSetting::getLogoUrl() }}" alt="Logo" class="popup-banner-logo" onerror="this.src='/image/Logo_DI.png';">
            <span class="popup-banner-badge">PENGUMUMAN RESMI</span>
          </div>
          <h3 id="popupBannerTitle" class="popup-banner-heading">{{ $bannerTitle }}</h3>
          <p class="popup-banner-text">
            Bergabunglah dalam ekosistem riset, pendidikan vokasi, publikasi ilmiah, dan kemitraan strategis bersama <strong>Denpasar Institute</strong>.
          </p>
          <div class="popup-banner-cta">
            <span>Daftar / Pelajari Selengkapnya <i class="fas fa-arrow-right"></i></span>
          </div>
        </div>
      @endif

      @if($bannerUrl)
        </a>
      @endif
    </div>
  </div>
</div>

<style>
.popup-banner-overlay {
  position: fixed;
  inset: 0;
  background: rgba(10, 10, 15, 0.75);
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);
  z-index: 999999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 16px;
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
  max-width: 580px;
  background: #ffffff;
  border-radius: 16px;
  box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
  overflow: hidden;
  transform: translateY(20px) scale(0.96);
  transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
  border: 1px solid rgba(255, 255, 255, 0.2);
}
.popup-banner-overlay.is-active .popup-banner-card {
  transform: translateY(0) scale(1);
}
.popup-banner-close {
  position: absolute;
  top: 10px;
  right: 10px;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: rgba(0, 0, 0, 0.65);
  color: #ffffff;
  border: 2px solid #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 10;
  font-size: 1rem;
  transition: all 0.2s ease;
}
.popup-banner-close:hover {
  background: var(--red, #cc0000);
  transform: rotate(90deg);
}
.popup-banner-body {
  position: relative;
  width: 100%;
  overflow: hidden;
}
.popup-banner-link {
  display: block;
  text-decoration: none;
  color: inherit;
}
.popup-banner-img {
  width: 100%;
  height: auto;
  max-height: 80vh;
  object-fit: contain;
  display: block;
  transition: transform 0.3s ease;
}
.popup-banner-link:hover .popup-banner-img {
  transform: scale(1.015);
}
.popup-banner-default {
  padding: 36px 30px 30px;
  background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
  color: #ffffff;
  text-align: center;
}
.popup-banner-header-default {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin-bottom: 16px;
}
.popup-banner-logo {
  height: 42px;
  width: auto;
  object-fit: contain;
}
.popup-banner-badge {
  font-size: 0.7rem;
  font-weight: 800;
  letter-spacing: 1px;
  background: var(--red, #cc0000);
  color: #fff;
  padding: 3px 10px;
  border-radius: 20px;
}
.popup-banner-heading {
  font-size: 1.35rem;
  font-weight: 800;
  color: #ffffff;
  margin-bottom: 12px;
  line-height: 1.3;
}
.popup-banner-text {
  font-size: 0.92rem;
  color: #cbd5e1;
  line-height: 1.6;
  margin-bottom: 22px;
}
.popup-banner-cta {
  display: inline-block;
  background: var(--red, #cc0000);
  color: #ffffff;
  font-weight: 700;
  padding: 10px 24px;
  border-radius: 25px;
  font-size: 0.9rem;
  box-shadow: 0 4px 15px rgba(204, 0, 0, 0.4);
  transition: transform 0.2s, background 0.2s;
}
.popup-banner-link:hover .popup-banner-cta {
  background: #b30000;
  transform: translateY(-2px);
}
@media (max-width: 600px) {
  .popup-banner-card {
    max-width: 95%;
  }
  .popup-banner-default {
    padding: 30px 20px 24px;
  }
  .popup-banner-heading {
    font-size: 1.15rem;
  }
  .popup-banner-text {
    font-size: 0.85rem;
  }
}
</style>

<script>
(function() {
  function checkAndShowPopupBanner() {
    var modal = document.getElementById('diPopupBannerModal');
    if (!modal) return;

    // Cek sessionStorage agar tidak muncul berulang kali di sesi yang sama jika sudah ditutup
    if (sessionStorage.getItem('di_banner_dismissed') === '1') {
      return;
    }

    var delaySec = {{ $bannerDelay }};
    setTimeout(function() {
      modal.classList.add('is-active');
      document.body.style.overflow = 'hidden';
    }, Math.max(500, delaySec * 1000));
  }

  window.closePopupBanner = function() {
    var modal = document.getElementById('diPopupBannerModal');
    if (modal) {
      modal.classList.remove('is-active');
      document.body.style.overflow = '';
      sessionStorage.setItem('di_banner_dismissed', '1');
    }
  };

  document.addEventListener('DOMContentLoaded', checkAndShowPopupBanner);
  if (document.readyState === 'interactive' || document.readyState === 'complete') {
    checkAndShowPopupBanner();
  }

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
