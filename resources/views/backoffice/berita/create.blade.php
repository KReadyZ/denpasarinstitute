@extends('backoffice.layouts.app')

@section('title', 'Tambah Berita')
@section('page-title', 'Tambah Berita Baru')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="font-weight-bold text-dark mb-1">
                <i class="fas fa-newspaper text-danger mr-2"></i> Publikasi Berita Baru
            </h4>
            <p class="text-muted small mb-0">Tulis artikel, tentukan foto sampul, dan publikasikan ke portal resmi Denpasar Institute.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('backoffice.berita.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
            </a>
            <button type="button" class="btn btn-danger font-weight-bold" onclick="document.getElementById('formTambahBerita').submit()">
                <i class="fas fa-paper-plane mr-1"></i> Publikasikan
            </button>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle mr-2 font-20"></i>
                <div>
                    <strong>Periksa kembali formulir Anda:</strong>
                    <ul class="mb-0 pl-3 mt-1 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ route('backoffice.berita.store') }}" method="POST" enctype="multipart/form-data" id="formTambahBerita">
        @csrf

        <div class="row">
            {{-- ===== KOLOM KIRI (UTAMA): KONTEN & CAPTION ===== --}}
            <div class="col-lg-8">
                {{-- Card: Judul --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="form-group mb-0">
                            <label for="title" class="font-weight-bold text-dark mb-2">
                                Judul Berita <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" id="title" class="form-control form-control-lg font-weight-bold @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}" required placeholder="Contoh: Denpasar Institute Gelar Pelatihan Internasional 2026..." style="font-size: 1.15rem;">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Card: Konten Berita --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-pen-nib text-danger mr-2"></i> Isi Lengkap Artikel / Berita <span class="text-danger">*</span>
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group mb-0">
                            <textarea name="content" id="content" class="summernote @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Card: Isian Caption Foto --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-closed-captioning text-danger mr-2"></i> Caption / Keterangan Foto Sampul
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group mb-0">
                            <label for="image_caption" class="font-weight-bold text-dark small mb-1">
                                Keterangan Foto (Opsional)
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light text-muted"><i class="fas fa-camera"></i></span>
                                </div>
                                <input type="text" name="image_caption" id="image_caption" class="form-control @error('image_caption') is-invalid @enderror" 
                                       value="{{ old('image_caption') }}" placeholder="Contoh: Suasana workshop di aula kampus (Foto: Dok. Humas DI / Veny Narlianti)">
                            </div>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-info-circle mr-1"></i> Keterangan ini akan ditampilkan rapi tepat di bawah foto artikel pada halaman berita publik.
                            </small>
                            @error('image_caption')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== KOLOM KANAN (SIDEBAR): MEDIA & PENGATURAN ===== --}}
            <div class="col-lg-4">
                {{-- Card: Upload Foto Sampul (Featured Image) --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-image text-danger mr-2"></i> Foto Utama / Sampul Berita
                        </h6>
                    </div>
                    <div class="card-body p-3 text-center">
                        {{-- Dropzone / Box Upload --}}
                        <div class="upload-dropzone p-3 border rounded text-center position-relative mb-3" id="dropzoneBox" style="border: 2px dashed #cbd5e1 !important; background: #f8fafc; cursor: pointer;">
                            <input type="file" name="image" id="imageInput" class="position-absolute w-100 h-100" style="top: 0; left: 0; opacity: 0; cursor: pointer; z-index: 5;" accept="image/*" onchange="handleImagePreview(this)">
                            
                            {{-- State A: Belum Ada Foto --}}
                            <div id="uploadPlaceholder" class="py-3">
                                <div class="icon-circle bg-white text-danger shadow-sm mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; border-radius: 50%; font-size: 1.4rem;">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <p class="font-weight-bold text-dark mb-1 small">Klik atau Tarik Foto ke Sini</p>
                                <span class="badge badge-light text-muted border font-weight-normal px-2 py-1">Pilih File Gambar</span>
                            </div>

                            {{-- State B: Preview Foto Live --}}
                            <div id="imagePreviewContainer" style="display: none;">
                                <div class="position-relative overflow-hidden rounded shadow-sm" style="aspect-ratio: 16/9; max-height: 220px; background: #000;">
                                    <img id="imagePreviewEl" src="" alt="Preview Foto" style="width: 100%; height: 100%; object-fit: cover;">
                                    <span class="badge badge-success position-absolute" style="top: 8px; left: 8px; z-index: 6;">
                                        <i class="fas fa-check-circle mr-1"></i> Foto Siap
                                    </span>
                                </div>
                                <p class="text-danger small mt-2 mb-0 font-weight-bold" style="font-size: 0.78rem;">
                                    <i class="fas fa-sync-alt mr-1"></i> Klik untuk mengganti foto
                                </p>
                            </div>
                        </div>

                        {{-- Panduan Format --}}
                        <div class="text-left bg-light p-2 rounded small text-muted">
                            <div class="d-flex align-items-center mb-1">
                                <i class="fas fa-check text-success mr-2 font-12"></i> <span>Rasio ideal: <strong>16:9</strong> (Landscape)</span>
                            </div>
                            <div class="d-flex align-items-center mb-1">
                                <i class="fas fa-check text-success mr-2 font-12"></i> <span>Ukuran: <strong>1200 x 675 px</strong></span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check text-success mr-2 font-12"></i> <span>Maksimal <strong>2 MB</strong> (JPG, PNG, WEBP)</span>
                            </div>
                        </div>
                        @error('image')
                            <small class="text-danger d-block mt-2 font-weight-bold">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Card: Metadata & Publikasi --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-sliders-h text-danger mr-2"></i> Pengaturan Publikasi
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        {{-- Switch Tampil di Website / Beranda --}}
                        <div class="p-3 bg-light rounded mb-3 border">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="is_active" id="is_active" class="custom-control-input" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold text-dark" for="is_active" style="cursor: pointer;">
                                    Tampilkan di Website
                                </label>
                            </div>
                            <small class="text-muted d-block mt-1 pl-4" style="font-size: 0.76rem;">
                                Jika aktif, berita ini akan tampil di Beranda dan halaman Berita Publik setelah disetujui.
                            </small>
                        </div>

                        {{-- Kategori --}}
                        <div class="form-group mb-3">
                            <label for="kategori" class="font-weight-bold small text-dark mb-1">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex gap-2">
                                <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" required style="flex: 1;">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoriList as $kat)
                                        <option value="{{ $kat->nama }}" {{ old('kategori') == $kat->nama ? 'selected' : '' }}>
                                            {{ $kat->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-outline-danger btn-sm px-2" onclick="openKategoriModal()" title="Tambah Kategori Baru">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            @error('kategori')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kontributor / Penulis --}}
                        <div class="form-group mb-3">
                            <label for="kontributor" class="font-weight-bold small text-dark mb-1">
                                Nama Kontributor / Penulis <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kontributor" id="kontributor" class="form-control @error('kontributor') is-invalid @enderror" 
                                   value="{{ old('kontributor', Auth::user()->name) }}" required placeholder="Contoh: Veny Narlianti / Humas DI">
                            @error('kontributor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- No. Anggota (Opsional) --}}
                        <div class="form-group mb-3">
                            <label for="no_anggota" class="font-weight-bold small text-dark mb-1">
                                No. Anggota (Opsional)
                            </label>
                            <input type="text" name="no_anggota" id="no_anggota" class="form-control" 
                                   value="{{ old('no_anggota') }}" placeholder="Contoh: DI-2026-001">
                        </div>

                        {{-- Tanggal Publikasi --}}
                        <div class="form-group mb-3">
                            <label for="published_at" class="font-weight-bold small text-dark mb-1">
                                Tanggal Publikasi
                            </label>
                            <input type="date" name="published_at" id="published_at" class="form-control" 
                                   value="{{ old('published_at', date('Y-m-d')) }}">
                        </div>

                        {{-- Jumlah Pengunjung (Views) --}}
                        <div class="form-group mb-0">
                            <label for="views" class="font-weight-bold small text-dark mb-1">
                                Jumlah Pembaca Awal (Views)
                            </label>
                            <input type="number" name="views" id="views" class="form-control" 
                                   value="{{ old('views', 0) }}" min="0" max="500" placeholder="0">
                            <small class="text-muted d-block mt-1" style="font-size: 0.74rem;">
                                Angka awal pembaca artikel (maksimal 500).
                            </small>
                            @error('views')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Card: Tombol Aksi --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-3">
                        <button type="submit" class="btn btn-danger btn-block font-weight-bold py-2 mb-2 shadow-sm">
                            <i class="fas fa-save mr-1"></i> Simpan &amp; Publikasikan
                        </button>
                        <a href="{{ route('backoffice.berita.index') }}" class="btn btn-light btn-block text-muted border">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- MODAL TAMBAH KATEGORI BERITA --}}
<div id="kategoriModal" class="modal-overlay" style="display:none;">
    <div class="modal-box shadow-lg">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="font-weight-bold text-dark mb-0">
                <i class="fas fa-folder-plus text-danger mr-1"></i> Tambah Kategori Berita
            </h5>
            <button type="button" class="close" onclick="closeKategoriModal()">&times;</button>
        </div>
        <div class="form-group mb-3">
            <label for="new_kategori_nama" class="font-weight-bold small text-dark">Nama Kategori Baru</label>
            <input type="text" id="new_kategori_nama" class="form-control" placeholder="Contoh: Riset &amp; Inovasi">
            <small id="kategoriError" class="text-danger mt-1 d-block" style="display:none;"></small>
        </div>
        <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-light border px-3" onclick="closeKategoriModal()">Batal</button>
            <button type="button" class="btn btn-danger px-3 font-weight-bold" onclick="submitKategoriBaru()">Simpan Kategori</button>
        </div>
    </div>
</div>

@push('styles')
<style>
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(3px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1050;
}
.modal-box {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    width: 100%;
    max-width: 440px;
    border: 1px solid #e2e8f0;
}
.upload-dropzone:hover {
    background: #f1f5f9 !important;
    border-color: #e30000 !important;
}
</style>
@endpush

@push('scripts')
<script>
    function handleImagePreview(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('uploadPlaceholder').style.display = 'none';
                document.getElementById('imagePreviewContainer').style.display = 'block';
                document.getElementById('imagePreviewEl').src = e.target.result;
            };

            reader.readAsDataURL(file);
        }
    }

    $(document).ready(function() {
        $('.summernote').summernote({
            height: 440,
            placeholder: 'Tulis isi artikel berita selengkapnya di sini...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video', 'hr']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });

    function openKategoriModal() {
        document.getElementById('kategoriModal').style.display = 'flex';
        document.getElementById('new_kategori_nama').value = '';
        document.getElementById('kategoriError').style.display = 'none';
        setTimeout(() => document.getElementById('new_kategori_nama').focus(), 100);
    }

    function closeKategoriModal() {
        document.getElementById('kategoriModal').style.display = 'none';
    }

    function submitKategoriBaru() {
        const nama = document.getElementById('new_kategori_nama').value.trim();
        const errorEl = document.getElementById('kategoriError');

        if (!nama) {
            errorEl.textContent = 'Nama kategori wajib diisi.';
            errorEl.style.display = 'block';
            return;
        }

        fetch('{{ route("backoffice.kategori-berita.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ nama: nama })
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) throw data;
            return data;
        })
        .then(data => {
            const select = document.getElementById('kategori');
            const option = document.createElement('option');
            option.value = data.kategori.nama;
            option.textContent = data.kategori.nama;
            option.selected = true;
            select.appendChild(option);
            closeKategoriModal();
        })
        .catch(err => {
            const message = err?.errors?.nama?.[0] || 'Gagal menambahkan kategori.';
            errorEl.textContent = message;
            errorEl.style.display = 'block';
        });
    }
</script>
@endpush

@endsection
