@extends('backoffice.layouts.app')

@section('title', 'Kelola Admin & Finance')
@section('page-title', 'Kelola Admin & Finance')

@section('content')
<div class="admin-management-page">
    {{-- Header Banner Khusus Super Admin --}}
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #111827 0%, #1f2937 60%, #991b1b 100%); border-radius: 14px; color: #fff;">
        <div class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2" style="background: rgba(255,255,255,0.12); font-size: 0.78rem; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase;">
                    <i class="fas fa-shield-halved text-warning"></i> Area Khusus Super Admin &bull; Role Dinamis
                </div>
                <h2 class="h4 fw-bold mb-1 text-white">Manajemen Akun Internal (Admin &amp; Finance)</h2>
                <p class="text-white-50 mb-0 small" style="max-width: 680px;">
                    Kelola akun staf internal secara terpusat. Seluruh peran (role) tersimpan secara dinamis di database sehingga dapat ditambah atau dimodifikasi sewaktu-waktu tanpa terkunci di baris kode program.
                </p>
            </div>
            <div class="d-flex flex-wrap gap-2 flex-shrink-0">
                <button type="button" class="btn btn-outline-light px-3 py-2 fw-semibold d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalKelolaRoles" style="border-radius: 8px;">
                    <i class="fas fa-tags"></i>
                    <span>Kelola Master Role</span>
                </button>
                <button type="button" class="btn btn-danger fw-semibold px-3 py-2 shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalTambahStaff" style="background: #CC0000; border-color: #CC0000; border-radius: 8px;">
                    <i class="fas fa-user-plus"></i>
                    <span>Tambah Akun Baru</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Kartu Ringkasan Statistik (Dihasilkan Dinamis dari Database) --}}
    <div class="row g-3 mb-4">
        @foreach($staffRoles as $sr)
            @php
                $colorHex = match($sr->badge_color) {
                    'danger'  => '#CC0000',
                    'primary' => '#2563eb',
                    'success' => '#16a34a',
                    'warning' => '#d97706',
                    'info'    => '#0284c7',
                    default   => '#4b5563',
                };
                $bgHex = match($sr->badge_color) {
                    'danger'  => '#fee2e2',
                    'primary' => '#dbeafe',
                    'success' => '#dcfce7',
                    'warning' => '#fef3c7',
                    'info'    => '#e0f2fe',
                    default   => '#f3f4f6',
                };
            @endphp
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid {{ $colorHex }} !important;">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small fw-semibold">{{ $sr->name }}</div>
                            <div class="fs-3 fw-bold text-dark mt-1">{{ $roleCounts[$sr->slug] ?? 0 }}</div>
                            <div class="text-muted text-truncate" style="font-size: 0.72rem; max-width: 140px;">
                                {{ $sr->is_system ? 'Role Sistem' : 'Role Kustom' }}
                            </div>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: {{ $bgHex }}; color: {{ $colorHex }}; font-size: 1.25rem;">
                            <i class="fas {{ $sr->icon ?? 'fa-user-shield' }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Kartu Total Aktif --}}
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #0ea5e9 !important;">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">Status Login Aktif</div>
                        <div class="fs-3 fw-bold text-dark mt-1">
                            {{ $totalActive }} <span class="fs-6 text-muted fw-normal">/ {{ $totalStaff }}</span>
                        </div>
                        <div class="text-muted" style="font-size: 0.72rem;">{{ $totalInactive }} Akun Nonaktif</div>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #e0f2fe; color: #0284c7; font-size: 1.25rem;">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter & Pencarian (Dinamis dari Database) --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body p-3">
            <form action="{{ route('backoffice.admin-management.index') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-12 col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1">Filter Role</label>
                    <select name="role" class="form-select form-select-sm" style="border-radius: 6px;">
                        <option value="">Semua Role (Internal)</option>
                        @foreach($staffRoles as $sr)
                            <option value="{{ $sr->slug }}" {{ request('role') === $sr->slug ? 'selected' : '' }}>
                                {{ $sr->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1">Status Akun</label>
                    <select name="status" class="form-select form-select-sm" style="border-radius: 6px;">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label small fw-semibold text-muted mb-1">Pencarian</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white text-muted border-end-0" style="border-radius: 6px 0 0 6px;">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control form-control-sm border-start-0" placeholder="Cari nama, email, atau no. telepon..." value="{{ request('search') }}" style="border-radius: 0 6px 6px 0;">
                    </div>
                </div>
                <div class="col-12 col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-dark flex-fill" style="border-radius: 6px;">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['role', 'status', 'search']))
                        <a href="{{ route('backoffice.admin-management.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 6px;" title="Reset Filter">
                            <i class="fas fa-redo"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Akun Admin & Finance --}}
    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom">
            <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2" style="font-size: 1rem;">
                <i class="fas fa-users-gear text-danger"></i>
                Daftar Akun Internal
                <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 0.75rem;">{{ $users->total() }} akun</span>
            </h5>
            <div class="small text-muted d-none d-md-block">
                <i class="fas fa-database text-success me-1"></i> Data role terbaca dinamis dari tabel <code>roles</code>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead class="table-light text-muted small text-uppercase" style="letter-spacing: 0.5px; font-weight: 600;">
                    <tr>
                        <th class="ps-4" style="width: 50px;">#</th>
                        <th>Profil &amp; Nama Staf</th>
                        <th>Email Login</th>
                        <th>Role Akses</th>
                        <th>No. Telepon</th>
                        <th>Status</th>
                        <th class="text-end pe-4" style="width: 220px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        @php
                            $isCurrentAuth = auth()->id() === $user->id;
                            $roleData = $user->roleModel;
                            $roleBadgeColor = $roleData ? 'bg-' . $roleData->badge_color . ' text-white' : 'bg-secondary text-white';
                            $roleLabel = $roleData ? $roleData->name : ucfirst($user->role);
                            $roleIcon = $roleData ? $roleData->icon : 'fa-user';
                        @endphp
                        <tr>
                            <td class="ps-4 fw-bold text-muted">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="position-relative">
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle border" style="width: 42px; height: 42px; object-fit: cover;" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=111827&color=fff&size=84';">
                                        @if($user->is_active)
                                            <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle" title="Aktif"></span>
                                        @else
                                            <span class="position-absolute bottom-0 end-0 p-1 bg-secondary border border-white rounded-circle" title="Nonaktif"></span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark d-flex align-items-center gap-2">
                                            <span>{{ $user->name }}</span>
                                            @if($isCurrentAuth)
                                                <span class="badge bg-warning text-dark px-2 py-0" style="font-size: 0.65rem;">Akun Anda</span>
                                            @endif
                                        </div>
                                        <div class="small text-muted" style="font-size: 0.74rem;">
                                            Dibuat: {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{-- Baris 1: Email Login --}}
                                <div class="d-flex align-items-center gap-2">
                                    <code class="text-dark bg-light px-2 py-1 rounded border" style="font-size: 0.82rem;">{{ $user->email }}</code>
                                    <button type="button" class="btn btn-sm btn-light p-1 text-muted border-0" onclick="copyToClipboard('{{ $user->email }}', 'Email disalin!')" title="Salin Email">
                                        <i class="far fa-copy"></i>
                                    </button>
                                </div>

                                {{-- Baris 2: Password Login (Bintang & Show/Hide Eye) --}}
                                <div class="d-flex align-items-center gap-1 mt-1 pt-1" style="border-top: 1px dashed #e2e8f0;">
                                    <span class="text-muted fw-semibold" style="font-size: 0.72rem; min-width: 32px;"><i class="fas fa-lock me-1 text-warning"></i>Pass:</span>
                                    @if($user->decrypted_password)
                                        <code class="px-2 py-0 rounded border bg-white text-dark fw-bold" id="pwd-display-{{ $user->id }}" style="font-size: 0.78rem; letter-spacing: 2px;" data-shown="false">••••••••</code>
                                        <button type="button" class="btn btn-sm btn-light p-0 px-1 text-muted border" onclick="toggleTablePassword({{ $user->id }}, '{{ addslashes($user->decrypted_password) }}')" title="Tampilkan / Sembunyikan Password">
                                            <i class="far fa-eye" id="pwd-icon-{{ $user->id }}" style="font-size: 0.74rem;"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light p-0 px-1 text-muted border" onclick="copyToClipboard('{{ addslashes($user->decrypted_password) }}', 'Password disalin!')" title="Salin Password">
                                            <i class="far fa-copy" style="font-size: 0.74rem;"></i>
                                        </button>
                                    @else
                                        <span class="text-muted small d-inline-flex align-items-center gap-1" style="font-size: 0.74rem;">
                                            <span style="letter-spacing: 2px;">••••••••</span>
                                            <button type="button" class="btn btn-sm btn-link p-0 text-danger text-decoration-none" onclick='openPasswordModal(@json($user), "{{ $roleLabel }}")' title="Klik untuk atur password agar dapat dilihat" style="font-size: 0.72rem;">
                                                <i class="fas fa-key" style="font-size: 0.68rem;"></i> Set Password
                                            </button>
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $roleBadgeColor }} d-inline-flex align-items-center gap-1 px-2 py-1" style="border-radius: 6px; font-weight: 600; font-size: 0.75rem;">
                                    <i class="fas {{ $roleIcon }}"></i>
                                    {{ $roleLabel }}
                                </span>
                            </td>
                            <td>
                                @if($user->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->phone) }}" target="_blank" class="text-decoration-none text-dark small d-inline-flex align-items-center gap-1">
                                        <i class="fab fa-whatsapp text-success"></i>
                                        {{ $user->phone }}
                                    </a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill" style="font-size: 0.72rem; font-weight: 600;">
                                        <i class="fas fa-check-circle me-1"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 rounded-pill" style="font-size: 0.72rem; font-weight: 600;">
                                        <i class="fas fa-circle-xmark me-1"></i> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm" role="group">
                                    {{-- Tombol Edit Profil / Email --}}
                                    <button type="button" class="btn btn-outline-primary" title="Ubah Email & Profil" onclick='openEditModal(@json($user))'>
                                        <i class="fas fa-user-pen"></i>
                                    </button>

                                    {{-- Tombol Reset Password --}}
                                    <button type="button" class="btn btn-outline-warning text-dark" title="Ganti / Reset Password" onclick='openPasswordModal(@json($user), "{{ $roleLabel }}")'>
                                        <i class="fas fa-key"></i>
                                    </button>

                                    {{-- Tombol Toggle Status Aktif --}}
                                    @if(!$isCurrentAuth)
                                        <button type="button" class="btn {{ $user->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}" title="{{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}" onclick="confirmToggleActive('{{ $user->id }}', '{{ addslashes($user->name) }}', {{ $user->is_active ? 'true' : 'false' }})">
                                            <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                        </button>
                                    @endif

                                    {{-- Tombol Hapus Akun --}}
                                    @if(!$isCurrentAuth)
                                        <button type="button" class="btn btn-outline-danger" title="Hapus Akun" onclick="confirmDeleteUser('{{ $user->id }}', '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ $roleLabel }}')">
                                            <i class="fas fa-trash-can"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-user-slash fs-1 d-block mb-3 text-secondary"></i>
                                    <h6 class="fw-bold">Tidak ada akun staf yang ditemukan</h6>
                                    <p class="small mb-3">Silakan gunakan filter lain atau tambahkan akun baru.</p>
                                    <button type="button" class="btn btn-sm btn-danger px-3" data-bs-toggle="modal" data-bs-target="#modalTambahStaff" style="background:#CC0000; border-color:#CC0000;">
                                        <i class="fas fa-user-plus me-1"></i> Tambah Akun Baru
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center">
                <span class="small text-muted">
                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari total {{ $users->total() }} akun
                </span>
                <div>
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>

