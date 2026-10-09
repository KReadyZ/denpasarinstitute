@extends('backoffice.layouts.app')
@section('page-title', 'Manajemen Bursa SDM')

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
<div class="card" style="margin-bottom:20px;">
  <div class="card-body">
    <form method="GET" class="filter-form">
      <div class="form-group" style="margin:0;">
        <label>Tipe</label>
        <select name="tipe" onchange="this.form.submit()">
          <option value="">Semua</option>
          <option value="perusahaan" {{ $tipe==='perusahaan'?'selected':'' }}>Perusahaan</option>
          <option value="individu" {{ $tipe==='individu'?'selected':'' }}>Individu</option>
        </select>
      </div>
      <div class="form-group" style="margin:0;">
        <label>Status</label>
        <select name="status" onchange="this.form.submit()">
          <option value="">Semua</option>
          <option value="pending" {{ $status==='pending'?'selected':'' }}>Pending</option>
          <option value="approved" {{ $status==='approved'?'selected':'' }}>Approved</option>
          <option value="rejected" {{ $status==='rejected'?'selected':'' }}>Rejected</option>
        </select>
      </div>
      <div></div>
      <div>
        <a href="{{ route('backoffice.bursa-sdm.create') }}" class="btn btn-primary" style="white-space:nowrap;">
          <i class="fas fa-plus"></i> Tambah Data
        </a>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3>Data Bursa SDM</h3>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>File</th><th>Nama</th><th>Tipe</th><th>Kategori</th><th>Status</th><th>Tampil</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $item)
        @php
          $ext = $item->foto ? strtolower(pathinfo($item->foto, PATHINFO_EXTENSION)) : null;
          $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        @endphp
        <tr>
          <td>
            @if($item->foto && $isImage)
              <a href="{{ asset('storage/'.$item->foto) }}" target="_blank">
                <img class="img-preview" src="{{ asset('storage/'.$item->foto) }}">
              </a>
            @elseif($item->foto)
              <a href="{{ asset('storage/'.$item->foto) }}" target="_blank" class="file-preview-link" style="display:flex;flex-direction:column;align-items:center;gap:4px;color:#dc2626;text-decoration:none;font-size:0.7rem;font-weight:600;">
                <i class="fas fa-file-pdf" style="font-size:1.6rem;"></i>
                {{ strtoupper($ext) }}
              </a>
            @else
              <img class="img-preview" src="https://via.placeholder.com/80x50">
            @endif
          </td>
          <td>{{ $item->nama }}</td>
          <td>{{ ucfirst($item->tipe) }}</td>
          <td>{{ $item->kategori }}</td>
          <td>
            @if($item->status==='pending') <span class="badge" style="background:#fef3c7;color:#92400e;">Pending</span>
            @elseif($item->status==='approved') <span class="badge badge-active">Approved</span>
            @else <span class="badge badge-inactive">Rejected</span>
            @endif
          </td>
          <td>
            <span class="badge {{ $item->is_active ? 'badge-active' : 'badge-inactive' }}">
              {{ $item->is_active ? 'Tampil' : 'Disembunyikan' }}
            </span>
          </td>
          <td>
            <div class="action-group">
              <a href="{{ route('backoffice.bursa-sdm.edit', $item->id) }}" class="btn btn-primary btn-icon" title="Edit">
                <i class="fas fa-edit"></i>
              </a>
              @if($item->status==='pending')
                <form method="POST" action="{{ route('backoffice.bursa-sdm.approve',$item->id) }}">
                  @csrf @method('PATCH')
                  <button class="btn btn-primary btn-icon" title="Approve"><i class="fas fa-check"></i></button>
                </form>
                <form method="POST" action="{{ route('backoffice.bursa-sdm.reject',$item->id) }}">
                  @csrf @method('PATCH')
                  <button class="btn btn-secondary btn-icon" title="Reject"><i class="fas fa-times"></i></button>
                </form>
              @endif
              @if($item->status==='approved')
                <form method="POST" action="{{ route('backoffice.bursa-sdm.toggle-active',$item->id) }}">
                  @csrf @method('PATCH')
                  <button class="btn btn-warning btn-icon" title="Toggle Tampil"><i class="fas fa-eye"></i></button>
                </form>
              @endif
              <form method="POST" action="{{ route('backoffice.bursa-sdm.destroy',$item->id) }}" onsubmit="return confirm('Hapus data ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-icon" title="Hapus"><i class="fas fa-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:30px;color:#999;">Belum ada data.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if ($items->hasPages())
    <div style="margin-top:30px;display:flex;justify-content:center;padding-bottom:20px;">
      <ul class="pagination">
        @if ($items->onFirstPage())
          <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
        @else
          <li class="page-item"><a class="page-link" href="{{ $items->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
        @endif

        @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
          @if ($page == $items->currentPage())
            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
          @else
            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
          @endif
        @endforeach

        @if ($items->hasMorePages())
          <li class="page-item"><a class="page-link" href="{{ $items->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
        @else
          <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
        @endif
      </ul>
    </div>
  @endif
</div>
@endsection