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
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

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

    /* Sidebar Mobile & Overlay Styles */
    .sidebar-backdrop {
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.65);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      z-index: 1040;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.28s ease, visibility 0.28s ease;
    }
    .sidebar-backdrop.active {
      opacity: 1;
      visibility: visible;
    }
    .sidebar-close-btn {
      display: none;
      background: rgba(255, 255, 255, 0.12);
      border: none;
      color: #ffffff;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      cursor: pointer;
      align-items: center;
      justify-content: center;
      font-size: 0.9rem;
      transition: all 0.2s;
    }
    .sidebar-close-btn:hover {
      background: var(--red);
    }
    .sidebar-toggle-btn {
      display: none;
      background: #f1f5f9;
      border: 1px solid #e2e8f0;
      color: #1e293b;
      width: 38px;
      height: 38px;
      border-radius: 8px;
      cursor: pointer;
      align-items: center;
      justify-content: center;
      font-size: 1.05rem;
      flex-shrink: 0;
      transition: all 0.2s;
    }
    .sidebar-toggle-btn:hover {
      background: #e2e8f0;
      color: var(--red);
    }
    .topbar-left {
      display: flex;
      align-items: center;
      gap: 12px;
      min-width: 0;
    }
    .topbar-title {
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--dark);
      margin: 0;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .topbar-right {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-shrink: 0;
    }
    .btn-topbar-link {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 0.76rem;
      color: #4b5563;
      background: #f1f5f9;
      border: 1px solid #e2e8f0;
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.2s;
    }
    .btn-topbar-link:hover {
      background: #e2e8f0;
      color: var(--red);
    }
    .topbar-user-badge {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: var(--red);
      color: #fff;
      font-weight: 700;
      font-size: 0.8rem;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 6px rgba(204, 0, 0, 0.25);
    }
    .verifikasi-grid {
      display: grid;
      grid-template-columns: 280px 1fr;
      gap: 24px;
    }

    @media (max-width: 1024px) {
      .form-check-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px 16px;
      }
      .stat-grid-role {
        grid-template-columns: repeat(2, 1fr);
      }
      .stat-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
      }
    }

    @media (max-width: 768px) {
      .verifikasi-grid {
        grid-template-columns: 1fr;
        gap: 16px;
      }
      .sidebar {
        transform: translateX(-100%);
        z-index: 1050;
        transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1);
      }
      .sidebar.open {
        transform: translateX(0);
        box-shadow: 10px 0 35px rgba(0, 0, 0, 0.45);
      }
      .sidebar-logo {
        display: flex;
        align-items: center;
        justify-content: space-between;
      }
      .sidebar-close-btn {
        display: inline-flex;
      }
      .sidebar-toggle-btn {
        display: inline-flex;
      }
      .main-wrap {
        margin-left: 0;
      }
      .topbar-back {
        padding: 0 16px;
        height: 56px;
      }
      .topbar-title {
        font-size: 0.95rem;
        max-width: 190px;
      }
      .hide-mobile {
        display: none !important;
      }
      .page-content {
        padding: 16px 14px;
      }
      .stat-grid {
        grid-template-columns: 1fr 1fr;
        gap: 12px;
      }
      .stat-grid-role {
        grid-template-columns: 1fr 1fr;
        gap: 12px;
      }
      .filter-form {
        grid-template-columns: 1fr;
        gap: 12px;
      }
      .form-row, .form-row-3 {
        grid-template-columns: 1fr;
        gap: 12px;
      }
      .action-group {
        display: inline-flex !important;
        flex-direction: row !important;
        gap: 6px !important;
        align-items: center;
        white-space: nowrap;
      }
      .table-wrap {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }
      .table-wrap table {
        min-width: 680px;
      }
    }

    @media (max-width: 576px) {
      .page-content {
        padding: 14px 10px;
      }
      .topbar-back {
        padding: 0 12px;
      }
      .topbar-title {
        font-size: 0.88rem;
        max-width: 140px;
      }
      .stat-grid {
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-bottom: 18px;
      }
      .stat-mini {
        padding: 12px 10px;
      }
      .stat-mini .num {
        font-size: 1.45rem;
      }
      .stat-mini .lbl {
        font-size: 0.68rem;
      }
      .card-header {
        padding: 12px 14px;
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
      }
      .card-header .btn {
        width: 100%;
        justify-content: center;
      }
      .card-body {
        padding: 14px 10px;
      }
      .form-check-grid {
        grid-template-columns: 1fr;
        gap: 8px;
      }
      .pagination-wrap {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 10px;
      }
      .pagination-wrap .pagination {
        flex-wrap: wrap;
        justify-content: center;
        gap: 4px;
      }
      .swal2-popup {
        width: 92% !important;
        padding: 18px 14px !important;
        border-radius: 14px !important;
      }
      .swal2-title {
        font-size: 1.15rem !important;
      }
      .swal-user-card {
        padding: 10px 12px !important;
        gap: 10px !important;
      }
      .swal-user-avatar {
        width: 38px !important;
        height: 38px !important;
        font-size: 0.85rem !important;
      }
      .swal2-actions {
        flex-direction: column-reverse !important;
        width: 100% !important;
        gap: 8px !important;
      }
      .swal2-confirm, .swal2-cancel {
        width: 100% !important;
        justify-content: center !important;
        margin: 0 !important;
      }
    }

    /* SweetAlert2 Premium Theme */
    .swal2-container {
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
    }
    .swal2-popup {
      font-family: 'Poppins', sans-serif !important;
      border-radius: 18px !important;
      padding: 24px 22px !important;
      box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.25), 0 0 1px 1px rgba(0,0,0,0.05) !important;
      border: 1px solid rgba(0,0,0,0.06) !important;
    }
    .swal2-title {
      font-size: 1.25rem !important;
      font-weight: 700 !important;
      color: #1a1a1a !important;
      margin-top: 8px !important;
      letter-spacing: -0.2px;
    }
    .swal2-html-container {
      font-size: 0.88rem !important;
      line-height: 1.55 !important;
      color: #4b5563 !important;
      margin: 12px 0 18px !important;
    }
    .swal2-actions {
      gap: 10px !important;
      margin-top: 14px !important;
    }
    .swal2-confirm, .swal2-cancel {
      font-family: 'Poppins', sans-serif !important;
      font-size: 0.84rem !important;
      font-weight: 600 !important;
      border-radius: 8px !important;
      padding: 9px 20px !important;
      transition: all 0.2s ease !important;
      display: inline-flex !important;
      align-items: center !important;
      gap: 6px !important;
      box-shadow: none !important;
    }
    .swal2-confirm:hover {
      transform: translateY(-1px);
      filter: brightness(1.05);
    }
    .swal2-cancel {
      background: #f1f5f9 !important;
      color: #64748b !important;
      border: 1px solid #e2e8f0 !important;
    }
    .swal2-cancel:hover {
      background: #e2e8f0 !important;
      color: #334155 !important;
    }
  </style>
  @stack('styles')