{{-- MODAL 1: Tambah Akun Baru (Role Dinamis) --}}
<div class="modal fade" id="modalTambahStaff" tabindex="-1" aria-labelledby="modalTambahStaffLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #fee2e2; color: #CC0000;">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark fs-6" id="modalTambahStaffLabel">Tambah Akun Staf Baru</h5>
                        <small class="text-muted">Peran diambil otomatis dari database role</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('backoffice.admin-management.store') }}" method="POST" id="formTambahStaff">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark mb-1">
                            Nama Lengkap Staf <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso" required value="{{ old('name') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark mb-1">
                            Alamat Email Login <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="admin@denpasarinstitute.id" required value="{{ old('email') }}">
                        </div>
                        <div class="form-text" style="font-size: 0.72rem;">Email digunakan sebagai username saat masuk ke Backoffice.</div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-dark mb-1">
                                Peran / Role Akses <span class="text-danger">*</span>
                            </label>
                            <select name="role" class="form-select" required>
                                @foreach($staffRoles as $sr)
                                    <option value="{{ $sr->slug }}" {{ old('role', 'admin') === $sr->slug ? 'selected' : '' }}>
                                        {{ $sr->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-dark mb-1">
                                No. Telepon / WA (Opsional)
                            </label>
                            <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-dark mb-0">
                                Password Login <span class="text-danger">*</span>
                            </label>
                            <button type="button" class="btn btn-link p-0 text-decoration-none small text-danger fw-semibold" style="font-size: 0.74rem;" onclick="generateRandomPassword('create')">
                                <i class="fas fa-dice me-1"></i> Generate Password Acak
                            </button>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="createPasswordInput" class="form-control" placeholder="Minimal 8 karakter" minlength="8" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('createPasswordInput', this)" title="Lihat/Sembunyikan">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark mb-1">
                            Konfirmasi Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted"><i class="fas fa-lock-open"></i></span>
                            <input type="password" name="password_confirmation" id="createPasswordConfirmInput" class="form-control" placeholder="Ketik ulang password" minlength="8" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('createPasswordConfirmInput', this)" title="Lihat/Sembunyikan">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="is_active" id="createIsActive" value="1" checked>
                        <label class="form-check-label small fw-semibold text-dark" for="createIsActive">
                            Aktifkan akun ini segera (dapat langsung login)
                        </label>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger fw-semibold px-4" style="background:#CC0000; border-color:#CC0000;">
                        <i class="fas fa-save me-1"></i> Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL 2: Ubah Email & Profil Akun (Role Dinamis) --}}
<div class="modal fade" id="modalEditStaff" tabindex="-1" aria-labelledby="modalEditStaffLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #dbeafe; color: #2563eb;">
                        <i class="fas fa-user-pen"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark fs-6" id="modalEditStaffLabel">Ubah Email &amp; Profil Staf</h5>
                        <small class="text-muted">Perbarui alamat email, peran akses, atau kontak staf</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditStaff" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark mb-1">
                            Nama Lengkap Staf <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark mb-1">
                            Alamat Email Login <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" id="editEmail" class="form-control" required>
                        </div>
                        <div class="form-text text-danger" style="font-size: 0.72rem;">
                            <i class="fas fa-triangle-exclamation me-1"></i> Jika email diubah, staf bersangkutan harus login menggunakan email baru tersebut.
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-dark mb-1">
                                Peran / Role Akses <span class="text-danger">*</span>
                            </label>
                            <select name="role" id="editRole" class="form-select" required>
                                @foreach($staffRoles as $sr)
                                    <option value="{{ $sr->slug }}">{{ $sr->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-dark mb-1">
                                No. Telepon / WA
                            </label>
                            <input type="text" name="phone" id="editPhone" class="form-control" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="is_active" id="editIsActive" value="1">
                        <label class="form-check-label small fw-semibold text-dark" for="editIsActive">
                            Status Akun Aktif (Dapat Login)
                        </label>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-semibold px-4">
                        <i class="fas fa-check me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL 3: Reset / Ganti Password Staf --}}
<div class="modal fade" id="modalPasswordStaff" tabindex="-1" aria-labelledby="modalPasswordStaffLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #fef3c7; color: #b45309;">
                        <i class="fas fa-key"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark fs-6" id="modalPasswordStaffLabel">Reset Password Staf</h5>
                        <small class="text-muted">Atur kata sandi baru untuk akun staf terpilih</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formPasswordStaff" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-3">
                    {{-- Target User Preview Card --}}
                    <div class="p-3 mb-3 bg-light rounded-3 border d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px; font-size: 1rem;" id="pwdStaffInitial">
                            U
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="fw-bold text-dark text-truncate" id="pwdStaffName">Nama Staf</div>
                            <div class="small text-muted text-truncate" id="pwdStaffEmail">email@denpasarinstitute.id</div>
                        </div>
                        <span class="badge bg-secondary" id="pwdStaffRole">Role</span>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-dark mb-0">
                                Password Baru <span class="text-danger">*</span>
                            </label>
                            <button type="button" class="btn btn-link p-0 text-decoration-none small text-danger fw-semibold" style="font-size: 0.74rem;" onclick="generateRandomPassword('reset')">
                                <i class="fas fa-dice me-1"></i> Buat Password Kuat
                            </button>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="resetPasswordInput" class="form-control" placeholder="Minimal 8 karakter" minlength="8" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('resetPasswordInput', this)" title="Lihat/Sembunyikan">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark mb-1">
                            Konfirmasi Password Baru <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted"><i class="fas fa-lock-open"></i></span>
                            <input type="password" name="password_confirmation" id="resetPasswordConfirmInput" class="form-control" placeholder="Ketik ulang password baru" minlength="8" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('resetPasswordConfirmInput', this)" title="Lihat/Sembunyikan">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="alert alert-warning py-2 px-3 small mb-0 d-flex align-items-start gap-2" style="border-radius: 8px;">
                        <i class="fas fa-lightbulb text-warning mt-1"></i>
                        <span>Pastikan menginformasikan password baru kepada staf terkait setelah proses reset berhasil.</span>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
                        <i class="fas fa-key me-1"></i> Simpan Password Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL 4: Kelola Master Role (Dinamis dari Database) --}}
<div class="modal fade" id="modalKelolaRoles" tabindex="-1" aria-labelledby="modalKelolaRolesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #e0f2fe; color: #0284c7;">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark fs-6" id="modalKelolaRolesLabel">Master Data Role &amp; Jabatan (Database)</h5>
                        <small class="text-muted">Kelola daftar peran staf secara dinamis tanpa mengubah kodingan</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-3">
                {{-- Form Tambah Role Baru --}}
                <div class="p-3 mb-4 rounded-3 border" style="background: #f8fafc;">
                    <h6 class="fw-bold text-dark mb-2 d-flex align-items-center gap-2">
                        <i class="fas fa-plus-circle text-primary"></i> Tambah Role Internal Baru
                    </h6>
                    <form action="{{ route('backoffice.admin-management.roles.store') }}" method="POST" class="row g-2 align-items-end">
                        @csrf
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-semibold text-muted mb-1">Nama Role <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Contoh: Sekretariat" required>
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label small fw-semibold text-muted mb-1">Kode / Slug (Opsional)</label>
                            <input type="text" name="slug" class="form-control form-control-sm" placeholder="sekretariat">
                        </div>
                        <div class="col-6 col-md-2">
                            <label class="form-label small fw-semibold text-muted mb-1">Warna Badge</label>
                            <select name="badge_color" class="form-select form-select-sm">
                                <option value="primary">Biru (Primary)</option>
                                <option value="success">Hijau (Success)</option>
                                <option value="danger">Merah (Danger)</option>
                                <option value="warning">Oranye (Warning)</option>
                                <option value="info">Cyan (Info)</option>
                                <option value="dark">Gelap (Dark)</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small fw-semibold text-muted mb-1">Ikon FontAwesome</label>
                            <input type="text" name="icon" class="form-control form-control-sm" value="fa-user-gear" placeholder="fa-user-gear">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-muted mb-1">Deskripsi Singkat</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="description" class="form-control form-control-sm" placeholder="Contoh: Pengelolaan surat menyurat dan administrasi umum">
                                <button type="submit" class="btn btn-primary px-3">
                                    <i class="fas fa-save me-1"></i> Simpan Role
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Daftar Role yang Tersimpan --}}
                <h6 class="fw-bold text-dark mb-2">Daftar Role Aktif di Database:</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle" style="font-size: 0.82rem;">
                        <thead class="table-light text-muted">
                            <tr>
                                <th style="width: 40px;">#</th>
                                <th>Nama Role</th>
                                <th>Kode (Slug)</th>
                                <th>Badge &amp; Ikon</th>
                                <th>Jumlah Akun</th>
                                <th>Tipe</th>
                                <th class="text-end" style="width: 90px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staffRoles as $sr)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $sr->name }}</div>
                                        <small class="text-muted">{{ $sr->description ?? '-' }}</small>
                                    </td>
                                    <td><code>{{ $sr->slug }}</code></td>
                                    <td>
                                        <span class="badge bg-{{ $sr->badge_color }} d-inline-flex align-items-center gap-1 px-2 py-1">
                                            <i class="fas {{ $sr->icon }}"></i>
                                            {{ $sr->name }}
                                        </span>
                                    </td>
                                    <td class="fw-bold text-center">
                                        <span class="badge bg-light text-dark border">{{ $roleCounts[$sr->slug] ?? 0 }} akun</span>
                                    </td>
                                    <td>
                                        @if($sr->is_system)
                                            <span class="badge bg-secondary">Sistem</span>
                                        @else
                                            <span class="badge bg-info text-dark">Kustom</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if(!$sr->is_system)
                                            <button type="button" class="btn btn-sm btn-outline-danger p-1" onclick="confirmDeleteRole('{{ $sr->id }}', '{{ addslashes($sr->name) }}', {{ $roleCounts[$sr->slug] ?? 0 }})" title="Hapus Role">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <span class="text-muted small" title="Role sistem bawaan tidak dapat dihapus"><i class="fas fa-lock"></i></span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light border-top px-4 py-2">
                <button type="button" class="btn btn-sm btn-secondary px-3" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- Hidden Form untuk Toggle Active & Delete --}}
