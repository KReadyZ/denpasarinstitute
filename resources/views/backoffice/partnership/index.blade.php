@extends('backoffice.layouts.app')

@section('title', 'Pilar Kemitraan (Partnership)')

@section('content')
<div class="container-fluid" style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <h4 style="margin:0;font-weight:700;">Kelola 6 Pilar Kemitraan (Partner with DI)</h4>
            <small class="text-muted">Kelola kartu pilar kemitraan, gambar ilustrasi, deskripsi, dan tombol "Learn more" pada halaman kemitraan.</small>
        </div>
        <div style="display:flex;gap:10px;">
            <a href="{{ route('partners-and-community') }}" target="_blank" class="btn btn-outline-danger">
                <i class="fas fa-external-link-alt"></i> Lihat Halaman Kemitraan
            </a>
            <a href="{{ route('backoffice.partnership-pillar.create') }}" class="btn btn-danger">
                <i class="fas fa-plus"></i> Tambah Pilar
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-danger">
                    <tr>
                        <th width="70" class="text-center">No</th>
                        <th width="100">Foto</th>
                        <th>Judul &amp; Tag Pilar</th>
                        <th>Deskripsi Singkat</th>
                        <th>Link Tujuan (Learn more)</th>
                        <th width="110" class="text-center">Status</th>
                        <th width="160" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pillars as $p)
                    <tr>
                        <td class="text-center font-monospace">
                            <span class="badge bg-danger text-white fs-6">{{ $p->number }}</span>
                        </td>
                        <td>
                            @if($p->image)
                                <img src="{{ asset($p->image) }}" alt="{{ $p->title }}" 
                                     style="width:85px;height:55px;object-fit:cover;border-radius:6px;border:1px solid #fee2e2;">
                            @else
                                <span class="badge bg-light text-muted border">No image</span>
                            @endif
                        </td>
                        <td>
                            <strong style="color:#1e293b;font-size:1.02rem;">{{ $p->title }}</strong><br>
                            <span class="badge bg-light text-danger border" style="font-size:0.75rem;">
                                <i class="fas {{ $p->icon ?? 'fa-tag' }}"></i> {{ $p->tag }}
                            </span>
                        </td>
                        <td>
                            <div style="font-size:0.86rem;color:#475569;max-width:320px;line-height:1.45;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                {{ $p->description }}
                            </div>
                        </td>
                        <td>
                            <code style="font-size:0.78rem;color:#cc0000;background:#fff5f5;padding:3px 6px;border-radius:4px;word-break:break-all;">
                                {{ $p->link_url ?? '-' }}
                            </code>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('backoffice.partnership-pillar.toggle-active', $p->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $p->is_active ? 'btn-success' : 'btn-secondary' }}" style="font-size:0.78rem;">
                                    <i class="fas {{ $p->is_active ? 'fa-check' : 'fa-times' }}"></i>
                                    {{ $p->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('backoffice.partnership-pillar.edit', $p->id) }}" class="btn btn-sm btn-warning text-dark me-1" title="Edit Pilar">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('backoffice.partnership-pillar.destroy', $p->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event, this, 'Apakah Anda yakin ingin menghapus pilar {{ $p->title }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Pilar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada pilar kemitraan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