</head>
<body>

<aside class="sidebar" id="sidebarNav">
  <div class="sidebar-logo">
    <div>
      <span>Denpasar Institute</span>
      <small>Backoffice Panel</small>
    </div>
    <button type="button" class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Tutup Menu">
      <i class="fas fa-times"></i>
    </button>
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
    <a href="{{ route('backoffice.navigation.index') }}" class="{{ request()->routeIs('backoffice.navigation.*') ? 'active' : '' }}">
      <i class="fas fa-bars"></i> Navigasi &amp; Menu
    </a>
    <a href="{{ route('backoffice.partnership-pillar.index') }}" class="{{ request()->routeIs('backoffice.partnership-pillar.*') ? 'active' : '' }}">
      <i class="fas fa-handshake"></i> Pilar Kemitraan (Partner)
    </a>
    <a href="{{ route('backoffice.settings.index') }}" class="{{ request()->routeIs('backoffice.settings.*') ? 'active' : '' }}">
      <i class="fas fa-sliders-h"></i> Konten, Kontak &amp; Footer
    </a>
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
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<script>
(function() {
  try {
    var sidebar = document.getElementById('sidebarNav') || document.querySelector('.sidebar');
    if (!sidebar) return;
    var saved = sessionStorage.getItem('backoffice_sidebar_scroll');
    if (saved !== null) {
      sidebar.scrollTop = parseInt(saved, 10);
    } else {
      var active = sidebar.querySelector('a.active');
      if (active) {
        active.scrollIntoView({ block: 'center', behavior: 'auto' });
      }
    }
  } catch (err) {}
})();
</script>

