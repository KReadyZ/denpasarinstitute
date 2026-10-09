@extends('backoffice.layouts.app')

@section('title', 'Manajemen Event')
@section('page-title', 'Manajemen Event')

@push('styles')
<style>
  .pagination {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 6px;
    flex-wrap: wrap;
    justify-content: center;
  }
  .pagination .page-item {
    display: inline-flex;
  }
  .pagination .page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 10px;
    color: #666;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    line-height: 1;
    cursor: pointer;
  }
  .pagination .page-link:hover {
    background: #f5f5f5;
    color: #333;
    border-color: #999;
  }
  .pagination .page-item.active .page-link {
    background: #0066cc;
    border-color: #0066cc;
    color: #fff;
  }
  .pagination .page-item.disabled .page-link {
    color: #ccc;
    background: #fafafa;
    cursor: not-allowed;
    border-color: #eee;
  }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Daftar Event</h3>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('backoffice.event.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Event
            </a>
            @if(Auth::user()->role === 'superadmin')
            <a href="{{ route('backoffice.event.verifikasi') }}" class="btn btn-warning">
                <i class="fas fa-check-circle"></i> Verifikasi Event
            </a>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div style="margin-bottom: 16px;">
            <form method="GET" action="{{ route('backoffice.event.index') }}" style="display: flex; gap: 8px; align-items: center;">
                <select name="status" class="form-control" style="width: 200px;">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button type="submit" class="btn btn-secondary"><i class="fas fa-filter"></i> Filter</button>
                <a href="{{ route('backoffice.event.index') }}" class="btn btn-light">Reset</a>
            </form>
        </div>

        @if($events->count() > 0)
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
                    @foreach($events as $event)
                    <tr>
                        <td>{{ ($events->currentPage() - 1) * $events->perPage() + $loop->iteration }}</td>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->kategori }}</td>
                        <td>{{ $event->kontributor }}</td>
                        <td>
                            <span style="background-color: #f0f0f0; padding: 4px 8px; border-radius: 4px; font-weight: bold;">
                                {{ $event->views }} / 500
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $event->getStatusBadgeClassAttribute() }}">
                                {{ $event->getStatusLabelAttribute() }}
                            </span>
                        </td>
                        <td>
                            @if($event->status === 'approved')
                                <form action="{{ route('backoffice.event.toggle-active', $event->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="badge {{ $event->is_active ? 'badge-active' : 'badge-inactive' }}" style="border: none; cursor: pointer; padding: 4px 8px;">
                                        {{ $event->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </button>
                                </form>
                            @else
                                <span class="badge badge-inactive">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('backoffice.event.edit', $event->id) }}" class="btn btn-warning btn-icon" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('backoffice.event.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus event ini?')" style="display: inline;">
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

        @if ($events->hasPages())
          <div style="margin-top:30px;display:flex;justify-content:center;">
            <ul class="pagination">
              @if ($events->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
              @else
                <li class="page-item"><a class="page-link" href="{{ $events->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
              @endif

              @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                @if ($page == $events->currentPage())
                  <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                  <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
              @endforeach

              @if ($events->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $events->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
              @else
                <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
              @endif
            </ul>
          </div>
        @endif
        @else
        <div style="text-align: center; padding: 40px; color: #666;">
            <i class="fas fa-info-circle"></i> Belum ada event.
        </div>
        @endif
    </div>
</div>
@endsection