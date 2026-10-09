@extends('backoffice.layouts.app')

@section('title', 'Tambah Divisi')
@section('page-title', 'Tambah Divisi Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Form Tambah Divisi Baru</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('backoffice.divisi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="nama">Nama Divisi <span style="color:red;">*</span></label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required placeholder="Contoh: Divisi Riset dan Inovasi">
                @error('nama') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="header">Header / Judul Halaman</label>
                <input type="text" name="header" id="header" class="form-control" value="{{ old('header') }}" placeholder="Judul besar di hero halaman divisi">
            </div>

            <div class="form-group">
                <label for="background_image">Background Image (Hero)</label>
                <input type="file" name="background_image" id="background_image" class="form-control" accept="image/*">
                <small style="display:block; color:#666;">Ukuran maksimal 2MB (jpg, png).</small>
            </div>

            <div class="form-group">
                <label>Statistik (Angka & Label)</label>
                <div class="form-row-3">
                    <input type="text" name="stats[0][number]" class="form-control" placeholder="Angka 1 (50+)" value="{{ old('stats.0.number') }}">
                    <input type="text" name="stats[0][label]" class="form-control" placeholder="Label 1 (Proyek Riset)" value="{{ old('stats.0.label') }}">
                </div>
                <div class="form-row-3" style="margin-top: 10px;">
                    <input type="text" name="stats[1][number]" class="form-control" placeholder="Angka 2" value="{{ old('stats.1.number') }}">
                    <input type="text" name="stats[1][label]" class="form-control" placeholder="Label 2" value="{{ old('stats.1.label') }}">
                </div>
                <div class="form-row-3" style="margin-top: 10px;">
                    <input type="text" name="stats[2][number]" class="form-control" placeholder="Angka 3" value="{{ old('stats.2.number') }}">
                    <input type="text" name="stats[2][label]" class="form-control" placeholder="Label 3" value="{{ old('stats.2.label') }}">
                </div>
                <div class="form-row-3" style="margin-top: 10px;">
                    <input type="text" name="stats[3][number]" class="form-control" placeholder="Angka 4" value="{{ old('stats.3.number') }}">
                    <input type="text" name="stats[3][label]" class="form-control" placeholder="Label 4" value="{{ old('stats.3.label') }}">
                </div>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi Singkat (tampil di bawah judul hero)</label>
                <textarea name="deskripsi" id="deskripsi">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="form-row-3">
                <div class="form-group">
                    <label>Urutan (Semakin kecil, semakin atas)</label>
                    <input type="number" name="urutan" class="form-control" value="{{ old('urutan', 0) }}">
                </div>
                <div class="form-group" style="display: flex; align-items: center; padding-top: 24px;">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                    <label for="is_active" style="margin-left: 8px; font-weight: normal; cursor: pointer;">Aktifkan Divisi (Tampil di website)</label>
                </div>
            </div>

            <div class="form-group" style="margin-top: 16px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Divisi</button>
                <a href="{{ route('backoffice.divisi.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>
<script>
$(document).ready(function() {
    $('#deskripsi').summernote({
        height: 220,
        minHeight: 150,
        maxHeight: 400,
        focus: false,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
});
</script>
@endpush

@endsection