<div class="main-wrap">
  <div class="topbar-back">
    <div class="topbar-left">
      <button type="button" class="sidebar-toggle-btn" id="sidebarToggleBtn" aria-label="Buka Menu">
        <i class="fas fa-bars"></i>
      </button>
      <h1 class="topbar-title">@yield('page-title', 'Dashboard')</h1>
    </div>
    <div class="topbar-right">
      <a href="{{ route('home') }}" class="btn-topbar-link" target="_blank" title="Lihat Website">
        <i class="fas fa-external-link-alt"></i> <span class="hide-mobile">Website</span>
      </a>
      <div class="topbar-user-badge" title="{{ auth()->user()->name ?? 'User' }} ({{ ucfirst(auth()->user()->role ?? 'Admin') }})">
        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
      </div>
    </div>
  </div>
  <div class="page-content">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-left: 4px solid #22c55e; border-radius: 8px; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.12); margin-bottom: 20px;">
        <i class="fas fa-check-circle text-success me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              iconColor: '#22c55e',
              title: 'Berhasil!',
              text: {!! json_encode(session('success')) !!},
              showConfirmButton: false,
              timer: 3500,
              timerProgressBar: true,
              customClass: {
                popup: 'swal2-di-toast swal2-di-toast-success'
              }
            });
          }
        });
      </script>
    @endif
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-left: 4px solid #CC0000; border-radius: 8px; box-shadow: 0 4px 14px rgba(204, 0, 0, 0.12); margin-bottom: 20px;">
        <i class="fas fa-exclamation-circle text-danger me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'error',
              iconColor: '#CC0000',
              title: 'Perhatian!',
              text: {!! json_encode(session('error')) !!},
              showConfirmButton: false,
              timer: 4500,
              timerProgressBar: true,
              customClass: {
                popup: 'swal2-di-toast swal2-di-toast-error'
              }
            });
          }
        });
      </script>
    @endif
    @yield('content')
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
  /* SweetAlert2 Denpasar Institute Custom Theme */
  .swal2-di-popup {
    border-radius: 16px !important;
    padding: 26px 22px 24px !important;
    font-family: 'Poppins', sans-serif !important;
    border: 1.5px solid #fee2e2 !important;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.18) !important;
    background: #ffffff !important;
  }
  .swal2-di-popup .swal2-title {
    font-size: 1.35rem !important;
    font-weight: 800 !important;
    color: #1e293b !important;
    margin-bottom: 8px !important;
  }
  .swal2-di-popup .swal2-html-container {
    font-size: 0.95rem !important;
    color: #475569 !important;
    margin: 10px 0 18px !important;
    line-height: 1.6 !important;
  }
  .swal2-di-btn-confirm {
    background: #CC0000 !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 10px 24px !important;
    font-weight: 700 !important;
    font-size: 0.9rem !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    box-shadow: 0 4px 14px rgba(204, 0, 0, 0.35) !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
  }
  .swal2-di-btn-confirm:hover {
    background: #a80000 !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 6px 18px rgba(204, 0, 0, 0.45) !important;
  }
  .swal2-di-btn-step1 {
    background: linear-gradient(135deg, #d97706, #b45309) !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 10px 24px !important;
    font-weight: 700 !important;
    font-size: 0.9rem !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    box-shadow: 0 4px 14px rgba(217, 119, 6, 0.35) !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
  }
  .swal2-di-btn-step1:hover {
    background: linear-gradient(135deg, #b45309, #92400e) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 6px 18px rgba(217, 119, 6, 0.45) !important;
  }
  .swal2-di-btn-cancel {
    background: #f1f5f9 !important;
    color: #475569 !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: 8px !important;
    padding: 10px 22px !important;
    font-weight: 600 !important;
    font-size: 0.9rem !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    margin-right: 10px !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
  }
  .swal2-di-btn-cancel:hover {
    background: #e2e8f0 !important;
    color: #1e293b !important;
  }
  .swal2-di-toast {
    border-radius: 12px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12) !important;
    font-family: 'Poppins', sans-serif !important;
    padding: 12px 16px !important;
  }
  .swal2-di-toast-success {
    border-left: 4px solid #22c55e !important;
  }
  .swal2-di-toast-error {
    border-left: 4px solid #CC0000 !important;
  }
  .swal2-di-toast-info {
    border-left: 4px solid #0284c7 !important;
  }
</style>

<script>
// Toast notification helper
window.showDiToast = function(type, title, message) {
  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3500,
    timerProgressBar: true,
    customClass: {
      popup: 'swal2-di-toast ' + (type === 'success' ? 'swal2-di-toast-success' : (type === 'info' ? 'swal2-di-toast-info' : 'swal2-di-toast-error'))
    },
    didOpen: function(toast) {
      toast.addEventListener('mouseenter', Swal.stopTimer);
      toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
  });

  Toast.fire({
    icon: type,
    title: title || (type === 'success' ? 'Berhasil!' : (type === 'info' ? 'Informasi' : 'Pemberitahuan')),
    text: message || ''
  });
};

