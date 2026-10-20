@extends('layouts.app')

@php
    $role = $role ?? request('role', 'konsultan');
    $isGrcs = ($role === 'grcs');
    $pageTitle = $isGrcs ? 'Formulir Pendaftaran Anggota GRCS Club' : 'Formulir Pendaftaran Anggota Konsultan';
    $formHeader = $isGrcs ? 'IDENTITAS ANGGOTA GRCS CLUB' : 'IDENTITAS KONSULTAN';

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

    $beritaTerkini = $beritaTerkini ?? \App\Models\Berita::where('is_active', true)
        ->where('status', 'approved')
        ->orderBy('published_at', 'desc')
        ->take(5)
        ->get();

    $beritaTerpopuler = $beritaTerpopuler ?? \App\Models\Berita::where('is_active', true)
        ->where('status', 'approved')
        ->orderBy('views', 'desc')
        ->take(5)
        ->get();
@endphp

@section('title', $pageTitle . ' — Denpasar Institute')

@section('extra-style')
.pendaftaran-page-wrapper {
    padding-top: 155px;
    padding-bottom: 90px;
    background: #f8fafc;
    min-height: 100vh;
    font-family: 'Poppins', sans-serif;
}
@media (max-width: 768px) {
    .pendaftaran-page-wrapper {
        padding-top: 95px;
        padding-bottom: 50px;
    }
}

.pendaftaran-inner {
    max-width: 1220px;
    margin: 0 auto;
    padding: 0 20px;
}

.pendaftaran-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
}

.btn-back-panduan {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #475569;
    font-size: 0.83rem;
    font-weight: 600;
    text-decoration: none;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    padding: 8px 16px;
    border-radius: 6px;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.03);
}
.btn-back-panduan:hover {
    color: #CC0000;
    border-color: #CC0000;
    background: #fff;
    transform: translateX(-3px);
}

.step-indicator {
    font-size: 0.78rem;
    color: #64748b;
    font-weight: 600;
    background: #f1f5f9;
    padding: 6px 14px;
    border-radius: 20px;
}

/* 2-Column Grid Layout */
.pendaftaran-grid-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 380px;
    gap: 32px;
    align-items: start;
}
@media (max-width: 1024px) {
    .pendaftaran-grid-layout {
        grid-template-columns: 1fr;
        gap: 40px;
    }
}

.pendaftaran-main-col {
    min-width: 0;
}

.pendaftaran-alerts {
    margin-bottom: 20px;
}
.pendaftaran-alert {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 16px 20px;
    border-radius: 8px;
    margin-bottom: 18px;
    font-size: 0.86rem;
    line-height: 1.5;
}
.pendaftaran-alert i {
    font-size: 1.3rem;
    flex-shrink: 0;
    margin-top: 2px;
}
.alert-box-success {
    background: #ecfdf5;
    border: 1px solid #10b981;
    color: #065f46;
}
.alert-box-error {
    background: #fef2f2;
    border: 1px solid #ef4444;
    color: #991b1b;
}

/* Card Form matching Image 2 */
.reg-form-card {
    background: #ffffff;
    border: 1px solid #dcdcdc;
    border-radius: 6px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    overflow: hidden;
}

.reg-form-header {
    background: #CC0000;
    color: #ffffff;
    padding: 14px 24px;
    font-weight: 700;
    font-size: 0.95rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.reg-form-body {
    padding: 28px 30px 36px;
}

.form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin-bottom: 18px;
}

.form-group-item {
    display: flex;
    flex-direction: column;
}

.form-group-item label {
    font-size: 0.8rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 7px;
}

