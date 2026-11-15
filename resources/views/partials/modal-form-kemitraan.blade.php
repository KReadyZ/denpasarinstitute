{{-- Modal Popup Form Kemitraan Denpasar Institute --}}
<div id="modalFormKemitraan" class="di-modal-overlay" style="display:none;" aria-hidden="true" role="dialog" aria-labelledby="modalKemitraanTitle">
  <div class="di-modal-container">
    
    {{-- Modal Header --}}
    <div class="di-modal-header">
      <div class="di-modal-header-text">
        <span class="di-modal-badge"><i class="fas fa-handshake"></i> Formulir Kemitraan</span>
        <h3 id="modalKemitraanTitle" class="di-modal-title">Pengajuan Kerja Sama Strategis</h3>
        <p class="di-modal-sub" id="modalKemitraanSub">Isi data di bawah ini untuk memulai inisiasi kemitraan bersama Denpasar Institute.</p>
      </div>
      <button type="button" class="di-modal-close" onclick="closePartnerModal()" aria-label="Tutup Form">&times;</button>
    </div>

    {{-- Modal Body / Form --}}
    <div class="di-modal-body">
      <form id="formKemitraan" action="{{ route('partner.submit-form') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Hidden / Selected Pillar --}}
        <input type="hidden" name="pillar_slug" id="partner_pillar_slug" value="{{ $slug ?? '' }}">
        <input type="hidden" name="pillar_title" id="partner_pillar_title" value="{{ $data['section_code'] ?? ($data['subtitle'] ?? 'Kemitraan Strategis') }}">



        <div class="di-form-grid">
          
          {{-- 1. Nama PIC --}}
          <div class="di-form-group">
            <label for="nama_pic" class="di-form-label">
              <i class="fas fa-user"></i> Nama PIC / Penanggung Jawab <span class="di-required">*</span>
            </label>
            <input type="text" name="nama_pic" id="nama_pic" class="di-form-control" placeholder="Contoh: Dr. I Made Wijaya, M.Si." required>
            <span class="di-error-msg" id="err_nama_pic"></span>
          </div>

          {{-- 2. Institusi / Perusahaan --}}
          <div class="di-form-group">
            <label for="institusi" class="di-form-label">
              <i class="fas fa-building"></i> Institusi / Perusahaan <span class="di-required">*</span>
            </label>
            <input type="text" name="institusi" id="institusi" class="di-form-control" placeholder="Contoh: Universitas / PT Inovasi Mandiri" required>
            <span class="di-error-msg" id="err_institusi"></span>
          </div>

          {{-- 3. Email --}}
          <div class="di-form-group">
            <label for="email" class="di-form-label">
              <i class="fas fa-envelope"></i> Email Resmi / PIC <span class="di-required">*</span>
            </label>
            <input type="email" name="email" id="email" class="di-form-control" placeholder="nama@institusi.ac.id / nama@perusahaan.com" required>
            <span class="di-error-msg" id="err_email"></span>
          </div>

          {{-- 4. WhatsApp --}}
          <div class="di-form-group">
            <label for="no_wa" class="di-form-label">
              <i class="fab fa-whatsapp"></i> Nomor WhatsApp Aktif <span class="di-required">*</span>
            </label>
            <input type="tel" name="no_wa" id="no_wa" class="di-form-control" placeholder="081234567890" required>
            <span class="di-error-msg" id="err_no_wa"></span>
          </div>

          {{-- 5. Link Google Maps --}}
          <div class="di-form-group di-full-col">
            <label for="link_gmap" class="di-form-label">
              <i class="fas fa-map-marked-alt"></i> Link Google Maps Kantor / Kampus
            </label>
            <input type="text" name="link_gmap" id="link_gmap" class="di-form-control" placeholder="Contoh: https://maps.app.goo.gl/...">
            <span class="di-help-text">Salin tautan lokasi Google Maps institusi / kantor Anda (opsional).</span>
          </div>

          {{-- 6. Website Institusi / Perusahaan --}}
          <div class="di-form-group">
            <label for="website" class="di-form-label">
              <i class="fas fa-globe"></i> Website Institusi / Perusahaan
            </label>
            <input type="text" name="website" id="website" class="di-form-control" placeholder="Contoh: https://www.institusi.ac.id">
          </div>

          {{-- 7. Unggah Logo Institusi / Perusahaan --}}
          <div class="di-form-group">
            <label for="logo" class="di-form-label">
              <i class="fas fa-image"></i> Unggah Logo Institusi / Perusahaan
            </label>
            <div class="di-file-upload-wrap">
              <input type="file" name="logo" id="logo" class="di-file-input" accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml" onchange="previewLogoFile(this)">
              <div class="di-file-upload-box" id="fileUploadBox">
                <i class="fas fa-cloud-upload-alt di-upload-icon"></i>
                <div class="di-upload-text" id="uploadText">Klik untuk memilih berkas logo</div>
                <div class="di-upload-hint">PNG, JPG, WebP atau SVG (Maks. 3MB)</div>
              </div>
              <div id="logoPreviewWrap" style="display:none;" class="di-logo-preview">
                <img id="logoPreviewImg" src="" alt="Preview Logo">
                <button type="button" class="di-remove-logo-btn" onclick="clearLogoUpload()" title="Hapus berkas">&times;</button>
              </div>
            </div>
            <span class="di-error-msg" id="err_logo"></span>
          </div>

          {{-- Catatan / Pesan Singkat (Opsional) --}}
          <div class="di-form-group di-full-col">
            <label for="pesan" class="di-form-label">
              <i class="fas fa-comment-alt"></i> Catatan / Harapan Kerja Sama (Opsional)
            </label>
            <textarea name="pesan" id="pesan" class="di-form-control" rows="2" placeholder="Tuliskan gambaran singkat rencana kemitraan, kebutuhan riset, sertifikasi, atau inisiatif yang ingin dijalankan..."></textarea>
          </div>

        </div>

        {{-- Form Actions --}}
        <div class="di-modal-footer">
          <button type="button" class="di-btn-cancel" onclick="closePartnerModal()">Batal</button>
          <button type="submit" class="di-btn-submit" id="btnSubmitKemitraan">
            <span class="btn-text"><i class="fas fa-paper-plane"></i> Kirim Formulir Kemitraan</span>
            <span class="btn-spinner" style="display:none;"><i class="fas fa-spinner fa-spin"></i> Mengirim...</span>
          </button>
        </div>

      </form>
    </div>

  </div>