// Global modern delete confirmation dialog powered by SweetAlert2
// Double Verification: Ditanyakan 2x ("Tanyakan Lagi Sekali Ingin Menghapus atau Tidak")
window.confirmDelete = function(event, form, message, title) {
  if (event) {
    event.preventDefault();
    event.stopPropagation();
  }

  if (form && form.dataset.confirmed === 'true') {
    delete form.dataset.confirmed;
    return true;
  }

  var msgText = message || 'Apakah Anda ingin menghapus data ini?';
  var titleText = title || 'Konfirmasi Penghapusan';

  // LANGKAH 1: Pertanyaan Awal (Ingin Menghapus atau Tidak)
  Swal.fire({
    title: titleText,
    html: '<div style="margin-bottom:12px;">' +
            '<span style="display:inline-flex;align-items:center;gap:6px;background:#fef3c7;color:#92400e;font-size:0.78rem;font-weight:700;padding:4px 12px;border-radius:20px;border:1px solid #fde68a;">' +
              '<i class="fas fa-layer-group"></i> Tahap 1 dari 2: Konfirmasi Awal' +
            '</span>' +
          '</div>' +
          '<div style="font-size:1.02rem;color:#1e293b;font-weight:600;margin-bottom:12px;line-height:1.5;">' + msgText + '</div>' +
          '<div style="font-size:0.83rem;color:#475569;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;text-align:left;line-height:1.5;">' +
            '<div style="font-weight:600;color:#334155;margin-bottom:4px;display:flex;align-items:center;gap:6px;">' +
              '<i class="fas fa-info-circle" style="color:#0284c7;"></i> Sistem Perlindungan Data' +
            '</div>' +
            'Untuk mencegah data terhapus secara tidak sengaja, sistem akan <strong>menanyakan sekali lagi</strong> pada tahap berikutnya. Apakah Anda ingin melanjutkan proses ini?' +
          '</div>',
    icon: 'warning',
    iconColor: '#f59e0b',
    showCancelButton: true,
    confirmButtonText: 'Lanjutkan <i class="fas fa-arrow-right ms-1"></i>',
    cancelButtonText: '<i class="fas fa-times me-1"></i> Batal, Jangan Hapus',
    reverseButtons: true,
    focusCancel: true,
    customClass: {
      popup: 'swal2-di-popup',
      confirmButton: 'swal2-di-btn-step1',
      cancelButton: 'swal2-di-btn-cancel'
    },
    buttonsStyling: false
  }).then(function(step1Result) {
    if (!step1Result.isConfirmed) {
      window.showDiToast('info', 'Penghapusan Dibatalkan', 'Data Anda tetap tersimpan dengan aman.');
      return;
    }

    // LANGKAH 2: Tanyakan Lagi Sekali (Konfirmasi Akhir / Double Confirmation)
    Swal.fire({
      title: '<span style="color:#CC0000;"><i class="fas fa-exclamation-triangle me-1"></i> Konfirmasi Terakhir!</span>',
      html: '<div style="margin-bottom:12px;">' +
              '<span style="display:inline-flex;align-items:center;gap:6px;background:#fee2e2;color:#991b1b;font-size:0.78rem;font-weight:700;padding:4px 12px;border-radius:20px;border:1px solid #fecaca;">' +
                '<i class="fas fa-shield-alt"></i> Tahap 2 dari 2: Tanyakan Lagi Sekali' +
              '</span>' +
            '</div>' +
            '<div style="font-size:1.05rem;color:#0f172a;font-weight:700;margin-bottom:8px;">Apakah Anda BENAR-BENAR Ingin Menghapus Data Ini?</div>' +
            '<div style="font-size:0.86rem;color:#334155;margin-bottom:12px;line-height:1.5;">' +
              'Data yang sudah dihapus akan <strong>hilang secara permanen</strong> dari database sistem dan tidak dapat dipulihkan kembali!' +
            '</div>' +
            '<div style="font-size:0.82rem;color:#991b1b;background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:10px 14px;text-align:left;display:flex;align-items:center;gap:10px;">' +
              '<i class="fas fa-trash-alt" style="font-size:1.1rem;color:#dc2626;flex-shrink:0;"></i>' +
              '<span>Pilih <strong>\"Ya, Hapus Sekarang\"</strong> jika Anda yakin, atau <strong>\"Batal, Jangan Hapus\"</strong> untuk membatalkannya.</span>' +
            '</div>',
      icon: 'error',
      iconColor: '#CC0000',
      showCancelButton: true,
      confirmButtonText: '<i class="fas fa-trash-alt me-1"></i> Ya, Hapus Sekarang!',
      cancelButtonText: '<i class="fas fa-undo me-1"></i> Batal, Jangan Hapus',
      reverseButtons: true,
      focusCancel: true,
      customClass: {
        popup: 'swal2-di-popup',
        confirmButton: 'swal2-di-btn-confirm',
        cancelButton: 'swal2-di-btn-cancel'
      },
      buttonsStyling: false
    }).then(function(step2Result) {
      if (step2Result.isConfirmed) {
        Swal.fire({
          title: 'Menghapus Data...',
          html: '<div style="font-size:0.88rem;color:#64748b;margin-top:6px;">Mohon tunggu, sistem sedang memproses penghapusan data secara aman.</div>',
          allowOutsideClick: false,
          allowEscapeKey: false,
          showConfirmButton: false,
          didOpen: function() {
            Swal.showLoading();
          }
        });

        if (form) {
          form.dataset.confirmed = 'true';
          form.submit();
        }
      } else {
        window.showDiToast('info', 'Penghapusan Dibatalkan', 'Data Anda tetap tersimpan dengan aman.');
      }
    });
  });

  return false;
};

