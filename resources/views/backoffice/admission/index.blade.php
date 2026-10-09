@extends('backoffice.layouts.app')

@section('title', 'Admission')
@section('page-title', 'Data Pendaftaran')

@section('content')

<div class="card">
  <div class="card-header">
    <h3>Data Pendaftaran (Admission)</h3>
    <a href="{{ route('backoffice.admission.create') }}" class="btn btn-primary">
      <i class="fas fa-plus"></i> Tambah Data
    </a>
  </div>
  <div class="card-body table-wrap">
    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Kontak</th>
          <th>Program</th>
          <th>Status</th>
          <th>Tanggal Daftar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($admissions as $admission)
        <tr>
          <td>{{ $admission->nama_lengkap }}</td>
          <td>
            {{ $admission->hp_wa }}<br>
            <small>{{ $admission->email }}</small>
          </td>
          <td>
            @forelse($admission->programs as $program)
              <span class="badge badge-regular">{{ $program->nama }}</span>
            @empty
              -
            @endforelse
          </td>
          <td>
            @if($admission->status == 'approved')
              <span class="badge badge-approved">Terverifikasi</span>
            @elseif($admission->status == 'rejected')
              <span class="badge badge-rejected">Ditolak</span>
            @else
              <span class="badge badge-pending">Pending</span>
            @endif
          </td>
          <td>{{ $admission->created_at->format('d M Y H:i') }}</td>
          <td>
            <div class="action-group">
              <a href="{{ route('backoffice.admission.edit', $admission->id) }}" class="btn btn-secondary btn-icon" title="Edit">
                <i class="fas fa-pen"></i>
              </a>

              @if($admission->status != 'approved')
              <button type="button" class="btn btn-success btn-icon" data-bs-toggle="modal" data-bs-target="#approveModal{{ $admission->id }}" title="Approve">
                <i class="fas fa-check"></i>
              </button>
              @endif

              @if($admission->status != 'rejected')
              <button type="button" class="btn btn-warning btn-icon" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $admission->id }}" title="Tolak">
                <i class="fas fa-ban"></i>
              </button>
              @endif

              <form action="{{ route('backoffice.admission.destroy', $admission->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-icon" title="Hapus">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>

        <div class="modal fade" id="approveModal{{ $admission->id }}" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="{{ route('backoffice.admission.approve', $admission->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                  <h5 class="modal-title">Approve Pendaftaran</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Catatan untuk peserta (opsional, akan dikirim via email)</label>
                    <textarea name="catatan_admin" rows="4">{{ $admission->catatan_admin }}</textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-success">Approve</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="modal fade" id="rejectModal{{ $admission->id }}" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="{{ route('backoffice.admission.reject', $admission->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                  <h5 class="modal-title">Tolak Pendaftaran</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Alasan penolakan (opsional)</label>
                    <textarea name="catatan_admin" rows="4">{{ $admission->catatan_admin }}</textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-warning">Tolak</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        @empty
        <tr>
          <td colspan="6">
            <div class="empty-state">
              <i class="fas fa-inbox"></i>
              <h3>Belum ada data</h3>
              <p>Data pendaftaran akan muncul di sini.</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>

    <div class="pagination-info">
      {{ $admissions->links() }}
    </div>
  </div>
</div>

@endsection