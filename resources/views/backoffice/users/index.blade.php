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

                <div class="filter-btn-group" style="display: flex; gap: 8px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1; justify-content: center;">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('backoffice.users.index') }}" class="btn btn-secondary" style="flex: 1; justify-content: center;">
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
                                            <button onclick="toggleActive('{{ $user->id }}', '{{ addslashes($user->name) }}', {{ $user->is_active ? 'true' : 'false' }}, '{{ addslashes($user->email) }}', '{{ addslashes($user->role) }}', '{{ $user->avatar_url }}')" class="btn btn-warning btn-icon" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas fa-{{ $user->is_active ? 'pause' : 'play' }}"></i>
                                            </button>
                                            <button onclick="deleteUser('{{ $user->id }}', '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')" class="btn btn-danger btn-icon" title="Hapus">
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
                                            <button onclick="toggleActive('{{ $user->id }}', '{{ addslashes($user->name) }}', {{ $user->is_active ? 'true' : 'false' }}, '{{ addslashes($user->email) }}', '{{ addslashes($user->role) }}', '{{ $user->avatar_url }}')" class="btn btn-warning btn-icon" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas fa-{{ $user->is_active ? 'pause' : 'play' }}"></i>
                                            </button>
                                            <button onclick="deleteUser('{{ $user->id }}', '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')" class="btn btn-danger btn-icon" title="Hapus">
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
<style>
    /* Styling khusus modal notifikasi konfirmasi user */
    .swal-user-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
        margin: 14px 0 10px;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .swal-user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e2e8f0;
        background: #CC0000;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.95rem;
        flex-shrink: 0;
    }
    .swal-user-details {
        flex: 1;
        min-width: 0;
    }
    .swal-user-name {
        font-weight: 700;
        font-size: 0.92rem;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .swal-user-email {
        font-size: 0.78rem;
        color: #64748b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-top: 1px;
    }
    .swal-transition-wrap {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        border: 1px dashed #cbd5e1;
        padding: 6px 14px;
        border-radius: 30px;
        margin: 6px 0 10px;
        font-size: 0.78rem;
        font-weight: 600;
    }
    .swal-status-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 14px;
        font-size: 0.75rem;
    }
    .swal-chip-active {
        background: #dcfce7;
        color: #15803d;
    }
    .swal-chip-inactive {
        background: #fee2e2;
        color: #b91c1c;
    }
    @media (max-width: 576px) {
        .swal-user-card {
            padding: 10px 12px;
            gap: 10px;
        }
        .swal-user-avatar {
            width: 38px;
            height: 38px;
            font-size: 0.85rem;
        }
        .swal-user-name {
            font-size: 0.86rem;
        }
        .swal-user-email {
            font-size: 0.72rem;
        }
        .swal-transition-wrap {
            padding: 4px 10px;
            font-size: 0.72rem;
            gap: 6px;
        }
        .swal-status-chip {
            padding: 2px 7px;
            font-size: 0.7rem;
        }
    }
</style>

