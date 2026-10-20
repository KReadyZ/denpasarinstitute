@extends('backoffice.layouts.app')

@section('title', 'Ceklist Verifikasi Konsultan - ' . $konsultan->name)
@section('page-title', 'Ceklist Verifikasi Konsultan')

@section('content')
<style>
    .verify-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 24px;
        align-items: start;
    }
    .doc-box {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 16px;
        transition: 0.2s;
    }
    .doc-box:hover {
        border-color: #CC0000;
        box-shadow: 0 4px 12px rgba(204, 0, 0, 0.08);
    }
    .checklist-card {
        background: #fff;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        position: sticky;
        top: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }
    .checklist-card.all-checked {
        border-color: #16a34a;
        background: #f0fdf4;
    }
    .checklist-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px;
        border-radius: 8px;
        background: #f9fafb;
        margin-bottom: 10px;
        border: 1px solid #f0f0f0;
        cursor: pointer;
        transition: 0.2s;
    }
    .checklist-item:hover {
        background: #f3f4f6;
    }
    .checklist-item input[type="checkbox"] {
        width: 20px;
        height: 20px;
        accent-color: #16a34a;
        cursor: pointer;
        margin-top: 2px;
    }
    .checklist-label {
        font-size: 0.84rem;
        font-weight: 700;
        color: #222;
        margin: 0;
        cursor: pointer;
    }
    .checklist-desc {
        font-size: 0.73rem;
        color: #6b7280;
        margin: 2px 0 0 0;
    }
    @media (max-width: 992px) {
        .verify-grid {
            grid-template-columns: 1fr;
        }
        .checklist-card {
            position: static;
        }
    }
</style>

<div style="margin-bottom: 20px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
    <div>
        <h2 style="font-size:1.35rem; font-weight:700; color:var(--dark); margin:0;">
            <i class="fas fa-clipboard-check" style="color:var(--red);"></i> Verifikasi Pendaftaran: {{ $konsultan->name }}
        </h2>
        <p style="color:#6b7280; font-size:0.83rem; margin:4px 0 0 0;">
            Silakan tinjau kelengkapan berkas fisik & administrasi di bawah ini, centang seluruh kriteria kelayakan, kemudian tentukan keputusan.
        </p>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('backoffice.konsultan.verifikasi') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Antrean Verifikasi
        </a>
        <a href="{{ route('backoffice.konsultan.index') }}" class="btn btn-light">
            <i class="fas fa-list"></i> Semua Konsultan
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif

<div class="verify-grid">
    {{-- KOLOM KIRI: DATA PENDAFTAR & DOKUMEN --}}
    <div>
        {{-- CARD 1: DOKUMEN LAMPIRAN --}}
        <div class="card mb-4" style="border:1px solid #e5e7eb; border-radius:12px; margin-bottom:24px;">
            <div class="card-header" style="background:#fff; border-bottom:1px solid #f0f0f0; padding:16px 20px; display:flex; justify-content:space-between; align-items:center;">
                <h4 style="margin:0; font-size:1rem; font-weight:700; color:#111;">
                    <i class="fas fa-folder-open" style="color:#CC0000;"></i> 1. Dokumen Lampiran Pendaftar
                </h4>
                <span class="badge" style="background:#fee2e2; color:#CC0000; font-size:0.75rem;">3 Berkas Wajib</span>
            </div>
            <div class="card-body" style="padding:20px;">
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:18px;">
                    
                    {{-- DOKUMEN 1: FOTO KTA --}}
                    <div class="doc-box">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <strong style="font-size:0.82rem; color:#222;"><i class="fas fa-camera"></i> Foto KTA (350x350)</strong>
                            <span class="badge" style="background:{{ $konsultan->foto ? '#dcfce7' : '#fee2e2' }}; color:{{ $konsultan->foto ? '#166534' : '#991b1b' }}; font-size:0.68rem;">
                                {{ $konsultan->foto ? 'Terlampir' : 'Kosong' }}
                            </span>
                        </div>
                        <div style="text-align:center; padding:10px 0;">
                            @if($konsultan->foto)
                                <img src="{{ asset('storage/' . $konsultan->foto) }}" alt="Foto KTA" style="width:130px; height:130px; object-fit:cover; border-radius:8px; border:2px solid #CC0000; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
                                <div style="margin-top:12px;">
                                    <a href="{{ asset('storage/' . $konsultan->foto) }}" target="_blank" class="btn btn-sm btn-secondary" style="font-size:0.74rem;">
                                        <i class="fas fa-search-plus"></i> Buka Foto Penuh
                                    </a>
                                </div>
                            @else
                                <div style="height:130px; display:flex; flex-direction:column; align-items:center; justify-content:center; color:#9ca3af; border:2px dashed #e5e7eb; border-radius:8px;">
                                    <i class="fas fa-image" style="font-size:2rem; margin-bottom:6px;"></i>
                                    <span style="font-size:0.75rem;">Tidak ada foto KTA</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- DOKUMEN 2: CV --}}
                    <div class="doc-box">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <strong style="font-size:0.82rem; color:#222;"><i class="fas fa-file-alt"></i> Curriculum Vitae (CV)</strong>
                            <span class="badge" style="background:{{ $konsultan->cv_path ? '#dcfce7' : '#fee2e2' }}; color:{{ $konsultan->cv_path ? '#166534' : '#991b1b' }}; font-size:0.68rem;">
                                {{ $konsultan->cv_path ? 'Terlampir' : 'Kosong' }}
                            </span>
                        </div>
                        <div style="text-align:center; padding:10px 0;">
                            @if($konsultan->cv_path)
                                @php
                                    $isCvImg = in_array(strtolower(pathinfo($konsultan->cv_path, PATHINFO_EXTENSION)), ['jpg','jpeg','png','webp','gif']);
                                @endphp
                                @if($isCvImg)
                                    <img src="{{ asset('storage/' . $konsultan->cv_path) }}" alt="CV Pendaftar" style="width:130px; height:130px; object-fit:cover; border-radius:8px; border:2px solid #2563eb; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
                                @else
                                    <div style="height:130px; display:flex; flex-direction:column; align-items:center; justify-content:center; background:#f9fafb; border-radius:8px; border:1px solid #eee;">
                                        <i class="fas fa-file-pdf" style="font-size:3rem; color:#CC0000; margin-bottom:6px;"></i>
                                        <span style="font-size:0.75rem; color:#444; font-weight:600;">File Dokumen CV</span>
                                    </div>
                                @endif
                                <div style="margin-top:12px;">
                                    <a href="{{ asset('storage/' . $konsultan->cv_path) }}" target="_blank" class="btn btn-sm btn-info" style="font-size:0.74rem;">
                                        <i class="fas fa-external-link-alt"></i> Buka & Periksa CV
                                    </a>
                                </div>
                            @else
                                <div style="height:130px; display:flex; flex-direction:column; align-items:center; justify-content:center; color:#9ca3af; border:2px dashed #e5e7eb; border-radius:8px;">
                                    <i class="fas fa-file-excel" style="font-size:2rem; margin-bottom:6px;"></i>
                                    <span style="font-size:0.75rem;">Tidak ada file CV</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- DOKUMEN 3: BUKTI KONTRIBUSI --}}
                    <div class="doc-box">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <strong style="font-size:0.82rem; color:#222;"><i class="fas fa-receipt"></i> Bukti Kontribusi KTA</strong>
                            <span class="badge" style="background:{{ $konsultan->bukti_kontribusi ? '#dcfce7' : '#fee2e2' }}; color:{{ $konsultan->bukti_kontribusi ? '#166534' : '#991b1b' }}; font-size:0.68rem;">
                                {{ $konsultan->bukti_kontribusi ? 'Terlampir' : 'Kosong' }}
                            </span>
                        </div>
                        <div style="text-align:center; padding:10px 0;">
                            @if($konsultan->bukti_kontribusi)
                                @php
                                    $isImage = in_array(strtolower(pathinfo($konsultan->bukti_kontribusi, PATHINFO_EXTENSION)), ['jpg','jpeg','png','webp']);
                                @endphp
                                @if($isImage)
                                    <img src="{{ asset('storage/' . $konsultan->bukti_kontribusi) }}" alt="Bukti Kontribusi" style="width:130px; height:130px; object-fit:cover; border-radius:8px; border:2px solid #16a34a; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
                                @else
                                    <div style="height:130px; display:flex; flex-direction:column; align-items:center; justify-content:center; background:#f9fafb; border-radius:8px; border:1px solid #eee;">
                                        <i class="fas fa-receipt" style="font-size:3rem; color:#16a34a; margin-bottom:6px;"></i>
                                        <span style="font-size:0.75rem; color:#444; font-weight:600;">Struk / Bukti Dokumen</span>
                                    </div>
                                @endif
                                <div style="margin-top:12px;">
                                    <a href="{{ asset('storage/' . $konsultan->bukti_kontribusi) }}" target="_blank" class="btn btn-sm btn-success" style="font-size:0.74rem;">
                                        <i class="fas fa-search-dollar"></i> Buka Bukti Transfer
                                    </a>
                                </div>
                            @else
                                <div style="height:130px; display:flex; flex-direction:column; align-items:center; justify-content:center; color:#9ca3af; border:2px dashed #e5e7eb; border-radius:8px;">
                                    <i class="fas fa-receipt" style="font-size:2rem; margin-bottom:6px;"></i>
                                    <span style="font-size:0.75rem;">Belum ada bukti kontribusi</span>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- CARD 2: DETAIL IDENTITAS PENDAFTAR --}}
        <div class="card" style="border:1px solid #e5e7eb; border-radius:12px;">
            <div class="card-header" style="background:#fff; border-bottom:1px solid #f0f0f0; padding:16px 20px; display:flex; justify-content:space-between; align-items:center;">
                <h4 style="margin:0; font-size:1rem; font-weight:700; color:#111;">
                    <i class="fas fa-user-check" style="color:#CC0000;"></i> 2. Identitas Lengkap Pendaftar
                </h4>
                <a href="{{ route('backoffice.konsultan.edit', $konsultan->id) }}" class="btn btn-sm btn-warning" target="_blank">
                    <i class="fas fa-edit"></i> Edit Data
                </a>
            </div>
            <div class="card-body" style="padding:20px;">
                <table style="width:100%; border-collapse:collapse; font-size:0.85rem;">
                    <tbody>
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td style="padding:10px 14px; width:220px; font-weight:700; color:#444;">Nama Lengkap</td>
                            <td style="padding:10px 14px; font-weight:700; color:#111; font-size:0.95rem;">{{ $konsultan->name }}</td>
                        </tr>
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td style="padding:10px 14px; font-weight:700; color:#444;">Email</td>
                            <td style="padding:10px 14px; color:#111;">
                                {{ $konsultan->email }}
                                <a href="mailto:{{ $konsultan->email }}" class="btn btn-sm btn-light" style="padding:2px 8px; font-size:0.7rem; margin-left:8px;">
                                    <i class="fas fa-envelope"></i> Kirim Email
                                </a>
                            </td>
                        </tr>
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td style="padding:10px 14px; font-weight:700; color:#444;">No. Handphone / WhatsApp</td>
                            <td style="padding:10px 14px;">
                                @if($konsultan->phone)
                                    <strong>{{ $konsultan->phone }}</strong>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $konsultan->phone) }}" target="_blank" class="btn btn-sm btn-success" style="padding:2px 8px; font-size:0.7rem; margin-left:8px;">
                                        <i class="fab fa-whatsapp"></i> Chat WhatsApp
                                    </a>
                                @else
                                    <span style="color:#888;">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td style="padding:10px 14px; font-weight:700; color:#444;">Tempat, Tanggal Lahir</td>
                            <td style="padding:10px 14px;">
                                {{ $konsultan->tempat_lahir ?? '-' }}, 
                                {{ $konsultan->tanggal_lahir ? \Carbon\Carbon::parse($konsultan->tanggal_lahir)->format('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td style="padding:10px 14px; font-weight:700; color:#444;">Institusi / Universitas</td>
                            <td style="padding:10px 14px;">{{ $konsultan->institution ?? '-' }}</td>
                        </tr>
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td style="padding:10px 14px; font-weight:700; color:#444;">Jabatan / Profesi</td>
                            <td style="padding:10px 14px;">{{ $konsultan->position ?? '-' }}</td>
                        </tr>
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td style="padding:10px 14px; font-weight:700; color:#444;">Provinsi</td>
                            <td style="padding:10px 14px;">{{ $konsultan->provinsi ?? '-' }} (Kode: {{ $konsultan->kode_provinsi ?? '51' }})</td>
                        </tr>
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td style="padding:10px 14px; font-weight:700; color:#444;">Alamat Tinggal</td>
                            <td style="padding:10px 14px;">{{ $konsultan->address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding:10px 14px; font-weight:700; color:#444;">Tanggal Mendaftar</td>
                            <td style="padding:10px 14px; color:#555;">
                                {{ $konsultan->created_at ? $konsultan->created_at->format('d M Y - H:i') : '-' }} WITA
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: KARTU CEKLIST VERIFIKASI (INTERACTIVE) --}}
    <div>
        <div class="checklist-card" id="checklistCard">
            <div style="border-bottom:2px solid #CC0000; padding-bottom:12px; margin-bottom:16px;">
                <h4 style="margin:0; font-size:1.05rem; font-weight:800; color:#111;">
                    <i class="fas fa-tasks" style="color:#CC0000;"></i> Ceklist Verifikasi
                </h4>
                <p style="font-size:0.75rem; color:#6b7280; margin:4px 0 0 0;">
                    Centang kriteria kelayakan di bawah ini setelah memeriksa berkas:
                </p>
            </div>

            {{-- Progress Counter --}}
            <div style="margin-bottom:16px;">
                <div style="display:flex; justify-content:space-between; font-size:0.78rem; font-weight:700; margin-bottom:6px;">
                    <span id="progressText">0 dari 4 kriteria terpenuhi</span>
                    <span id="progressPercent" style="color:#CC0000;">0%</span>
                </div>
                <div style="width:100%; height:8px; background:#e5e7eb; border-radius:10px; overflow:hidden;">
                    <div id="progressBar" style="width:0%; height:100%; background:#CC0000; transition:width 0.3s;"></div>
                </div>
            </div>

            {{-- Checklist Items --}}
            <div class="checklist-item" onclick="toggleItem('check1')">
                <input type="checkbox" id="check1" class="verify-check" onclick="event.stopPropagation(); updateProgress();">
                <div>
                    <label class="checklist-label" for="check1">1. Data Identitas Valid</label>
                    <p class="checklist-desc">Nama, email, telepon, dan alamat sesuai & dapat dihubungi.</p>
                </div>
            </div>

            <div class="checklist-item" onclick="toggleItem('check2')">
                <input type="checkbox" id="check2" class="verify-check" {{ $konsultan->foto ? '' : 'disabled' }} onclick="event.stopPropagation(); updateProgress();">
                <div>
                    <label class="checklist-label" for="check2">2. Foto KTA Standar</label>
                    <p class="checklist-desc">Foto formal, jelas, dan layak dicetak pada Kartu Tanda Anggota.</p>
                </div>
            </div>

            <div class="checklist-item" onclick="toggleItem('check3')">
                <input type="checkbox" id="check3" class="verify-check" {{ $konsultan->cv_path ? '' : 'disabled' }} onclick="event.stopPropagation(); updateProgress();">
                <div>
                    <label class="checklist-label" for="check3">3. Berkas CV Memenuhi Syarat</label>
                    <p class="checklist-desc">Riwayat pendidikan & profesi konsultan valid terlampir.</p>
                </div>
            </div>

            <div class="checklist-item" onclick="toggleItem('check4')">
                <input type="checkbox" id="check4" class="verify-check" {{ $konsultan->bukti_kontribusi ? '' : 'disabled' }} onclick="event.stopPropagation(); updateProgress();">
                <div>
                    <label class="checklist-label" for="check4">4. Bukti Kontribusi Sah</label>
                    <p class="checklist-desc">Struk transfer kontribusi keanggotaan terkonfirmasi.</p>
                </div>
            </div>

            {{-- Status Banner --}}
            <div id="checklistAlert" style="margin-top:16px; padding:12px; border-radius:8px; font-size:0.78rem; line-height:1.4; background:#fef3c7; color:#92400e; border:1px solid #fde68a;">
                <i class="fas fa-info-circle"></i> Centang seluruh kriteria di atas untuk memastikan pendaftar memenuhi syarat.
            </div>

            {{-- Form Approve --}}
            <form action="{{ route('backoffice.konsultan.approve', $konsultan->id) }}" method="POST" id="approveForm" style="margin-top:16px;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success" id="btnApprove" style="width:100%; padding:12px; font-weight:700; font-size:0.9rem; justify-content:center; box-shadow:0 4px 12px rgba(22, 163, 74, 0.2);">
                    <i class="fas fa-check-circle"></i> Setujui & Terbitkan KTA
                </button>
            </form>

            {{-- Button Reject --}}
            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModalSingle" style="width:100%; margin-top:10px; padding:9px; font-size:0.82rem; justify-content:center; background:#fff; border:1px solid #dc2626; color:#dc2626;">
                <i class="fas fa-times-circle"></i> Tolak Pendaftaran
            </button>
        </div>
    </div>
</div>

{{-- Modal Reject Single --}}
<div class="modal fade" id="rejectModalSingle" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:10px;">
            <div class="modal-header" style="background:#fee2e2; border-bottom:1px solid #fecaca;">
                <h5 class="modal-title" style="font-weight:700; color:#991b1b; font-size:1rem;">
                    <i class="fas fa-exclamation-triangle"></i> Tolak Pendaftaran Konsultan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('backoffice.konsultan.reject', $konsultan->id) }}" method="POST">
                @csrf
                <div class="modal-body" style="padding:20px;">
                    <p style="font-size:0.83rem; color:#444; margin-bottom:12px;">
                        Anda akan menolak pendaftaran atas nama <strong>{{ $konsultan->name }}</strong>. Masukkan alasan penolakan:
                    </p>
                    <div class="form-group">
                        <label style="font-weight:700; font-size:0.8rem; margin-bottom:6px;">Alasan Penolakan <span style="color:red;">*</span></label>
                        <textarea name="rejection_reason" class="form-control" rows="4" placeholder="Contoh: Bukti transfer belum terbaca jelas / CV belum terlampir..." required style="font-size:0.83rem;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #f0f0f0;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Pendaftaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleItem(id) {
    var cb = document.getElementById(id);
    if (cb && !cb.disabled) {
        cb.checked = !cb.checked;
        updateProgress();
    }
}

