@extends('backoffice.layouts.app')

@section('title', 'Pengaturan Navigasi & Menu')

@section('content')
<div class="container-fluid" style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <h4 style="margin:0;font-weight:700;">Pengaturan Navigasi &amp; Menu Website</h4>
            <small class="text-muted">Kelola item menu pada Navbar (atas) dan Footer (bawah) seluruh website.</small>
        </div>
        <a href="{{ route('backoffice.navigation.create', ['location' => $currentLocation]) }}" class="btn btn-danger">
            <i class="fas fa-plus"></i> Tambah Menu
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabs Lokasi Menu --}}
    <ul class="nav nav-pills mb-3" style="background:#fff;padding:8px;border-radius:8px;border:1px solid #e2e8f0;">
        @foreach($locations as $key => $label)
            <li class="nav-item">
                <a class="nav-link {{ $currentLocation === $key ? 'active bg-danger' : 'text-dark' }}" 
                   href="{{ route('backoffice.navigation.index', ['location' => $key]) }}"
                   style="font-weight:600;padding:8px 18px;">
                    {{ $label }}
                </a>
            </li>
        @endforeach
    </ul>

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-danger">
                    <tr>
                        <th width="80" class="text-center">Urutan</th>
                        <th>Judul Menu</th>
                        <th>URL / Link Tujuan</th>
                        <th>Target Window</th>
                        <th width="120" class="text-center">Status</th>
                        <th width="160" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td class="text-center font-monospace"><strong>{{ $item->order }}</strong></td>
                        <td>
                            <strong style="color:#1e293b;">{{ $item->title }}</strong>
                            @if($item->location === 'navbar_left' && $item->title === 'Divisi')
                                <span class="badge bg-secondary ms-1">Dropdown Dinamis</span>
                            @endif
                        </td>
                        <td>
                            <code style="color:#cc0000;background:#fff1f1;padding:2px 8px;border-radius:4px;">{{ $item->url }}</code>
                        </td>
                        <td>
                            <span class="badge {{ $item->target === '_blank' ? 'bg-info text-dark' : 'bg-light text-dark border' }}">
                                {{ $item->target === '_blank' ? 'Tab Baru (_blank)' : 'Halaman Sama (_self)' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('backoffice.navigation.toggle-active', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $item->is_active ? 'btn-success' : 'btn-secondary' }}" style="font-size:0.78rem;">
                                    <i class="fas {{ $item->is_active ? 'fa-check' : 'fa-times' }}"></i>
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('backoffice.navigation.edit', $item->id) }}" class="btn btn-sm btn-warning text-dark me-1" title="Edit Menu">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('backoffice.navigation.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event, this, 'Apakah Anda yakin ingin menghapus menu {{ $item->title }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Menu">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Belum ada item menu untuk kategori <strong>{{ $locations[$currentLocation] ?? $currentLocation }}</strong>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

