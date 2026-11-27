<!-- Modal Tentang Denpasar Institute -->
<div id="tentangDiModal" class="modal-tentang-overlay" onclick="handleTentangBackdropClick(event)" role="dialog" aria-modal="true" aria-labelledby="modalTentangTitle">
  <div class="modal-tentang-card">
    <div class="modal-tentang-header">
      <div class="modal-tentang-brand">
        <img src="{{ \App\Models\SiteSetting::getLogoUrl() }}" alt="Logo Denpasar Institute" class="modal-tentang-logo" onerror="this.src='{{ asset('image/Logo_DI.png') }}';">
        <div>
          <span class="modal-tentang-label">Profil Resmi Lembaga</span>
          <h3 id="modalTentangTitle" class="modal-tentang-title">Tentang Denpasar Institute</h3>
        </div>
      </div>
      <button type="button" class="modal-tentang-close" onclick="closeTentangModal()" aria-label="Tutup Modal">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <div class="modal-tentang-body">
      <div class="modal-tentang-quote">
        <i class="fas fa-quote-left quote-icon"></i>
        <div class="quote-text">
          <strong>"Transforming Ideas into Action"</strong>
          <span>Menerjemahkan ide dan kebutuhan partners &amp; clients menjadi tindakan nyata berdaya saing global.</span>
        </div>
      </div>

      <div class="modal-tentang-desc">
        <p>
          <strong>Denpasar Institute</strong> adalah Lembaga Riset &amp; Pengembangan SDM. Kami menyediakan layanan kerja sama <strong>Riset</strong>, <strong>Pengembangan SDM</strong>, <strong>Jasa Konsultan</strong>, Kolaborasi Program <strong><em>CSR (Corporate Social Responsibility)</em></strong> dan <strong>Layanan Informasi Objektif</strong>. Prioritas kami berfokus pada moto <strong><em>"Transforming Ideas into Action"</em></strong>, yakni menerjemahkan ide dan kebutuhan <em>partners &amp; clients</em> menjadi tindakan nyata.
        </p>
        <p>
          Denpasar Institute ditunjuk oleh berbagai perusahaan dan lembaga pendidikan sebagai konsultan bidang pendidikan, pariwisata, <em>research based business plan, SROI (Social Return on Investment), training management, R &amp; D (Research &amp; Development), SOP Development, institutional repository development,</em> penjaminan mutu dan pengembangan sistem aplikasi terintegrasi.
        </p>
        <p>
          Kami melakukan riset dengan metode kualitatif, kuantitatif dan <em>mixed-methods</em>. Kami berperan aktif dalam kerja sama riset bidang sumber daya manusia, sains data, sosial budaya, ekonomi, pariwisata, pendidikan, pertanian, teknologi informasi, kesehatan, dan dampak kebijakan publik yang secara implementatif dikelola oleh unit Program Riset dan Pusat Kajian.
        </p>
      </div>

      <div class="modal-tentang-section" id="modalSectionDivisi">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:8px;">
          <h4 class="section-title" style="margin-bottom:0;"><i class="fas fa-cubes text-danger"></i> Unit Kerja &amp; Divisi Layanan</h4>
          <span style="font-size:0.78rem; color:#64748b; font-weight:600;"><i class="fas fa-mouse-pointer me-1 text-danger"></i>Klik kotak divisi untuk melihat detail &amp; program</span>
        </div>
        <div class="divisi-info-grid">
          <a href="{{ route('divisi.show', 'divisi-riset-dan-inovasi') }}" class="divisi-info-card" onclick="closeTentangModal()" title="Buka Detail Divisi Riset dan Inovasi">
            <div class="divisi-info-icon"><i class="fas fa-microscope"></i></div>
            <div class="divisi-info-content">
              <div class="divisi-title-wrap">
                <strong>Divisi Riset dan Inovasi</strong>
                <span class="divisi-card-arrow"><i class="fas fa-arrow-right"></i></span>
              </div>
              <p>Meningkatkan kapasitas riset, kolaborasi <em>Research and Development (R &amp; D)</em>, membangun jejaring ilmiah <em>(science networking)</em>, dan menjadi wadah kolaboratif bagi akademisi &amp; praktisi.</p>
            </div>
          </a>

          <a href="{{ route('divisi.show', 'divisi-sains-data-dan-ti') }}" class="divisi-info-card" onclick="closeTentangModal()" title="Buka Detail Divisi Sains Data & Teknologi Informasi">
            <div class="divisi-info-icon"><i class="fas fa-database"></i></div>
            <div class="divisi-info-content">
              <div class="divisi-title-wrap">
                <strong>Divisi Sains Data &amp; Teknologi Informasi</strong>
                <span class="divisi-card-arrow"><i class="fas fa-arrow-right"></i></span>
              </div>
              <p>Berfokus pada pengembangan <em>data science</em>, program <em>coding</em> &amp; <em>data management</em>, short courses &amp; statistics training, repository development, website &amp; aplikasi, serta SIM pendidikan.</p>
            </div>
          </a>

          <a href="{{ route('divisi.show', 'divisi-publikasi-dan-hki') }}" class="divisi-info-card" onclick="closeTentangModal()" title="Buka Detail Divisi Publikasi dan HKI">
            <div class="divisi-info-icon"><i class="fas fa-book-open"></i></div>
            <div class="divisi-info-content">
              <div class="divisi-title-wrap">
                <strong>Divisi Publikasi dan HKI</strong>
                <span class="divisi-card-arrow"><i class="fas fa-arrow-right"></i></span>
              </div>
              <p>Asistensi bagi para mitra untuk menerbitkan buku ber-ISBN dan artikel ilmiah pada jurnal ber-ISSN nasional terakreditasi maupun jurnal internasional bereputasi, serta perlindungan HKI.</p>
            </div>
          </a>

          <a href="{{ route('divisi.show', 'divisi-pengembangan-sdm') }}" class="divisi-info-card" onclick="closeTentangModal()" title="Buka Detail Divisi Pengembangan SDM">
            <div class="divisi-info-icon"><i class="fas fa-user-graduate"></i></div>
            <div class="divisi-info-content">
              <div class="divisi-title-wrap">
                <strong>Divisi Pengembangan SDM</strong>
                <span class="divisi-card-arrow"><i class="fas fa-arrow-right"></i></span>
              </div>
              <p>Meningkatkan produktivitas lembaga dan kompetensi pegawai, program Kolaborasi Karir Dosen untuk pengajuan jabatan akademik, serta aplikasi Mobile Performance List (MPL Apps).</p>
            </div>
          </a>

          <a href="{{ route('divisi.show', 'divisi-vokasi-dan-sertifikasi') }}" class="divisi-info-card" onclick="closeTentangModal()" title="Buka Detail Divisi Vokasi dan Sertifikasi">
            <div class="divisi-info-icon"><i class="fas fa-award"></i></div>
            <div class="divisi-info-content">
              <div class="divisi-title-wrap">
                <strong>Divisi Vokasi dan Sertifikasi</strong>
                <span class="divisi-card-arrow"><i class="fas fa-arrow-right"></i></span>
              </div>
              <p>Penyelenggaraan pelatihan vokasi terstandar industri, sertifikasi kompetensi profesi nasional &amp; internasional, serta program magang kerja aplikatif.</p>
            </div>
          </a>

          <a href="{{ route('divisi.show', 'divisi-bahasa-seni-dan-budaya') }}" class="divisi-info-card" onclick="closeTentangModal()" title="Buka Detail Divisi Bahasa, Seni dan Budaya">
            <div class="divisi-info-icon"><i class="fas fa-language"></i></div>
            <div class="divisi-info-content">
              <div class="divisi-title-wrap">
                <strong>Divisi Bahasa, Seni dan Budaya</strong>
                <span class="divisi-card-arrow"><i class="fas fa-arrow-right"></i></span>
              </div>
              <p>Kajian bahasa, seni &amp; budaya serta pusat layanan Bahasa Jerman (Ausbildung &amp; Studienkolleg), English Course, pelatihan Bahasa Korea &amp; Jepang, TOEFL/IELTS, dan BIPA.</p>
            </div>
          </a>

          <a href="{{ route('divisi.show', 'divisi-kerja-sama-dan-hi') }}" class="divisi-info-card" onclick="closeTentangModal()" title="Buka Detail Divisi Kerja Sama dan HI">
            <div class="divisi-info-icon"><i class="fas fa-handshake"></i></div>
            <div class="divisi-info-content">
              <div class="divisi-title-wrap">
                <strong>Divisi Kerja Sama dan HI</strong>
                <span class="divisi-card-arrow"><i class="fas fa-arrow-right"></i></span>
              </div>
              <p>Memfasilitasi kemitraan tridharma perguruan tinggi, jejaring industri nasional dan internasional, pertukaran pengajar/mahasiswa, serta joint research lintas negara.</p>
            </div>
          </a>

          <a href="{{ route('divisi.show', 'divisi-konsultan') }}" class="divisi-info-card" onclick="closeTentangModal()" title="Buka Detail Divisi Konsultan">
            <div class="divisi-info-icon"><i class="fas fa-user-tie"></i></div>
            <div class="divisi-info-content">
              <div class="divisi-title-wrap">
                <strong>Divisi Konsultan</strong>
                <span class="divisi-card-arrow"><i class="fas fa-arrow-right"></i></span>
              </div>
              <p>Penyusunan renstra, SOP kelembagaan, analisis SROI (Social Return on Investment), penjaminan mutu SPMI, dan konsultasi bisnis strategis berbasis riset.</p>
            </div>
          </a>

          <a href="{{ route('divisi.show', 'divisi-karir-dan-kewirausahaan') }}" class="divisi-info-card" onclick="closeTentangModal()" title="Buka Detail Divisi Karir dan Kewirausahaan">
            <div class="divisi-info-icon"><i class="fas fa-briefcase"></i></div>
            <div class="divisi-info-content">
              <div class="divisi-title-wrap">
                <strong>Divisi Karir dan Kewirausahaan</strong>
                <span class="divisi-card-arrow"><i class="fas fa-arrow-right"></i></span>
              </div>
              <p>Inkubasi usaha rintisan (startup), bimbingan karir siap kerja, pelatihan kewirausahaan mandiri, dan fasilitas jejaring talenta profesional.</p>
            </div>
          </a>

          <a href="{{ route('bursa-sdm.index') }}" class="divisi-info-card" onclick="closeTentangModal()" title="Buka Platform Bursa SDM Indonesia">
            <div class="divisi-info-icon"><i class="fas fa-users-cog"></i></div>
            <div class="divisi-info-content">
              <div class="divisi-title-wrap">
                <strong>FOKUSINDO &amp; Bursa SDM Indonesia</strong>
                <span class="divisi-card-arrow"><i class="fas fa-arrow-right"></i></span>
              </div>
              <p>Forum Komunikasi SDM Indonesia (FOKUSINDO) dan Bursa SDM Indonesia <em>(bursasdm.denpasarinstitute.com)</em> dibentuk untuk membangun jejaring komunikasi SDM seluruh Indonesia, disediakan gratis sebagai program <em>Corporate Social Responsibility (CSR)</em>.</p>
            </div>
          </a>
        </div>
      </div>

      <div class="modal-tentang-section">
        <h4 class="section-title"><i class="fas fa-certificate"></i> Legalitas Lembaga</h4>
        <p class="section-subtext">
          Denpasar Institute didirikan dan dikelola oleh Badan Penyelenggara Yayasan Guna Widya Paramesthi dengan legalitas resmi:
        </p>
        <div class="legalitas-badges">
          <div class="legal-badge-item">
            <span class="legal-badge-label">SK KEMENKUMHAM RI</span>
            <span class="legal-badge-val">AHU-0017480.AH.01.04</span>
          </div>
          <div class="legal-badge-item">
            <span class="legal-badge-label">NPWP</span>
            <span class="legal-badge-val">86.729.551.1-903.000</span>
          </div>
          <div class="legal-badge-item">
            <span class="legal-badge-label">NPSN</span>
            <span class="legal-badge-val">K9980948</span>
          </div>
          <div class="legal-badge-item">
            <span class="legal-badge-label">NIB</span>
            <span class="legal-badge-val">0220007343218</span>
          </div>
        </div>
      </div>

      <div class="modal-tentang-partnership">
        <i class="fas fa-hands-helping"></i>
        <div>
          <strong>Komitmen Kemitraan Praktisi &amp; Akademisi</strong>
          <p>Dengan dukungan tim dari <strong>Praktisi &amp; Akademisi</strong>, Denpasar Institute berkolaborasi dengan lembaga pemerintah, swasta, perguruan tinggi dan berbagai pihak dalam bidang Riset &amp; Pengembangan SDM untuk berbagi dan bertumbuh bersama menuju Indonesia Maju.</p>
        </div>
      </div>

      <div class="modal-tentang-section">
        <h4 class="section-title"><i class="fas fa-compass"></i> Visi, Misi &amp; Tujuan</h4>
        <div class="vmt-wrap">
          <div class="vmt-card visi-card">
            <div class="vmt-badge">Visi</div>
            <p>Mentransformasi ide menjadi tindakan nyata untuk menghasilkan riset yang objektif dan mewujudkan SDM unggul.</p>
          </div>

          <div class="vmt-card">
            <div class="vmt-badge">Misi</div>
            <ol class="vmt-list">
              <li>Membangun SDM Unggul melalui Program Riset dan Pengembangan SDM.</li>
              <li>Menyelenggarakan Program Peningkatan Kapasitas Riset dan Pengembangan SDM.</li>
              <li>Mengembangkan Program Riset, Pendidikan dan Pelatihan secara Profesional.</li>
            </ol>
          </div>

          <div class="vmt-card">
            <div class="vmt-badge">Tujuan</div>
            <ol class="vmt-list">
              <li>Menyelenggarakan Program Riset dan Pengembangan SDM sesuai kebutuhan masyarakat.</li>
              <li>Menyelenggarakan <em>Human Resources Training &amp; Development</em> berdasarkan <em>Need Analysis</em> dan <em>Research Survey</em> serta menyediakan beasiswa pendidikan untuk pengembangan SDM.</li>
              <li>Menyelenggarakan Lokakarya, Seminar, Konferensi, Webinar dan kegiatan akademik lainnya untuk meningkatkan kapasitas riset dan pengembangan SDM.</li>
            </ol>
          </div>
        </div>
      </div>

      <div class="modal-tentang-section">
        <h4 class="section-title"><i class="fas fa-gem"></i> Nilai-Nilai Lembaga</h4>
        <div class="nilai-grid">
          <div class="nilai-card">
            <div class="nilai-num">1</div>
            <div class="nilai-content">
              <strong>Integritas <em>(Integrity)</em></strong>
              <p>Denpasar Institute memegang teguh aturan dan prinsip-prinsip yang tertuang dalam kesepakatan kerja sama.</p>
            </div>
          </div>
          <div class="nilai-card">
            <div class="nilai-num">2</div>
            <div class="nilai-content">
              <strong>Responsibilitas <em>(Responsibility)</em></strong>
              <p>Denpasar Institute bertanggung jawab terhadap tugas yang diemban dan yang diberikan oleh <em>partners &amp; clients</em> untuk berbagi bertumbuh bersama dalam pelaksanaan kerja sama.</p>
            </div>
          </div>
          <div class="nilai-card">
            <div class="nilai-num">3</div>
            <div class="nilai-content">
              <strong>Kualitas <em>(Quality)</em></strong>
              <p>Denpasar Institute memberikan layanan dan solusi terbaik yang berfokus pada kualitas kinerja untuk keberlanjutan kerja sama.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-tentang-membership-box">
        <i class="fas fa-id-card-alt"></i>
        <div>
          <strong>Keanggotaan &amp; Kolaborasi</strong>
          <p>
            Kami mengundang praktisi, akademisi, periset, pelaksana abdimas dan relawan program CSR untuk bergabung menjadi anggota <strong>Global Research &amp; Community Service (GRCS) Club</strong> atau bergabung sebagai <strong>Konsultan Ahli</strong>.
          </p>
        </div>
      </div>

      <div class="modal-tentang-contact-bar">
        <div class="modal-tentang-contact-item">
          <i class="fas fa-envelope text-danger"></i>
          <span><strong>Email:</strong> <a href="mailto:partner@denpasarinstitute.com">partner@denpasarinstitute.com</a></span>
        </div>
        <div class="modal-tentang-contact-divider">&bull;</div>
        <div class="modal-tentang-contact-item">
          <i class="fab fa-whatsapp text-success"></i>
          <span><strong>WhatsApp:</strong> <a href="https://wa.me/6287865309966" target="_blank" rel="noopener">0878-6530-9966</a> / <a href="https://wa.me/6281337644463" target="_blank" rel="noopener">0813-3764-4463</a></span>
        </div>
        <div class="modal-tentang-contact-divider">&bull;</div>
        <div class="modal-tentang-contact-item">
          <i class="fas fa-phone text-primary"></i>
          <span><strong>Telp:</strong> (0361) 2727369</span>
        </div>
        <div class="modal-tentang-contact-divider">&bull;</div>
        <div class="modal-tentang-sosmed-wrap">
          <span class="sosmed-label"><strong>Sosmed:</strong></span>
          <div class="modal-tentang-sosmed-icons">
            <a href="{{ \App\Models\SiteSetting::get('social_instagram', '#') }}" target="_blank" rel="noopener noreferrer" class="sosmed-btn instagram" title="Instagram Denpasar Institute">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="{{ \App\Models\SiteSetting::get('social_facebook', '#') }}" target="_blank" rel="noopener noreferrer" class="sosmed-btn facebook" title="Facebook Denpasar Institute">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="{{ \App\Models\SiteSetting::get('social_youtube', '#') }}" target="_blank" rel="noopener noreferrer" class="sosmed-btn youtube" title="YouTube Denpasar Institute">
              <i class="fab fa-youtube"></i>
            </a>
            <a href="{{ \App\Models\SiteSetting::get('social_linkedin', '#') }}" target="_blank" rel="noopener noreferrer" class="sosmed-btn linkedin" title="LinkedIn Denpasar Institute">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="modal-tentang-footer">
      <a href="{{ route('home') }}#divisi-detail" class="btn-modal-divisi" onclick="closeTentangModal()">
        <i class="fas fa-th-large"></i> Lihat 9 Divisi
      </a>
      <button type="button" class="btn-modal-close" onclick="closeTentangModal()">
        Tutup
      </button>
    </div>
  </div>