</div>

{{-- Styles khusus modal popup kemitraan --}}
<style>
  .di-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.72);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    opacity: 0;
    transition: opacity 0.28s ease;
  }
  .di-modal-overlay.active {
    opacity: 1;
  }
  .di-modal-container {
    background: #ffffff;
    border-radius: 20px;
    max-width: 680px;
    width: 100%;
    max-height: 92vh;
    overflow-y: auto;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
    border: 1px solid rgba(255, 255, 255, 0.8);
    transform: translateY(20px) scale(0.96);
    transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1);
    display: flex;
    flex-direction: column;
  }
  .di-modal-overlay.active .di-modal-container {
    transform: translateY(0) scale(1);
  }
  .di-modal-header {
    background: linear-gradient(135deg, #CC0000 0%, #990000 55%, #180303 100%);
    color: #ffffff;
    padding: 26px 30px 22px;
    position: relative;
    border-top-left-radius: 19px;
    border-top-right-radius: 19px;
  }
  .di-modal-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(245, 196, 0, 0.2);
    border: 1px solid #F5C400;
    color: #F5C400;
    font-size: 0.78rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 4px 12px;
    border-radius: 20px;
    margin-bottom: 10px;
  }
  .di-modal-title {
    font-size: 1.55rem;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 6px;
    letter-spacing: -0.3px;
  }
  .di-modal-sub {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.88);
    margin: 0;
    line-height: 1.5;
  }
  .di-modal-close {
    position: absolute;
    top: 20px;
    right: 22px;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.16);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #ffffff;
    font-size: 1.6rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    line-height: 1;
    transition: all 0.2s ease;
  }
  .di-modal-close:hover {
    background: #ffffff;
    color: #CC0000;
    transform: rotate(90deg);
  }
  .di-modal-body {
    padding: 26px 30px;
  }
  .di-form-pillar-banner {
    background: #fef2f2;
    border: 1.5px solid #fecaca;
    border-left: 5px solid #CC0000;
    border-radius: 12px;
    padding: 12px 18px;
    margin-bottom: 22px;
    display: flex;
    align-items: center;
    gap: 14px;
    color: #1e293b;
  }
  .di-form-pillar-banner i {
    color: #CC0000;
    font-size: 1.4rem;
  }
  .di-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px 20px;
  }
  .di-full-col {
    grid-column: 1 / -1;
  }
  .di-form-group {
    display: flex;
    flex-direction: column;
  }
  .di-form-label {
    font-size: 0.88rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 7px;
    display: flex;
    align-items: center;
    gap: 7px;
  }
  .di-form-label i {
    color: #CC0000;
    font-size: 0.86rem;
  }
  .di-required {
    color: #CC0000;
    font-weight: 800;
  }
  .di-form-control {
    width: 100%;
    padding: 11px 15px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.93rem;
    color: #1e293b;
    background: #f8fafc;
    transition: all 0.2s ease;
    font-family: inherit;
    box-sizing: border-box;
  }
  .di-form-control:focus {
    outline: none;
    border-color: #CC0000;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(204, 0, 0, 0.12);
  }
  .di-help-text {
    font-size: 0.78rem;
    color: #64748b;
    margin-top: 5px;
  }
  .di-error-msg {
    font-size: 0.8rem;
    color: #dc2626;
    margin-top: 4px;
    display: none;
    font-weight: 600;
  }
  .di-file-upload-wrap {
    position: relative;
    border: 1.5px dashed #cbd5e1;
    border-radius: 10px;
    padding: 12px;
    text-align: center;
    background: #f8fafc;
    transition: all 0.2s ease;
    cursor: pointer;
  }
  .di-file-upload-wrap:hover {
    border-color: #CC0000;
    background: #fffdfd;
  }
  .di-file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
  }
  .di-upload-icon {
    font-size: 1.5rem;
    color: #CC0000;
    margin-bottom: 4px;
  }
  .di-upload-text {
    font-size: 0.85rem;
    font-weight: 700;
    color: #334155;
  }
  .di-upload-hint {
    font-size: 0.74rem;
    color: #94a3b8;
  }
  .di-logo-preview {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    padding: 6px;
    background: #ffffff;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
  }
  .di-logo-preview img {
    max-height: 55px;
    max-width: 100%;
    object-fit: contain;
  }
  .di-remove-logo-btn {
    position: absolute;
    top: -6px;
    right: -6px;
    width: 22px;
    height: 22px;
    background: #dc2626;
    color: #ffffff;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 1rem;
    line-height: 1;
    z-index: 5;
  }
  .di-modal-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
    padding-top: 18px;
    border-top: 1.5px solid #f1f5f9;
  }
  .di-btn-cancel {
    padding: 12px 22px;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 0.92rem;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .di-btn-cancel:hover {
    background: #e2e8f0;
    color: #0f172a;
  }
  .di-btn-submit {
    padding: 12px 28px;
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg, #CC0000 0%, #a00000 100%);
    color: #ffffff;
    font-weight: 800;
    font-size: 0.95rem;
    cursor: pointer;
    box-shadow: 0 6px 18px rgba(204, 0, 0, 0.35);
    display: inline-flex;
    align-items: center;
    gap: 9px;
    transition: all 0.2s ease;
  }
  .di-btn-submit:hover {
    background: linear-gradient(135deg, #b30000 0%, #850000 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(204, 0, 0, 0.45);
  }
  .di-btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
  }

  @media (max-width: 640px) {
    .di-modal-header { padding: 22px 20px 18px; }
    .di-modal-body { padding: 20px 18px; }
    .di-modal-title { font-size: 1.25rem; }
    .di-form-grid { grid-template-columns: 1fr; gap: 14px; }
    .di-modal-footer { flex-direction: column-reverse; }
    .di-btn-cancel, .di-btn-submit { width: 100%; justify-content: center; }
  }
</style>

{{-- SweetAlert2 CDN jika belum terpasang --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Script Modal & AJAX Handler --}}
<script>
  function openPartnerModal(pillarSlug, pillarTitle) {
    const modal = document.getElementById('modalFormKemitraan');
    if (!modal) return;

    if (pillarSlug) {
      const slugInput = document.getElementById('partner_pillar_slug');
      if (slugInput) slugInput.value = pillarSlug;
    }
    if (pillarTitle) {
      const titleInput = document.getElementById('partner_pillar_title');
      const bannerText = document.getElementById('pillarBannerText');
      if (titleInput) titleInput.value = pillarTitle;
      if (bannerText) bannerText.textContent = pillarTitle;
    }

    modal.style.display = 'flex';
    setTimeout(() => {
      modal.classList.add('active');
    }, 10);
    document.body.style.overflow = 'hidden';
  }

  function closePartnerModal() {
    const modal = document.getElementById('modalFormKemitraan');
    if (!modal) return;

    modal.classList.remove('active');
    setTimeout(() => {
      modal.style.display = 'none';
      document.body.style.overflow = '';
    }, 280);
  }

  // Close when clicking outside container
  document.addEventListener('click', function(e) {
    const modal = document.getElementById('modalFormKemitraan');
    if (modal && e.target === modal) {
      closePartnerModal();
    }
  });

  // Close on Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closePartnerModal();
    }
  });

  // Preview logo file
  function previewLogoFile(input) {
    const box = document.getElementById('fileUploadBox');
    const wrap = document.getElementById('logoPreviewWrap');
    const img = document.getElementById('logoPreviewImg');
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        img.src = e.target.result;
        box.style.display = 'none';
        wrap.style.display = 'flex';
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  function clearLogoUpload() {
    const input = document.getElementById('logo');
    const box = document.getElementById('fileUploadBox');
    const wrap = document.getElementById('logoPreviewWrap');
    const img = document.getElementById('logoPreviewImg');
    if (input) input.value = '';
    if (img) img.src = '';
    if (wrap) wrap.style.display = 'none';
    if (box) box.style.display = 'block';
  }

  // Handle Form Submission via AJAX
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formKemitraan');
    if (!form) return;

    form.addEventListener('submit', function(e) {
      e.preventDefault();

      const btn = document.getElementById('btnSubmitKemitraan');
      const btnText = btn.querySelector('.btn-text');
      const btnSpinner = btn.querySelector('.btn-spinner');

      // Clear previous error messages
      document.querySelectorAll('.di-error-msg').forEach(el => {
        el.textContent = '';
        el.style.display = 'none';
      });

      // Disable button & show spinner
      btn.disabled = true;
      btnText.style.display = 'none';
      btnSpinner.style.display = 'inline-flex';

      const formData = new FormData(form);

      fetch(form.action, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
        },
        body: formData
      })
      .then(response => response.json().then(data => ({ status: response.status, body: data })))
      .then(({ status, body }) => {
        btn.disabled = false;
        btnText.style.display = 'inline-flex';
        btnSpinner.style.display = 'none';

        if (status === 200 && body.success) {
          closePartnerModal();
          form.reset();
          clearLogoUpload();

          Swal.fire({
            icon: 'success',
            title: '<span style="color:#CC0000;font-weight:800;">Pengajuan Kemitraan Berhasil!</span>',
            html: `
              <p style="font-size:0.95rem;color:#475569;margin-bottom:16px;">
                Terima kasih <strong>${body.data.nama_pic}</strong>. Formulir kemitraan dari <strong>${body.data.institusi}</strong> telah kami terima.
              </p>
              <p style="font-size:0.88rem;color:#64748b;margin-bottom:12px;">
                Permohonan kemitraan Anda telah masuk ke tahap <strong>verifikasi</strong> oleh Super Admin. Setelah diverifikasi &amp; disetujui, logo institusi Anda akan resmi tampil di halaman publik <strong>Mitra &amp; Klien</strong>.
              </p>
              <p style="font-size:0.84rem;color:#94a3b8;">
                Tim kami juga akan segera menindaklanjuti dan menghubungi kontak PIC Anda.
              </p>
            `,
            showCancelButton: true,
            confirmButtonColor: '#25D366',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fab fa-whatsapp"></i> Chat WhatsApp Sekarang',
            cancelButtonText: 'Selesai',
            reverseButtons: true,
            customClass: {
              popup: 'rounded-4'
            }
          }).then((result) => {
            if (result.isConfirmed && body.wa_url) {
              window.open(body.wa_url, '_blank');
            }
          });

        } else if (status === 422 && body.errors) {
          // Validation errors
          for (const [key, msgs] of Object.entries(body.errors)) {
            const errEl = document.getElementById('err_' + key);
            if (errEl) {
              errEl.textContent = msgs[0];
              errEl.style.display = 'block';
            }
          }
          Swal.fire({
            icon: 'warning',
            title: 'Isian Belum Lengkap',
            text: 'Mohon periksa kembali kolom formulir yang bertanda wajib.',
            confirmButtonColor: '#CC0000',
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal Mengirim',
            text: body.message || 'Terjadi kesalahan sistem, silakan coba lagi.',
            confirmButtonColor: '#CC0000',
          });
        }
      })
      .catch(err => {
        btn.disabled = false;
        btnText.style.display = 'inline-flex';
        btnSpinner.style.display = 'none';

        Swal.fire({
          icon: 'error',
          title: 'Koneksi Bermasalah',
          text: 'Gagal terhubung ke server. Silakan periksa jaringan internet Anda.',
          confirmButtonColor: '#CC0000',
        });
      });

    });
  });
</script>

