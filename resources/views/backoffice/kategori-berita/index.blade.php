@extends('backoffice.layouts.app')

@section('title', 'Kategori Berita')
@section('page-title', 'Kategori Berita')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Daftar Kategori Berita</h3>
        <button type="button" class="btn btn-primary" onclick="openAddModal()">
            <i class="fas fa-plus"></i> Tambah Kategori
        </button>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($kategoris->count() > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Kategori</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategoris as $kategori)
                    <tr>
                        <td>{{ ($kategoris->currentPage() - 1) * $kategoris->perPage() + $loop->iteration }}</td>
                        <td>{{ $kategori->nama }}</td>
                        <td>
                            <div class="action-group">
                                <button type="button" class="btn btn-warning btn-icon" title="Edit" onclick="openEditModal('{{ $kategori->id }}', '{{ addslashes($kategori->nama) }}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('backoffice.kategori-berita.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-icon" title="Hapus">
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

        <div class="pagination-wrap">
            <small class="text-muted">
                Menampilkan {{ $kategoris->firstItem() }} - {{ $kategoris->lastItem() }} dari {{ $kategoris->total() }} data
            </small>
            {{ $kategoris->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
        @else
        <div style="text-align:center; padding:40px; color:#666;">
            <i class="fas fa-info-circle"></i> Belum ada kategori.
        </div>
        @endif
    </div>
</div>

<div id="addModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h4>Tambah Kategori Berita</h4>
        <form action="{{ route('backoffice.kategori-berita.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama">Nama Kategori</label>
                <input type="text" name="nama" id="nama" class="form-control" required placeholder="Contoh: Ekonomi">
                @error('nama') <small style="color:red;">{{ $message }}</small> @enderror
            </div>
            <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:16px;">
                <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h4>Edit Kategori Berita</h4>
        <form id="editForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_nama">Nama Kategori</label>
                <input type="text" name="nama" id="edit_nama" class="form-control" required>
            </div>
            <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:16px;">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
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
.pagination-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 0 0 0;
    flex-wrap: wrap;
    gap: 12px;
}
.pagination-wrap .text-muted {
    color: #6b7280;
    font-size: 13px;
}
</style>

@if($errors->any())
<script>document.addEventListener('DOMContentLoaded', function() { openAddModal(); });</script>
@endif

@push('scripts')
<script>
function openAddModal() {
    document.getElementById('addModal').style.display = 'flex';
}
function closeAddModal() {
    document.getElementById('addModal').style.display = 'none';
}
function openEditModal(id, nama) {
    document.getElementById('editForm').action = '{{ url("backoffice/kategori-berita") }}/' + id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('editModal').style.display = 'flex';
}
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}
</script>
@endpush
@endsection