<form id="formToggleActive" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="_method" value="PATCH">
</form>

<form id="formDeleteUser" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="_method" value="DELETE">
</form>

<form id="formDeleteRole" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="_method" value="DELETE">
</form>
@endsection

@push('scripts')
<script>
    const adminManagementBaseUrl = "{{ url('backoffice/admin-management') }}";
    // Copy to clipboard helper
    function copyToClipboard(text, message) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: message || 'Tersalin ke clipboard!',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            });
        } else {
            const tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: message || 'Tersalin ke clipboard!',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        }
    }

    // Toggle Password Visibility (Input Form)
    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            if (icon) {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        } else {
            input.type = 'password';
            if (icon) {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    }

    // Toggle Tampilan Password di Tabel (Show/Hide Mata)
    function toggleTablePassword(userId, realPassword) {
        const el = document.getElementById(`pwd-display-${userId}`);
        const icon = document.getElementById(`pwd-icon-${userId}`);
        if (!el || !icon) return;

        if (el.dataset.shown === 'true') {
            el.textContent = '••••••••';
            el.style.letterSpacing = '2px';
            el.dataset.shown = 'false';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            el.textContent = realPassword;
            el.style.letterSpacing = 'normal';
            el.dataset.shown = 'true';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }

    // Generator Password Kuat Acak
    function generateRandomPassword(prefix) {
        const length = 10;
        const charset = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789!@#$%';
        let retVal = '';
        for (let i = 0, n = charset.length; i < length; ++i) {
            retVal += charset.charAt(Math.floor(Math.random() * n));
        }

        if (prefix === 'create') {
            const p1 = document.getElementById('createPasswordInput');
            const p2 = document.getElementById('createPasswordConfirmInput');
            if (p1 && p2) {
                p1.value = retVal;
                p2.value = retVal;
                p1.type = 'text';
                p2.type = 'text';
            }
        } else if (prefix === 'reset') {
            const p1 = document.getElementById('resetPasswordInput');
            const p2 = document.getElementById('resetPasswordConfirmInput');
            if (p1 && p2) {
                p1.value = retVal;
                p2.value = retVal;
                p1.type = 'text';
                p2.type = 'text';
            }
        }

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'info',
            title: `Password acak digenerate: ${retVal}`,
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true
        });
    }

    // Buka Modal Edit Profil & Email
    function openEditModal(user) {
        const form = document.getElementById('formEditStaff');
        form.action = `${adminManagementBaseUrl}/${user.id}`;

        document.getElementById('editName').value = user.name || '';
        document.getElementById('editEmail').value = user.email || '';
        document.getElementById('editRole').value = user.role || 'admin';
        document.getElementById('editPhone').value = user.phone || '';
        document.getElementById('editIsActive').checked = Boolean(user.is_active);

        // Jika user adalah superadmin yang sedang login, kunci select role dan checkbox aktif
        const currentAuthId = {{ auth()->id() }};
        const editRoleSelect = document.getElementById('editRole');
        const editActiveCheckbox = document.getElementById('editIsActive');

        if (user.id === currentAuthId) {
            editRoleSelect.disabled = true;
            editActiveCheckbox.disabled = true;
        } else {
            editRoleSelect.disabled = false;
            editActiveCheckbox.disabled = false;
        }

        const modal = new bootstrap.Modal(document.getElementById('modalEditStaff'));
        modal.show();
    }

    // Buka Modal Reset Password
    function openPasswordModal(user, roleLabel) {
        const form = document.getElementById('formPasswordStaff');
        form.action = `${adminManagementBaseUrl}/${user.id}/password`;

        document.getElementById('pwdStaffName').textContent = user.name || 'Staf';
        document.getElementById('pwdStaffEmail').textContent = user.email || '-';
        document.getElementById('pwdStaffInitial').textContent = (user.name || 'U').charAt(0).toUpperCase();
        document.getElementById('pwdStaffRole').textContent = roleLabel || user.role;

        // Reset input password
        const p1 = document.getElementById('resetPasswordInput');
        const p2 = document.getElementById('resetPasswordConfirmInput');
        p1.value = '';
        p2.value = '';
        p1.type = 'password';
        p2.type = 'password';

        const modal = new bootstrap.Modal(document.getElementById('modalPasswordStaff'));
        modal.show();
    }

    // Konfirmasi Toggle Status Aktif
    function confirmToggleActive(userId, userName, currentActive) {
        const actionText = currentActive ? 'menonaktifkan' : 'mengaktifkan';
        const confirmBtnColor = currentActive ? '#6b7280' : '#16a34a';

        Swal.fire({
            title: `Apakah Anda yakin ingin ${actionText} akun ini?`,
            html: `Staf <strong>${userName}</strong> akan ${currentActive ? 'kehilangan akses login sementara' : 'dapat kembali login ke sistem'}.`,
            icon: currentActive ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonColor: confirmBtnColor,
            cancelButtonColor: '#9ca3af',
            confirmButtonText: `Ya, ${actionText}!`,
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('formToggleActive');
                form.action = `${adminManagementBaseUrl}/${userId}/toggle-active`;
                form.submit();
            }
        });
    }

    // Konfirmasi Hapus Akun
    function confirmDeleteUser(userId, userName, userEmail, userRole) {
        Swal.fire({
            title: 'Hapus Akun Staf Ini?',
            html: `
                <div style="text-align: left; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; padding: 12px; margin-top: 10px;">
                    <div style="font-weight: 700; color: #991b1b; font-size: 0.95rem;">${userName}</div>
                    <div style="color: #7f1d1d; font-size: 0.82rem;">${userEmail} &bull; <span class="badge bg-danger">${userRole}</span></div>
                </div>
                <p style="margin-top: 12px; font-size: 0.85rem; color: #6b7280;">Tindakan ini tidak dapat dibatalkan. Akun akan dihapus secara permanen dari basis data.</p>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#CC0000',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, Hapus Permanen!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('formDeleteUser');
                form.action = `${adminManagementBaseUrl}/${userId}`;
                form.submit();
            }
        });
    }

    // Konfirmasi Hapus Role Dinamis
    function confirmDeleteRole(roleId, roleName, assignedCount) {
        if (assignedCount > 0) {
            Swal.fire({
                title: 'Tidak Dapat Dihapus',
                html: `Role <strong>${roleName}</strong> masih digunakan oleh <strong>${assignedCount}</strong> akun staf. Ubah role akun-akun tersebut terlebih dahulu sebelum menghapusnya.`,
                icon: 'error',
                confirmButtonColor: '#CC0000'
            });
            return;
        }

        Swal.fire({
            title: `Hapus Role "${roleName}"?`,
            text: 'Role ini akan dihapus dari daftar pilihan role di database.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#CC0000',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('formDeleteRole');
                form.action = `${adminManagementBaseUrl}/roles/${roleId}`;
                form.submit();
            }
        });
    }
</script>
@endpush
