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
    max-width: 720px;
    margin: 0 auto;
    padding: 0 16px;
}

.pendaftaran-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    flex-wrap: wrap;
    gap: 10px;
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

/* Upload Dropzone */
.upload-box-wrap {
    margin-bottom: 18px;
}

.drag-drop-zone {
    border: 1.5px dashed #c9c9c9;
    border-radius: 6px;
    padding: 32px 16px;
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
    width: 48px;
    height: 48px;
}

.drag-text {
    font-size: 0.83rem;
    color: #333;
    font-weight: 500;
    text-align: center;
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

@media (max-width: 680px) {
    .form-row-2 {
        grid-template-columns: 1fr;
        gap: 14px;
    }
    .reg-form-body {
        padding: 20px 18px;
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
                        <label for="reg_tgl">Tanggal Lahir</label>
                        <input type="date" id="reg_tgl" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" placeholder="Tanggal Lahir...">
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
                        <svg class="cloud-upload-svg" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"/>
                            <polyline points="12 12 12 16"/>
                            <polyline points="9 13 12 10 15 13"/>
                        </svg>
                        <span class="drag-text" id="text_foto">Drag atau drop untuk memilih gambar</span>
                        <input type="file" id="input_foto" name="foto" accept="image/*" style="display:none;" onchange="updateUploadLabel(this, 'text_foto')">
                    </div>
                    <div class="upload-note">note: ukuran gambar 600x350 pixel. (recommended)</div>
                </div>

                {{-- Row 5: Unggah CV --}}
                <div class="form-group-item upload-box-wrap">
                    <label>Unggah CV</label>
                    <div class="drag-drop-zone" id="drop_cv" onclick="document.getElementById('input_cv').click()">
                        <svg class="cloud-upload-svg" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"/>
                            <polyline points="12 12 12 16"/>
                            <polyline points="9 13 12 10 15 13"/>
                        </svg>
                        <span class="drag-text" id="text_cv">Drag atau drop untuk memilih gambar</span>
                        <input type="file" id="input_cv" name="cv_file" accept=".pdf,.doc,.docx,image/*" style="display:none;" onchange="updateUploadLabel(this, 'text_cv')">
                    </div>
                    <div class="upload-note">note: ukuran file maksimal 2MB</div>
                </div>

                {{-- Row 6: Unggah Bukti Kontribusi KTA --}}
                <div class="form-group-item upload-box-wrap">
                    <label>Unggah Bukti Kontribusi KTA</label>
                    <div class="drag-drop-zone" id="drop_bukti" onclick="document.getElementById('input_bukti').click()">
                        <svg class="cloud-upload-svg" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"/>
                            <polyline points="12 12 12 16"/>
                            <polyline points="9 13 12 10 15 13"/>
                        </svg>
                        <span class="drag-text" id="text_bukti">Drag atau drop untuk memilih gambar</span>
                        <input type="file" id="input_bukti" name="bukti_kontribusi" accept="image/*,.pdf" style="display:none;" onchange="updateUploadLabel(this, 'text_bukti')">
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
</div>

<script>
function updateUploadLabel(input, labelId) {
    const label = document.getElementById(labelId);
    if (input.files && input.files[0]) {
        label.textContent = '✓ ' + input.files[0].name;
        label.style.color = '#16a34a';
        label.style.fontWeight = '700';
    }
}

function resetFormCustom() {
    setTimeout(() => {
        ['text_foto', 'text_cv', 'text_bukti'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.textContent = 'Drag atau drop untuk memilih gambar';
                el.style.color = '';
                el.style.fontWeight = 'normal';
            }
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
            updateUploadLabel(input, 'text_' + type);
        }
    }, false);
});
</script>
@endsection
