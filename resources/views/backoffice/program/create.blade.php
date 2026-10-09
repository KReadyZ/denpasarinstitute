@extends('backoffice.layouts.app')
@section('title', 'Tambah Program')
@section('page-title', 'Tambah Program untuk Divisi: ' . $divisi->nama)

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Form Tambah Program</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('backoffice.program.store', $divisi->id) }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Program</label>
                    <input type="text" name="nama" class="form-control" required placeholder="Contoh: Diklat Riset">
                </div>
                <div class="form-group">
                    <label>Ikon (FontAwesome)</label>
                    <input type="text" name="ikon" class="form-control" placeholder="Contoh: fa-flask">
                </div>
            </div>
            <div class="form-group">
                <label>Deskripsi / Konten Penjelasan Program</label>
                <textarea name="deskripsi" class="summernote" rows="10"></textarea>
            </div>
            <div class="form-row-3">
                <div class="form-group">
                    <label>Urutan</label>
                    <input type="number" name="urutan" class="form-control" value="0">
                </div>
                <div class="form-group">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <label style="font-weight:normal;">Aktifkan Program</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() { $('.summernote').summernote({ height: 400 }); });
</script>
@endpush
@endsection