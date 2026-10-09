@extends('backoffice.layouts.app')

@section('title', 'Data GRCS Club')
@section('page-title', 'Data Anggota GRCS Club')

@section('content')
<div class="row" style="display:flex; gap:15px; margin-bottom:20px; flex-wrap:wrap;">
    <div class="card" style="flex:1; min-width:150px; text-align:center; padding:15px;">
        <h3 style="color: var(--red);">{{ $totalActive }}</h3>
        <small>Aktif</small>
    </div>
    <div class="card" style="flex:1; min-width:150px; text-align:center; padding:15px;">
        <h3 style="color:#999;">{{ $totalInactive }}</h3>
        <small>Non-Aktif</small>
    </div>
    <div class="card" style="flex:1; min-width:150px; text-align:center; padding:15px;">
        <h3 style="color:#F5C400;">{{ $totalPremium }}</h3>
        <small>Premium</small>
    </div>
    <div class="card" style="flex:1; min-width:150px; text-align:center; padding:15px;">
        <h3 style="color:#CC0000;">{{ $totalVip }}</h3>
        <small>VIP</small>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-users"></i> Data GRCS Club</h3>
        <a href="{{ route('backoffice.grcs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Anggota GRCS
        </a>
    </div>
    <div class="card-body">
        <form method="GET" id="grcsFilterForm" style="display:flex; gap:10px; margin-bottom:15px; flex-wrap:wrap;">
            <input
                type="text"
                name="search"
                id="grcsSearchInput"
                class="form-control"
                placeholder="Cari nama, email, no. anggota..."
                value="{{ request('search') }}"
                style="max-width:300px;"
                autocomplete="off"
            >
            <select name="status" id="grcsStatusFilter" class="form-control" style="max-width:150px;">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
            </select>
            <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Cari</button>
        </form>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div style="overflow-x:auto;" id="grcsTableWrap">
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
                    @forelse($grcsMembers as $member)
                    <tr>
                        <td><img src="{{ $member->foto_url }}" alt="{{ $member->name }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;"></td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->no_anggota ?? '-' }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->institution ?? '-' }}</td>
                        <td>
                            <span class="badge" style="background:{{ $member->membership_type == 'vip' ? '#CC0000' : ($member->membership_type == 'premium' ? '#F5C400' : '#999') }}; color:#fff; padding:3px 8px; border-radius:4px;">
                                {{ ucfirst($member->membership_type) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('backoffice.grcs.toggle-active', $member->id) }}" method="POST" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm" style="background:{{ $member->is_active ? '#28a745' : '#999' }}; color:#fff;">
                                    {{ $member->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </button>
                            </form>
                        </td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('backoffice.grcs.show', $member->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('backoffice.grcs.edit', $member->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('backoffice.grcs.destroy', $member->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus anggota GRCS ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" style="text-align:center;">Belum ada data anggota GRCS</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:15px;">
            {{ $grcsMembers->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    var searchInput   = document.getElementById('grcsSearchInput');
    var statusFilter  = document.getElementById('grcsStatusFilter');
    var filterForm    = document.getElementById('grcsFilterForm');
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
        statusFilter.addEventListener('change', function () {
            clearTimeout(debounceTimer);
            filterForm.submit();
        });
    }
})();
</script>
@endpush
@endsection