<script>
    function toggleActive(userId, userName, isActive, userEmail, userRole, avatarUrl) {
        var willDeactivate = isActive;
        var title = willDeactivate ? 'Nonaktifkan Akun Pengguna?' : 'Aktifkan Akun Pengguna?';
        var actionVerb = willDeactivate ? 'menonaktifkan' : 'mengaktifkan';
        var confirmText = willDeactivate ? '<i class="fas fa-pause"></i> Ya, Nonaktifkan' : '<i class="fas fa-play"></i> Ya, Aktifkan';
        var confirmColor = willDeactivate ? '#eab308' : '#16a34a';
        var helperText = willDeactivate 
            ? 'Pengguna tidak akan dapat login atau mengakses fasilitas keanggotaan sementara waktu. Anda dapat mengaktifkannya kembali kapan saja.' 
            : 'Pengguna akan dipulihkan dan dapat kembali login serta menggunakan seluruh fasilitas keanggotaan.';

        var avatarHtml = '';
        if (avatarUrl && avatarUrl.indexOf('placeholder') === -1) {
            avatarHtml = '<img src="' + avatarUrl + '" class="swal-user-avatar" onerror="this.outerHTML=\'<div class=\\\'swal-user-avatar\\\'>' + ((userName || 'U').charAt(0).toUpperCase()) + '</div>\';">';
        } else {
            avatarHtml = '<div class="swal-user-avatar">' + ((userName || 'U').charAt(0).toUpperCase()) + '</div>';
        }

        var htmlContent = 
            '<div class="swal-user-card">' +
                avatarHtml +
                '<div class="swal-user-details">' +
                    '<div class="swal-user-name">' + (userName || 'Pengguna') + '</div>' +
                    '<div class="swal-user-email">' + (userEmail || '-') + '</div>' +
                '</div>' +
            '</div>' +
            '<div class="swal-transition-wrap">' +
                '<span class="swal-status-chip ' + (willDeactivate ? 'swal-chip-active' : 'swal-chip-inactive') + '">' +
                    '<i class="fas fa-' + (willDeactivate ? 'check-circle' : 'pause-circle') + '"></i> ' + (willDeactivate ? 'Aktif' : 'Nonaktif') +
                '</span>' +
                '<i class="fas fa-arrow-right" style="color:#94a3b8; font-size:0.75rem;"></i>' +
                '<span class="swal-status-chip ' + (willDeactivate ? 'swal-chip-inactive' : 'swal-chip-active') + '">' +
                    '<i class="fas fa-' + (willDeactivate ? 'pause-circle' : 'check-circle') + '"></i> ' + (willDeactivate ? 'Nonaktif' : 'Aktif') +
                '</span>' +
            '</div>' +
            '<p style="margin: 6px 0 0; font-size: 0.83rem; color: #64748b; line-height: 1.55;">' + helperText + '</p>';

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: title,
                html: htmlContent,
                icon: willDeactivate ? 'warning' : 'question',
                iconColor: willDeactivate ? '#f59e0b' : '#16a34a',
                showCancelButton: true,
                confirmButtonColor: confirmColor,
                cancelButtonColor: '#64748b',
                confirmButtonText: confirmText,
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses Perubahan...',
                        html: '<div style="font-size:0.86rem; color:#64748b; margin-top:6px;">Sedang memperbarui status akun pengguna ke server.</div>',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: function() {
                            Swal.showLoading();
                        }
                    });

                    fetch('{{ url("backoffice/users") }}/' + userId + '/toggle-active', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(function(response) {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json().catch(function() { return { success: true }; });
                    })
                    .then(function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: willDeactivate ? 'Akun Dinonaktifkan!' : 'Akun Diaktifkan!',
                            html: '<div style="font-size:0.88rem; color:#334155; margin-top:4px;">' + (data.message || ('Status akun <b>' + userName + '</b> berhasil diperbarui.')) + '</div>',
                            timer: 1500,
                            timerProgressBar: true,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.reload();
                        });
                    })
                    .catch(function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Memperbarui Status',
                            text: 'Terjadi kesalahan pada sistem saat memperbarui status. Silakan coba kembali.',
                            confirmButtonColor: '#CC0000',
                            confirmButtonText: 'Tutup'
                        });
                        console.error('Error toggling user status:', error);
                    });
                }
            });
        } else {
            if (!confirm('Apakah Anda yakin ingin ' + actionVerb + ' akun ' + userName + '?')) return;
            fetch('{{ url("backoffice/users") }}/' + userId + '/toggle-active', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).then(function() {
                window.location.reload();
            });
        }
    }

    function deleteUser(userId, userName, userEmail) {
        var htmlContent = 
            '<div class="swal-user-card" style="border-left: 3px solid #dc2626;">' +
                '<div class="swal-user-avatar" style="background:#dc2626;">' + ((userName || 'U').charAt(0).toUpperCase()) + '</div>' +
                '<div class="swal-user-details">' +
                    '<div class="swal-user-name">' + (userName || 'Pengguna') + '</div>' +
                    '<div class="swal-user-email">' + (userEmail || '-') + '</div>' +
                '</div>' +
            '</div>' +
            '<div style="background:#fef2f2; border:1px solid #fee2e2; border-radius:10px; padding:10px 14px; margin-top:8px; text-align:left;">' +
                '<div style="color:#b91c1c; font-weight:600; font-size:0.82rem; display:flex; align-items:center; gap:6px;">' +
                    '<i class="fas fa-exclamation-triangle"></i> Peringatan Penghapusan Data' +
                '</div>' +
                '<p style="margin:4px 0 0; font-size:0.78rem; color:#7f1d1d; line-height:1.5;">' +
                    'Seluruh data pengguna ini akan dihapus permanen dari sistem dan tidak dapat dipulihkan kembali.' +
                '</p>' +
            '</div>';

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Konfirmasi Penghapusan User',
                html: htmlContent,
                icon: 'warning',
                iconColor: '#f59e0b',
                showCancelButton: true,
                confirmButtonColor: '#d97706',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Lanjutkan <i class="fas fa-arrow-right ms-1"></i>',
                cancelButtonText: '<i class="fas fa-times me-1"></i> Batal, Jangan Hapus',
                reverseButtons: true,
                focusCancel: true
            }).then(function(step1Result) {
                if (!step1Result.isConfirmed) {
                    if (window.showDiToast) window.showDiToast('info', 'Penghapusan Dibatalkan', 'Data user tetap aman.');
                    return;
                }
                Swal.fire({
                    title: '<span style="color:#CC0000;"><i class="fas fa-exclamation-triangle me-1"></i> Konfirmasi Terakhir!</span>',
                    html: '<div style="margin-bottom:12px;">' +
                            '<span style="display:inline-flex;align-items:center;gap:6px;background:#fee2e2;color:#991b1b;font-size:0.78rem;font-weight:700;padding:4px 12px;border-radius:20px;border:1px solid #fecaca;">' +
                              '<i class="fas fa-shield-alt"></i> Tahap 2 dari 2: Tanyakan Lagi Sekali' +
                            '</span>' +
                          '</div>' +
                          '<div style="font-size:1.05rem;color:#0f172a;font-weight:700;margin-bottom:8px;">Apakah Anda BENAR-BENAR Ingin Menghapus User Ini?</div>' +
                          '<div style="font-size:0.86rem;color:#334155;margin-bottom:12px;line-height:1.5;">' +
                            'Akun <strong>' + (userName || 'Pengguna') + '</strong> akan <strong>dihapus permanen</strong> dari sistem!' +
                          '</div>' +
                          '<div style="font-size:0.82rem;color:#991b1b;background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:10px 14px;text-align:left;display:flex;align-items:center;gap:10px;">' +
                            '<i class="fas fa-trash-alt" style="font-size:1.1rem;color:#dc2626;flex-shrink:0;"></i>' +
                            '<span>Pilih <strong>"Ya, Hapus Sekarang"</strong> jika Anda yakin, atau <strong>"Batal, Jangan Hapus"</strong> untuk membatalkannya.</span>' +
                          '</div>',
                    icon: 'error',
                    iconColor: '#CC0000',
                    showCancelButton: true,
                    confirmButtonColor: '#CC0000',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fas fa-trash-alt me-1"></i> Ya, Hapus Sekarang!',
                    cancelButtonText: '<i class="fas fa-undo me-1"></i> Batal, Jangan Hapus',
                    reverseButtons: true,
                    focusCancel: true
                }).then(function(result) {
                    if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus User...',
                        html: '<div style="font-size:0.86rem; color:#64748b; margin-top:6px;">Sedang menghapus data pengguna dari server.</div>',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: function() {
                            Swal.showLoading();
                        }
                    });

                    fetch('{{ url("backoffice/users") }}/' + userId, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ _method: 'DELETE' })
                    })
                    .then(function(response) {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json().catch(function() { return { success: true }; });
                    })
                    .then(function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'User Berhasil Dihapus!',
                            html: '<div style="font-size:0.88rem; color:#334155; margin-top:4px;">' + (data.message || 'Data pengguna berhasil dihapus.') + '</div>',
                            timer: 1500,
                            timerProgressBar: true,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.reload();
                        });
                    })
                    .catch(function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menghapus',
                            text: 'Terjadi kesalahan sistem saat menghapus data user. Silakan coba kembali.',
                            confirmButtonColor: '#CC0000',
                            confirmButtonText: 'Tutup'
                        });
                        console.error('Error deleting user:', error);
                    });
                }
            });
        } else {
            if (!confirm('Apakah Anda yakin ingin menghapus user "' + userName + '"?\n\nData yang dihapus tidak dapat dikembalikan!')) return;
            fetch('{{ url("backoffice/users") }}/' + userId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ _method: 'DELETE' })
            }).then(function() {
                window.location.reload();
            });
        }
    }
</script>
@endpush