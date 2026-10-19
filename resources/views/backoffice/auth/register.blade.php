<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar|Denpasar Institute Backoffice</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root { --red:#CC0000; --yellow:#F5C400; }
    * { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Poppins',sans-serif; background:#f4f6f9; min-height:100vh;
      display:flex; align-items:center; justify-content:center; padding:20px; }
    .auth-wrap { width:100%; max-width:500px; }
    .auth-card { background:#fff; border-radius:10px; padding:40px 36px;
      border-top:4px solid var(--red); box-shadow:0 4px 24px rgba(0,0,0,0.08); }
    .auth-logo { text-align:center; margin-bottom:28px; }
    .auth-logo span { font-size:1.4rem; font-weight:800; color:#CC0000; }
    .auth-logo small { display:block; font-size:0.72rem; color:#999; margin-top:4px; }
    h2 { font-size:1.1rem; font-weight:700; margin-bottom:6px; color:#1a1a1a; }
    .sub { font-size:0.75rem; color:#888; margin-bottom:20px; }
    .form-group { margin-bottom:14px; }
    .form-group label { display:block; font-size:0.75rem; font-weight:700; color:#555; margin-bottom:5px; }
    .form-group input, .form-group select { width:100%; padding:10px 12px; border:1px solid #d1d5db; border-radius:5px;
      font-family:Poppins,sans-serif; font-size:0.85rem; outline:none; transition:border-color 0.2s; }
    .form-group input:focus, .form-group select:focus { border-color:var(--red); }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    .role-info { font-size:0.7rem; color:#888; margin-top:4px; }
    .btn-reg { width:100%; padding:11px; background:var(--red); color:#fff; border:none;
      border-radius:5px; font-family:Poppins,sans-serif; font-size:0.88rem; font-weight:700; cursor:pointer; transition:0.2s; }
    .btn-reg:hover { background:#a80000; }
    .auth-link { text-align:center; font-size:0.78rem; color:#888; margin-top:16px; }
    .auth-link a { color:var(--red); font-weight:600; }
    .error-msg { background:#fee2e2; color:#991b1b; padding:10px 14px; border-radius:5px; font-size:0.78rem; margin-bottom:14px; border-left:3px solid #dc2626; }
    .notice { background:#fef9c3; color:#854d0e; padding:12px 14px; border-radius:5px; font-size:0.75rem; margin-bottom:16px; border-left:3px solid var(--yellow); }
  </style>
</head>
<body>
<div class="auth-wrap">
  <div class="auth-card">
    <div class="auth-logo">
      <span>Denpasar Institute</span>
      <small>Backoffice Panel</small>
    </div>
    <h2>Buat Akun Baru</h2>
    <p class="sub">Akun baru perlu diaktivasi oleh Super Admin sebelum bisa login.</p>

    <div class="notice"><i class="fas fa-info-circle"></i> Registrasi hanya untuk <strong>Konsultan</strong> dan <strong>GRCS Club</strong>.</div>

    @if($errors->any())
      <div class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('backoffice.register.submit') }}">
      @csrf
      
      <div class="form-group">
        <label>Nama Lengkap *</label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap" required>
      </div>

      <div class="form-group">
        <label>Email *</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Alamat email aktif" required>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>No. Telepon</label>
          <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
        </div>
        <div class="form-group">
          <label>Jabatan</label>
          <input type="text" name="position" value="{{ old('position') }}" placeholder="Contoh: Dosen, Peneliti">
        </div>
      </div>

      <div class="form-group">
        <label>Institusi/Organisasi</label>
        <input type="text" name="institution" value="{{ old('institution') }}" placeholder="Nama institusi atau organisasi">
      </div>

      <div class="form-group">
        <label>Daftar Sebagai *</label>
        <select name="role" required>
          <option value="">-- Pilih role --</option>
          <option value="konsultan" {{ old('role', request('role')) === 'konsultan' ? 'selected' : '' }}>Konsultan</option>
          <option value="grcs" {{ old('role', request('role')) === 'grcs' ? 'selected' : '' }}>GRCS Club</option>
        </select>
        <p class="role-info">Role superadmin hanya dibuat langsung oleh pengelola sistem.</p>
      </div>

      <div class="form-group">
        <label>Password *</label>
        <input type="password" name="password" placeholder="Minimal 8 karakter" required>
      </div>

      <div class="form-group">
        <label>Konfirmasi Password *</label>
        <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
      </div>

      <button type="submit" class="btn-reg">Daftar Sekarang</button>
    </form>
    <p class="auth-link">Sudah punya akun? <a href="{{ route('backoffice.login') }}">Login di sini</a></p>
  </div>
</div>
</body>
</html>