.form-group-item input[type="text"],
.form-group-item input[type="email"],
.form-group-item input[type="date"],
.form-group-item textarea,
.form-group-item select {
    width: 100%;
    padding: 10px 14px;
    font-size: 0.83rem;
    font-family: 'Poppins', sans-serif;
    border: 1px solid #c9c9c9;
    border-radius: 4px;
    box-sizing: border-box;
    background: #fff;
    color: #222;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-group-item input:focus,
.form-group-item textarea:focus,
.form-group-item select:focus {
    border-color: #CC0000;
    box-shadow: 0 0 0 3px rgba(204, 0, 0, 0.1);
}

.form-group-item textarea {
    resize: vertical;
}

.form-group-item input[type="date"] {
    cursor: pointer;
}

.form-group-item input[type="date"]::-webkit-calendar-picker-indicator {
    cursor: pointer;
    opacity: 0.85;
    padding: 3px 5px;
    border-radius: 4px;
    transition: opacity 0.2s, background-color 0.2s;
}

.form-group-item input[type="date"]::-webkit-calendar-picker-indicator:hover {
    opacity: 1;
    background-color: rgba(0, 0, 0, 0.06);
}

/* Upload Dropzone */
.upload-box-wrap {
    margin-bottom: 18px;
}

.drag-drop-zone {
    border: 1.5px dashed #c9c9c9;
    border-radius: 6px;
    padding: 30px 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    cursor: pointer;
    background: #ffffff;
    transition: all 0.2s ease;
}

.drag-drop-zone:hover, .drag-drop-zone.dragover {
    border-color: #CC0000;
    background: #fff9f9;
}

.cloud-upload-svg {
    width: 46px;
    height: 46px;
}

.drag-text {
    font-size: 0.82rem;
    color: #333;
    font-weight: 500;
    text-align: center;
}

.upload-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
}

.upload-preview-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    width: 100%;
    animation: fadeInPreview 0.25s ease-in-out;
}

@keyframes fadeInPreview {
    from { opacity: 0; transform: translateY(4px); }
    to { opacity: 1; transform: translateY(0); }
}

.preview-img-wrap {
    position: relative;
    max-width: 320px;
    max-height: 190px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
    border: 2px solid #16a34a;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
}

.upload-preview-img {
    max-width: 100%;
    max-height: 190px;
    object-fit: contain;
    display: block;
}

.preview-doc-wrap {
    padding: 16px 28px;
    background: #f8fafc;
    border: 1.5px solid #cbd5e1;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.preview-info {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    text-align: center;
}

.preview-filename {
    font-size: 0.84rem;
    font-weight: 700;
    color: #16a34a;
    word-break: break-all;
    max-width: 380px;
}

