@php
    $theme = $theme ?? 'light';
    $isDark = ($theme === 'dark');
    $currentRole = request('role', $role ?? null);
    $provinces = [
        'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Kepulauan Riau',
        'Jambi', 'Sumatera Selatan', 'Kepulauan Bangka Belitung', 'Bengkulu', 'Lampung',
        'DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur',
        'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
        'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
        'Sulawesi Utara', 'Gorontalo', 'Sulawesi Tengah', 'Sulawesi Barat', 'Sulawesi Selatan', 'Sulawesi Tenggara',
        'Maluku', 'Maluku Utara',
        'Papua', 'Papua Barat', 'Papua Tengah', 'Papua Pegunungan', 'Papua Selatan', 'Papua Barat Daya'
    ];
@endphp

<section class="alur-pendaftaran-section {{ $isDark ? 'alur-theme-dark' : 'alur-theme-light' }}" id="alur-pendaftaran">
    <div class="alur-container">

        {{-- Heading --}}
        <div class="alur-header">
            <span class="alur-pill">Panduan Pendaftaran</span>
            <h2 class="alur-title">Bagaimana cara mendaftar menjadi tim konsultan Denpasar Institute dan GRCS Club ?</h2>
            <p class="alur-subtitle">Ikuti 4 langkah terarah di bawah ini untuk bergabung menjadi tim profesional &amp; komunitas riset kami.</p>
        </div>

        {{-- Flowchart Container --}}
        <div class="alur-flow-wrap">

            {{-- SVG Connector Lines for Desktop --}}
            <svg class="alur-connectors-svg" aria-hidden="true" preserveAspectRatio="none" viewBox="0 0 1000 700">
                {{-- Line 1 -> 2 --}}
                <path d="M 450 110 C 600 110, 600 240, 550 240" fill="none" stroke="#f39c12" stroke-width="2.5" stroke-dasharray="6,4" />
                {{-- Line 2 -> 3 --}}
                <path d="M 550 310 C 400 310, 400 440, 450 440" fill="none" stroke="#f39c12" stroke-width="2.5" stroke-dasharray="6,4" />
                {{-- Line 3 -> 4 --}}
                <path d="M 450 510 C 600 510, 600 620, 550 620" fill="none" stroke="#f39c12" stroke-width="2.5" stroke-dasharray="6,4" />
            </svg>

            {{-- STEP 01 --}}
            <div class="alur-step-row alur-row-left">
                <div class="alur-card">
                    <div class="alur-badge">01</div>
                    <div class="alur-card-content">
                        <h3 class="alur-step-title">DAFTAR</h3>
                        <p class="alur-step-desc">
                            Daftar anggota GRCS Club dan/atau anggota Konsultan Denpasar Institute. Apabila memenuhi persyaratan, dibolehkan mendaftar keduanya. Silahkan, gunakan berbagai manfaatnya.
                        </p>
                    </div>
                </div>
                <div class="alur-illustration">
                    <div class="alur-illus-circle illus-color-1">
                        {{-- Person with laptop SVG --}}
                        <svg viewBox="0 0 120 120" class="alur-svg-icon" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="60" cy="60" r="54" fill="#FFF4E5"/>
                            <circle cx="60" cy="42" r="16" fill="#F8C291"/>
                            <path d="M46 38 C46 26, 74 26, 74 38 C74 40, 70 34, 60 34 C50 34, 46 40, 46 38 Z" fill="#2C3E50"/>
                            <path d="M38 78 C38 62, 50 58, 60 58 C70 58, 82 62, 82 78 Z" fill="#E74C3C"/>
                            <polygon points="56,58 64,58 60,68" fill="#FFF"/>
                            <rect x="36" y="72" width="48" height="28" rx="3" fill="#BDC3C7"/>
                            <rect x="40" y="75" width="40" height="20" rx="2" fill="#34495E"/>
                            <circle cx="60" cy="85" r="3" fill="#3498DB"/>
                            <path d="M30 100 L90 100 L86 103 L34 103 Z" fill="#95A5A6"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- STEP 02 --}}
            <div class="alur-step-row alur-row-right">
                <div class="alur-illustration">
                    <div class="alur-illus-circle illus-color-2">
                        {{-- Phone with register screen SVG --}}
                        <svg viewBox="0 0 120 120" class="alur-svg-icon" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="60" cy="60" r="54" fill="#EBF5FB"/>
                            <rect x="42" y="22" width="36" height="66" rx="6" fill="#2C3E50"/>
                            <rect x="45" y="28" width="30" height="50" rx="3" fill="#1ABC9C"/>
                            <rect x="49" y="34" width="22" height="4" rx="2" fill="#FFF" opacity="0.8"/>
                            <rect x="49" y="42" width="22" height="4" rx="2" fill="#FFF" opacity="0.8"/>
                            <rect x="49" y="50" width="14" height="4" rx="2" fill="#FFF" opacity="0.8"/>
                            <rect x="49" y="60" width="22" height="7" rx="3.5" fill="#E74C3C"/>
                            <rect x="53" y="62" width="14" height="3" rx="1.5" fill="#FFF"/>
                            <path d="M56 82 L56 70 C56 67, 60 67, 60 70 L60 84 L64 85 C67 86, 68 89, 67 92 L64 100 L48 100 L48 90 Z" fill="#F8C291"/>
                            <circle cx="60" cy="82" r="1.5" fill="#BDC3C7"/>
                        </svg>
                    </div>
                </div>
                <div class="alur-card">
                    <div class="alur-badge">02</div>
                    <div class="alur-card-content">
                        <h3 class="alur-step-title">ISI FORMULIR</h3>
                        <p class="alur-step-desc">
                            Isi formulir, unggah foto dan CV (khusus bagi tim konsultan) pada 
                            @if($currentRole === 'grcs')
                                <a href="{{ route('pendaftaran.grcs') }}" class="alur-highlight-link">tombol pendaftaran</a>.
                            @elseif($currentRole === 'konsultan')
                                <a href="{{ route('pendaftaran.konsultan') }}" class="alur-highlight-link">tombol pendaftaran</a>.
                            @else
                                <a href="#alurActionButtons" class="alur-highlight-link">tombol pendaftaran</a>.
                            @endif
                            Pastikan Bapak/Ibu/Saudara mengisi data dengan benar dan mengunggah CV bagi pendaftar tim Konsultan DI.
                        </p>
                    </div>
                </div>
            </div>

            {{-- STEP 03 --}}
            <div class="alur-step-row alur-row-left">
                <div class="alur-card">
                    <div class="alur-badge">03</div>
                    <div class="alur-card-content">
                        <h3 class="alur-step-title">VERIFIKASI</h3>
                        <p class="alur-step-desc">
                            Verifikasi max. 2 x 24 jam. Setelah verifikasi, kartu anggota dan akun (username dan password) anggota dikirimkan melalui email yang digunakan ketika mendaftar. Pastikan alamat email masih aktif.
                        </p>
                    </div>
                </div>
                <div class="alur-illustration">
                    <div class="alur-illus-circle illus-color-3">
                        {{-- Checklist document and pencil SVG --}}
                        <svg viewBox="0 0 120 120" class="alur-svg-icon" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="60" cy="60" r="54" fill="#FDEDEC"/>
                            <rect x="36" y="26" width="44" height="64" rx="4" fill="#FFFFFF" stroke="#E2E8F0" stroke-width="2"/>
                            <path d="M44 42 L48 46 L56 38" stroke="#2ECC71" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <line x1="62" y1="42" x2="72" y2="42" stroke="#CBD5E0" stroke-width="3" stroke-linecap="round"/>
                            <path d="M44 56 L48 60 L56 52" stroke="#2ECC71" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <line x1="62" y1="56" x2="72" y2="56" stroke="#CBD5E0" stroke-width="3" stroke-linecap="round"/>
                            <path d="M44 70 L48 74 L56 66" stroke="#2ECC71" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <line x1="62" y1="70" x2="72" y2="70" stroke="#CBD5E0" stroke-width="3" stroke-linecap="round"/>
                            <g transform="translate(68, 48) rotate(35)">
                                <rect x="0" y="0" width="8" height="42" rx="2" fill="#E67E22"/>
                                <polygon points="0,42 8,42 4,50" fill="#F8C291"/>
                                <polygon points="3,48 5,48 4,50" fill="#2C3E50"/>
                                <rect x="0" y="0" width="8" height="8" rx="1" fill="#E74C3C"/>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- STEP 04 --}}
            <div class="alur-step-row alur-row-right">
                <div class="alur-illustration">
                    <div class="alur-illus-circle illus-color-4">
                        {{-- People collaborating & success flag SVG --}}
                        <svg viewBox="0 0 120 120" class="alur-svg-icon" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="60" cy="60" r="54" fill="#E8F8F5"/>
                            <path d="M25 96 L58 48 L95 96 Z" fill="#D5F5E3"/>
                            <line x1="58" y1="30" x2="58" y2="52" stroke="#2C3E50" stroke-width="2.5" stroke-linecap="round"/>
                            <polygon points="58,32 76,38 58,45" fill="#E74C3C"/>
                            <circle cx="40" cy="74" r="8" fill="#F39C12" opacity="0.3"/>
                            <circle cx="40" cy="74" r="4" fill="#FFFFFF"/>
                            <circle cx="78" cy="78" r="4" fill="#2C3E50"/>
                            <path d="M72 96 C72 88, 84 88, 84 96 Z" fill="#3498DB"/>
                            <circle cx="46" cy="84" r="3.5" fill="#2C3E50"/>
                            <path d="M41 96 C41 90, 51 90, 51 96 Z" fill="#9B59B6"/>
                        </svg>
                    </div>
                </div>
                <div class="alur-card">
                    <div class="alur-badge">04</div>
                    <div class="alur-card-content">
                        <h3 class="alur-step-title">BENEFIT</h3>
                        <p class="alur-step-desc">
                            Anggota GRCS Club dapat memanfaatkan wadah ini untuk membangun dan meningkatkan networking bidang riset, pengabdian masyarakat dan pengembangan SDM. Konsultan juga dapat memanfaatkan kesempatan ini untuk menambah pekerjaan sampingan.
                        </p>
                    </div>
                </div>
            </div>

        </div>

        {{-- ACTION BUTTONS (Mengarahkan ke halaman formulir khusus) --}}
        <div class="alur-actions" id="alurActionButtons">
            @if(!$currentRole || $currentRole === 'konsultan')
                <a href="{{ route('pendaftaran.konsultan') }}" class="btn-alur-cta btn-alur-konsultan" id="btnTriggerKonsultan">
                    <i class="fas fa-user-tie"></i> DAFTAR ANGGOTA KONSULTAN
                </a>
            @endif
            @if(!$currentRole || $currentRole === 'grcs')
                <a href="{{ route('pendaftaran.grcs') }}" class="btn-alur-cta btn-alur-grcs" id="btnTriggerGrcs">
                    <i class="fas fa-users"></i> DAFTAR ANGGOTA GRCS CLUB
                </a>
            @endif
        </div>

    </div>
