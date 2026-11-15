@extends('backoffice.layouts.app')

@section('title', 'Verifikasi & Data Mitra Kemitraan')

@section('content')
<div class="container-fluid" style="padding:24px;">
    
    {{-- Header --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <h4 style="margin:0;font-weight:700;">Verifikasi &amp; Data Mitra Kemitraan</h4>
            <small class="text-muted">Kelola pengajuan kemitraan baru, verifikasi persetujuan (approval), dan tampilkan langsung di halaman publik Mitra &amp; Klien.</small>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <a href="{{ route('backoffice.partnership-submission.create') }}" class="btn btn-danger">
                <i class="fas fa-plus"></i> Tambah Mitra Baru (Manual)
            </a>
            <a href="{{ route('mitra-dan-klien') }}" target="_blank" class="btn btn-outline-danger">
                <i class="fas fa-external-link-alt"></i> Lihat Halaman Mitra &amp; Klien
            </a>
        </div>
    </div>

    {{-- Tabs Navigasi Kemitraan --}}
    <ul class="nav nav-pills mb-4" style="background:#ffffff;padding:8px 12px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.04);border:1px solid #fee2e2;">
        <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('backoffice.partnership-pillar.index') }}">
                <i class="fas fa-cubes text-danger me-1"></i> 6 Pilar Kemitraan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active bg-danger" href="{{ route('backoffice.partnership-submission.index') }}">
                <i class="fas fa-user-check me-1"></i> Verifikasi &amp; Mitra Klien
                @if(isset($totalPending) && $totalPending > 0)
                    <span class="badge bg-warning text-dark ms-1">{{ $totalPending }} Perlu Verifikasi</span>
                @endif
            </a>
        </li>
    </ul>

    {{-- Ringkasan Statistik Card --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('backoffice.partnership-submission.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm" style="border-left: 4px solid #64748b !important;border-radius:10px;">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small fw-bold text-uppercase">Semua Data</div>
                            <div class="h4 mb-0 fw-bold text-dark">{{ $totalAll }}</div>
                        </div>
                        <div class="bg-light p-3 rounded-circle text-muted">
                            <i class="fas fa-clipboard-list fa-lg"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('backoffice.partnership-submission.index', ['status' => 'pending']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm" style="border-left: 4px solid #f59e0b !important;border-radius:10px;">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-warning small fw-bold text-uppercase">Menunggu Verifikasi</div>
                            <div class="h4 mb-0 fw-bold text-warning">{{ $totalPending }}</div>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                            <i class="fas fa-hourglass-half fa-lg"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('backoffice.partnership-submission.index', ['status' => 'approved']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm" style="border-left: 4px solid #10b981 !important;border-radius:10px;">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-success small fw-bold text-uppercase">Mitra Disetujui (Tayang)</div>
                            <div class="h4 mb-0 fw-bold text-success">{{ $totalApproved }}</div>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('backoffice.partnership-submission.index', ['status' => 'rejected']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm" style="border-left: 4px solid #ef4444 !important;border-radius:10px;">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-danger small fw-bold text-uppercase">Pengajuan Ditolak</div>
                            <div class="h4 mb-0 fw-bold text-danger">{{ $totalRejected }}</div>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger">
                            <i class="fas fa-times-circle fa-lg"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filter & Search Card --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('backoffice.partnership-submission.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama institusi, PIC, email, atau no WA...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status ({{ $totalAll }})</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>⏳ Menunggu Verifikasi ({{ $totalPending }})</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>✅ Disetujui / Tayang di Web ({{ $totalApproved }})</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>❌ Ditolak ({{ $totalRejected }})</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('backoffice.partnership-submission.index') }}" class="btn btn-light border">
                        <i class="fas fa-undo"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Submissions Table Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-danger">
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th width="75" class="text-center">Logo</th>
                        <th>Institusi / Perusahaan</th>
                        <th>PIC &amp; Kontak</th>
                        <th>Minat Pilar</th>
                        <th width="140" class="text-center">Status Verifikasi</th>
                        <th width="220" class="text-center">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $index => $s)
                    <tr style="{{ $s->status === 'pending' ? 'background: #fffdf5;' : '' }}">
                        <td class="text-center text-muted fw-bold">
                            {{ $submissions->firstItem() + $index }}
                        </td>
                        <td class="text-center">
                            @if($s->logo && file_exists(public_path($s->logo)))
                                <a href="{{ asset($s->logo) }}" target="_blank" title="Buka logo asli">
                                    <img src="{{ asset($s->logo) }}" alt="Logo {{ $s->institusi }}" 
                                         style="width:55px;height:55px;object-fit:contain;border-radius:8px;border:1px solid #e2e8f0;background:#ffffff;padding:4px;">
                                </a>
                            @else
                                <div style="width:55px;height:55px;border-radius:8px;background:#f1f5f9;color:#94a3b8;display:flex;align-items:center;justify-content:center;margin:0 auto;font-size:1.2rem;">
                                    <i class="fas fa-building"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong style="color:#0f172a;font-size:1rem;display:block;">{{ $s->institusi }}</strong>
                            <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                @if($s->kategori)
                                    <span class="badge bg-secondary" style="font-size:0.72rem;">{{ $s->kategori }}</span>
                                @endif
                                @if($s->website)
                                    @php $wUrl = str_starts_with($s->website, 'http') ? $s->website : 'https://' . $s->website; @endphp
                                    <a href="{{ $wUrl }}" target="_blank" rel="noopener noreferrer" style="font-size:0.8rem;color:#0284c7;text-decoration:none;">
                                        <i class="fas fa-globe"></i> Website
                                    </a>
                                @endif
                                @if($s->link_gmap)
                                    <a href="{{ $s->link_gmap }}" target="_blank" rel="noopener noreferrer" style="font-size:0.8rem;color:#cc0000;text-decoration:none;">
                                        <i class="fas fa-map-marker-alt"></i> Maps
                                    </a>
                                @endif
                            </div>
                            <div style="font-size:0.75rem;color:#94a3b8;margin-top:4px;">
                                <i class="far fa-clock"></i> Masuk: {{ $s->created_at->format('d M Y, H:i') }}
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:700;color:#1e293b;">{{ $s->nama_pic }}</div>
                            <div style="font-size:0.82rem;color:#475569;">
                                <i class="fas fa-envelope text-danger" style="width:14px;"></i> {{ $s->email }}
                            </div>
                            <div style="font-size:0.82rem;margin-top:2px;">
                                @php
                                    $waClean = preg_replace('/[^0-9]/', '', $s->no_wa);
                                    if (str_starts_with($waClean, '0')) {
                                        $waClean = '62' . substr($waClean, 1);
                                    }
                                @endphp
                                @if($waClean)
                                    <a href="https://wa.me/{{ $waClean }}?text={{ urlencode('Halo ' . $s->nama_pic . ', kami dari Denpasar Institute menindaklanjuti permohonan kemitraan ' . $s->institusi . '.') }}" target="_blank" class="text-success fw-bold text-decoration-none">
                                        <i class="fab fa-whatsapp" style="width:14px;"></i> {{ $s->no_wa }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-danger text-white p-2" style="font-size:0.78rem;">
                                <i class="fas fa-handshake me-1"></i> {{ $s->pillar_title ?? 'Kemitraan Strategis' }}
                            </span>
                            @if($s->pesan)
                                <div style="font-size:0.78rem;color:#64748b;margin-top:6px;max-width:220px;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;" title="{{ $s->pesan }}">
                                    "{{ $s->pesan }}"
                                </div>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($s->status === 'pending')
                                <span class="badge bg-warning text-dark px-3 py-2" style="font-size:0.82rem;">
                                    <i class="fas fa-hourglass-half me-1"></i> Menunggu Verifikasi
                                </span>
                            @elseif($s->status === 'approved')
                                <span class="badge bg-success text-white px-3 py-2" style="font-size:0.82rem;">
                                    <i class="fas fa-check-circle me-1"></i> Terverifikasi / Tayang
                                </span>
                                @if($s->verified_at)
                                    <div style="font-size:0.72rem;color:#64748b;margin-top:3px;">
                                        Oleh: {{ $s->verified_by ?? 'Super Admin' }}<br>
                                        {{ $s->verified_at->format('d M Y') }}
                                    </div>
                                @endif
                            @elseif($s->status === 'rejected')
                                <span class="badge bg-danger text-white px-3 py-2" style="font-size:0.82rem;">
                                    <i class="fas fa-times-circle me-1"></i> Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex align-items-center justify-content-center gap-1 flex-wrap">
                                {{-- Tombol Aksi Verifikasi --}}
                                @if($s->status === 'pending')
                                    {{-- Approve Button --}}
                                    <form action="{{ route('backoffice.partnership-submission.update-status', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Verifikasi dan setujui kemitraan dari {{ $s->institusi }}?\n\nSetelah disetujui, logo dan nama mitra akan langsung tampil di halaman publik Mitra & Klien.');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-sm btn-success fw-bold" title="Setujui dan tayangkan di halaman Mitra & Klien">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                    </form>

                                    {{-- Reject Button --}}
                                    <form action="{{ route('backoffice.partnership-submission.update-status', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tolak permohonan kemitraan dari {{ $s->institusi }}?');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Tolak Pengajuan">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @elseif($s->status === 'approved')
                                    {{-- Batalkan Verifikasi --}}
                                    <form action="{{ route('backoffice.partnership-submission.update-status', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Batalkan verifikasi {{ $s->institusi }}?\n\nMitra ini tidak akan tampil lagi di halaman Mitra & Klien sampai diverifikasi ulang.');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="pending">
                                        <button type="submit" class="btn btn-sm btn-outline-warning" title="Batalkan verifikasi (kembalikan ke pending)">
                                            <i class="fas fa-undo"></i> Batal Verif
                                        </button>
                                    </form>
                                @elseif($s->status === 'rejected')
                                    {{-- Setujui Ulang --}}
                                    <form action="{{ route('backoffice.partnership-submission.update-status', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Setujui kembali kemitraan {{ $s->institusi }} dan tayangkan di web?');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Setujui Ulang">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                    </form>
                                @endif

                                {{-- Edit Button --}}
                                <a href="{{ route('backoffice.partnership-submission.edit', $s->id) }}" class="btn btn-sm btn-light border text-primary" title="Edit Data Mitra">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Delete Button --}}
                                <form action="{{ route('backoffice.partnership-submission.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus permanen data {{ $s->institusi }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border text-danger" title="Hapus Permanen">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 text-secondary" style="opacity:0.4;"></i>
                            <p class="mb-0">Tidak ada data mitra atau pengajuan kemitraan yang sesuai kriteria.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($submissions->hasPages())
        <div class="card-footer bg-white border-0 py-3 d-flex justify-content-center">
            {{ $submissions->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>

</div>
@endsection