</div>

<style>
.modal-tentang-overlay {
  position: fixed;
  inset: 0;
  background: rgba(10, 10, 15, 0.75);
  backdrop-filter: blur(5px);
  -webkit-backdrop-filter: blur(5px);
  z-index: 99999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 16px;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.28s ease, visibility 0.28s ease;
}
.modal-tentang-overlay.is-active {
  opacity: 1;
  visibility: visible;
}
.modal-tentang-card {
  background: #ffffff;
  border-radius: 14px;
  width: 100%;
  max-width: 800px;
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  box-shadow: 0 24px 60px rgba(0, 0, 0, 0.35);
  border-top: 5px solid var(--red);
  transform: translateY(20px) scale(0.97);
  transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1);
  overflow: hidden;
}
.modal-tentang-overlay.is-active .modal-tentang-card {
  transform: translateY(0) scale(1);
}
.modal-tentang-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 18px 24px 14px;
  border-bottom: 1px solid #f0f0f0;
  background: #fff;
  flex-shrink: 0;
}
.modal-tentang-brand {
  display: flex;
  align-items: center;
  gap: 14px;
}
.modal-tentang-logo {
  height: 44px;
  width: auto;
  object-fit: contain;
}
.modal-tentang-label {
  display: inline-block;
  font-size: 0.72rem;
  font-weight: 800;
  color: var(--red);
  text-transform: uppercase;
  letter-spacing: 0.8px;
  margin-bottom: 2px;
}
.modal-tentang-title {
  margin: 0;
  font-size: 1.35rem;
  font-weight: 800;
  color: var(--dark);
  line-height: 1.2;
}
.modal-tentang-close {
  background: #f4f4f4;
  border: none;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  color: #555;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  transition: all 0.2s;
}
.modal-tentang-close:hover {
  background: var(--red);
  color: #fff;
  transform: rotate(90deg);
}
.modal-tentang-body {
  padding: 20px 24px;
  overflow-y: auto;
  font-size: 0.95rem;
  color: #444;
  line-height: 1.7;
}
.modal-tentang-body::-webkit-scrollbar {
  width: 6px;
}
.modal-tentang-body::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 4px;
}
.modal-tentang-body::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

