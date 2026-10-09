@extends('backoffice.layouts.app')

@section('title', 'Verifikasi Event')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">Verifikasi Event</h4>
        <p class="text-muted small mb-0">Tinjau dan setujui event yang tertunda</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    @forelse($events as $event)
    <div class="card mb-4">
        <div class="card-header" style="background: #fff5f5; border-bottom: 1px solid #f0f0f0; padding: 16px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h5 class="fw-bold mb-1">{{ $event->title }}</h5>
                <small class="text-muted">
                    Dikirim oleh <strong>{{ $event->creator->name ?? $event->kontributor }}</strong> 
                    pada {{ $event->created_at->format('d M Y H:i') }}
                </small>
            </div>
            <span class="badge" style="background:#fef3c7;color:#92400e;">{{ $event->kategori }}</span>
        </div>
        <div class="card-body">
            <div class="row">
                @if($event->image)
                <div class="col-md-3 mb-3">
                    <img src="{{ asset('storage/' . $event->image) }}" class="img-fluid rounded" style="width:100%;max-height:200px;object-fit:cover;">
                </div>
                @endif

                <div class="{{ $event->image ? 'col-md-9' : 'col-12' }}">
                    <div style="line-height:1.6;color:#555;">
                        {!! Str::limit(strip_tags($event->content), 300) !!}...
                    </div>

                    <div style="margin-top:16px;padding:12px;background:#f9f9f9;border-radius:6px;font-size:0.85rem;color:#666;">
                        <strong>Informasi:</strong><br>
                        Kategori: {{ $event->kategori }}<br>
                        Kontributor: {{ $event->kontributor }}<br>
                        Tayang: {{ $event->published_at ? $event->published_at->format('d M Y H:i') : '-' }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer" style="background: #fafafa; padding: 16px; display: flex; gap: 10px; justify-content: flex-end;">
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $event->id }}">
                <i class="fas fa-times"></i> Tolak
            </button>
            <form action="{{ route('backoffice.event.approve', $event->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i> Setujui
                </button>
            </form>
        </div>
    </div>

    {{-- Modal Reject --}}
    <div class="modal fade" id="rejectModal{{ $event->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('backoffice.event.reject', $event->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label class="form-label">Alasan Penolakan</label>
                        <textarea name="rejection_note" class="form-control" rows="4" placeholder="Jelaskan mengapa event ditolak..." required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @empty
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-check-circle" style="font-size:3rem;color:#d1d5db;margin-bottom:10px;display:block;"></i>
            <h4 style="color:#9ca3af;">Tidak ada event untuk diverifikasi</h4>
            <p style="color:#9ca3af;">Semua event sudah diproses</p>
        </div>
    </div>
    @endforelse

    @if($events->hasPages())
    <div style="margin-top:20px;text-align:center;">
        {{ $events->links() }}
    </div>
    @endif

</div>
@endsection