// General Action Confirmation (1-step for non-destructive actions like activate/toggle/renew)
window.confirmAction = function(event, form, message, title, btnText) {
  if (event) {
    event.preventDefault();
    event.stopPropagation();
  }

  if (form && form.dataset.confirmed === 'true') {
    delete form.dataset.confirmed;
    return true;
  }

  Swal.fire({
    title: title || 'Konfirmasi Tindakan',
    text: message || 'Apakah Anda yakin ingin melanjutkan tindakan ini?',
    icon: 'question',
    iconColor: '#0284c7',
    showCancelButton: true,
    confirmButtonText: btnText || '<i class="fas fa-check me-1"></i> Ya, Lanjutkan',
    cancelButtonText: '<i class="fas fa-times me-1"></i> Batal',
    reverseButtons: true,
    focusCancel: true,
    customClass: {
      popup: 'swal2-di-popup',
      confirmButton: 'swal2-di-btn-confirm',
      cancelButton: 'swal2-di-btn-cancel'
    },
    buttonsStyling: false
  }).then(function(result) {
    if (result.isConfirmed) {
      if (form) {
        form.dataset.confirmed = 'true';
        form.submit();
      }
    }
  });

  return false;
};

// Universal automatic interception: Replace browser native confirm on all forms
(function() {
  function attachSwalConfirmToForms() {
    document.querySelectorAll('form').forEach(function(form) {
      var onsubmitAttr = form.getAttribute('onsubmit') || '';
      if (onsubmitAttr.includes('confirm(') && !onsubmitAttr.includes('confirmDelete(') && !onsubmitAttr.includes('confirmAction(')) {
        var match = onsubmitAttr.match(/confirm\(\s*['"`]([^'"`]+)['"`]\s*\)/);
        var msg = match && match[1] ? match[1] : 'Apakah Anda yakin ingin melanjutkan tindakan ini?';

        form.removeAttribute('onsubmit');
        form.onsubmit = null;

        var isDelete = (form.querySelector('input[name="_method"][value="DELETE"]') !== null) ||
                       (form.getAttribute('action') && form.getAttribute('action').includes('destroy')) ||
                       msg.toLowerCase().includes('hapus') ||
                       msg.toLowerCase().includes('delete');

        form.addEventListener('submit', function(e) {
          if (form.dataset.confirmed === 'true') {
            return true;
          }
          if (isDelete) {
            return window.confirmDelete(e, form, msg);
          } else {
            return window.confirmAction(e, form, msg);
          }
        });
      }
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', attachSwalConfirmToForms);
  } else {
    attachSwalConfirmToForms();
  }

  // Also capture click events directly on submit buttons before any inline handler runs
  document.addEventListener('click', function(e) {
    var btn = e.target.closest('button[type="submit"], input[type="submit"]');
    if (!btn) return;
    var form = btn.closest('form');
    if (!form) return;

    var onsubmitAttr = form.getAttribute('onsubmit') || '';
    if (onsubmitAttr.includes('confirm(') && !onsubmitAttr.includes('confirmDelete(') && !onsubmitAttr.includes('confirmAction(')) {
      var match = onsubmitAttr.match(/confirm\(\s*['"`]([^'"`]+)['"`]\s*\)/);
      var msg = match && match[1] ? match[1] : 'Apakah Anda yakin ingin melanjutkan tindakan ini?';

      form.removeAttribute('onsubmit');
      form.onsubmit = null;
      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();

      var isDelete = (form.querySelector('input[name="_method"][value="DELETE"]') !== null) ||
                     (form.getAttribute('action') && form.getAttribute('action').includes('destroy')) ||
                     msg.toLowerCase().includes('hapus') ||
                     msg.toLowerCase().includes('delete');

      if (isDelete) {
        window.confirmDelete(e, form, msg);
      } else {
        window.confirmAction(e, form, msg);
      }
      return false;
    }
  }, true);
})();
</script>

<style>
  .note-editor.note-frame {
    border: 1px solid #ced4da;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: none;
    background: #fff;
  }
  .note-editor.note-frame .note-toolbar {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 6px 10px;
  }
  .note-editor.note-frame .note-statusbar {
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
  }
  .note-editor.note-frame.focus {
    border-color: #CC0000 !important;
    box-shadow: 0 0 0 0.25rem rgba(204, 0, 0, 0.15) !important;
  }
  .note-btn {
    font-size: 0.82rem;
    padding: 4px 8px;
  }
</style>
<script>
  $(document).ready(function() {
    function initGlobalSummernote() {
      $('.summernote, .summernote-editor, textarea[data-editor="summernote"]').each(function() {
        var $el = $(this);
        if (!$el.hasClass('summernote-initialized') && !$el.next().hasClass('note-editor')) {
          $el.addClass('summernote-initialized');
          var customHeight = $el.data('height') || ($el.attr('rows') ? Math.max($el.attr('rows') * 35, 150) : 180);
          $el.summernote({
            height: customHeight,
            minHeight: 120,
            toolbar: [
              ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
              ['font', ['strikethrough', 'superscript', 'subscript']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['insert', ['link', 'table', 'hr']],
              ['view', ['fullscreen', 'codeview', 'help']]
            ],
            placeholder: $el.attr('placeholder') || 'Tulis konten di sini...'
          });
        }
      });
    }

    initGlobalSummernote();

    // Re-init / refresh for dynamic Bootstrap tabs
    $('button[data-bs-toggle="tab"], a[data-bs-toggle="tab"]').on('shown.bs.tab', function() {
      initGlobalSummernote();
    });
  });
</script>

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

  // Pertahankan posisi scroll sidebar navigasi saat berpindah halaman
  (function() {
    try {
      var sidebar = document.querySelector('.sidebar');
      if (!sidebar) return;

      function applySidebarScroll() {
        var saved = sessionStorage.getItem('backoffice_sidebar_scroll');
        if (saved !== null) {
          sidebar.scrollTop = parseInt(saved, 10);
        } else {
          var active = sidebar.querySelector('a.active');
          if (active) {
            active.scrollIntoView({ block: 'center', behavior: 'auto' });
          }
        }
      }

      applySidebarScroll();
      window.addEventListener('load', applySidebarScroll);

      var scrollTimer;
      sidebar.addEventListener('scroll', function() {
        clearTimeout(scrollTimer);
        scrollTimer = setTimeout(function() {
          sessionStorage.setItem('backoffice_sidebar_scroll', sidebar.scrollTop);
        }, 50);
      }, { passive: true });

      sidebar.addEventListener('click', function(e) {
        var link = e.target.closest('a');
        if (link) {
          sessionStorage.setItem('backoffice_sidebar_scroll', sidebar.scrollTop);
        }
      });

      window.addEventListener('beforeunload', function() {
        sessionStorage.setItem('backoffice_sidebar_scroll', sidebar.scrollTop);
      });
    } catch (err) {}
  })();

  // Mobile Sidebar Toggle Controller
  (function() {
    var toggleBtn = document.getElementById('sidebarToggleBtn');
    var closeBtn = document.getElementById('sidebarCloseBtn');
    var backdrop = document.getElementById('sidebarBackdrop');
    var sidebar = document.getElementById('sidebarNav') || document.querySelector('.sidebar');

    function openSidebar() {
      if (sidebar) sidebar.classList.add('open');
      if (backdrop) backdrop.classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
      if (sidebar) sidebar.classList.remove('open');
      if (backdrop) backdrop.classList.remove('active');
      document.body.style.overflow = '';
    }

    if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (backdrop) backdrop.addEventListener('click', closeSidebar);

    // Auto-close on mobile when clicking any navigation link
    if (sidebar) {
      sidebar.querySelectorAll('.sidebar-nav a').forEach(function(link) {
        link.addEventListener('click', function() {
          if (window.innerWidth <= 768) {
            closeSidebar();
          }
        });
      });
    }

    // Auto-close on desktop resize
    window.addEventListener('resize', function() {
      if (window.innerWidth > 768) {
        closeSidebar();
      }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) {
        closeSidebar();
      }
    });
  })();
</script>

@stack('scripts')
</body>
</html>