function updateProgress() {
    var checkboxes = document.querySelectorAll('.verify-check');
    var total = checkboxes.length;
    var checked = 0;

    checkboxes.forEach(function(cb) {
        if (cb.checked) checked++;
    });

    var pct = Math.round((checked / total) * 100);
    document.getElementById('progressText').innerText = checked + ' dari ' + total + ' kriteria terpenuhi';
    document.getElementById('progressPercent').innerText = pct + '%';
    document.getElementById('progressBar').style.width = pct + '%';

    var alertBox = document.getElementById('checklistAlert');
    var card = document.getElementById('checklistCard');
    var bar = document.getElementById('progressBar');

    if (pct === 100) {
        bar.style.background = '#16a34a';
        card.classList.add('all-checked');
        alertBox.style.background = '#dcfce7';
        alertBox.style.color = '#166534';
        alertBox.style.borderColor = '#86efac';
        alertBox.innerHTML = '<i class="fas fa-check-circle"></i> <strong>Semua kriteria terpenuhi!</strong> Berkas lengkap dan akun siap diaktifkan.';
    } else {
        bar.style.background = '#CC0000';
        card.classList.remove('all-checked');
        alertBox.style.background = '#fef3c7';
        alertBox.style.color = '#92400e';
        alertBox.style.borderColor = '#fde68a';
        alertBox.innerHTML = '<i class="fas fa-info-circle"></i> Centang seluruh kriteria di atas untuk memastikan pendaftar memenuhi syarat.';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    updateProgress();
});
</script>
@endpush
@endsection
