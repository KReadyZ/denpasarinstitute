@extends('backoffice.layouts.app')

@section('title', 'Data Konsultan')
@section('page-title', 'Data Anggota Konsultan')

@section('content')
<div class="row" style="display:flex; gap:15px; margin-bottom:20px; flex-wrap:wrap;">
    <div class="card" style="flex:1; min-width:140px; text-align:center; padding:15px;">
        <h3 style="color: var(--red);">{{ $totalActive }}</h3>
        <small>Aktif</small>
    </div>
    <div class="card" style="flex:1; min-width:140px; text-align:center; padding:15px; border-top: 3px solid #f59e0b;">
        <h3 style="color:#d97706;">{{ $totalPending }}</h3>
        <small><strong>Menunggu Verifikasi</strong></small>
    </div>
    <div class="card" style="flex:1; min-width:140px; text-align:center; padding:15px;">
        <h3 style="color:#999;">{{ $totalInactive }}</h3>
        <small>Non-Aktif</small>
    </div>
    <div class="card" style="flex:1; min-width:140px; text-align:center; padding:15px;">
        <h3 style="color:#F5C400;">{{ $totalPremium }}</h3>
        <small>Premium</small>
    </div>
    <div class="card" style="flex:1; min-width:140px; text-align:center; padding:15px;">
        <h3 style="color:#CC0000;">{{ $totalVip }}</h3>
        <small>VIP</small>
    </div>
</div>

<div class="card">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
        <h3 style="margin:0;"><i class="fas fa-user-tie"></i> Data Konsultan</h3>
        <div style="display:flex; gap:10px; align-items:center;">
            <a href="{{ route('backoffice.konsultan.verifikasi') }}" class="btn btn-warning" style="position:relative;">
                <i class="fas fa-clipboard-check"></i> Verifikasi Pendaftar
                @if($totalPending > 0)
                    <span class="badge" style="background:#CC0000; color:#fff; border-radius:10px; padding:2px 7px; font-size:0.72rem; margin-left:4px;">{{ $totalPending }}</span>
                @endif
            </a>
            <a href="{{ route('backoffice.konsultan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Konsultan
            </a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" id="konsultanFilterForm" style="display:flex; gap:10px; margin-bottom:15px; flex-wrap:wrap;">
            <input
                type="text"
                name="search"
                id="konsultanSearchInput"
                class="form-control"
                placeholder="Cari nama, email, no. anggota..."
                value="{{ request('search') }}"
                style="max-width:300px;"
                autocomplete="off"
            >
            <select name="status" id="konsultanStatusFilter" class="form-control" style="max-width:200px;">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi ({{ $totalPending }})</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Cari</button>
            @if(request()->filled('status') || request()->filled('search'))
                <a href="{{ route('backoffice.konsultan.index') }}" class="btn btn-light"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div style="overflow-x:auto;" id="konsultanTableWrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>No. Anggota</th>
                        <th>Email</th>
                        <th>Institusi</th>
                        <th>Membership</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($konsultans as $konsultan)
                    <tr>
                        <td><img src="{{ $konsultan->foto_url }}" alt="{{ $konsultan->name }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:1px solid #ddd;"></td>
                        <td>
                            <strong>{{ $konsultan->name }}</strong>
                            @if($konsultan->verification_status === 'pending' || (!$konsultan->is_active && empty($konsultan->verification_status)))
                                <span class="badge" style="background:#fef3c7; color:#92400e; font-size:0.68rem; margin-left:4px;">Baru</span>
                            @endif
                        </td>
                        <td>{{ $konsultan->no_anggota ?? '-' }}</td>
                        <td>{{ $konsultan->email }}</td>
                        <td>{{ $konsultan->institution ?? '-' }}</td>
                        <td>
                            <span class="badge" style="background:{{ $konsultan->membership_type == 'vip' ? '#CC0000' : ($konsultan->membership_type == 'premium' ? '#F5C400' : '#999') }}; color:#fff; padding:3px 8px; border-radius:4px;">
                                {{ ucfirst($konsultan->membership_type) }}
                            </span>
                        </td>
                        <td>
                            @if($konsultan->verification_status === 'pending' || (!$konsultan->is_active && empty($konsultan->verification_status)))
                                <span class="badge" style="background:#fef3c7; color:#92400e; padding:4px 8px; font-size:0.73rem;">
                                    <i class="fas fa-clock"></i> Perlu Verifikasi
                                </span>
                            @elseif($konsultan->verification_status === 'rejected')
                                <span class="badge" style="background:#fee2e2; color:#991b1b; padding:4px 8px; font-size:0.73rem;" title="{{ $konsultan->rejection_reason }}">
                                    <i class="fas fa-times-circle"></i> Ditolak
                                </span>
                            @else
                                <form action="{{ route('backoffice.konsultan.toggle-active', $konsultan->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm" style="background:{{ $konsultan->is_active ? '#28a745' : '#999' }}; color:#fff;" title="Klik untuk ubah status aktif/non-aktif">
                                        {{ $konsultan->is_active ? 'Aktif' : 'Non-Aktif' }}
                                    </button>
                                </form>
                            @endif
                        </td>
                        <td style="white-space:nowrap;">
                            @if($konsultan->verification_status === 'pending' || (!$konsultan->is_active && empty($konsultan->verification_status)))
                                <a href="{{ route('backoffice.konsultan.verifikasi.show', $konsultan->id) }}" class="btn btn-sm btn-success" title="Verifikasi Pendaftar">
                                    <i class="fas fa-clipboard-check"></i> Verifikasi
                                </a>
                            @endif
                            <a href="{{ route('backoffice.konsultan.show', $konsultan->id) }}" class="btn btn-sm btn-info" title="Lihat Profil"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('backoffice.konsultan.edit', $konsultan->id) }}" class="btn btn-sm btn-warning" title="Edit Data"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('backoffice.konsultan.destroy', $konsultan->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus konsultan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" style="text-align:center; padding:30px; color:#888;">Belum ada data konsultan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:15px;">
            {{ $konsultans->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    var searchInput   = document.getElementById('konsultanSearchInput');
    var statusFilter  = document.getElementById('konsultanStatusFilter');
    var filterForm    = document.getElementById('konsultanFilterForm');
    var debounceTimer = null;

    if (searchInput) {
        // Auto-submit sambil mengetik (debounce 500ms supaya tidak submit tiap huruf)
        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                filterForm.submit();
            }, 500);
        });

        // Jaga posisi kursor & fokus tetap di input setelah reload
        var savedValue = searchInput.value;
        if (savedValue) {
            searchInput.focus();
            searchInput.setSelectionRange(savedValue.length, savedValue.length);
        }
    }

    if (statusFilter) {
        // Filter status langsung submit begitu dipilih
        statusFilter.addEventListener('change', function () {
            clearTimeout(debounceTimer);
            filterForm.submit();
        });
    }
})();
</script>
@endpush
@endsection