@extends('backoffice.layouts.app')

@section('title', 'Manajemen User')

@section('page-title', 'Manajemen User')

@section('content')
    <div class="stat-grid">
        <div class="stat-mini" style="border-left-color: #CC0000;">
            <div class="num">{{ $totalKonsultan }}</div>
            <div class="lbl"><i class="fas fa-user-tie"></i> Total Konsultan</div>
        </div>
        <div class="stat-mini" style="border-left-color: #16a34a;">
            <div class="num">{{ $totalGrcs }}</div>
            <div class="lbl"><i class="fas fa-user-shield"></i> Total GRCS Club</div>
        </div>
        <div class="stat-mini" style="border-left-color: #0ea5e9;">
            <div class="num">{{ $totalActive }}</div>
            <div class="lbl"><i class="fas fa-check-circle"></i> Anggota Aktif</div>
        </div>
        <div class="stat-mini" style="border-left-color: #f59e0b;">
            <div class="num">{{ $totalInactive }}</div>
            <div class="lbl"><i class="fas fa-clock"></i> Anggota Nonaktif</div>
        </div>
    </div>

    <div class="card" style="margin-bottom: 24px;">
        <div class="card-header">
            <h3><i class="fas fa-filter"></i> Filter & Pencarian</h3>
            <a href="{{ route('backoffice.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah User
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('backoffice.users.index') }}" method="GET" class="filter-form">
                <div class="form-group" style="margin-bottom: 0;">
                    <label>Role</label>
                    <select name="role">
                        <option value="">Semua Role</option>
                        <option value="konsultan" {{ request('role') == 'konsultan' ? 'selected' : '' }}>Konsultan</option>
                        <option value="grcs" {{ request('role') == 'grcs' ? 'selected' : '' }}>GRCS Club</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label>Status</label>
                    <select name="status">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label>Cari</label>
                    <input type="text" name="search" placeholder="Nama, email, atau institusi..." value="{{ request('search') }}">
                </div>

                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('backoffice.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>
                <i class="fas fa-users-cog"></i>
                Daftar User
                <span class="badge" style="background: #e5e7eb; color: #374151; margin-left: 8px;">{{ $users->total() }}</span>
            </h3>
        </div>

        @if($users->count() > 0)
            @php
                $groupedUsers = $users->groupBy('role');
            @endphp

            @if($groupedUsers->has('konsultan'))
            <div class="role-section">
                <div class="role-header konsultan">
                    <div class="role-icon konsultan">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="role-info">
                        <h3 style="color: #CC0000;">Konsultan</h3>
                        <small>Tenaga Ahli & Profesional</small>
                    </div>
                    <div class="role-count konsultan">
                        {{ $groupedUsers['konsultan']->count() }} Anggota
                    </div>
                </div>
                <div class="user-table" style="border: 1px solid #e8e8e8; border-top: none;">
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th width="50">#</th>
                                    <th>User</th>
                                    <th>Institusi</th>
                                    <th>Keanggotaan</th>
                                    <th>Status</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groupedUsers['konsultan'] as $user)
                                <tr>
                                    <td><strong style="color: #CC0000;">{{ $loop->iteration }}</strong></td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <img src="{{ $user->avatar_url }}" class="user-avatar konsultan" alt="{{ $user->name }}">
                                            <div class="user-info">
                                                <strong>{{ $user->name }}</strong>
                                                <small>{{ $user->email }}</small>
                                                @if($user->nip_nim)
                                                <span class="id-badge konsultan">NIP: {{ $user->nip_nim }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-regular">
                                            <i class="fas fa-building"></i> {{ $user->institution ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->membership_type == 'premium')
                                            <span class="badge badge-premium"><i class="fas fa-star"></i> Premium</span>
                                        @elseif($user->membership_type == 'vip')
                                            <span class="badge badge-vip"><i class="fas fa-crown"></i> VIP</span>
                                        @else
                                            <span class="badge badge-regular">Regular</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->is_active)
                                            <span class="badge badge-active"><i class="fas fa-check"></i> Aktif</span>
                                        @else
                                            <span class="badge badge-inactive"><i class="fas fa-pause"></i> Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-group">
                                            <a href="{{ route('backoffice.users.edit', $user->id) }}" class="btn btn-info btn-icon" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="toggleActive('{{ $user->id }}')" class="btn btn-warning btn-icon" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas fa-{{ $user->is_active ? 'pause' : 'play' }}"></i>
                                            </button>
                                            <button onclick="deleteUser('{{ $user->id }}', '{{ $user->name }}')" class="btn btn-danger btn-icon" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            @if($groupedUsers->has('grcs'))
            <div class="role-section">
                <div class="role-header grcs">
                    <div class="role-icon grcs">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="role-info">
                        <h3 style="color: #16a34a;">GRCS Club</h3>
                        <small>Governance, Risk & Compliance Specialist</small>
                    </div>
                    <div class="role-count grcs">
                        {{ $groupedUsers['grcs']->count() }} Anggota
                    </div>
                </div>
                <div class="user-table" style="border: 1px solid #e8e8e8; border-top: none;">
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th width="50">#</th>
                                    <th>User</th>
                                    <th>Institusi</th>
                                    <th>Keanggotaan</th>
                                    <th>Status</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groupedUsers['grcs'] as $user)
                                <tr>
                                    <td><strong style="color: #16a34a;">{{ $loop->iteration }}</strong></td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <img src="{{ $user->avatar_url }}" class="user-avatar grcs" alt="{{ $user->name }}">
                                            <div class="user-info">
                                                <strong>{{ $user->name }}</strong>
                                                <small>{{ $user->email }}</small>
                                                @if($user->nip_nim)
                                                <span class="id-badge grcs">NIM: {{ $user->nip_nim }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-regular">
                                            <i class="fas fa-building"></i> {{ $user->institution ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->membership_type == 'premium')
                                            <span class="badge badge-premium"><i class="fas fa-star"></i> Premium</span>
                                        @elseif($user->membership_type == 'vip')
                                            <span class="badge badge-vip"><i class="fas fa-crown"></i> VIP</span>
                                        @else
                                            <span class="badge badge-regular">Regular</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->is_active)
                                            <span class="badge badge-active"><i class="fas fa-check"></i> Aktif</span>
                                        @else
                                            <span class="badge badge-inactive"><i class="fas fa-pause"></i> Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-group">
                                            <a href="{{ route('backoffice.users.edit', $user->id) }}" class="btn btn-info btn-icon" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="toggleActive('{{ $user->id }}')" class="btn btn-warning btn-icon" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas fa-{{ $user->is_active ? 'pause' : 'play' }}"></i>
                                            </button>
                                            <button onclick="deleteUser('{{ $user->id }}', '{{ $user->name }}')" class="btn btn-danger btn-icon" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

        @else
            <div class="empty-state">
                <i class="fas fa-users-slash"></i>
                <h3>Tidak Ada Data</h3>
                <p>Belum ada user yang terdaftar atau filter tidak menemukan hasil</p>
                <a href="{{ route('backoffice.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah User Baru
                </a>
            </div>
        @endif

        @if($users->hasPages())
        <div class="pagination-wrap">
            <small class="text-muted">
                Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} data
            </small>
            {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    function toggleActive(userId) {
        if (!confirm('Apakah Anda yakin ingin mengubah status akun ini?')) return;

        fetch('{{ url("backoffice/users") }}/' + userId + '/toggle-active', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            window.location.href = '{{ route("backoffice.users.index") }}';
        })
        .catch(error => {
            alert('Terjadi kesalahan. Silakan refresh halaman.');
            console.error(error);
        });
    }

    function deleteUser(userId, userName) {
        if (!confirm('Apakah Anda yakin ingin menghapus user "' + userName + '"?\n\nData yang dihapus tidak dapat dikembalikan!')) return;

        fetch('{{ url("backoffice/users") }}/' + userId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                _method: 'DELETE'
            })
        })
        .then(response => {
            window.location.href = '{{ route("backoffice.users.index") }}';
        })
        .catch(error => {
            alert('Terjadi kesalahan saat menghapus user.');
            console.error(error);
        });
    }
</script>
@endpush