</section>

<style>
/* ===== ALUR PENDAFTARAN STYLES ===== */
.alur-pendaftaran-section {
    padding: 60px 20px 70px;
    position: relative;
    font-family: 'Poppins', sans-serif;
}

/* Light Theme */
.alur-theme-light {
    background: #fdfdfd;
}
.alur-theme-light .alur-title { color: #1a1a1a; }
.alur-theme-light .alur-subtitle { color: #666; }
.alur-theme-light .alur-card {
    background: #ffffff;
    border: 1px solid #e8e8e8;
    box-shadow: 0 10px 28px rgba(0,0,0,0.05);
}
.alur-theme-light .alur-step-desc { color: #444; }

/* Dark Theme */
.alur-theme-dark {
    background: #181818;
}
.alur-theme-dark .alur-title { color: #ffffff; }
.alur-theme-dark .alur-subtitle { color: #aaa; }
.alur-theme-dark .alur-card {
    background: #242424;
    border: 1px solid #363636;
    box-shadow: 0 10px 28px rgba(0,0,0,0.35);
}
.alur-theme-dark .alur-step-desc { color: #ccc; }

.alur-container {
    max-width: 1060px;
    margin: 0 auto;
    position: relative;
}

.alur-header {
    text-align: center;
    max-width: 780px;
    margin: 0 auto 50px;
}
.alur-pill {
    display: inline-block;
    background: rgba(243, 156, 18, 0.15);
    color: #e67e22;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 4px 14px;
    border-radius: 20px;
    margin-bottom: 12px;
}
.alur-theme-dark .alur-pill {
    background: rgba(245, 196, 0, 0.15);
    color: #F5C400;
}
.alur-title {
    font-size: 1.75rem;
    font-weight: 800;
    line-height: 1.35;
    margin: 0 0 12px;
}
.alur-subtitle {
    font-size: 0.92rem;
    line-height: 1.6;
    margin: 0;
}

/* Flowchart rows */
.alur-flow-wrap {
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 36px;
    margin-bottom: 50px;
}
.alur-connectors-svg {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
}

.alur-step-row {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 32px;
}
.alur-row-left {
    justify-content: flex-start;
}
.alur-row-right {
    justify-content: flex-end;
}

.alur-card {
    display: flex;
    align-items: flex-start;
    gap: 18px;
    padding: 22px 26px;
    border-radius: 12px;
    max-width: 540px;
    width: 100%;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.alur-card:hover {
    transform: translateY(-3px);
}
.alur-theme-light .alur-card:hover {
    box-shadow: 0 16px 36px rgba(0,0,0,0.08);
}
.alur-theme-dark .alur-card:hover {
    box-shadow: 0 16px 36px rgba(0,0,0,0.5);
    border-color: #F5C400;
}

.alur-badge {
    background: #f39c12;
    color: #ffffff;
    font-size: 1.15rem;
    font-weight: 800;
    width: 44px;
    height: 44px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 10px rgba(243, 156, 18, 0.35);
}
.alur-card-content {
    flex: 1;
}
.alur-step-title {
    font-size: 0.88rem;
    font-weight: 800;
    color: #f39c12;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    margin: 0 0 6px;
}
.alur-step-desc {
    font-size: 0.84rem;
    line-height: 1.65;
    margin: 0;
}
.alur-highlight-link {
    color: #2980b9;
    font-weight: 700;
    text-decoration: underline;
}
.alur-theme-dark .alur-highlight-link {
    color: #F5C400;
}

/* Illustrations */
.alur-illustration {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.alur-illus-circle {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(0,0,0,0.07);
    transition: transform 0.3s ease;
}
.alur-illus-circle:hover {
    transform: scale(1.05) rotate(2deg);
}
.alur-svg-icon {
    width: 90px;
    height: 90px;
}

/* Action Buttons */
.alur-actions {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 18px;
    flex-wrap: wrap;
    position: relative;
    z-index: 2;
    padding-top: 10px;
    margin-bottom: 20px;
}
.btn-alur-cta {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 13px 28px;
    border-radius: 8px;
    font-size: 0.88rem;
    font-weight: 800;
    letter-spacing: 0.5px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}
.btn-alur-konsultan {
    background: #e69500;
    color: #ffffff !important;
}
.btn-alur-konsultan:hover {
    background: #cf8400;
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(230, 149, 0, 0.4);
}
.btn-alur-grcs {
    background: #F5C400;
    color: #1a1a1a !important;
}
.btn-alur-grcs:hover {
    background: #e0b000;
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(245, 196, 0, 0.4);
}

/* ===== FORM PENDAFTARAN DARI GAMBAR 2 ===== */
.alur-form-wrapper {
    margin-top: 40px;
    position: relative;
    z-index: 5;
}
.alur-alert {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 16px 20px;
    border-radius: 6px;
    margin-bottom: 24px;
    font-size: 0.85rem;
    line-height: 1.5;
}
.alur-alert i { font-size: 1.3rem; flex-shrink: 0; margin-top: 2px; }
.alur-alert-success {
    background: #ecfdf5;
    border: 1px solid #10b981;
    color: #065f46;
}
.alur-alert-error {
    background: #fef2f2;
    border: 1px solid #ef4444;
    color: #991b1b;
}

.reg-form-card {
    background: #ffffff;
    border: 1px solid #dcdcdc;
    border-radius: 4px;
    max-width: 680px;
    margin: 0 auto;
    box-shadow: 0 8px 30px rgba(0,0,0,0.06);
    overflow: hidden;
}
.reg-form-header {
    background: #CC0000;
    color: #ffffff;
    padding: 12px 20px;
    font-weight: 700;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
.reg-form-body {
    padding: 24px 28px 32px;
}
.form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin-bottom: 16px;
}
.form-group-item {
    display: flex;
    flex-direction: column;
}
.form-group-item label {
    font-size: 0.78rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 6px;
}
.form-group-item input[type="text"],
.form-group-item input[type="email"],
.form-group-item input[type="date"],
.form-group-item textarea,
.form-group-item select {
    width: 100%;
    padding: 9px 12px;
    font-size: 0.8rem;
    font-family: 'Poppins', sans-serif;
    border: 1px solid #c9c9c9;
    border-radius: 4px;
    box-sizing: border-box;
    background: #fff;
    color: #222;
    outline: none;
    transition: border-color 0.2s;
}
.form-group-item input:focus,
.form-group-item textarea:focus,
.form-group-item select:focus {
    border-color: #CC0000;
}
.form-group-item textarea {
    resize: vertical;
}

/* Upload Dropzone matching Image 2 */
.upload-box-wrap {
    margin-bottom: 16px;
}
.drag-drop-zone {
    border: 1px solid #c9c9c9;
    border-radius: 4px;
    padding: 30px 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    background: #ffffff;
    transition: all 0.2s ease;
}
.drag-drop-zone:hover {
    border-color: #CC0000;
    background: #fbfbfb;
}
.cloud-upload-svg {
    width: 44px;
    height: 44px;
}
.drag-text {
    font-size: 0.8rem;
    color: #333;
    font-weight: 500;
}
.upload-note {
    font-size: 0.72rem;
    color: #222;
    margin-top: 5px;
    font-weight: 500;
}

/* Action buttons at bottom */
.reg-form-actions {
    display: flex;
    justify-content: center;
    gap: 14px;
    margin-top: 24px;
}
.btn-form-reset {
    background: #f39c12;
    color: #fff;
    border: none;
    padding: 8px 24px;
    border-radius: 4px;
    font-weight: 700;
    font-size: 0.82rem;
    cursor: pointer;
    transition: background 0.2s;
}
.btn-form-reset:hover {
    background: #e67e22;
}
.btn-form-submit {
    background: #3e804d;
    color: #fff;
    border: none;
    padding: 8px 24px;
    border-radius: 4px;
    font-weight: 700;
    font-size: 0.82rem;
    cursor: pointer;
    transition: background 0.2s;
}
.btn-form-submit:hover {
    background: #2e663c;
}

/* Responsive adjustments */
@media (max-width: 860px) {
    .alur-connectors-svg { display: none; }
    .alur-step-row {
        flex-direction: column !important;
        align-items: stretch;
        gap: 16px;
    }
    .alur-card {
        max-width: 100%;
    }
    .alur-illustration {
        order: -1;
        justify-content: center;
    }
    .alur-title { font-size: 1.35rem; }
    .form-row-2 {
        grid-template-columns: 1fr;
        gap: 14px;
    }
    .reg-form-body {
        padding: 20px 18px;
    }
}
</style>
