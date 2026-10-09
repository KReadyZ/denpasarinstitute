@extends('backoffice.layouts.app')

@section('title', 'Manajemen Divisi')
@section('page-title', 'Manajemen Divisi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Daftar Divisi</h3>
        <a href="{{ route('backoffice.divisi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Divisi
        </a>
    </div>
    <div class="card-body">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Divisi</th>
                        <th>Slug</th>
                        <th>Header Halaman</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($divisis as $divisi)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $divisi->nama }}</td>
                        <td><code>{{ $divisi->slug }}</code></td>
                        <td>{{ $divisi->header }}</td>
                        <td>
                            <span class="badge {{ $divisi->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $divisi->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('backoffice.divisi.edit', $divisi->id) }}" class="btn btn-warning btn-icon" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('backoffice.divisi.destroy', $divisi->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus divisi ini?')">
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
    </div>
</div>
@endsection