.modal-tentang-quote {
  background: linear-gradient(135deg, #fff9e6 0%, #fffdf5 100%);
  border-left: 4px solid var(--yellow);
  padding: 14px 18px;
  border-radius: 8px;
  margin-bottom: 18px;
  display: flex;
  align-items: flex-start;
  gap: 12px;
}
.modal-tentang-quote .quote-icon {
  color: var(--yellow);
  font-size: 1.3rem;
  margin-top: 2px;
  flex-shrink: 0;
}
.modal-tentang-quote strong {
  display: block;
  color: #1a1a1a;
  font-size: 1.05rem;
  margin-bottom: 2px;
}
.modal-tentang-quote span {
  font-size: 0.9rem;
  color: #666;
}

.modal-tentang-desc p {
  margin: 0 0 12px;
  text-align: left;
}
.modal-tentang-desc strong {
  color: #1a1a1a;
}

.modal-tentang-section {
  margin-top: 22px;
  padding-top: 18px;
  border-top: 1px dashed #e5e5e5;
}
.section-title {
  margin: 0 0 12px;
  font-size: 1.02rem;
  font-weight: 800;
  text-transform: uppercase;
  color: var(--dark);
  letter-spacing: 0.5px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.section-title i {
  color: var(--red);
}
.section-subtext {
  font-size: 0.92rem;
  color: #555;
  margin: 0 0 12px;
}

.divisi-info-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
}
.divisi-info-card {
  background: #fbfbfc;
  border: 1px solid #ebebeb;
  border-radius: 8px;
  padding: 12px 14px;
  display: flex;
  align-items: flex-start;
  gap: 12px;
  transition: all 0.2s;
  text-decoration: none;
  color: inherit;
  cursor: pointer;
  position: relative;
}
.divisi-info-card.full-width {
  grid-column: 1 / -1;
}
.divisi-info-card:hover {
  background: #fff8f8;
  border-color: rgba(204,0,0,0.35);
  transform: translateY(-2px);
  box-shadow: 0 4px 14px rgba(204,0,0,0.08);
}
.divisi-info-card:hover .divisi-info-content strong {
  color: #CC0000;
}
.divisi-info-card:hover .divisi-card-arrow {
  color: #CC0000;
  transform: translateX(3px);
}
.divisi-title-wrap {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 3px;
  gap: 8px;
}
.divisi-card-arrow {
  color: #cbd5e1;
  font-size: 0.8rem;
  transition: all 0.2s ease;
  flex-shrink: 0;
}
.divisi-info-icon {
  width: 34px;
  height: 34px;
  border-radius: 8px;
  background: rgba(204,0,0,0.08);
  color: var(--red);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.95rem;
  flex-shrink: 0;
}
.divisi-info-content strong {
  display: block;
  font-size: 0.92rem;
  color: var(--dark);
  line-height: 1.3;
  margin-bottom: 3px;
}
.divisi-info-content p {
  margin: 0;
  font-size: 0.86rem; line-height: 1.55;
  color: #666;
  line-height: 1.45;
  text-align: left;
}

.legalitas-badges {
  display: grid;
  grid-template-columns: 1.35fr 1.15fr 0.75fr 0.85fr;
  gap: 10px;
}
.legal-badge-item {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  padding: 10px 8px;
  text-align: center;
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 4px;
}
.legal-badge-label {
  font-size: 0.72rem;
  font-weight: 800;
  color: var(--red);
  text-transform: uppercase;
  letter-spacing: 0.3px;
  white-space: nowrap;
}
.legal-badge-val {
  font-size: 0.84rem;
  font-weight: 700;
  color: #1e293b;
  white-space: nowrap;
}

.modal-tentang-partnership {
  margin-top: 20px;
  background: #f0fdf4;
  border: 1px solid #bbf7d0;
  border-left: 4px solid #16a34a;
  border-radius: 8px;
  padding: 12px 16px;
  display: flex;
  align-items: flex-start;
  gap: 12px;
}
.modal-tentang-partnership i {
  color: #16a34a;
  font-size: 1.25rem;
  margin-top: 3px;
  flex-shrink: 0;
}
.modal-tentang-partnership strong {
  display: block;
  color: #14532d;
  font-size: 0.95rem;
  margin-bottom: 2px;
}
.modal-tentang-partnership p {
  margin: 0;
  font-size: 0.9rem; line-height: 1.6;
  color: #166534;
  line-height: 1.5;
  text-align: left;
}

.vmt-wrap {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.vmt-card {
  background: #fafafa;
  border: 1px solid #ebebeb;
  border-radius: 8px;
  padding: 14px 16px;
}
.vmt-card.visi-card {
  background: #fffdf5;
  border-left: 4px solid var(--yellow);
}
.vmt-badge {
  display: inline-block;
  background: var(--red);
  color: #fff;
  font-size: 0.68rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  padding: 2px 8px;
  border-radius: 4px;
  margin-bottom: 6px;
}
.vmt-card p {
  margin: 0;
  font-size: 0.94rem;
  line-height: 1.6;
  color: #222;
  font-weight: 500;
}
.vmt-list {
  margin: 0;
  padding-left: 20px;
  font-size: 0.9rem;
  color: #333;
  line-height: 1.65;
}
.vmt-list li {
  margin-bottom: 4px;
  text-align: left;
}

.nilai-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
}
.nilai-card {
  background: #fff;
  border: 1px solid #ebebeb;
  border-radius: 8px;
  padding: 12px 14px;
  display: flex;
  gap: 10px;
  align-items: flex-start;
}
.nilai-num {
  width: 26px;
  height: 26px;
  border-radius: 50%;
  background: var(--yellow);
  color: var(--dark);
  font-weight: 800;
  font-size: 0.8rem;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.nilai-content strong {
  display: block;
  font-size: 0.92rem;
  color: var(--dark);
  margin-bottom: 3px;
}
.nilai-content p {
  margin: 0;
  font-size: 0.86rem; line-height: 1.55;
  color: #666;
  line-height: 1.45;
  text-align: left;
}

.modal-tentang-membership-box {
  margin-top: 18px;
  background: #eff6ff;
  border: 1px solid #bfdbfe;
  border-left: 4px solid #2563eb;
  border-radius: 8px;
  padding: 12px 16px;
  display: flex;
  align-items: flex-start;
  gap: 12px;
}
.modal-tentang-membership-box i {
  color: #2563eb;
  font-size: 1.25rem;
  margin-top: 3px;
  flex-shrink: 0;
}
.modal-tentang-membership-box strong {
  display: block;
  color: #1e3a8a;
  font-size: 0.95rem;
  margin-bottom: 2px;
}
.modal-tentang-membership-box p {
  margin: 0;
  font-size: 0.9rem;
  color: #1e40af;
  line-height: 1.5;
  text-align: left;
}

.modal-tentang-contact-bar {
  margin-top: 16px;
  padding: 12px 16px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  font-size: 0.84rem;
  color: #475569;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
  gap: 10px 14px;
  line-height: 1.5;
}
.modal-tentang-contact-item {
  display: inline-flex;
  align-items: center;
  gap: 6px;
}
.modal-tentang-contact-item a {
  color: inherit;
  text-decoration: none;
  font-weight: 600;
  transition: color 0.15s;
}
.modal-tentang-contact-item a:hover {
  color: var(--red);
  text-decoration: underline;
}
.modal-tentang-contact-divider {
  color: #cbd5e1;
  font-size: 0.9rem;
}
.modal-tentang-sosmed-wrap {
  display: inline-flex;
  align-items: center;
  gap: 8px;
}
.modal-tentang-sosmed-icons {
  display: inline-flex;
  align-items: center;
  gap: 6px;
}
.sosmed-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 28px;
  height: 28px;
  border-radius: 50%;
  color: #fff !important;
  font-size: 0.78rem;
  text-decoration: none;
  transition: transform 0.2s, opacity 0.2s;
}
.sosmed-btn:hover {
  transform: translateY(-2px);
  opacity: 0.9;
}
.sosmed-btn.instagram {
  background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
}
.sosmed-btn.facebook {
  background: #1877f2;
}
.sosmed-btn.youtube {
  background: #ff0000;
}
.sosmed-btn.linkedin {
  background: #0a66c2;
}

.modal-tentang-footer {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 10px;
  padding: 14px 24px;
  border-top: 1px solid #f0f0f0;
  background: #fafafa;
  flex-wrap: wrap;
  flex-shrink: 0;
}
.btn-modal-divisi {
  background: var(--yellow);
  color: var(--dark) !important;
  font-weight: 800;
  font-size: 0.86rem;
  padding: 9px 18px;
  border-radius: 5px;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.2s;
}
.btn-modal-divisi:hover {
  background: #e0b000;
  transform: translateY(-1px);
}
.btn-modal-close {
  background: #e9ecef;
  color: #333;
  border: none;
  font-weight: 600;
  font-size: 0.86rem;
  padding: 9px 18px;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.2s;
}
.btn-modal-close:hover {
  background: #dee2e6;
}

@media (max-width: 768px) {
  .divisi-info-grid {
    grid-template-columns: 1fr;
  }
  .legalitas-badges {
    grid-template-columns: 1fr 1fr;
  }
  .nilai-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 600px) {
  .modal-tentang-footer {
    flex-direction: column;
    align-items: stretch;
  }
  .modal-tentang-footer a,
  .modal-tentang-footer button {
    justify-content: center;
    width: 100%;
    text-align: center;
  }
}

@media (max-width: 480px) {
  .modal-tentang-header {
    padding: 14px 16px 12px;
  }
  .modal-tentang-title {
    font-size: 1.05rem !important;
  }
  .modal-tentang-logo {
    height: 34px !important;
  }
  .modal-tentang-body {
    padding: 14px 16px;
    font-size: 0.84rem;
  }
  .modal-tentang-quote {
    padding: 10px 14px;
    gap: 10px;
  }
  .legalitas-badges {
    grid-template-columns: 1fr;
  }
  .modal-tentang-contact-bar {
    font-size: 0.78rem;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    padding: 10px 12px;
  }
  .modal-tentang-contact-divider {
    display: none;
  }
}
</style>

<script>
function openTentangModal(targetSection) {
  var modal = document.getElementById('tentangDiModal');
  if (modal) {
    modal.classList.add('is-active');
    document.body.style.overflow = 'hidden';
    if (targetSection === 'divisi') {
      setTimeout(function() {
        var el = document.getElementById('modalSectionDivisi');
        if (el) {
          el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      }, 150);
    }
  }
}
window.openTentangModal = openTentangModal;

function closeTentangModal() {
  var modal = document.getElementById('tentangDiModal');
  if (modal) {
    modal.classList.remove('is-active');
    document.body.style.overflow = '';
  }
}
window.closeTentangModal = closeTentangModal;

function handleTentangBackdropClick(event) {
  if (event.target && event.target.id === 'tentangDiModal') {
    closeTentangModal();
  }
}

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeTentangModal();
  }
});

// Otomatis buka jika ada hash #tentang-di, #divisi-modal atau query ?open_about=1 / ?open_divisi=1 di URL
(function() {
  var hash = window.location.hash;
  var search = window.location.search;
  if (hash === '#tentang-di' || search.indexOf('open_about=1') !== -1) {
    setTimeout(function() { openTentangModal(); }, 300);
  } else if (hash === '#divisi-modal' || hash === '#all-divisions' || search.indexOf('open_divisi=1') !== -1) {
    setTimeout(function() { openTentangModal('divisi'); }, 300);
  }
})();
</script>