.preview-btn-change {
    font-size: 0.74rem;
    color: #64748b;
    background: #f1f5f9;
    padding: 3px 12px;
    border-radius: 999px;
    transition: all 0.2s;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.drag-drop-zone:hover .preview-btn-change {
    background: #CC0000;
    color: #fff;
}

.upload-note {
    font-size: 0.73rem;
    color: #333;
    margin-top: 6px;
    font-weight: 500;
}

/* Action buttons at bottom */
.reg-form-actions {
    display: flex;
    justify-content: center;
    gap: 16px;
    margin-top: 28px;
}

.btn-form-reset {
    background: #f39c12;
    color: #fff;
    border: none;
    padding: 10px 32px;
    border-radius: 4px;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
.btn-form-reset:hover {
    background: #e67e22;
}

.btn-form-submit {
    background: #3e804d;
    color: #fff;
    border: none;
    padding: 10px 32px;
    border-radius: 4px;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.btn-form-submit:hover {
    background: #2e663c;
}

.pendaftaran-footer-note {
    margin-top: 24px;
    text-align: center;
    color: #64748b;
    font-size: 0.78rem;
    line-height: 1.6;
}

/* ===================================================
   SIDEBAR STYLES (Berita Terkini & Terpopuler)
   =================================================== */
.pendaftaran-sidebar-col {
    display: flex;
    flex-direction: column;
    gap: 24px;
    position: sticky;
    top: 95px;
}

.sidebar-news-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    overflow: hidden;
}

.news-tabs-header {
    background: #ffffff;
    border-bottom: 1px solid #e2e8f0;
}

.news-tabs-nav {
    display: flex;
    background: #f8fafc;
    padding: 6px 6px 0;
    gap: 4px;
}

.news-tab-trigger {
    flex: 1;
    padding: 11px 12px;
    border: none;
    background: transparent;
    font-family: 'Poppins', sans-serif;
    font-size: 0.8rem;
    font-weight: 700;
    color: #64748b;
    cursor: pointer;
    border-radius: 6px 6px 0 0;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    position: relative;
}

.news-tab-trigger.active {
    background: #ffffff;
    color: #CC0000;
    box-shadow: 0 -2px 8px rgba(0,0,0,0.04);
}
.news-tab-trigger.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 3px;
    background: #CC0000;
}
.news-tab-trigger:hover:not(.active) {
    color: #1e293b;
    background: rgba(0,0,0,0.02);
}

.news-tab-body {
    padding: 18px 20px;
}

.news-tab-pane {
    display: none;
    flex-direction: column;
    gap: 16px;
}
.news-tab-pane.active {
    display: flex;
}

.news-sidebar-item {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    text-decoration: none;
    color: inherit;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
    transition: transform 0.2s ease;
}
.news-sidebar-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.news-sidebar-item:hover {
    transform: translateX(3px);
}
.news-sidebar-item:hover .news-item-title {
    color: #CC0000;
}

.news-item-thumb-wrap {
    position: relative;
    width: 82px;
    height: 62px;
    flex-shrink: 0;
    border-radius: 6px;
    overflow: hidden;
    background: #f1f5f9;
    border: 1px solid #f1f5f9;
}
.news-item-thumb {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}
.news-sidebar-item:hover .news-item-thumb {
    transform: scale(1.06);
}

.news-thumb-fallback {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 1.1rem;
    background: #f8fafc;
}

.news-rank-badge {
    position: absolute;
    top: 4px;
    left: 4px;
    width: 20px;
    height: 20px;
    border-radius: 4px;
    font-size: 0.68rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    background: #475569;
    box-shadow: 0 2px 4px rgba(0,0,0,0.25);
    z-index: 2;
}
.news-rank-1 { background: #eab308; color: #1e293b; }
.news-rank-2 { background: #94a3b8; color: #fff; }
.news-rank-3 { background: #d97706; color: #fff; }

.news-item-content {
    flex: 1;
    min-width: 0;
}
.news-item-cat {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #CC0000;
    margin-bottom: 2px;
    display: inline-block;
    letter-spacing: 0.3px;
}
.news-item-title {
    font-size: 0.8rem;
    font-weight: 700;
    line-height: 1.35;
    color: #1e293b;
    margin-bottom: 5px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.2s ease;
}
.news-item-meta {
    font-size: 0.71rem;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 12px;
}
.news-item-meta span {
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.news-card-footer {
    padding: 12px 18px;
    background: #f8fafc;
    border-top: 1px solid #f1f5f9;
    text-align: center;
}
.btn-see-all-news {
    font-size: 0.78rem;
    font-weight: 700;
    color: #CC0000;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}
.btn-see-all-news:hover {
    gap: 10px;
    color: #990000;
}

/* Sidebar Help Card */
.sidebar-help-card {
    background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
    border: 1px solid #bbf7d0;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 16px rgba(16, 185, 129, 0.05);
}
.help-card-head {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}
.help-card-head i {
    font-size: 1.4rem;
    color: #16a34a;
}
.help-card-head h4 {
    margin: 0;
    font-size: 0.9rem;
    font-weight: 700;
    color: #065f46;
}
.sidebar-help-card p {
    font-size: 0.78rem;
    line-height: 1.55;
    color: #166534;
    margin: 0 0 14px;
}
.btn-sidebar-wa {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 9px 14px;
    background: #16a34a;
    color: #ffffff !important;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);
    transition: all 0.2s ease;
    box-sizing: border-box;
}
.btn-sidebar-wa:hover {
    background: #15803d;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(22, 163, 74, 0.35);
}

/* Sidebar Benefit Card */
.sidebar-benefit-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.03);
}
.benefit-card-title {
    margin: 0 0 12px;
    font-size: 0.88rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 8px;
}
.benefit-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 9px;
}
.benefit-list li {
    font-size: 0.77rem;
    line-height: 1.45;
    color: #475569;
    display: flex;
    align-items: flex-start;
    gap: 8px;
}
.benefit-list li i {
    color: #10b981;
    font-size: 0.82rem;
    margin-top: 3px;
    flex-shrink: 0;
}

@media (max-width: 680px) {
    .form-row-2 {
        grid-template-columns: 1fr;
        gap: 14px;
    }
    .reg-form-body {
        padding: 20px 18px;
    }
    .news-tab-trigger {
        font-size: 0.75rem;
        padding: 9px 8px;
    }
}
@endsection

@section('content')
<div class="pendaftaran-page-wrapper">
    <div class="pendaftaran-inner">

        {{-- Top Navigation & Breadcrumbs --}}
        <div class="pendaftaran-topbar">
            <a href="{{ route('panduan-pendaftaran') }}" class="btn-back-panduan">
                <i class="fas fa-arrow-left"></i> Kembali ke Panduan Pendaftaran
            </a>
            <span class="step-indicator">
                <i class="fas fa-edit"></i> Langkah 2: Pengisian Formulir
            </span>
        </div>

        {{-- 2-Column Grid Layout (Formulir + Berita Sidebar) --}}
        <div class="pendaftaran-grid-layout">

            {{-- Kolom Kiri: Formulir Pendaftaran --}}
            <div class="pendaftaran-main-col">

                {{-- Success / Error Alerts --}}
                <div class="pendaftaran-alerts">
                    @if(session('register_success'))
                        <div class="pendaftaran-alert alert-box-success">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong style="font-size:0.95rem;">Pendaftaran Berhasil Dikirim!</strong>
                                <p style="margin:4px 0 10px;">{{ session('register_success') }}</p>
                                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                                    <a href="{{ route('home') }}" class="btn-back-panduan" style="background:#065f46; color:#fff; border-color:#065f46;">
                                        <i class="fas fa-home"></i> Kembali ke Beranda
                                    </a>
                                    <a href="{{ route('panduan-pendaftaran') }}" class="btn-back-panduan">
                                        <i class="fas fa-book"></i> Lihat Panduan
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="pendaftaran-alert alert-box-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div>
                                <strong>Mohon Periksa Kembali Isian Anda:</strong>
                                <ul style="margin:6px 0 0; padding-left:18px;">
                                    @foreach($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Main Form Card (Matching Image 2) --}}
                <div class="reg-form-card">
                    <div class="reg-form-header">
                        {{ $formHeader }}
                    </div>

                    <form method="POST" action="{{ route('backoffice.register.submit') }}" enctype="multipart/form-data" class="reg-form-body" id="formPendaftaranKhusus">
                        @csrf
                        <input type="hidden" name="role" value="{{ $role }}">

                        {{-- Row 1: Nama Lengkap & Tanggal Lahir --}}
                        <div class="form-row-2">
                            <div class="form-group-item">
                                <label for="reg_name">Nama Lengkap</label>
                                <input type="text" id="reg_name" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap..." required>
                            </div>
                            <div class="form-group-item">
                                <label for="reg_tgl" style="cursor: pointer;">Tanggal Lahir</label>
                                <input type="date" id="reg_tgl" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" placeholder="Tanggal Lahir..." onclick="try { this.showPicker(); } catch(e) {}">
                            </div>
                        </div>

                        {{-- Row 2: No.Hp/WA & Email --}}
                        <div class="form-row-2">
                            <div class="form-group-item">
                                <label for="reg_phone">No.Hp/WA</label>
                                <input type="text" id="reg_phone" name="phone" value="{{ old('phone') }}" placeholder="Nomer Hp/WA..." required>
                            </div>
                            <div class="form-group-item">
                                <label for="reg_email">Email</label>
                                <input type="email" id="reg_email" name="email" value="{{ old('email') }}" placeholder="Email..." required>
                            </div>
                        </div>

                        {{-- Row 3: Alamat Domisili & Provinsi --}}
                        <div class="form-row-2">
                            <div class="form-group-item">
                                <label for="reg_address">Alamat Domisili</label>
                                <textarea id="reg_address" name="address" rows="3" placeholder="Alamat Domisili...">{{ old('address') }}</textarea>
                            </div>
                            <div class="form-group-item">
                                <label for="reg_provinsi">Provinsi</label>
                                <select id="reg_provinsi" name="provinsi">
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $prov)
                                        <option value="{{ $prov }}" {{ old('provinsi') == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Row 4: Foto Setengah Badan --}}
                        <div class="form-group-item upload-box-wrap">
                            <label>Foto Setengah Badan untuk Kartu Tanda Anggota (KTA)</label>
                            <div class="drag-drop-zone" id="drop_foto" onclick="document.getElementById('input_foto').click()">
                                <div class="upload-placeholder" id="placeholder_foto">
                                    <svg class="cloud-upload-svg" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"/>
                                        <polyline points="12 12 12 16"/>
                                        <polyline points="9 13 12 10 15 13"/>
                                    </svg>
                                    <span class="drag-text" id="text_foto">Drag atau drop untuk memilih gambar</span>
                                </div>
                                <div class="upload-preview-container" id="preview_foto" style="display:none;">
                                    <div class="preview-img-wrap" id="img_wrap_foto">
                                        <img src="" id="img_preview_foto" class="upload-preview-img" alt="Preview Foto">
                                    </div>
                                    <div class="preview-info">
                                        <span class="preview-filename" id="name_preview_foto"></span>
                                        <span class="preview-btn-change"><i class="fas fa-camera"></i> Ganti Foto</span>
                                    </div>
                                </div>
                                <input type="file" id="input_foto" name="foto" accept="image/*" style="display:none;" onchange="previewUpload(this, 'foto')">
                            </div>
                            <div class="upload-note">note: ukuran gambar 600x350 pixel. (recommended)</div>
                        </div>

                        {{-- Row 5: Unggah CV --}}
                        <div class="form-group-item upload-box-wrap">
                            <label>Unggah CV</label>
                            <div class="drag-drop-zone" id="drop_cv" onclick="document.getElementById('input_cv').click()">
                                <div class="upload-placeholder" id="placeholder_cv">
                                    <svg class="cloud-upload-svg" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"/>
                                        <polyline points="12 12 12 16"/>
                                        <polyline points="9 13 12 10 15 13"/>
                                    </svg>
                                    <span class="drag-text" id="text_cv">Drag atau drop untuk memilih berkas</span>
                                </div>
                                <div class="upload-preview-container" id="preview_cv" style="display:none;">
                                    <div class="preview-img-wrap" id="img_wrap_cv" style="display:none;">
                                        <img src="" id="img_preview_cv" class="upload-preview-img" alt="Preview CV">
                                    </div>
                                    <div class="preview-doc-wrap" id="doc_wrap_cv" style="display:none;"></div>
                                    <div class="preview-info">
                                        <span class="preview-filename" id="name_preview_cv"></span>
                                        <span class="preview-btn-change"><i class="fas fa-sync-alt"></i> Ganti Berkas</span>
                                    </div>
                                </div>
                                <input type="file" id="input_cv" name="cv_file" accept=".pdf,.doc,.docx,image/*" style="display:none;" onchange="previewUpload(this, 'cv')">
                            </div>
                            <div class="upload-note">note: ukuran file maksimal 2MB</div>
                        </div>

                        {{-- Row 6: Unggah Bukti Kontribusi KTA --}}
                        <div class="form-group-item upload-box-wrap">
                            <label>Unggah Bukti Kontribusi KTA</label>
                            <div class="drag-drop-zone" id="drop_bukti" onclick="document.getElementById('input_bukti').click()">
                                <div class="upload-placeholder" id="placeholder_bukti">
                                    <svg class="cloud-upload-svg" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"/>
                                        <polyline points="12 12 12 16"/>
                                        <polyline points="9 13 12 10 15 13"/>
                                    </svg>
                                    <span class="drag-text" id="text_bukti">Drag atau drop untuk memilih gambar / berkas</span>
                                </div>
                                <div class="upload-preview-container" id="preview_bukti" style="display:none;">
                                    <div class="preview-img-wrap" id="img_wrap_bukti" style="display:none;">
                                        <img src="" id="img_preview_bukti" class="upload-preview-img" alt="Preview Bukti">
                                    </div>
                                    <div class="preview-doc-wrap" id="doc_wrap_bukti" style="display:none;"></div>
                                    <div class="preview-info">
                                        <span class="preview-filename" id="name_preview_bukti"></span>
                                        <span class="preview-btn-change"><i class="fas fa-sync-alt"></i> Ganti Berkas</span>
                                    </div>
                                </div>
                                <input type="file" id="input_bukti" name="bukti_kontribusi" accept="image/*,.pdf" style="display:none;" onchange="previewUpload(this, 'bukti')">
                            </div>
                        </div>

                        {{-- Action Buttons: Reset & Submit --}}
                        <div class="reg-form-actions">
                            <button type="reset" class="btn-form-reset" onclick="resetFormCustom()">Reset</button>
                            <button type="submit" class="btn-form-submit">
                                <i class="fas fa-paper-plane"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>

                <div class="pendaftaran-footer-note">
                    <p style="margin: 0;">
                        Data pendaftaran Anda akan diverifikasi dalam waktu maksimal <strong>2 x 24 jam</strong>.<br>
                        Setelah diverifikasi, Kartu Tanda Anggota (KTA) dan akun login akan dikirimkan ke email yang Anda daftarkan.
                    </p>
                    <div style="margin-top: 12px;">
                        Sudah memiliki akun? <a href="{{ route('backoffice.login') }}" style="color: #CC0000; font-weight: 700; text-decoration: none;">Login di sini</a>
                    </div>
                </div>

            </div>

            {{-- Kolom Kanan: Sidebar Berita & Informasi --}}
            <aside class="pendaftaran-sidebar-col">

                {{-- Widget Tab: Berita Terkini & Terpopuler --}}
                <div class="sidebar-news-card">
                    <div class="news-tabs-header">
                        <div class="news-tabs-nav" role="tablist">
                            <button type="button" class="news-tab-trigger active" id="tabTriggerTerkini" onclick="switchNewsTab('terkini')">
                                <i class="fas fa-bolt" style="color:#CC0000;"></i> Berita Terkini
                            </button>
                            <button type="button" class="news-tab-trigger" id="tabTriggerPopuler" onclick="switchNewsTab('populer')">
                                <i class="fas fa-fire" style="color:#f59e0b;"></i> Terpopuler
                            </button>
                        </div>
                    </div>

                    <div class="news-tab-body">
                        {{-- Pane 1: Berita Terkini --}}
                        <div class="news-tab-pane active" id="paneNewsTerkini">
                            @forelse($beritaTerkini as $b)
                            <a href="{{ route('berita.show', $b->id) }}" class="news-sidebar-item" target="_blank">
                                <div class="news-item-thumb-wrap">
                                    @if($b->image)
                                        <img src="{{ asset('storage/' . $b->image) }}" alt="{{ $b->title }}" class="news-item-thumb">
                                    @else
                                        <div class="news-thumb-fallback"><i class="fas fa-newspaper"></i></div>
                                    @endif
                                </div>
                                <div class="news-item-content">
                                    <span class="news-item-cat">{{ $b->kategori }}</span>
                                    <div class="news-item-title">{{ $b->title }}</div>
                                    <div class="news-item-meta">
                                        <span><i class="far fa-calendar-alt"></i> {{ $b->published_at ? $b->published_at->format('d M Y') : $b->created_at->format('d M Y') }}</span>
                                        <span><i class="far fa-eye"></i> {{ number_format($b->views ?? 0) }}</span>
                                    </div>
                                </div>
                            </a>
                            @empty
                            <p style="color:#94a3b8; font-size:0.8rem; text-align:center; margin:16px 0;">Belum ada berita terkini.</p>
                            @endforelse
                        </div>

                        {{-- Pane 2: Berita Terpopuler --}}
                        <div class="news-tab-pane" id="paneNewsPopuler">
                            @forelse($beritaTerpopuler as $idx => $bp)
                            <a href="{{ route('berita.show', $bp->id) }}" class="news-sidebar-item" target="_blank">
                                <div class="news-item-thumb-wrap">
                                    <span class="news-rank-badge news-rank-{{ $idx + 1 }}">{{ $idx + 1 }}</span>
                                    @if($bp->image)
                                        <img src="{{ asset('storage/' . $bp->image) }}" alt="{{ $bp->title }}" class="news-item-thumb">
                                    @else
                                        <div class="news-thumb-fallback"><i class="fas fa-fire"></i></div>
                                    @endif
                                </div>
                                <div class="news-item-content">
                                    <span class="news-item-cat">{{ $bp->kategori }}</span>
                                    <div class="news-item-title">{{ $bp->title }}</div>
                                    <div class="news-item-meta">
                                        <span><i class="fas fa-eye" style="color:#CC0000;"></i> {{ number_format($bp->views ?? 0) }} views</span>
                                    </div>
                                </div>
                            </a>
                            @empty
                            <p style="color:#94a3b8; font-size:0.8rem; text-align:center; margin:16px 0;">Belum ada berita populer.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="news-card-footer">
                        <a href="{{ route('berita.index') }}" class="btn-see-all-news" target="_blank">
                            Lihat Semua Berita <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                {{-- Widget 2: Hotline Bantuan Pendaftaran --}}
                <div class="sidebar-help-card">
                    <div class="help-card-head">
                        <i class="fab fa-whatsapp"></i>
                        <h4>Butuh Bantuan?</h4>
                    </div>
                    <p>
                        Mengalami kendala saat mengisi data diri atau unggah berkas? Tim kami siap membantu Anda melalui layanan WhatsApp:
                    </p>
                    <div style="display:flex; flex-direction:column; gap:8px;">
                        <a href="https://wa.me/6282144814593?text=Halo%20Admin%20Denpasar%20Institute,%20saya%20butuh%20bantuan%20terkait%20pendaftaran." target="_blank" rel="noopener noreferrer" class="btn-sidebar-wa">
                            <i class="fab fa-whatsapp"></i> Admin 1 (0821-4481-4593)
                        </a>
                        <a href="https://wa.me/6282318666547?text=Halo%20Admin%20Denpasar%20Institute,%20saya%20butuh%20bantuan%20terkait%20pendaftaran." target="_blank" rel="noopener noreferrer" class="btn-sidebar-wa" style="background:#059669;">
                            <i class="fab fa-whatsapp"></i> Admin 2 (0823-1866-6547)
                        </a>
                    </div>
                </div>

                {{-- Widget 3: Manfaat Keanggotaan --}}
                <div class="sidebar-benefit-card">
                    <h4 class="benefit-card-title">
                        <i class="fas fa-certificate" style="color:#eab308;"></i> Manfaat Keanggotaan
                    </h4>
                    <ul class="benefit-list">
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Penerbitan <strong>Kartu Tanda Anggota (KTA)</strong> resmi ber-Nomor Anggota.</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Jejaring profesional riset, akademisi, dan praktisi industri se-Indonesia.</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Peluang kolaborasi proyek konsultansi, riset ilmiah, dan pengabdian.</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Akses informasi kegiatan workshop, seminar, dan agenda institusi.</span>
                        </li>
                    </ul>
                </div>

            </aside>

        </div>

    </div>
</div>

<script>
// Switch tabs between Berita Terkini and Berita Terpopuler
function switchNewsTab(tab) {
    const triggerTerkini = document.getElementById('tabTriggerTerkini');
    const triggerPopuler = document.getElementById('tabTriggerPopuler');
    const paneTerkini = document.getElementById('paneNewsTerkini');
    const panePopuler = document.getElementById('paneNewsPopuler');

    if (tab === 'terkini') {
        triggerTerkini.classList.add('active');
        triggerPopuler.classList.remove('active');
        paneTerkini.classList.add('active');
        panePopuler.classList.remove('active');
    } else {
        triggerPopuler.classList.add('active');
        triggerTerkini.classList.remove('active');
        panePopuler.classList.add('active');
        paneTerkini.classList.remove('active');
    }
}

function previewUpload(input, type) {
    const file = input.files && input.files[0];
    if (!file) return;

    const placeholder = document.getElementById('placeholder_' + type);
    const previewContainer = document.getElementById('preview_' + type);
    const filenameEl = document.getElementById('name_preview_' + type);
    const imgPreview = document.getElementById('img_preview_' + type);
    const imgWrap = document.getElementById('img_wrap_' + type);
    const docWrap = document.getElementById('doc_wrap_' + type);

    // Format ukuran file
    const sizeStr = file.size > 1048576 
        ? (file.size / 1048576).toFixed(1) + ' MB' 
        : Math.round(file.size / 1024) + ' KB';

    if (filenameEl) {
        filenameEl.textContent = '✓ ' + file.name + ' (' + sizeStr + ')';
    }

    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            if (imgPreview) {
                imgPreview.src = e.target.result;
            }
            if (imgWrap) imgWrap.style.display = 'flex';
            if (docWrap) docWrap.style.display = 'none';
            if (placeholder) placeholder.style.display = 'none';
            if (previewContainer) previewContainer.style.display = 'flex';
        };
        reader.readAsDataURL(file);
    } else {
        // Berkas Dokumen (PDF, DOC, dll)
        if (imgWrap) imgWrap.style.display = 'none';
        if (docWrap) {
            docWrap.style.display = 'flex';
            if (file.name.endsWith('.pdf')) {
                docWrap.innerHTML = '<i class="fas fa-file-pdf" style="color:#ef4444; font-size:2.4rem;"></i>';
            } else if (file.name.endsWith('.doc') || file.name.endsWith('.docx')) {
                docWrap.innerHTML = '<i class="fas fa-file-word" style="color:#2563eb; font-size:2.4rem;"></i>';
            } else {
                docWrap.innerHTML = '<i class="fas fa-file-alt" style="color:#64748b; font-size:2.4rem;"></i>';
            }
        }
        if (placeholder) placeholder.style.display = 'none';
        if (previewContainer) previewContainer.style.display = 'flex';
    }
}

