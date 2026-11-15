@extends('backoffice.layouts.app')

@section('title', 'Tambah Mitra & Klien Baru')

@section('content')
<div class="container-fluid" style="padding:24px;">
    
    {{-- Header --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
        <div>
            <h4 style="margin:0;font-weight:700;">Tambah Mitra &amp; Klien Baru</h4>
            <small class="text-muted">Tambahkan data mitra institusi atau perusahaan langsung ke database Denpasar Institute.</small>
        </div>
        <a href="{{ route('backoffice.partnership-submission.index', ['status' => 'approved']) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Mitra
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('backoffice.partnership-submission.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    {{-- Nama Institusi --}}
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Nama Institusi / Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" name="institusi" class="form-control @error('institusi') is-invalid @enderror" value="{{ old('institusi') }}" placeholder="Contoh: Universitas Dwijendra / PT PLN (Persero)" required>
                    </div>

                    {{-- Kategori --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Kategori Mitra</label>
                        <input type="text" name="kategori" class="form-control" list="kategoriList" value="{{ old('kategori', 'Perguruan Tinggi') }}" placeholder="Pilih atau ketik baru...">
                        <datalist id="kategoriList">
                            <option value="Perguruan Tinggi">
                            <option value="BUMN / BUMD">
                            <option value="Industri & Korporasi">
                            <option value="Lembaga Pemerintah">
                            <option value="Konsultan & Profesi">
                            <option value="Komunitas & Yayasan">
                        </datalist>
                    </div>

                    {{-- Logo Upload --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Logo Institusi / Perusahaan</label>
                        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*" onchange="previewLogo(this)">
                        <small class="text-muted">Format: PNG, JPG, WebP, SVG. Maks 3MB. Disarankan background transparan.</small>
                        <div id="logoPreviewWrap" class="mt-2 text-center p-2 border rounded" style="display:none;background:#f8fafc;">
                            <img id="logoPreview" src="#" alt="Preview" style="max-height:80px;object-fit:contain;">
                        </div>
                    </div>

                    {{-- Website --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Website Resmi Institusi</label>
                        <input type="text" name="website" class="form-control" value="{{ old('website') }}" placeholder="https://www.institusi.ac.id">
                    </div>

                    {{-- Nama PIC --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama PIC / Narahubung</label>
                        <input type="text" name="nama_pic" class="form-control" value="{{ old('nama_pic') }}" placeholder="Contoh: Dr. I Made Wijaya, M.Si.">
                    </div>

                    {{-- Nomor WhatsApp --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nomor WhatsApp Aktif</label>
                        <input type="text" name="no_wa" class="form-control" value="{{ old('no_wa') }}" placeholder="Contoh: 081234567890">
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email PIC / Resmi</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="kerjasama@institusi.ac.id">
                    </div>

                    {{-- Link Google Maps --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tautan Google Maps Kampus / Kantor</label>
                        <input type="text" name="link_gmap" class="form-control" value="{{ old('link_gmap') }}" placeholder="https://maps.app.goo.gl/...">
                    </div>

                    {{-- Minat Pilar Kemitraan --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Pilar Kemitraan Terkait</label>
                        <select name="pillar_slug" class="form-select" onchange="updatePillarTitle(this)">
                            <option value="">-- Pilih Pilar (Opsional) --</option>
                            @foreach($pillars as $pil)
                                <option value="{{ $pil->slug }}" data-title="{{ $pil->title }}">{{ $pil->title }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="pillar_title" id="pillarTitleHidden" value="">
                    </div>

                    {{-- Urutan Tampil --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Urutan Tampil</label>
                        <input type="number" name="urutan" class="form-control" value="{{ old('urutan', 0) }}" min="0">
                        <small class="text-muted">Angka lebih kecil tampil lebih awal di grid.</small>
                    </div>

                    {{-- Status Verifikasi --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Status Verifikasi <span class="text-danger">*</span></label>
                        <select name="status" class="form-select">
                            <option value="approved" selected>Disetujui / Tayang di Web</option>
                            <option value="pending">Menunggu Verifikasi (Pending)</option>
                            <option value="rejected">Ditolak (Rejected)</option>
                        </select>
                    </div>

                    {{-- Catatan Kerjasama --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">Catatan / Deskripsi Kerjasama</label>
                        <textarea name="pesan" class="form-control" rows="3" placeholder="Gambaran singkat bentuk kerja sama, riset, atau sertifikasi...">{{ old('pesan') }}</textarea>
                    </div>

                    {{-- Catatan Internal Admin --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">Catatan Internal Super Admin</label>
                        <input type="text" name="admin_notes" class="form-control" value="{{ old('admin_notes', 'Ditambahkan langsung oleh Super Admin.') }}" placeholder="Catatan internal pengurus (tidak tampil di publik)...">
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('backoffice.partnership-submission.index') }}" class="btn btn-light border">Batal</a>
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-save me-1"></i> Simpan Mitra
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewLogo(input) {
    var wrap = document.getElementById('logoPreviewWrap');
    var img = document.getElementById('logoPreview');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            wrap.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        wrap.style.display = 'none';
    }
}

function updatePillarTitle(select) {
    var opt = select.options[select.selectedIndex];
    var title = opt.getAttribute('data-title') || '';
    document.getElementById('pillarTitleHidden').value = title;
}
</script>
@endsection

