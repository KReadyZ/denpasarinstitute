@extends('backoffice.layouts.app')

@section('title', 'Verifikasi Berita')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">Verifikasi Berita</h4>
        <p class="text-muted small mb-0">Tinjau dan setujui berita yang tertunda</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    @forelse($beritas as $berita)
    <div class="card mb-4">
        <div class="card-header" style="background: #fff5f5; border-bottom: 1px solid #f0f0f0; padding: 16px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h5 class="fw-bold mb-1">{{ $berita->title }}</h5>
                <small class="text-muted">
                    Dikirim oleh <strong>{{ $berita->creator->name ?? $berita->kontributor }}</strong> 
                    pada {{ $berita->created_at->format('d M Y H:i') }}
                </small>
            </div>
            <span class="badge" style="background:#fef3c7;color:#92400e;">{{ $berita->kategori }}</span>
        </div>
        <div class="card-body">
            <div class="row">
                @if($berita->image)
                <div class="col-md-3 mb-3">
                    <img src="{{ asset('storage/' . $berita->image) }}" class="img-fluid rounded" style="width:100%;max-height:200px;object-fit:cover;">
                </div>
                @endif

                <div class="{{ $berita->image ? 'col-md-9' : 'col-12' }}">
                    <div style="line-height:1.6;color:#555;">
                        {!! Str::limit(strip_tags($berita->content), 300) !!}...
                    </div>

                    <div style="margin-top:16px;padding:12px;background:#f9f9f9;border-radius:6px;font-size:0.85rem;color:#666;">
                        <strong>Informasi:</strong><br>
                        Kategori: {{ $berita->kategori }}<br>
                        Kontributor: {{ $berita->kontributor }}<br>
                        Tayang: {{ $berita->published_at ? $berita->published_at->format('d M Y H:i') : '-' }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer" style="background: #fafafa; padding: 16px; display: flex; gap: 10px; justify-content: flex-end;">
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $berita->id }}">
                <i class="fas fa-times"></i> Tolak
            </button>
            <form action="{{ route('backoffice.berita.approve', $berita->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i> Setujui
                </button>
            </form>
        </div>
    </div>

    {{-- Modal Reject --}}
    <div class="modal fade" id="rejectModal{{ $berita->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('backoffice.berita.reject', $berita->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label class="form-label">Alasan Penolakan</label>
                        <textarea name="rejection_note" class="form-control" rows="4" placeholder="Jelaskan mengapa berita ditolak..." required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak Berita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @empty
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-check-circle" style="font-size:3rem;color:#d1d5db;margin-bottom:10px;display:block;"></i>
            <h4 style="color:#9ca3af;">Tidak ada berita untuk diverifikasi</h4>
            <p style="color:#9ca3af;">Semua berita sudah diproses</p>
        </div>
    </div>
    @endforelse

    @if($beritas->hasPages())
    <div style="margin-top:20px;text-align:center;">
        {{ $beritas->links() }}
    </div>
    @endif

</div>
@endsection