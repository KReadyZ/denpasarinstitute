@extends('backoffice.layouts.app')

@section('title', 'Kelola Statistik')

@section('content')
<div class="container-fluid" style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <h4 style="margin:0;">Kelola Statistik (Denpasar Institute dalam Angka)</h4>
        <a href="{{ route('backoffice.statistic.create') }}" class="btn btn-danger">
            <i class="fas fa-plus"></i> Tambah Statistik
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-danger">
                    <tr>
                        <th>Urutan</th>
                        <th>Icon</th>
                        <th>Angka</th>
                        <th>Label</th>
                        <th>Trend</th>
                        <th>Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($statistics as $stat)
                    <tr>
                        <td>{{ $stat->order }}</td>
                        <td><i class="fas {{ $stat->icon }}"></i> {{ $stat->icon }}</td>
                        <td><strong>{{ $stat->number }}</strong></td>
                        <td>{{ $stat->label }}</td>
                        <td>
                            <i class="fas fa-arrow-{{ $stat->trend_direction === 'up' ? 'up' : 'down' }}"></i>
                            {{ $stat->trend_percentage }}%
                        </td>
                        <td>
                            <form action="{{ route('backoffice.statistic.toggle-active', $stat->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $stat->is_active ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $stat->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('backoffice.statistic.edit', $stat->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('backoffice.statistic.destroy', $stat->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted">Belum ada data statistik.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection