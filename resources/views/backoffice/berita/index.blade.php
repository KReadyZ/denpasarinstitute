@extends('backoffice.layouts.app')

@section('title', 'Manajemen Berita')
@section('page-title', 'Manajemen Berita')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Daftar Berita</h3>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('backoffice.berita.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Berita
            </a>
            @if(Auth::user()->role === 'superadmin')
            <a href="{{ route('backoffice.berita.verifikasi') }}" class="btn btn-warning">
                <i class="fas fa-check-circle"></i> Verifikasi Berita
            </a>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div style="margin-bottom: 16px;">
            <form method="GET" action="{{ route('backoffice.berita.index') }}" style="display: flex; gap: 8px; align-items: center;">
                <select name="status" class="form-control" style="width: 200px;">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button type="submit" class="btn btn-secondary"><i class="fas fa-filter"></i> Filter</button>
                <a href="{{ route('backoffice.berita.index') }}" class="btn btn-light">Reset</a>
            </form>
        </div>

        @if($beritas->count() > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Kontributor</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th>Tayang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($beritas as $berita)
                    <tr>
                        <td>{{ ($beritas->currentPage() - 1) * $beritas->perPage() + $loop->iteration }}</td>
                        <td>{{ $berita->title }}</td>
                        <td>{{ $berita->kategori }}</td>
                        <td>{{ $berita->kontributor }}</td>
                        <td>
                            <span style="background-color: #f0f0f0; padding: 4px 8px; border-radius: 4px; font-weight: bold;">
                                {{ $berita->views }} / 500
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $berita->getStatusBadgeClassAttribute() }}">
                                {{ $berita->getStatusLabelAttribute() }}
                            </span>
                        </td>
                        <td>
                            @if($berita->status === 'approved')
                                <form action="{{ route('backoffice.berita.toggle-active', $berita->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="badge {{ $berita->is_active ? 'badge-active' : 'badge-inactive' }}" style="border: none; cursor: pointer; padding: 4px 8px;">
                                        {{ $berita->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </button>
                                </form>
                            @else
                                <span class="badge badge-inactive">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('backoffice.berita.edit', $berita->id) }}" class="btn btn-warning btn-icon" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('backoffice.berita.destroy', $berita->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita ini?')" style="display: inline;">
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

        <div style="margin-top: 16px;">
            {{ $beritas->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
        @else
        <div style="text-align: center; padding: 40px; color: #666;">
            <i class="fas fa-info-circle"></i> Belum ada berita.
        </div>
        @endif
    </div>
</div>
@endsection