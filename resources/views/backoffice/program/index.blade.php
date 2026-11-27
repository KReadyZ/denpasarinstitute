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
                                <i class="fas {{ $program->is_active ? 'fa-check-circle' : 'fa-eye-slash' }} mr-1"></i>
                                {{ $program->is_active ? 'Aktif (Tampil)' : 'Disembunyikan (Hide)' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <form action="{{ route('backoffice.program.toggle', [$divisi->id, $program->id]) }}" method="POST" style="display:inline-block; margin:0;">
                                    @csrf
                                    @method('PATCH')
                                    @if($program->is_active)
                                        <button type="submit" class="btn btn-icon" title="Sembunyikan Program (Hide)" style="background:#64748b; color:#fff;">
                                            <i class="fas fa-eye-slash"></i>
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-success btn-icon" title="Tampilkan Program (Show)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    @endif
                                </form>
                                <a href="{{ route('backoffice.program.edit', [$divisi->id, $program->id]) }}" class="btn btn-warning btn-icon" title="Edit Program">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('backoffice.program.destroy', [$divisi->id, $program->id]) }}" method="POST" onsubmit="return confirmDelete(event, this, 'Yakin ingin menghapus program ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-icon" title="Hapus Program">
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