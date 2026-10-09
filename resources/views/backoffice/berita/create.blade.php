@extends('backoffice.layouts.app')

@section('title', 'Tambah Berita')
@section('page-title', 'Tambah Berita Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Form Tambah Berita Baru</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('backoffice.berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="kategori">Kategori <span style="color:red;">*</span></label>
                    <div style="display:flex; gap:8px;">
                        <select name="kategori" id="kategori" class="form-control" required style="flex:1;">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat->nama }}" {{ old('kategori') == $kat->nama ? 'selected' : '' }}>
                                    {{ $kat->nama }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-secondary" onclick="openKategoriModal()">
                            <i class="fas fa-plus"></i> Kategori
                        </button>
                    </div>
                    @error('kategori') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label for="kontributor">Nama Kontributor <span style="color:red;">*</span></label>
                    <input type="text" name="kontributor" id="kontributor" class="form-control" value="{{ old('kontributor') }}" required placeholder="Nama penulis atau institusi">
                    @error('kontributor') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="no_anggota">No. Anggota (Opsional)</label>
                    <input type="text" name="no_anggota" id="no_anggota" class="form-control" value="{{ old('no_anggota') }}" placeholder="Contoh: 123456">
                </div>
                <div class="form-group">
                    <label for="published_at">Tanggal Publikasi</label>
                    <input type="date" name="published_at" id="published_at" class="form-control" value="{{ old('published_at') }}">
                </div>
            </div>

            <div class="form-group">
                <label for="title">Judul Berita <span style="color:red;">*</span></label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required placeholder="Judul berita yang menarik">
                @error('title') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="image">Gambar Berita</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                <small style="display:block; color:#666; margin-top: 6px;">
                    <strong>Ukuran:</strong> 1200 x 600px (landscape, 16:9) | <strong>Max:</strong> 2MB | <strong>Format:</strong> JPG, PNG
                </small>
            </div>

            <div class="form-group">
                <label for="content">Konten Berita <span style="color:red;">*</span></label>
                <textarea name="content" id="content" class="summernote" rows="15">{{ old('content') }}</textarea>
                @error('content') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="views">Jumlah Pengunjung (Views) - Maksimal 500</label>
                    <input type="number" name="views" id="views" class="form-control" value="{{ old('views', 0) }}" min="0" max="500" placeholder="0">
                    <small style="display:block; color:#666;">Jumlah klik/pengunjung berita. Maksimal 500.</small>
                    @error('views') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
                <div class="form-group" style="display: flex; align-items: center; padding-top: 24px;">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ Auth::user()->role === 'superadmin' ? 'checked' : '' }}>
                    <label for="is_active" style="margin-left: 8px; font-weight: normal; cursor: pointer;">Aktifkan Berita (Tampil di website)</label>
                </div>
            </div>

            <div class="form-group" style="margin-top: 16px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Berita</button>
                <a href="{{ route('backoffice.berita.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>

<div id="kategoriModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h4>Tambah Kategori Berita</h4>
        <div class="form-group">
            <label for="new_kategori_nama">Nama Kategori</label>
            <input type="text" id="new_kategori_nama" class="form-control" placeholder="Contoh: Ekonomi">
            <small id="kategoriError" style="color:red; display:none;"></small>
        </div>
        <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:16px;">
            <button type="button" class="btn btn-secondary" onclick="closeKategoriModal()">Batal</button>
            <button type="button" class="btn btn-primary" onclick="submitKategoriBaru()">Simpan</button>
        </div>
    </div>
</div>

<style>
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
.modal-box {
    background: #fff;
    border-radius: 8px;
    padding: 24px;
    width: 100%;
    max-width: 420px;
}
.modal-box h4 {
    margin: 0 0 16px 0;
}
</style>

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

    function openKategoriModal() {
        document.getElementById('kategoriModal').style.display = 'flex';
        document.getElementById('new_kategori_nama').value = '';
        document.getElementById('kategoriError').style.display = 'none';
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