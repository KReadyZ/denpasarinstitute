<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Denpasar Institute Backoffice</title>
  <link rel="icon" type="image/png" href="{{ \App\Models\SiteSetting::getLogoUrl() }}">
  <link rel="shortcut icon" type="image/png" href="{{ \App\Models\SiteSetting::getLogoUrl() }}">
  <link rel="apple-touch-icon" href="{{ \App\Models\SiteSetting::getLogoUrl() }}">
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
    .password-wrap { position:relative; width:100%; display:flex; align-items:center; }
    .password-wrap input { padding-right:42px; }
    .btn-toggle-pwd { position:absolute; right:0; top:0; height:100%; width:42px; background:none; border:none;
      outline:none; color:#9ca3af; cursor:pointer; display:flex; align-items:center; justify-content:center;
      font-size:0.95rem; transition:color 0.2s; border-radius:0 5px 5px 0; }
    .btn-toggle-pwd:hover { color:var(--red); }
    .btn-toggle-pwd:focus-visible { color:var(--red); }
    /* Hilangkan ikon mata default Edge agar tidak dobel */
    input::-ms-reveal, input::-ms-clear { display:none; }
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
    @media (max-width: 480px) {
      .auth-wrap { padding: 14px; }
      .auth-card { padding: 26px 18px; }
    }
  </style>
</head>
<body>
<div class="auth-wrap">
  <div class="auth-card">
    <div class="auth-logo">
      <img src="{{ \App\Models\SiteSetting::getLogoUrl() }}" alt="Logo Denpasar Institute" style="height: 52px; width: auto; object-fit: contain; margin-bottom: 10px;" onerror="this.onerror=null;this.src='{{ asset('image/Logo_DI.png') }}';"><br>
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
        <label for="passwordInput">Password</label>
        <div class="password-wrap">
          <input type="password" name="password" id="passwordInput" placeholder="••••••••" required autocomplete="current-password">
          <button type="button" class="btn-toggle-pwd" id="togglePasswordBtn" aria-label="Tampilkan password" title="Tampilkan password">
            <i class="far fa-eye" id="togglePasswordIcon"></i>
          </button>
        </div>
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

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('togglePasswordBtn');
    const pwdInput = document.getElementById('passwordInput');
    const pwdIcon = document.getElementById('togglePasswordIcon');

    if (toggleBtn && pwdInput && pwdIcon) {
      // Mencegah input kehilangan fokus saat ikon mata diklik
      toggleBtn.addEventListener('mousedown', function (e) {
        e.preventDefault();
      });

      toggleBtn.addEventListener('click', function () {
        const isPassword = pwdInput.type === 'password';
        const start = pwdInput.selectionStart;
        const end = pwdInput.selectionEnd;

        pwdInput.type = isPassword ? 'text' : 'password';

        // Pertahankan kursor/seleksi
        if (typeof start === 'number' && typeof end === 'number') {
          pwdInput.setSelectionRange(start, end);
        }

        if (isPassword) {
          pwdIcon.classList.remove('fa-eye');
          pwdIcon.classList.add('fa-eye-slash');
          toggleBtn.setAttribute('title', 'Sembunyikan password');
          toggleBtn.setAttribute('aria-label', 'Sembunyikan password');
        } else {
          pwdIcon.classList.remove('fa-eye-slash');
          pwdIcon.classList.add('fa-eye');
          toggleBtn.setAttribute('title', 'Tampilkan password');
          toggleBtn.setAttribute('aria-label', 'Tampilkan password');
        }
      });
    }
  });
</script>
</body>
</html>