@extends('backoffice.layouts.app')

@section('title', 'Edit Program')
@section('page-title', 'Edit Program untuk Divisi: ' . $divisi->nama)

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Form Edit Program</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('backoffice.program.update', [$divisi->id, $program->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label>Nama Program</label>
                    <input type="text" name="nama" class="form-control" required value="{{ old('nama', $program->nama) }}">
                </div>
                <div class="form-group">
                    <label>Ikon (FontAwesome)</label>
                    <input type="text" name="ikon" class="form-control" value="{{ old('ikon', $program->ikon) }}" placeholder="Contoh: fa-flask">
                </div>
            </div>

            <div class="form-group">
                <label>Deskripsi / Konten Penjelasan Program</label>
                <textarea name="deskripsi" class="summernote" rows="10">{!! old('deskripsi', $program->deskripsi) !!}</textarea>
            </div>

            <div class="form-row-3">
                <div class="form-group">
                    <label>Urutan</label>
                    <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $program->urutan) }}">
                </div>
                <div class="form-group">
                    <input type="checkbox" name="is_active" value="1" {{ $program->is_active ? 'checked' : '' }}>
                    <label style="font-weight:normal;">Aktifkan Program</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Program</button>
            <a href="{{ route('backoffice.program.index', $divisi->id) }}" class="btn btn-secondary">Kembali</a>
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