function updateUploadLabel(input, labelId) {
    const type = labelId.replace('text_', '');
    previewUpload(input, type);
}

function resetFormCustom() {
    setTimeout(() => {
        ['foto', 'cv', 'bukti'].forEach(type => {
            const placeholder = document.getElementById('placeholder_' + type);
            const previewContainer = document.getElementById('preview_' + type);
            const imgPreview = document.getElementById('img_preview_' + type);
            const input = document.getElementById('input_' + type);

            if (input) input.value = '';
            if (imgPreview) imgPreview.src = '';
            if (previewContainer) previewContainer.style.display = 'none';
            if (placeholder) placeholder.style.display = 'flex';
        });
    }, 50);
}

// Drag & Drop event handlers
['foto', 'cv', 'bukti'].forEach(type => {
    const zone = document.getElementById('drop_' + type);
    const input = document.getElementById('input_' + type);
    if (!zone || !input) return;

    ['dragenter', 'dragover'].forEach(eventName => {
        zone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            zone.classList.add('dragover');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        zone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            zone.classList.remove('dragover');
        }, false);
    });

    zone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files && files.length > 0) {
            input.files = files;
            previewUpload(input, type);
        }
    }, false);
});

// Otomatis buka date picker saat kolom tanggal diklik
document.querySelectorAll('input[type="date"]').forEach(function(dateEl) {
    dateEl.addEventListener('click', function() {
        if (typeof this.showPicker === 'function') {
            try { this.showPicker(); } catch (err) {}
        }
    });
});
</script>
@endsection
