@extends('backoffice.layouts.app')
@section('title', 'Program Divisi')
@section('page-title', 'Program Divisi: ' . $divisi->nama)

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Daftar Program</h3>
        <a href="{{ route('backoffice.program.create', $divisi->id) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Program
        </a>
    </div>
    <div class="card-body">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Ikon</th>
                        <th>Nama Program</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programs as $program)
                    <tr>
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
    </div>
</div>
@endsection