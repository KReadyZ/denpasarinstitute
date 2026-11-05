@extends('backoffice.layouts.app')

@section('title', 'Edit Menu Navigasi')

@section('content')
<div class="container-fluid" style="padding:24px;max-width:720px;">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
        <a href="{{ route('backoffice.navigation.index', ['location' => $item->location]) }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h4 style="margin:0;font-weight:700;">Edit Menu Navigasi: {{ $item->title }}</h4>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('backoffice.navigation.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Lokasi Penempatan Menu <span class="text-danger">*</span></label>
                    <select name="location" class="form-select @error('location') is-invalid @enderror" required>
                        @foreach($locations as $key => $label)
                            <option value="{{ $key }}" {{ old('location', $item->location) === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Judul / Teks Menu <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title', $item->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">URL / Link Tujuan <span class="text-danger">*</span></label>
                    <input type="text" name="url" class="form-control @error('url') is-invalid @enderror" 
                           value="{{ old('url', $item->url) }}" required>
                    <small class="text-muted">Gunakan awalan slash <code>/</code> untuk halaman lokal (misal: <code>/partner-with-di</code>), atau URL penuh untuk link eksternal.</small>
                    @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Urutan Tampil <span class="text-danger">*</span></label>
                        <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" 
                               value="{{ old('order', $item->order) }}" required>
                        <small class="text-muted">Angka lebih kecil tampil lebih dulu.</small>
                        @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Buka Link Di</label>
                        <select name="target" class="form-select">
                            <option value="_self" {{ old('target', $item->target) === '_self' ? 'selected' : '' }}>Halaman Sama (_self)</option>
                            <option value="_blank" {{ old('target', $item->target) === '_blank' ? 'selected' : '' }}>Tab Baru (_blank)</option>
                        </select>
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" name="is_active" class="form-check-input" id="isActiveCheck" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="isActiveCheck">
                        <strong>Aktifkan Menu Ini</strong> (Tampilkan di website)
                    </label>
                </div>

                <div style="display:flex;gap:10px;">
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-save"></i> Perbarui Menu
                    </button>
                    <a href="{{ route('backoffice.navigation.index', ['location' => $item->location]) }}" class="btn btn-secondary px-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

