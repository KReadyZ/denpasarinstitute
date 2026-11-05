@extends('backoffice.layouts.app')

@section('title', 'Edit Pilar Kemitraan')

@section('content')
<div class="container-fluid" style="padding:24px;max-width:800px;">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
        <a href="{{ route('backoffice.partnership-pillar.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h4 style="margin:0;font-weight:700;">Edit Pilar Kemitraan: {{ $pillar->title }}</h4>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('backoffice.partnership-pillar.update', $pillar->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold">Nomor Kartu <span class="text-danger">*</span></label>
                        <input type="text" name="number" class="form-control @error('number') is-invalid @enderror" 
                               value="{{ old('number', $pillar->number) }}" required>
                        @error('number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-9">
                        <label class="form-label font-weight-bold">Judul Pilar <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title', $pillar->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Label Tag Pita <span class="text-danger">*</span></label>
                        <input type="text" name="tag" class="form-control @error('tag') is-invalid @enderror" 
                               value="{{ old('tag', $pillar->tag) }}" required>
                        @error('tag')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Ikon FontAwesome (Opsional)</label>
                        <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror" 
                               value="{{ old('icon', $pillar->icon) }}">
                        @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Deskripsi Pilar <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control summernote @error('description') is-invalid @enderror" rows="4" required>{{ old('description', $pillar->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Ganti Foto Ilustrasi</label>
                        <input type="file" name="image_file" class="form-control @error('image_file') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, WEBP (Maks: 3MB). Biarkan kosong jika tidak ingin mengganti.</small>
                        @error('image_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Atau Path Gambar Manual</label>
                        <input type="text" name="image" class="form-control @error('image') is-invalid @enderror" 
                               value="{{ old('image', $pillar->image) }}">
                        @if($pillar->image)
                            <div class="mt-2">
                                <small class="text-muted">Preview Saat Ini:</small><br>
                                <img src="{{ asset($pillar->image) }}" alt="Preview" style="height:60px;border-radius:6px;border:1px solid #ddd;">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label font-weight-bold">Link URL Tujuan (Learn more)</label>
                        <input type="text" name="link_url" class="form-control @error('link_url') is-invalid @enderror" 
                               value="{{ old('link_url', $pillar->link_url) }}">
                        @error('link_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold">Teks Tombol</label>
                        <input type="text" name="link_text" class="form-control" value="{{ old('link_text', $pillar->link_text ?? 'Learn more') }}">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold">Urutan Tampil <span class="text-danger">*</span></label>
                        <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" 
                               value="{{ old('order', $pillar->order) }}" required>
                        @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-8 d-flex align-items-center">
                        <div class="form-check mt-3">
                            <input type="checkbox" name="is_active" class="form-check-input" id="isActiveCheck" value="1" {{ old('is_active', $pillar->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label font-weight-bold" for="isActiveCheck">
                                Aktifkan Pilar (Tampilkan di halaman Kemitraan)
                            </label>
                        </div>
                    </div>
                </div>

                <div style="display:flex;gap:10px;">
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-save"></i> Perbarui Pilar
                    </button>
                    <a href="{{ route('backoffice.partnership-pillar.index') }}" class="btn btn-secondary px-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

