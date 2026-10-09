@extends('backoffice.layouts.app')

@section('title', 'Edit Divisi')
@section('page-title', 'Edit Divisi: ' . $divisi->nama)

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Form Edit Data Divisi</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('backoffice.divisi.update', $divisi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama">Nama Divisi <span style="color:red;">*</span></label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $divisi->nama) }}" required>
            </div>

            <div class="form-group">
                <label for="header">Header / Judul Halaman</label>
                <input type="text" name="header" id="header" class="form-control" value="{{ old('header', $divisi->header) }}">
            </div>

            <div class="form-group">
                <label>Background Image (Hero)</label>
                @if($divisi->background_image)
                    <div style="margin-bottom: 8px;">
                        <img src="{{ asset('storage/' . $divisi->background_image) }}" class="img-preview" style="width: 200px; height: auto; object-fit: cover; border-radius: 4px;">
                    </div>
                @endif
                <input type="file" name="background_image" class="form-control" accept="image/*">
                <small style="display:block; color:#666;">Kosongkan jika tidak ingin mengganti gambar.</small>
            </div>

            <div class="form-group">
                <label>Statistik (Angka & Label)</label>
                @for($i = 0; $i < 4; $i++)
                    <div class="form-row-3" style="margin-top: {{ $i > 0 ? '10px' : '0' }};">
                        <input type="text" name="stats[{{ $i }}][number]" class="form-control" placeholder="Angka {{ $i+1 }}" value="{{ old('stats.'.$i.'.number', $divisi->stats[$i]['number'] ?? '') }}">
                        <input type="text" name="stats[{{ $i }}][label]" class="form-control" placeholder="Label {{ $i+1 }}" value="{{ old('stats.'.$i.'.label', $divisi->stats[$i]['label'] ?? '') }}">
                    </div>
                @endfor
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi Singkat (tampil di bawah judul hero)</label>
                <textarea name="deskripsi" id="deskripsi">{{ old('deskripsi', $divisi->deskripsi) }}</textarea>
            </div>

            <div class="form-row-3">
                <div class="form-group">
                    <label>Urutan</label>
                    <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $divisi->urutan) }}">
                </div>
                <div class="form-group" style="display: flex; align-items: center; padding-top: 24px;">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $divisi->is_active ? 'checked' : '' }}>
                    <label for="is_active" style="margin-left: 8px; font-weight: normal; cursor: pointer;">Aktifkan Divisi</label>
                </div>
            </div>

            <div class="form-group" style="margin-top: 16px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Divisi</button>
                <a href="{{ route('backoffice.divisi.index') }}" class="btn btn-secondary">Kembali ke Daftar Divisi</a>
            </div>
        </form>
    </div>
</div>

<br><hr><br>

<div class="card" style="border-left: 4px solid #CC0000;">
    <div class="card-header" style="background: #fff5f5;">
        <h3 style="margin: 0; color: #CC0000;">
            <i class="fas fa-th"></i> Kelola Sections Custom
        </h3>
    </div>
    <div class="card-body">
        <p style="margin: 0; color: #666; margin-bottom: 16px;">
            Tambahkan section custom (Tentang, Keunggulan, dll) yang akan tampil setelah hero. Section ini terpisah dari form di atas.
        </p>
        <a href="{{ route('backoffice.sections.index', $divisi->id) }}" class="btn btn-primary">
            <i class="fas fa-th"></i> Manage Sections ({{ $divisi->sections()->withoutGlobalScopes()->count() }} sections)
        </a>
    </div>
</div>

<br><hr><br>

<div class="card">
    <div class="card-header">
        <h3>Manajemen Program untuk Divisi Ini</h3>
        <a href="{{ route('backoffice.program.create', $divisi->id) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Program Baru
        </a>
    </div>
    <div class="card-body">
        @if($divisi->programs->count() > 0)
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Ikon</th>
                            <th>Nama Program</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($divisi->programs as $program)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><i class="{{ $program->ikon }}"></i></td>
                            <td>{{ $program->nama }}</td>
                            <td>
                                <span class="badge {{ $program->is_active ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $program->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('backoffice.program.edit', [$divisi->id, $program->id]) }}" class="btn btn-warning btn-icon">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('backoffice.program.destroy', [$divisi->id, $program->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus program ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-icon">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align:center; padding:20px; color:#666;">
                <i class="fas fa-info-circle"></i> Belum ada program untuk divisi ini. Klik tombol <strong>"Tambah Program Baru"</strong> di atas untuk membuatnya.
            </div>
        @endif
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