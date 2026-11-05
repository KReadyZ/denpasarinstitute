@extends('backoffice.layouts.app')

@section('title', 'Tambah Pilar Kemitraan')

@section('content')
<div class="container-fluid" style="padding:24px;max-width:800px;">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
        <a href="{{ route('backoffice.partnership-pillar.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h4 style="margin:0;font-weight:700;">Tambah Pilar Kemitraan</h4>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('backoffice.partnership-pillar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold">Nomor Kartu <span class="text-danger">*</span></label>
                        <input type="text" name="number" class="form-control @error('number') is-invalid @enderror" 
                               placeholder="01, 02..." value="{{ old('number', '07') }}" required>
                        @error('number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-9">
                        <label class="form-label font-weight-bold">Judul Pilar <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                               placeholder="Contoh: Riset dan Inovasi" value="{{ old('title') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Label Tag Pita <span class="text-danger">*</span></label>
                        <input type="text" name="tag" class="form-control @error('tag') is-invalid @enderror" 
                               placeholder="Contoh: Riset & Inovasi" value="{{ old('tag') }}" required>
                        @error('tag')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Ikon FontAwesome (Opsional)</label>
                        <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror" 
                               placeholder="fa-microscope, fa-industry, dll" value="{{ old('icon', 'fa-handshake') }}">
                        @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Deskripsi Pilar <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control summernote @error('description') is-invalid @enderror" rows="4" required>{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Upload Foto Ilustrasi</label>
                        <input type="file" name="image_file" class="form-control @error('image_file') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, WEBP (Maks: 3MB). Rasio ideal 16:10.</small>
                        @error('image_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Atau Path Gambar Manual</label>
                        <input type="text" name="image" class="form-control @error('image') is-invalid @enderror" 
                               placeholder="image/partners/..." value="{{ old('image') }}">
                        <small class="text-muted">Opsional jika gambar sudah ada di public folder.</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label font-weight-bold">Link URL Tujuan (Learn more)</label>
                        <input type="text" name="link_url" class="form-control @error('link_url') is-invalid @enderror" 
                               placeholder="/divisi/divisi-riset-dan-inovasi atau https://wa.me/..." value="{{ old('link_url') }}">
                        @error('link_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold">Teks Tombol</label>
                        <input type="text" name="link_text" class="form-control" value="{{ old('link_text', 'Learn more') }}">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold">Urutan Tampil <span class="text-danger">*</span></label>
                        <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" 
                               value="{{ old('order', 7) }}" required>
                        @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-8 d-flex align-items-center">
                        <div class="form-check mt-3">
                            <input type="checkbox" name="is_active" class="form-check-input" id="isActiveCheck" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label font-weight-bold" for="isActiveCheck">
                                Aktifkan Pilar (Tampilkan di halaman Kemitraan)
                            </label>
                        </div>
                    </div>
                </div>

                <div style="display:flex;gap:10px;">
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-save"></i> Simpan Pilar Kemitraan
                    </button>
                    <a href="{{ route('backoffice.partnership-pillar.index') }}" class="btn btn-secondary px-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

