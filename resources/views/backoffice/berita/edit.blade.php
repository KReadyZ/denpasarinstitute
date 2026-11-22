@extends('backoffice.layouts.app')

@section('title', 'Edit Berita')
@section('page-title', 'Edit Berita: ' . $berita->title)

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="font-weight-bold text-dark mb-1">
                <i class="fas fa-edit text-danger mr-2"></i> Edit Artikel Berita
            </h4>
            <p class="text-muted small mb-0">Perbarui konten artikel, foto sampul, keterangan caption, atau status publikasi berita.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('backoffice.berita.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
            </a>
            <button type="button" class="btn btn-danger font-weight-bold" onclick="document.getElementById('formEditBerita').submit()">
                <i class="fas fa-save mr-1"></i> Simpan Perubahan
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

    <form action="{{ route('backoffice.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data" id="formEditBerita">
        @csrf
        @method('PUT')

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
                                   value="{{ old('title', $berita->title) }}" required placeholder="Tulis judul berita..." style="font-size: 1.15rem;">
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
                            <textarea name="content" id="content" class="summernote @error('content') is-invalid @enderror">{!! old('content', $berita->content) !!}</textarea>
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
                                       value="{{ old('image_caption', $berita->image_caption) }}" placeholder="Contoh: Suasana seminar nasional di kampus (Foto: Dok. Undhira / Humas DI)">
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
                            
                            {{-- Jika Sudah Ada Gambar Sebelumnya --}}
                            @if($berita->image)
                                <div id="existingImageContainer">
                                    <div class="position-relative overflow-hidden rounded shadow-sm" style="aspect-ratio: 16/9; max-height: 220px; background: #000;">
                                        <img src="{{ $berita->gambar_url }}" alt="Foto Berita" style="width: 100%; height: 100%; object-fit: cover;">
                                        <span class="badge badge-primary position-absolute" style="top: 8px; left: 8px; z-index: 6;">
                                            <i class="fas fa-check mr-1"></i> Foto Aktif Saat Ini
                                        </span>
                                    </div>
                                    <p class="text-muted small mt-2 mb-0">
                                        <i class="fas fa-sync-alt mr-1"></i> Klik untuk mengganti dengan foto baru
                                    </p>
                                </div>
                            @else
                                {{-- Placeholder Kosong --}}
                                <div id="uploadPlaceholder" class="py-3">
                                    <div class="icon-circle bg-white text-danger shadow-sm mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; border-radius: 50%; font-size: 1.4rem;">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <p class="font-weight-bold text-dark mb-1 small">Klik atau Tarik Foto ke Sini</p>
                                    <span class="badge badge-light text-muted border font-weight-normal px-2 py-1">Pilih File Gambar</span>
                                </div>
                            @endif

                            {{-- State B: Preview Foto Baru Live --}}
                            <div id="imagePreviewContainer" style="display: none;">
                                <div class="position-relative overflow-hidden rounded shadow-sm" style="aspect-ratio: 16/9; max-height: 220px; background: #000;">
                                    <img id="imagePreviewEl" src="" alt="Preview Foto Baru" style="width: 100%; height: 100%; object-fit: cover;">
                                    <span class="badge badge-success position-absolute" style="top: 8px; left: 8px; z-index: 6;">
                                        <i class="fas fa-camera mr-1"></i> Foto Baru Dipilih
                                    </span>
                                </div>
                                <p class="text-danger small mt-2 mb-0 font-weight-bold" style="font-size: 0.78rem;">
                                    <i class="fas fa-sync-alt mr-1"></i> Klik lagi jika ingin mengganti
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
                                <input type="checkbox" name="is_active" id="is_active" class="custom-control-input" value="1" {{ old('is_active', $berita->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold text-dark" for="is_active" style="cursor: pointer;">
                                    Tampilkan di Website
                                </label>
                            </div>
                            <small class="text-muted d-block mt-1 pl-4" style="font-size: 0.76rem;">
                                Jika aktif, berita ini akan tampil di Beranda dan halaman Berita Publik.
                            </small>
                        </div>

                        {{-- Kategori --}}
                        <div class="form-group mb-3">
                            <label for="kategori" class="font-weight-bold small text-dark mb-1">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoriList as $kat)
                                    <option value="{{ $kat->nama }}" {{ old('kategori', $berita->kategori) == $kat->nama ? 'selected' : '' }}>
                                        {{ $kat->nama }}
                                    </option>
                                @endforeach
                            </select>
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
                                   value="{{ old('kontributor', $berita->kontributor) }}" required placeholder="Nama penulis atau institusi">
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
                                   value="{{ old('no_anggota', $berita->no_anggota) }}" placeholder="Contoh: DI-2026-001">
                        </div>

                        {{-- Tanggal Publikasi --}}
                        <div class="form-group mb-3">
                            <label for="published_at" class="font-weight-bold small text-dark mb-1">
                                Tanggal Publikasi
                            </label>
                            <input type="date" name="published_at" id="published_at" class="form-control" 
                                   value="{{ old('published_at', $berita->published_at ? $berita->published_at->format('Y-m-d') : date('Y-m-d')) }}">
                        </div>

                        {{-- Jumlah Pengunjung (Views) --}}
                        <div class="form-group mb-0">
                            <label for="views" class="font-weight-bold small text-dark mb-1">
                                Jumlah Pembaca (Views)
                            </label>
                            <input type="number" name="views" id="views" class="form-control" 
                                   value="{{ old('views', $berita->views) }}" min="0" max="500">
                            <small class="text-muted d-block mt-1" style="font-size: 0.74rem;">
                                Maksimal 500 pembaca terhitung.
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
                            <i class="fas fa-save mr-1"></i> Perbarui Berita
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

@push('styles')
<style>
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
                const existingContainer = document.getElementById('existingImageContainer');
                const uploadPlaceholder = document.getElementById('uploadPlaceholder');
                if (existingContainer) existingContainer.style.display = 'none';
                if (uploadPlaceholder) uploadPlaceholder.style.display = 'none';

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
</script>
@endpush

@endsection
