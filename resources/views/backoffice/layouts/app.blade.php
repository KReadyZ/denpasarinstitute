<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
  <title>@yield('title', 'Backoffice') | Denpasar Institute</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs5.min.css" rel="stylesheet">

  <style>
    :root { --red:#CC0000; --yellow:#F5C400; --dark:#1a1a1a; --sidebar-w:260px; }
    *, *::before, *::after { box-sizing: border-box; }
    body { margin:0; font-family:'Poppins',sans-serif; background:#f4f6f9; color:#333; }
    a { text-decoration:none; }

    .sidebar { position:fixed; top:0; left:0; width:var(--sidebar-w); height:100vh;
      background:var(--dark); display:flex; flex-direction:column; z-index:100; overflow-y:auto; }
    .sidebar-logo { padding:24px 20px; border-bottom:1px solid rgba(255,255,255,0.08); }
    .sidebar-logo span { font-size:1rem; font-weight:700; color:var(--yellow); }
    .sidebar-logo small { display:block; font-size:0.7rem; color:rgba(255,255,255,0.4); margin-top:2px; }
    .sidebar-nav { padding:16px 0; flex:1; }
    .nav-section { padding:8px 20px 4px; font-size:0.65rem; font-weight:700; text-transform:uppercase;
      letter-spacing:1.5px; color:rgba(255,255,255,0.3); margin-top:8px; }
    .nav-section:first-of-type { margin-top:0; }
    .sidebar-nav a { display:flex; align-items:center; gap:12px; padding:10px 20px;
      color:rgba(255,255,255,0.65); font-size:0.83rem; transition:0.2s; }
    .sidebar-nav a:hover, .sidebar-nav a.active { background:rgba(255,255,255,0.07); color:#fff; border-right:3px solid var(--red); }
    .sidebar-nav a i { width:20px; text-align:center; font-size:0.9rem; }
    .sidebar-footer { padding:16px 20px; border-top:1px solid rgba(255,255,255,0.08); }
    .sidebar-user { display:flex; align-items:center; gap:10px; margin-bottom:12px; }
    .sidebar-avatar { width:36px; height:36px; border-radius:50%; background:var(--red);
      display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:0.85rem; flex-shrink:0; }
    .sidebar-user-info small { display:block; font-size:0.7rem; color:rgba(255,255,255,0.4); }
    .sidebar-user-info span { font-size:0.8rem; color:#fff; font-weight:600; }
    .btn-logout { width:100%; padding:8px; background:rgba(204,0,0,0.15); border:1px solid rgba(204,0,0,0.3);
      color:rgba(255,255,255,0.7); border-radius:4px; cursor:pointer; font-size:0.78rem; font-family:Poppins,sans-serif;
      display:flex; align-items:center; justify-content:center; gap:6px; transition:0.2s; }
    .btn-logout:hover { background:var(--red); color:#fff; }

    .main-wrap { margin-left:var(--sidebar-w); min-height:100vh; }
    .topbar-back { background:#fff; padding:0 28px; height:60px; display:flex; align-items:center;
      justify-content:space-between; border-bottom:1px solid #e8e8e8; }
    .topbar-back h1 { font-size:1rem; font-weight:700; color:var(--dark); margin:0; }
    .page-content { padding:28px; }

    .card { background:#fff; border-radius:8px; border:1px solid #e8e8e8; }
    .card-header { padding:16px 20px; border-bottom:1px solid #e8e8e8; display:flex; align-items:center; justify-content:space-between; }
    .card-header h3 { margin:0; font-size:0.95rem; font-weight:700; }
    .card-body { padding:20px; }

    .stat-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:28px; }
    .stat-grid-role { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:28px; }
    .stat-mini { background:#fff; border-radius:8px; padding:20px; border:1px solid #e8e8e8;
      border-left:4px solid var(--red); }
    .stat-grid-role .stat-mini { border-left-color: var(--yellow); }
    .stat-mini .num { font-size:1.8rem; font-weight:800; color:var(--dark); }
    .stat-mini .lbl { font-size:0.75rem; color:#888; margin-top:4px; }

    .btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:4px;
      font-size:0.8rem; font-weight:600; cursor:pointer; border:none; font-family:Poppins,sans-serif; transition:0.2s; }
    .btn-primary { background:var(--red); color:#fff; }
    .btn-primary:hover { background:#a80000; }
    .btn-warning { background:var(--yellow); color:var(--dark); }
    .btn-warning:hover { background:#e0b000; }
    .btn-danger { background:#dc2626; color:#fff; }
    .btn-danger:hover { background:#b91c1c; }
    .btn-secondary { background:#e5e7eb; color:#374151; }
    .btn-secondary:hover { background:#d1d5db; }
    .btn-info { background:#0ea5e9; color:#fff; }
    .btn-info:hover { background:#0284c7; }
    .btn-success { background:#16a34a; color:#fff; }
    .btn-success:hover { background:#15803d; }

    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; font-size:0.82rem; }
    th { background:#f9fafb; padding:10px 14px; text-align:left; font-weight:700; color:#555;
      border-bottom:1px solid #e8e8e8; white-space:nowrap; }
    td { padding:10px 14px; border-bottom:1px solid #f0f0f0; vertical-align:middle; }
    tr:last-child td { border-bottom:none; }
    tr:hover td { background:#fafafa; }

    .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:0.68rem; font-weight:700; }
    .badge-active { background:#dcfce7; color:#166534; }
    .badge-inactive { background:#fee2e2; color:#991b1b; }
    .badge-premium { background:#fef3c7; color:#92400e; }
    .badge-regular { background:#e0e7ff; color:#3730a3; }
    .badge-vip { background:#fce7f3; color:#9d174d; }
    .badge-pending { background:#fef3c7; color:#92400e; }
    .badge-approved { background:#dcfce7; color:#166534; }
    .badge-rejected { background:#fee2e2; color:#991b1b; }

    .alert { padding:12px 16px; border-radius:6px; margin-bottom:20px; font-size:0.83rem; }
    .alert-success { background:#dcfce7; color:#166534; border-left:4px solid #22c55e; }
    .alert-error { background:#fee2e2; color:#991b1b; border-left:4px solid #dc2626; }

    .form-group { margin-bottom:16px; }
    .form-group label { display:block; font-size:0.78rem; font-weight:700; margin-bottom:5px; }
    .form-group input, .form-group select, .form-group textarea {
      width:100%; padding:9px 12px; border:1px solid #d1d5db; border-radius:4px;
      font-family:Poppins,sans-serif; font-size:0.83rem; outline:none; transition:border-color 0.2s; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:var(--red); }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-row-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; }
    .form-check-wrap { border:1px solid #d1d5db; border-radius:4px; padding:12px 14px; }
    .form-check-line { display:flex; align-items:center; gap:8px; padding:4px 0; font-size:0.83rem; }

    .img-preview { width:80px; height:50px; object-fit:cover; border-radius:4px; border:1px solid #e8e8e8; }

    .role-section { margin-bottom: 24px; }
    .role-header { padding: 16px 20px; display: flex; align-items: center; border-radius: 8px 8px 0 0; border-left: 4px solid; }
    .role-header.konsultan { background: #fee2e2; border-left-color: #CC0000; }
    .role-header.grcs { background: #dcfce7; border-left-color: #16a34a; }
    .role-icon { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; color: white; font-size: 1.1rem; }
    .role-icon.konsultan { background: #CC0000; }
    .role-icon.grcs { background: #16a34a; }
    .role-info h3 { margin: 0; font-size: 0.95rem; font-weight: 700; }
    .role-info small { font-size: 0.75rem; color: #6b7280; }
    .role-count { margin-left: auto; padding: 6px 16px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; color: white; }
    .role-count.konsultan { background: #CC0000; }
    .role-count.grcs { background: #16a34a; }

    .filter-form { display: grid; grid-template-columns: 1fr 1fr 2fr auto; gap: 16px; align-items: end; }

    .user-table { border-radius: 0 0 8px 8px; overflow: hidden; }
    .user-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb; }
    .user-avatar.konsultan { border-color: #CC0000; }
    .user-avatar.grcs { border-color: #16a34a; }
    .user-info strong { font-size: 0.85rem; }
    .user-info small { font-size: 0.73rem; color: #6b7280; display: block; }
    .id-badge { font-size: 0.7rem; font-weight: 600; padding: 2px 8px; border-radius: 4px; display: inline-block; margin-top: 2px; }
    .id-badge.konsultan { background: #fee2e2; color: #CC0000; }
    .id-badge.grcs { background: #dcfce7; color: #16a34a; }

    .action-group { display: flex; gap: 4px; }
    .btn-icon { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 4px; font-size: 0.8rem; }

    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state i { font-size: 3rem; color: #d1d5db; margin-bottom: 16px; }
    .empty-state h3 { color: #6b7280; margin-bottom: 8px; }
    .empty-state p { color: #9ca3af; margin-bottom: 20px; }

    .pagination-info { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-top: 1px solid #e8e8e8; }
    .pagination-info small { color: #6b7280; }

    .form-check-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 12px 20px;
    }
    .form-check-grid .form-check-line {
      padding: 0;
      margin: 0;
      border: none;
    }
    .form-check-grid .form-check-line input[type="checkbox"] {
      margin-right: 6px;
      cursor: pointer;
    }
    .form-check-grid .form-check-line label {
      margin-bottom: 0;
      font-weight: 500;
      cursor: pointer;
      font-size: 0.82rem;
    }

    @media (max-width: 1024px) {
      .form-check-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px 16px;
      }
      .stat-grid-role {
        grid-template-columns: repeat(2, 1fr);
      }
    }
    @media (max-width: 768px) {
      .sidebar { transform:translateX(-100%); }
      .main-wrap { margin-left:0; }
      .stat-grid { grid-template-columns:1fr 1fr; }
      .stat-grid-role { grid-template-columns:1fr 1fr; }
      .filter-form { grid-template-columns:1fr; }
      .action-group { flex-direction: column; }
    }
    @media (max-width: 576px) {
      .form-check-grid {
        grid-template-columns: 1fr;
        gap: 8px;
      }
      .stat-grid { grid-template-columns:1fr; }
      .stat-grid-role { grid-template-columns:1fr; }
    }
  </style>
  @stack('styles')
</head>
<body>

<aside class="sidebar">
  <div class="sidebar-logo">
    <span>Denpasar Institute</span>
    <small>Backoffice Panel</small>
  </div>
  <nav class="sidebar-nav">
    <div class="nav-section">Main</div>
    <a href="{{ route('backoffice.dashboard') }}" class="{{ request()->routeIs('backoffice.dashboard') ? 'active' : '' }}">
      <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    @if(auth()->check() && auth()->user()->role === 'superadmin')
    <div class="nav-section">Pendaftaran &amp; Verifikasi</div>
    <a href="{{ route('backoffice.konsultan.verifikasi') }}" class="{{ request()->routeIs('backoffice.konsultan.verifikasi*') ? 'active' : '' }}" style="display:flex; align-items:center; justify-content:space-between;">
      <span><i class="fas fa-user-check"></i> Verifikasi Konsultan</span>
      @if(($pendingKonsultanCount ?? 0) > 0)
        <span class="badge" style="background:#CC0000; color:#fff; font-size:0.68rem; padding:2px 7px; border-radius:10px;">{{ $pendingKonsultanCount }}</span>
      @endif
    </a>
    <a href="{{ route('backoffice.grcs.verifikasi') }}" class="{{ request()->routeIs('backoffice.grcs.verifikasi*') ? 'active' : '' }}" style="display:flex; align-items:center; justify-content:space-between;">
      <span><i class="fas fa-users-cog"></i> Verifikasi GRCS Club</span>
      @if(($pendingGrcsCount ?? 0) > 0)
        <span class="badge" style="background:#16a34a; color:#fff; font-size:0.68rem; padding:2px 7px; border-radius:10px;">{{ $pendingGrcsCount }}</span>
      @endif
    </a>
    <a href="{{ route('backoffice.admission.index') }}" class="{{ request()->routeIs('backoffice.admission.*') ? 'active' : '' }}" style="display:flex; align-items:center; justify-content:space-between;">
      <span><i class="fas fa-graduation-cap"></i> Peserta Program (Admission)</span>
      @if(($pendingAdmissionCount ?? 0) > 0)
        <span class="badge" style="background:#2563eb; color:#fff; font-size:0.68rem; padding:2px 7px; border-radius:10px;">{{ $pendingAdmissionCount }}</span>
      @endif
    </a>

    <div class="nav-section">Data Anggota</div>
    <a href="{{ route('backoffice.konsultan.index') }}" class="{{ (request()->routeIs('backoffice.konsultan.*') && !request()->routeIs('backoffice.konsultan.verifikasi*')) ? 'active' : '' }}">
      <i class="fas fa-user-tie"></i> Data Konsultan
    </a>
    <a href="{{ route('backoffice.grcs.index') }}" class="{{ (request()->routeIs('backoffice.grcs.*') && !request()->routeIs('backoffice.grcs.verifikasi*')) ? 'active' : '' }}">
      <i class="fas fa-users"></i> Data GRCS Club
    </a>
    <a href="{{ route('backoffice.bursa-sdm.index') }}" class="{{ request()->routeIs('backoffice.bursa-sdm.*') ? 'active' : '' }}">
      <i class="fas fa-briefcase"></i> Bursa SDM
    </a>

    <div class="nav-section">Pengguna</div>
    <a href="{{ route('backoffice.users.index') }}" class="{{ request()->routeIs('backoffice.users.*') ? 'active' : '' }}">
      <i class="fas fa-user-cog"></i> Manajemen User
    </a>

    <div class="nav-section">Konten</div>
    <a href="{{ route('backoffice.slider.index') }}" class="{{ request()->routeIs('backoffice.slider.*') ? 'active' : '' }}">
      <i class="fas fa-images"></i> Hero Slider
    </a>
    <a href="{{ route('backoffice.kategori-berita.index') }}" class="{{ request()->routeIs('backoffice.kategori-berita.*') ? 'active' : '' }}">
      <i class="fa-regular fa-calendar-plus"></i> Tambah Kategori
    </a>
    <a href="{{ route('backoffice.berita.index') }}" class="{{ request()->routeIs('backoffice.berita.*') ? 'active' : '' }}">
      <i class="fas fa-newspaper"></i> Manajemen Berita
    </a>
    <a href="{{ route('backoffice.kategori-event.index') }}" class="{{ request()->routeIs('backoffice.kategori-event.*') ? 'active' : '' }}">
      <i class="fa-regular fa-calendar-plus"></i> Tambah Kategori Event
    </a>
    <a href="{{ route('backoffice.event.index') }}" class="{{ request()->routeIs('backoffice.event.*') ? 'active' : '' }}">
      <i class="fas fa-calendar-alt"></i> Manajemen Event
    </a>

    <div class="nav-section">Pengaturan Website</div>
    <a href="{{ route('backoffice.divisi.index') }}" class="{{ request()->routeIs('backoffice.divisi.*') ? 'active' : '' }}">
      <i class="fas fa-sitemap"></i> Manajemen Divisi
    </a>
    <a href="{{ route('backoffice.statistic.index') }}" class="{{ request()->routeIs('backoffice.statistic.*') ? 'active' : '' }}">
      <i class="fas fa-chart-line"></i> Statistik (Angka)
    </a>

    <div class="nav-section">Testimonial</div>
    <a href="{{ route('backoffice.testimonial.index') }}" class="{{ request()->routeIs('backoffice.testimonial.*') ? 'active' : '' }}">
      <i class="fas fa-comment-dots"></i> Testimoni
    </a>

    @elseif(auth()->check() && auth()->user()->role === 'konsultan')
    <div class="nav-section">Profil</div>
    <a href="{{ route('backoffice.konsultan.show', auth()->user()->id) }}" class="{{ request()->routeIs('backoffice.konsultan.show') ? 'active' : '' }}">
      <i class="fas fa-user-tie"></i> Profil Saya
    </a>
    <div class="nav-section">Informasi</div>
    <a href="{{ route('backoffice.berita.index') }}" class="{{ request()->routeIs('backoffice.berita.*') ? 'active' : '' }}">
      <i class="fas fa-newspaper"></i> Manajemen Berita
    </a>

    @elseif(auth()->check() && auth()->user()->role === 'grcs')
    <div class="nav-section">Profil</div>
    <a href="{{ route('backoffice.grcs.show', auth()->user()->id) }}" class="{{ request()->routeIs('backoffice.grcs.show') ? 'active' : '' }}">
      <i class="fas fa-users"></i> Profil Saya
    </a>
    @endif

    <div class="nav-section">Akun</div>
    <a href="{{ route('backoffice.profile.edit') }}" class="{{ request()->routeIs('backoffice.profile.*') ? 'active' : '' }}">
      <i class="fas fa-user-circle"></i> Profil Saya
    </a>
  </nav>
  <div class="sidebar-footer">
    <div class="sidebar-user">
      <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
      <div class="sidebar-user-info">
        <span>{{ auth()->user()->name ?? 'User' }}</span>
        <small>{{ ucfirst(auth()->user()->role ?? 'Admin') }}</small>
      </div>
    </div>
    <form method="POST" action="{{ route('backoffice.logout') }}">
      @csrf
      <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </form>
  </div>
</aside>

<div class="main-wrap">
  <div class="topbar-back">
    <h1>@yield('page-title', 'Dashboard')</h1>
  </div>
  <div class="page-content">
    @if(session('success'))
      <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif
    @yield('content')
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs5.min.js"></script>

<style>
  input[type="date"] { cursor: pointer; }
  input[type="date"]::-webkit-calendar-picker-indicator { cursor: pointer; }
</style>
<script>
  // Otomatis buka picker kalender saat kolom tanggal diklik
  document.addEventListener('click', function(e) {
    if (e.target && e.target.matches('input[type="date"]')) {
      if (typeof e.target.showPicker === 'function') {
        try {
          e.target.showPicker();
        } catch (err) {}
      }
    }
  });
</script>

@stack('scripts')
</body>
</html>