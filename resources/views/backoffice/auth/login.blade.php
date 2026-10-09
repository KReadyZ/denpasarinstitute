<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Denpasar Institute Backoffice</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root { --red:#CC0000; --yellow:#F5C400; }
    * { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Poppins',sans-serif; background:#f4f6f9; min-height:100vh;
      display:flex; align-items:center; justify-content:center; }
    .auth-wrap { width:100%; max-width:420px; padding:20px; }
    .auth-card { background:#fff; border-radius:10px; padding:40px 36px;
      border-top:4px solid var(--red); box-shadow:0 4px 24px rgba(0,0,0,0.08); }
    .auth-logo { text-align:center; margin-bottom:28px; }
    .auth-logo span { font-size:1.4rem; font-weight:800; color:#CC0000; }
    .auth-logo small { display:block; font-size:0.72rem; color:#999; margin-top:4px; }
    h2 { font-size:1.1rem; font-weight:700; margin-bottom:20px; color:#1a1a1a; }
    .form-group { margin-bottom:14px; }
    .form-group label { display:block; font-size:0.75rem; font-weight:700; color:#555; margin-bottom:5px; }
    .form-group input { width:100%; padding:10px 12px; border:1px solid #d1d5db; border-radius:5px;
      font-family:Poppins,sans-serif; font-size:0.85rem; outline:none; transition:border-color 0.2s; }
    .form-group input:focus { border-color:var(--red); }
    .check-row { display:flex; align-items:center; gap:8px; font-size:0.78rem; color:#666; margin-bottom:16px; }
    .btn-login { width:100%; padding:11px; background:var(--red); color:#fff; border:none;
      border-radius:5px; font-family:Poppins,sans-serif; font-size:0.88rem; font-weight:700;
      cursor:pointer; transition:0.2s; }
    .btn-login:hover { background:#a80000; }
    .auth-link { text-align:center; font-size:0.78rem; color:#888; margin-top:16px; }
    .auth-link a { color:var(--red); font-weight:600; }
    .error-msg { background:#fee2e2; color:#991b1b; padding:10px 14px; border-radius:5px;
      font-size:0.78rem; margin-bottom:14px; border-left:3px solid #dc2626; }
    .success-msg { background:#dcfce7; color:#166534; padding:10px 14px; border-radius:5px;
      font-size:0.78rem; margin-bottom:14px; border-left:3px solid #22c55e; }
  </style>
</head>
<body>
<div class="auth-wrap">
  <div class="auth-card">
    <div class="auth-logo">
      <span>Denpasar Institute</span>
      <small>Backoffice Panel</small>
    </div>
    <h2>Masuk ke Akun Anda</h2>

    @if(session('success'))
      <div class="success-msg"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('backoffice.login') }}">
      @csrf
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@denpasarinstitute.id" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>
      <div class="check-row">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Ingat saya</label>
      </div>
      <button type="submit" class="btn-login">Masuk</button>
    </form>
    <p class="auth-link">Belum punya akun? <a href="{{ route('backoffice.register') }}">Daftar di sini</a></p>
  </div>
</div>
</body>
</html>