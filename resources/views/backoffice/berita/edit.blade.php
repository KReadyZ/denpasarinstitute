@extends('backoffice.layouts.app')

@section('title', 'Edit Berita')
@section('page-title', 'Edit Berita: ' . $berita->title)

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Form Edit Berita</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('backoffice.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label for="kategori">Kategori <span style="color:red;">*</span></label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat->nama }}" {{ old('kategori', $berita->kategori) == $kat->nama ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label for="kontributor">Nama Kontributor <span style="color:red;">*</span></label>
                    <input type="text" name="kontributor" id="kontributor" class="form-control" value="{{ old('kontributor', $berita->kontributor) }}" required>
                    @error('kontributor') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="no_anggota">No. Anggota (Opsional)</label>
                    <input type="text" name="no_anggota" id="no_anggota" class="form-control" value="{{ old('no_anggota', $berita->no_anggota) }}">
                </div>
                <div class="form-group">
                    <label for="published_at">Tanggal Publikasi</label>
                    <input type="date" name="published_at" id="published_at" class="form-control" value="{{ old('published_at', $berita->published_at ? $berita->published_at->format('Y-m-d') : '') }}">
                </div>
            </div>

            <div class="form-group">
                <label for="title">Judul Berita <span style="color:red;">*</span></label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $berita->title) }}" required>
                @error('title') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Gambar Berita</label>
                @if($berita->image)
                    <div style="margin-bottom: 8px;">
                        <img src="{{ asset('storage/' . $berita->image) }}" class="img-preview" style="width: 300px; height: auto; object-fit: cover; border-radius: 4px;">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label for="content">Konten Berita <span style="color:red;">*</span></label>
                <textarea name="content" id="content" class="summernote" rows="15">{!! old('content', $berita->content) !!}</textarea>
                @error('content') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="views">Jumlah Pengunjung (Views) - Maksimal 500</label>
                    <input type="number" name="views" id="views" class="form-control" value="{{ old('views', $berita->views) }}" min="0" max="500">
                    <small style="display:block; color:#666;">Jumlah klik/pengunjung berita. Maksimal 500.</small>
                    @error('views') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
                <div class="form-group" style="display: flex; align-items: center; padding-top: 24px;">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $berita->is_active ? 'checked' : '' }}>
                    <label for="is_active" style="margin-left: 8px; font-weight: normal; cursor: pointer;">Aktifkan Berita</label>
                </div>
            </div>

            <div class="form-group" style="margin-top: 16px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Berita</button>
                <a href="{{ route('backoffice.berita.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endpush

@endsection