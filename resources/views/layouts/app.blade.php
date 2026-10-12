<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
  <title>@yield('title', 'Denpasar Institute')</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --red:    #CC0000;
      --red2:   #E30000;
      --yellow: #F5C400;
      --white:  #ffffff;
      --dark:   #1a1a1a;
      --gray:   #f4f4f4;
      --text:   #333;
      --border: #e0e0e0;
    }
    *, *::before, *::after { box-sizing: border-box; }
    html, body {
      overflow-x: hidden;
      max-width: 100%;
      scroll-behavior: smooth;
      touch-action: pan-x pan-y;
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }
    body { margin: 0; font-family: "Poppins", sans-serif; background: #fff; color: var(--text); }
    a { text-decoration: none; }
    img { display: block; }

    /* Google Translate Fix */
    .goog-te-banner-frame.skiptranslate { display: none !important; }
    body { top: 0px !important; }
    .goog-text-highlight { background: none !important; box-shadow: none !important; }
    .goog-tooltip { display: none !important; }
    .goog-tooltip:hover { display: none !important; }
    .goog-text-highlight { background-color: transparent !important; border: none !important; box-shadow: none !important; }

    .topbar { background: var(--red); color: #fff; font-size: 0.78rem; padding: 6px 0; }
    .topbar-inner { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 6px; }
    .topbar a { color: #fff; opacity: 0.9; }
    .topbar a:hover { opacity: 1; text-decoration: underline; }
    .topbar-right { display: flex; align-items: center; gap: 12px; }
    .topbar-social a { color: #fff; font-size: 0.85rem; margin-left: 8px; opacity: 0.9; transition: 0.2s; }
    .topbar-social a:hover { opacity: 1; }

    header {
      background: #fff;
      border-bottom: 3px solid var(--red);
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }
    .header-inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 68px;
      position: relative;
    }
    .nav-logo-center {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      top: -49px;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1001;
      pointer-events: none;
      user-select: none;
      cursor: default;
      transition: top 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    header.is-scrolled .nav-logo-center {
      top: -7px;
    }
    .nav-logo-center img {
      height: 270px;
      width: auto;
      filter: drop-shadow(0 6px 16px rgba(0,0,0,0.3));
      pointer-events: none;
      user-select: none;
      -webkit-user-drag: none;
      cursor: default;
      transition: height 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    header.is-scrolled .nav-logo-center img {
      height: 120px;
    }
    .nav-left, .nav-right {
      display: flex; align-items: center; gap: 2px;
      list-style: none; margin: 0; padding: 0;
    }
    .nav-left { flex: 1; justify-content: flex-start; }
    .nav-right { flex: 1; justify-content: flex-end; }
    .nav-left li, .nav-right li { position: relative; }
    .nav-left a, .nav-right a {
      color: var(--dark); font-weight: 500; font-size: 0.82rem;
      padding: 8px 11px; border-radius: 4px;
      transition: background 0.2s, color 0.2s;
      white-space: nowrap; display: flex; align-items: center; gap: 4px;
    }
    .nav-left a:hover, .nav-right a:hover { background: #fff5f5; color: var(--red); }

    .nav-left a.active, .nav-right a.active {
      color: var(--red);
      background: #fff5f5;
      font-weight: 700;
    }

    .has-dropdown > a::after {
      content: '\f078'; font-family: 'Font Awesome 6 Free';
      font-weight: 900; font-size: 0.58rem; margin-left: 2px;
    }
    .dropdown-menu {
      position: absolute; top: calc(100% + 4px); left: 0;
      background: #fff; border: 1px solid var(--border);
      border-top: 3px solid var(--red); border-radius: 6px;
      min-width: 220px; box-shadow: 0 8px 24px rgba(0,0,0,0.12);
      opacity: 0; visibility: hidden; transform: translateY(6px);
      transition: opacity 0.2s, transform 0.2s, visibility 0.2s;
      z-index: 2000; padding: 4px 0; list-style: none;
    }
    .nav-right .has-dropdown .dropdown-menu { left: auto; right: 0; }
    .has-dropdown:hover .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }
    .dropdown-menu li { list-style: none; }
    .dropdown-menu a {
      display: flex; align-items: center; gap: 10px;
      padding: 8px 16px; font-size: 0.8rem; color: var(--dark);
      font-weight: 500; border-radius: 0;
      transition: background 0.15s, color 0.15s;
    }
    .dropdown-menu a:hover { background: #fff5f5; color: var(--red); }
    .dropdown-menu a::after { display: none !important; }
    .dropdown-menu a i { width: 16px; text-align: center; color: var(--red); font-size: 0.78rem; flex-shrink: 0; }
    .dropdown-divider { height: 1px; background: var(--border); margin: 4px 0; }
    
    .lang-select {
      font-family: Poppins, sans-serif; font-size: 0.8rem; font-weight: 500;
      border: 1px solid var(--border); border-radius: 4px; padding: 6px 10px;
      color: var(--dark); background: #fff; cursor: pointer; outline: none;
      transition: border-color 0.2s;
      max-height: 350px;
      overflow-y: auto;
      min-width: 160px;
    }
    .lang-select:hover, .lang-select:focus { border-color: var(--red); }
    .lang-select option { padding: 4px 8px; }
    
    .hamburger-btn { display: none; flex-direction: column; justify-content: center; gap: 5px; cursor: pointer; z-index: 1400; padding: 4px; flex-shrink: 0; background: none; border: none; outline: none; position: absolute; right: 20px; }
    .hamburger-btn span { display: block; width: 26px; height: 3px; background: var(--red); border-radius: 3px; transition: all 0.35s ease; transform-origin: center; }
    .hamburger-btn.is-active span:nth-child(1) { transform: translateY(8px) rotate(45deg); }
    .hamburger-btn.is-active span:nth-child(2) { opacity: 0; transform: scaleX(0); }
    .hamburger-btn.is-active span:nth-child(3) { transform: translateY(-8px) rotate(-45deg); }
    .menu-backdrop { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.55); z-index: 1200; opacity: 0; transition: opacity 0.35s; }
    .menu-backdrop.is-active { display: block; opacity: 1; }
    .mobile-menu { position: fixed; top: 0; right: -100%; width: 80%; max-width: 300px; height: 100vh; background: #fff; padding: 72px 24px 32px; transition: right 0.38s cubic-bezier(0.4,0,0.2,1); z-index: 1300; overflow-y: auto; box-sizing: border-box; display: flex; flex-direction: column; gap: 0; border-left: 4px solid var(--red); }
    .mobile-menu.is-active { right: 0; }
    .mobile-nav { list-style: none; padding: 0; margin: 0; }
    .mobile-nav li { border-bottom: 1px solid #eee; }
    .mobile-nav a { display: block; color: var(--dark); font-size: 15px; font-weight: 600; text-decoration: none; padding: 12px 0; transition: color 0.2s, padding-left 0.2s; }
    .mobile-nav a:hover { color: var(--red); padding-left: 8px; }
    .mobile-nav a.active { color: var(--red); font-weight: 700; }
    .mobile-nav-sub { padding-left: 16px; list-style: none; }
    .mobile-nav-sub a { font-size: 13px; font-weight: 400; }
    .mobile-lang-wrap { padding: 14px 0; }
    .mobile-lang-wrap .lang-select { width: 100%; }
    @media (max-width: 991px) and (min-width: 769px) {
      .nav-left a, .nav-right a {
        font-size: 0.74rem;
        padding: 5px 6px;
      }
      .nav-logo-center {
        top: -43px;
      }
      .nav-logo-center img {
        height: 190px;
      }
      header.is-scrolled .nav-logo-center {
        top: -5px;
      }
      header.is-scrolled .nav-logo-center img {
        height: 100px;
      }
    }
    @media (max-width: 768px) {
      .nav-left, .nav-right { display: none !important; }
      .nav-logo-center {
        top: 50% !important;
        transform: translate(-50%, -50%) !important;
      }
      .nav-logo-center img {
        height: 52px !important;
      }
      .hamburger-btn { display: flex !important; }
      .topbar-left { display: none; }
    }

    .container, .section-wrap { max-width: 1200px; margin: 0 auto; padding: 0 24px; box-sizing: border-box; }
    .section-header { display: flex; align-items: center; gap: 12px; margin-bottom: 28px; }
    .section-header h2 { font-size: 1.4rem; font-weight: 800; color: var(--dark); margin: 0; }
    .section-line { flex: 1; height: 3px; background: var(--red); }
    .section-tag { background: var(--red); color: #fff; font-size: 0.7rem; font-weight: 700; padding: 3px 12px; border-radius: 2px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; }

    .news-section { background: #fff; padding: 60px 0; }
    .news-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; }
    .news-card { border: 1px solid var(--border); border-radius: 6px; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s; }
    .news-card:hover { transform: translateY(-5px); box-shadow: 0 12px 32px rgba(0,0,0,0.12); }
    .news-card img { width: 100%; height: 185px; object-fit: cover; }
    .news-card-body { padding: 16px; }
    .news-card-cat { color: var(--red); font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; display: block; }
    .news-card-title { font-size: 0.93rem; font-weight: 700; color: var(--dark); margin-bottom: 8px; line-height: 1.45; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .news-card-excerpt { font-size: 0.8rem; color: #666; line-height: 1.6; margin-bottom: 14px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .news-card-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 10px; border-top: 1px solid var(--border); }
    .news-date { font-size: 0.74rem; color: #999; }
    .btn-read { background: var(--red); color: #fff; padding: 5px 14px; border-radius: 4px; font-size: 0.74rem; font-weight: 600; transition: 0.2s; }
    .btn-read:hover { background: #a80000; }
    .news-more { text-align: center; margin-top: 36px; }
    .btn-more { background: var(--yellow); color: var(--dark); padding: 12px 40px; border-radius: 4px; font-weight: 800; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 0.5px; transition: 0.2s; display: inline-block; }
    .btn-more:hover { background: #e0b000; transform: translateY(-2px); }

    .contact-section { background: url('https://images.unsplash.com/photo-1476249202953-93ec0d185ab7?q=80&w=1170&auto=format&fit=crop') center/cover no-repeat; position: relative; padding: 80px 0; }
    .contact-section::after { content: ""; position: absolute; inset: 0; background: rgba(0,0,0,0.58); z-index: 1; }
    .contact-section > * { position: relative; z-index: 2; }
    .contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; max-width: 1200px; margin: 0 auto; padding: 0 20px; }
    .contact-left h2 { font-size: 2.3rem; font-weight: 800; color: #fff; margin-bottom: 16px; line-height: 1.2; }
    .contact-left p { font-size: 0.93rem; color: rgba(255,255,255,0.88); line-height: 1.8; margin-bottom: 14px; }
    .contact-left .highlight { color: var(--yellow); font-weight: 700; font-style: italic; }
    .contact-form-wrap { background: #fff; border-radius: 6px; padding: 32px; border-top: 4px solid var(--red); }
    .contact-form-wrap h3 { font-size: 1.2rem; font-weight: 800; color: var(--dark); margin-bottom: 6px; }
    .contact-form-wrap > p { font-size: 0.8rem; color: #666; margin-bottom: 18px; line-height: 1.6; }
    .form-group { margin-bottom: 12px; }
    .form-group label { display: block; font-size: 0.78rem; font-weight: 700; color: var(--dark); margin-bottom: 4px; }
    .form-group input, .form-group textarea { width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 4px; font-family: Poppins, sans-serif; font-size: 0.84rem; color: var(--dark); transition: border-color 0.2s; outline: none; }
    .form-group input:focus, .form-group textarea:focus { border-color: var(--red); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .btn-wa { background: #25d366; color: #fff; border: none; padding: 11px 22px; border-radius: 4px; font-weight: 700; cursor: pointer; font-family: Poppins, sans-serif; font-size: 0.84rem; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s; }
    .btn-wa:hover { background: #1aad54; transform: translateY(-2px); }

    footer { background: #1a1a1a; padding: 50px 0 0; color: rgba(255,255,255,0.75); }
    .footer-grid { display: grid; grid-template-columns: 1.2fr 1fr 1fr 0.9fr; gap: 36px; max-width: 1200px; margin: 0 auto; padding: 0 20px; }
    .footer-logo-name { font-size: 1.2rem; font-weight: 800; color: var(--yellow); margin-bottom: 10px; }
    .footer-desc { font-size: 0.81rem; line-height: 1.7; color: rgba(255,255,255,0.6); margin-bottom: 16px; }
    .footer-social { display: flex; gap: 10px; }
    .footer-social a { width: 34px; height: 34px; border-radius: 50%; background: rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.84rem; transition: 0.2s; }
    .footer-social a:hover { background: var(--red); }
    .footer-col h4 { font-size: 0.88rem; font-weight: 700; color: #fff; margin-bottom: 14px; padding-bottom: 8px; border-bottom: 2px solid var(--red); }
    .footer-links { list-style: none; padding: 0; margin: 0; }
    .footer-links li { margin-bottom: 7px; }
    .footer-links a { color: rgba(255,255,255,0.6); font-size: 0.81rem; transition: 0.2s; }
    .footer-links a:hover { color: var(--yellow); padding-left: 4px; }
    .footer-contact-item { display: flex; gap: 10px; align-items: flex-start; margin-bottom: 10px; }
    .footer-contact-item i { color: var(--yellow); font-size: 0.84rem; margin-top: 2px; flex-shrink: 0; }
    .footer-contact-item span { font-size: 0.81rem; color: rgba(255,255,255,0.6); line-height: 1.5; }
    .footer-bottom-bar { border-top: 1px solid rgba(255,255,255,0.08); margin-top: 40px; padding: 16px 20px; max-width: 1200px; margin-left: auto; margin-right: auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
    .footer-bottom-bar p { font-size: 0.76rem; color: rgba(255,255,255,0.4); margin: 0; }
    .footer-bottom-bar a { font-size: 0.76rem; color: rgba(255,255,255,0.4); }
    .footer-bottom-bar a:hover { color: var(--yellow); }

    #backToTop { position: fixed; bottom: 28px; right: 28px; background: var(--red); color: #fff; border: none; width: 42px; height: 42px; border-radius: 50%; font-size: 1rem; cursor: pointer; opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 500; display: flex; align-items: center; justify-content: center; }
    #backToTop.show { opacity: 1; visibility: visible; }
    #backToTop:hover { background: #a80000; transform: translateY(-3px); }
    .contact-widget { position: fixed; bottom: 28px; right: 78px; z-index: 500; display: flex; flex-direction: column; align-items: flex-end; }
    .cw-toggle {
      position: relative;
      display: flex; align-items: center; justify-content: center;
      gap: 9px;
      height: 42px; width: 42px;
      padding: 0;
      background: #25d366; color: #fff; border: none; border-radius: 42px;
      cursor: pointer; box-shadow: 0 4px 14px rgba(37,211,102,0.4);
      transition: width 0.4s cubic-bezier(.4,0,.2,1), padding 0.4s cubic-bezier(.4,0,.2,1), background 0.25s, transform 0.25s;
      overflow: hidden;
      font-family: 'Poppins', sans-serif;
    }
    .cw-toggle:hover { transform: translateY(-3px); }
    .cw-toggle.cw-wide { width: 168px; padding: 0 18px 0 14px; justify-content: flex-start; }
    .cw-toggle.cw-open { background: #1aad54; }
    .cw-icon-wrap { flex-shrink: 0; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; position: relative; }
    .cw-icon-wrap i { font-size: 1.25rem; position: absolute; opacity: 1; transition: opacity 0.25s ease, transform 0.25s ease; }
    .cw-icon-wrap i.cw-icon-leaving { opacity: 0; transform: scale(0.6) rotate(-20deg); }
    .cw-icon-wrap i.cw-icon-entering { opacity: 0; transform: scale(0.6) rotate(20deg); }
    .cw-label { font-size: 0.82rem; font-weight: 700; white-space: nowrap; opacity: 0; transition: opacity 0.25s ease 0.1s; }
    .cw-toggle.cw-wide .cw-label { opacity: 1; }
    .cw-menu {
      position: absolute; bottom: 54px; right: 0;
      background: #fff; border-radius: 12px;
      box-shadow: 0 12px 36px rgba(0,0,0,0.18);
      padding: 10px; min-width: 220px;
      display: flex; flex-direction: column; gap: 4px;
      opacity: 0; visibility: hidden; transform: translateY(12px) scale(0.97);
      transform-origin: bottom right;
      transition: opacity 0.25s ease, transform 0.25s ease, visibility 0.25s;
      pointer-events: none;
    }
    .contact-widget.cw-open .cw-menu { opacity: 1; visibility: visible; transform: translateY(0) scale(1); pointer-events: auto; }
    .cw-item {
      display: flex; align-items: center; gap: 12px;
      padding: 9px 10px; border-radius: 8px;
      text-decoration: none; transition: background 0.15s;
    }
    .cw-item:hover { background: #f6f6f6; }
    .cw-item-icon { width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.95rem; color: #fff; }
    .cw-item-icon.cw-wa-color { background: #25d366; }
    .cw-item-icon.cw-email-color { background: #f5811f; }
    .cw-item-icon.cw-admission-color { background: var(--red); }
    .cw-item-label { font-size: 0.84rem; font-weight: 600; color: var(--dark); }

    .carousel { position: relative; overflow: hidden; }
    .carousel-inner-wrap { display: flex; transition: transform 0.5s ease; will-change: transform; }
    .carousel-slide { flex: 0 0 100%; padding: 0 4px; }
    .carousel-controls-row { display: flex; justify-content: center; gap: 12px; margin-top: 32px; }
    .carousel-controls-row button { background: white; border: 1px solid var(--border); width: 42px; height: 42px; border-radius: 60px; cursor: pointer; font-size: 1rem; transition: 0.2s; color: var(--red); }
    .carousel-controls-row button:hover { background: var(--red); color: white; border-color: var(--red); }
    .carousel-dots { display: flex; justify-content: center; gap: 12px; margin-top: 24px; }
    .carousel-dot { width: 10px; height: 10px; background: #ccc; border-radius: 10px; cursor: pointer; transition: 0.2s; }
    .carousel-dot.active { background: var(--red); width: 28px; }

    @media (max-width: 768px) {
      .news-grid { grid-template-columns: 1fr; }
      .contact-grid { grid-template-columns: 1fr; gap: 28px; }
      .footer-grid { grid-template-columns: 1fr; gap: 24px; }
      .form-row { grid-template-columns: 1fr; }
    }
    @yield('extra-style')
  </style>
  @stack('styles')
</head>
<body>

<div id="google_translate_element" style="display:none;"></div>

<div class="topbar">
  <div class="topbar-inner">
    <span class="topbar-left">Denpasar, Bali Indonesia &nbsp;|&nbsp; <a href="mailto:info@denpasarinstitute.id">info@denpasarinstitute.id</a></span>
    <div class="topbar-right">
      <div class="topbar-social">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>
  </div>
</div>

<header>
  <div class="header-inner">

    <ul class="nav-left">
      <li>
        <a href="{{ route('home') }}"
           class="{{ request()->routeIs('home') ? 'active' : '' }}">
          Home
        </a>
      </li>
      <li class="has-dropdown">
        <a href="{{ route('home') }}#divisi-detail"
           class="{{ request()->routeIs('divisi.*') ? 'active' : '' }}">
          Divisi
        </a>
        <ul class="dropdown-menu">
          @php
              $allDivisi = \App\Models\Divisi::where('is_active', true)->orderBy('urutan', 'asc')->get();
          @endphp
          @foreach($allDivisi as $d)
            <li>
              <a href="/divisi/{{ $d->slug }}">{{ $d->nama }}</a>
            </li>
          @endforeach
        </ul>
      </li>
      <li>
        <a href="{{ route('konsultan.index') }}"
           class="{{ request()->routeIs('konsultan.*') ? 'active' : '' }}">
          Konsultan
        </a>
      </li>
      <li>
        <a href="{{ route('grcs.index') }}"
           class="{{ request()->routeIs('grcs.*') ? 'active' : '' }}">
          GRCS Club
        </a>
      </li>
    </ul>

    <div class="nav-logo-center">
      <img src="/image/logo_DI.png" alt="Denpasar Institute"
        onerror="this.style.display='none';this.parentElement.innerHTML='<span style=\'font-size:1.1rem;font-weight:800;color:var(--red)\'>DI</span>'">
    </div>

    <ul class="nav-right">
      <li>
        <a href="{{ route('bursa-sdm.index') }}"
           class="{{ request()->routeIs('bursa-sdm.*') ? 'active' : '' }}">
          Bursa SDM
        </a>
      </li>
      <li>
        <a href="{{ route('event.index') }}"
           class="{{ request()->routeIs('event.*') ? 'active' : '' }}">
          Event
        </a>
      </li>
      <li>
        <a href="{{ route('berita.index') }}"
           class="{{ request()->routeIs('berita.*') ? 'active' : '' }}">
          Berita
        </a>
      </li>
      <li>
        <select class="lang-select" id="langSelectDesktop" onchange="changeLanguage(this.value)">
          <option value="">🌐 Bahasa</option>
          <option value="id">🇮🇩 Indonesia</option>
          <option value="en">🇬🇧 English</option>
          <option value="de">🇩🇪 Deutsch</option>
          <option value="it">🇮🇹 Italiano</option>
          <option value="hi">🇮🇳 हिन्दी</option>
          <option value="ja">🇯🇵 日本語</option>
          <option value="ko">🇰🇷 한국어</option>
          <option value="zh-CN">🇨🇳 中文</option>
          <option value="ar">🇸🇦 العربية</option>
          <option value="fr">🇫🇷 Français</option>
          <option value="es">🇪🇸 Español</option>
          <option value="ru">🇷🇺 Русский</option>
          <option value="nl">🇳🇱 Nederlands</option>
          <option value="th">🇹🇭 ไทย</option>
          <option value="vi">🇻🇳 Tiếng Việt</option>
          <option value="ms">🇲🇾 Bahasa Melayu</option>
          <option value="pt">🇵🇹 Português</option>
        </select>
      </li>
    </ul>

    <button class="hamburger-btn" id="hamburgerBtn" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>

<div class="menu-backdrop" id="menuBackdrop"></div>

<div class="mobile-menu" id="mobileMenu">
  <ul class="mobile-nav">
    <li>
      <a href="{{ route('home') }}"
         class="{{ request()->routeIs('home') ? 'active' : '' }}">
        Home
      </a>
    </li>
    <li>
      <a href="{{ route('home') }}#divisi-detail"
         class="{{ request()->routeIs('divisi.*') ? 'active' : '' }}">
        Divisi
      </a>
    </li>
    <ul class="mobile-nav-sub">
      @php
          $allDivisi = \App\Models\Divisi::where('is_active', true)->orderBy('urutan', 'asc')->get();
      @endphp
      @foreach($allDivisi as $d)
        <li><a href="/divisi/{{ $d->slug }}">{{ $d->nama }}</a></li>
      @endforeach
    </ul>
    <li>
      <a href="{{ route('konsultan.index') }}"
         class="{{ request()->routeIs('konsultan.*') ? 'active' : '' }}">
        Konsultan
      </a>
    </li>
    <li>
      <a href="{{ route('grcs.index') }}"
         class="{{ request()->routeIs('grcs.*') ? 'active' : '' }}">
        GRCS Club
      </a>
    </li>
    <li>
      <a href="{{ route('bursa-sdm.index') }}"
         class="{{ request()->routeIs('bursa-sdm.*') ? 'active' : '' }}">
        Bursa SDM
      </a>
    </li>
    <li>
      <a href="{{ route('event.index') }}"
         class="{{ request()->routeIs('event.*') ? 'active' : '' }}">
        Event
      </a>
    </li>
    <li>
      <a href="{{ route('berita.index') }}"
         class="{{ request()->routeIs('berita.*') ? 'active' : '' }}">
        Berita
      </a>
    </li>
    <li class="mobile-lang-wrap">
      <select class="lang-select" id="langSelectMobile" onchange="changeLanguage(this.value)">
        <option value="">🌐 Pilih Bahasa</option>
        <option value="id">🇮🇩 Indonesia</option>
        <option value="en">🇬🇧 English</option>
        <option value="de">🇩🇪 Deutsch</option>
        <option value="it">🇮🇹 Italiano</option>
        <option value="hi">🇮🇳 हिन्दी</option>
        <option value="ja">🇯🇵 日本語</option>
        <option value="ko">🇰🇷 한국어</option>
        <option value="zh-CN">🇨🇳 中文</option>
        <option value="ar">🇸🇦 العربية</option>
        <option value="fr">🇫🇷 Français</option>
        <option value="es">🇪🇸 Español</option>
        <option value="ru">🇷🇺 Русский</option>
        <option value="nl">🇳🇱 Nederlands</option>
        <option value="th">🇹🇭 ไทย</option>
        <option value="vi">🇻🇳 Tiếng Việt</option>
        <option value="ms">🇲🇾 Bahasa Melayu</option>
        <option value="pt">🇵🇹 Português</option>
      </select>
    </li>
  </ul>
</div>

@yield('content')

<footer>
  <div class="footer-grid">
    <div>
      <div class="footer-logo-name">Denpasar Institute</div>
      <p class="footer-desc">Lembaga Penelitian &amp; Pengembangan SDM yang berkomitmen pada inovasi, kolaborasi, dan kemajuan sumber daya manusia Indonesia.</p>
      <div class="footer-social">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>
    <div class="footer-col">
      <h4>Divisi Kami</h4>
      <ul class="footer-links">
        @foreach($allDivisi as $d)
          <li><a href="/divisi/{{ $d->slug }}">{{ $d->nama }}</a></li>
        @endforeach
      </ul>
    </div>
    <div class="footer-col">
      <h4>Komunitas</h4>
      <ul class="footer-links">
        <li><a href="{{ route('grcs.index') }}">GRCS Club</a></li>
        <li><a href="{{ route('konsultan.index') }}">Konsultan</a></li>
        <li><a href="{{ route('bursa-sdm.index') }}">Bursa SDM</a></li>
        <li><a href="{{ route('event.index') }}">News &amp; Event</a></li>
        <li><a href="{{ route('berita.index') }}">Berita &amp; Opini</a></li>
        <li><a href="{{ route('home') }}#news">Research Sharing</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Kontak</h4>
      <div class="footer-contact-item"><i class="fas fa-map-marker-alt"></i><span>Denpasar, Bali - Indonesia</span></div>
      <div class="footer-contact-item"><i class="fas fa-envelope"></i><span>info@denpasarinstitute.id</span></div>
      <div class="footer-contact-item"><i class="fab fa-whatsapp"></i><span>+62 878-653-9966</span></div>
    </div>
  </div>
  <div class="footer-bottom-bar">
    <p>© {{ date('Y') }} Denpasar Institute. Hak cipta dilindungi undang-undang.</p>
    <div style="display:flex;gap:16px;">
      <a href="#">Kebijakan Privasi</a>
      <a href="#">Syarat &amp; Ketentuan</a>
    </div>
  </div>
</footer>

<div class="contact-widget" id="contactWidget">
  <div class="cw-menu" id="cwMenu">
    <a href="https://wa.me/6287865309966" class="cw-item" target="_blank" rel="noopener noreferrer">
      <span class="cw-item-icon cw-wa-color"><i class="fab fa-whatsapp"></i></span>
      <span class="cw-item-label">Admin Sekretariat</span>
    </a>
    <a href="mailto:info@denpasarinstitute.com" class="cw-item">
      <span class="cw-item-icon cw-email-color"><i class="fas fa-envelope"></i></span>
      <span class="cw-item-label">Email</span>
    </a>
    <a href="https://wa.me/6281337644463" class="cw-item" target="_blank" rel="noopener noreferrer">
      <span class="cw-item-icon cw-wa-color"><i class="fab fa-whatsapp"></i></span>
      <span class="cw-item-label">Lead Consultant</span>
    </a>
    <a href="{{ route('admission.create') }}" class="cw-item">
      <span class="cw-item-icon cw-admission-color"><i class="fas fa-graduation-cap"></i></span>
      <span class="cw-item-label">Admission</span>
    </a>
  </div>
  <button class="cw-toggle" id="cwToggle" aria-label="Contact us" aria-expanded="false">
    <span class="cw-icon-wrap" id="cwIconWrap"><i class="fas fa-comment-dots" id="cwIcon"></i></span>
    <span class="cw-label" id="cwLabel">Contact us</span>
  </button>
</div>
<button id="backToTop"><i class="fas fa-arrow-up"></i></button>

<script type="text/javascript">
// Google Translate Configuration
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'id',
    includedLanguages: 'id,en,de,it,hi,ja,ko,zh-CN,ar,fr,es,ru,nl,th,vi,ms,pt',
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
    autoDisplay: false,
    multilanguagePage: true
  }, 'google_translate_element');
}

// Load Google Translate Script
function loadGoogleTranslateScript() {
  // Check if script is already loaded
  if (document.querySelector('script[src*="translate.google.com"]')) {
    return true;
  }
  
  var script = document.createElement('script');
  script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
  script.async = true;
  script.defer = true;
  script.id = 'google-translate-script';
  
  return new Promise((resolve, reject) => {
    script.onload = resolve;
    script.onerror = reject;
    document.head.appendChild(script);
  });
}

// Change Language Function
async function changeLanguage(langCode) {
  const desktopSelect = document.getElementById('langSelectDesktop');
  const mobileSelect = document.getElementById('langSelectMobile');
  
  // If empty or Indonesian, reset to original
  if (!langCode || langCode === '' || langCode === 'id') {
    // Reset translation
    localStorage.removeItem('google_translate_lang');
    
    // Try to reset Google Translate
    const frame = document.querySelector('iframe.goog-te-banner-frame');
    if (frame) {
      const resetButton = frame.contentDocument?.querySelector('.goog-te-menu-value span');
      if (resetButton) {
        resetButton.textContent = 'Select Language';
      }
    }
    
    // Reload page to reset
    window.location.reload();
    return;
  }

  // Save language preference
  localStorage.setItem('google_translate_lang', langCode);
  
  // Sync both select elements
  if (desktopSelect) desktopSelect.value = langCode;
  if (mobileSelect) mobileSelect.value = langCode;

  try {
    // Load Google Translate script if not loaded
    await loadGoogleTranslateScript();
    
    // Wait for Google Translate to initialize
    await waitForGoogleTranslate();
    
    // Trigger translation
    await triggerGoogleTranslate(langCode);
    
  } catch (error) {
    console.error('Translation error:', error);
    // Fallback: reload page with language cookie
    document.cookie = `googtrans=/id/${langCode}; path=/; max-age=31536000`;
    window.location.reload();
  }
}

// Wait for Google Translate to be ready
function waitForGoogleTranslate() {
  return new Promise((resolve) => {
    let attempts = 0;
    const maxAttempts = 20;
    
    const checkInterval = setInterval(() => {
      attempts++;
      
      const translateElement = document.querySelector('#google_translate_element select');
      const comboBox = document.querySelector('.goog-te-combo');
      
      if (translateElement || comboBox || attempts >= maxAttempts) {
        clearInterval(checkInterval);
        resolve();
      }
    }, 500);
  });
}

// Trigger Google Translate
async function triggerGoogleTranslate(langCode) {
  return new Promise((resolve) => {
    let attempts = 0;
    const maxAttempts = 10;
    
    const tryTranslate = () => {
      attempts++;
      
      // Try to find the Google Translate combo box
      const comboBox = document.querySelector('.goog-te-combo');
      
      if (comboBox) {
        // Set the language
        comboBox.value = langCode;
        
        // Dispatch change event
        const event = new Event('change', { bubbles: true });
        comboBox.dispatchEvent(event);
        
        // Also try to trigger via the Google Translate API
        if (typeof google !== 'undefined' && google.translate) {
          google.translate.TranslateElement().setLanguage(langCode);
        }
        
        resolve();
      } else if (attempts < maxAttempts) {
        // Retry after delay
        setTimeout(tryTranslate, 500);
      } else {
        // Last resort: use cookie method
        document.cookie = `googtrans=/id/${langCode}; path=/; max-age=31536000`;
        window.location.reload();
        resolve();
      }
    };
    
    tryTranslate();
  });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', async function() {
  // Load Google Translate script
  try {
    await loadGoogleTranslateScript();
  } catch (error) {
    console.warn('Google Translate script failed to load:', error);
  }
  
  // Check for saved language preference
  const savedLang = localStorage.getItem('google_translate_lang');
  
  if (savedLang && savedLang !== 'id') {
    setTimeout(async () => {
      await changeLanguage(savedLang);
    }, 2000);
  }
});

// Listen for Google Translate changes
document.addEventListener('DOMContentLoaded', function() {
  // Observer for Google Translate combo box
  const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
      if (mutation.type === 'childList') {
        const comboBox = document.querySelector('.goog-te-combo');
        if (comboBox) {
          comboBox.addEventListener('change', function() {
            const selectedLang = this.value;
            if (selectedLang) {
              localStorage.setItem('google_translate_lang', selectedLang);
              
              // Sync with our custom selects
              const desktopSelect = document.getElementById('langSelectDesktop');
              const mobileSelect = document.getElementById('langSelectMobile');
              
              if (desktopSelect) desktopSelect.value = selectedLang;
              if (mobileSelect) mobileSelect.value = selectedLang;
            }
          });
        }
      }
    });
  });
  
  observer.observe(document.body, { childList: true, subtree: true });
});

// Mobile menu toggle
document.addEventListener('click', function(e) {
  var hamburgerBtn = e.target.closest('.hamburger-btn');
  if (hamburgerBtn) {
    var mobileMenu = document.getElementById('mobileMenu');
    var backdrop = document.getElementById('menuBackdrop');

    hamburgerBtn.classList.toggle('is-active');
    mobileMenu.classList.toggle('is-active');
    backdrop.classList.toggle('is-active');
  }
});

// Close mobile menu on backdrop click
var backdrop = document.getElementById('menuBackdrop');
if (backdrop) {
  backdrop.addEventListener('click', function() {
    var hamburger = document.getElementById('hamburgerBtn');
    var mobileMenu = document.getElementById('mobileMenu');

    hamburger.classList.remove('is-active');
    mobileMenu.classList.remove('is-active');
    backdrop.classList.remove('is-active');
  });
}

// Back to top button
var btt = document.getElementById('backToTop');
if (btt) {
  var scrollTimeout;
  window.addEventListener('scroll', function() {
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(function() {
      btt.classList.toggle('show', window.scrollY > 300);
    }, 100);
  }, { passive: true });

  btt.addEventListener('click', function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

// Contact widget
(function() {
  var widget = document.getElementById('contactWidget');
  var toggleBtn = document.getElementById('cwToggle');
  var iconWrap = document.getElementById('cwIconWrap');
  var iconEl = document.getElementById('cwIcon');
  var labelEl = document.getElementById('cwLabel');
  var menuEl = document.getElementById('cwMenu');
  if (!widget || !toggleBtn) return;

  var states = [
    { icon: 'fa-comment-dots', label: 'Contact us', wide: true,  duration: 4000 },
    { icon: 'fa-whatsapp',     label: 'Contact us', wide: false, duration: 2000, brand: true },
    { icon: 'fa-envelope',     label: 'Contact us', wide: false, duration: 2000 },
    { icon: 'fa-graduation-cap', label: 'Contact us', wide: false, duration: 2000 }
  ];
  var stateIndex = 0;
  var cycleTimer = null;
  var isOpen = false;

  function applyState(i) {
    var s = states[i];

    iconEl.classList.add('cw-icon-leaving');
    setTimeout(function() {
      iconEl.className = 'fa ' + (s.brand ? 'fab' : 'fas') + ' ' + s.icon + ' cw-icon-entering';
      iconEl.id = 'cwIcon';
      void iconEl.offsetWidth;
      iconEl.classList.remove('cw-icon-entering');
    }, 180);

    toggleBtn.classList.toggle('cw-wide', !!s.wide);
  }

  function scheduleNext() {
    clearTimeout(cycleTimer);
    if (isOpen) return;
    var s = states[stateIndex];
    cycleTimer = setTimeout(function() {
      stateIndex = (stateIndex + 1) % states.length;
      applyState(stateIndex);
      scheduleNext();
    }, s.duration);
  }

  applyState(stateIndex);
  scheduleNext();

  toggleBtn.addEventListener('click', function() {
    isOpen = !isOpen;
    widget.classList.toggle('cw-open', isOpen);
    toggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    toggleBtn.classList.toggle('cw-open', isOpen);

    if (isOpen) {
      clearTimeout(cycleTimer);
      toggleBtn.classList.remove('cw-wide');
      iconEl.className = 'fas fa-times';
    } else {
      stateIndex = 0;
      applyState(stateIndex);
      scheduleNext();
    }
  });

  document.addEventListener('click', function(e) {
    if (isOpen && !widget.contains(e.target)) {
      isOpen = false;
      widget.classList.remove('cw-open');
      toggleBtn.classList.remove('cw-open');
      toggleBtn.setAttribute('aria-expanded', 'false');
      stateIndex = 0;
      applyState(stateIndex);
      scheduleNext();
    }
  });
})();
</script>

<script>
/**
 * Menonaktifkan zoom in / zoom out agar tampilan website tetap diam dan presisi:
 * 1. Mencegah Ctrl + Mouse Wheel (zoom scroll)
 * 2. Mencegah Shortcut Keyboard (Ctrl +, Ctrl -, Ctrl 0)
 * 3. Mencegah Gesture Pinch pada Trackpad & Layar Sentuh / Safari iOS
 * 4. Mencegah Double Tap Zoom pada Mobile
 */
(function() {
  // Cegah Ctrl + Scroll Wheel (Mouse & Trackpad Desktop)
  window.addEventListener('wheel', function(e) {
    if (e.ctrlKey) {
      e.preventDefault();
    }
  }, { passive: false });

  // Cegah tombol kombinasi keyboard: Ctrl +, Ctrl -, Ctrl 0, Ctrl =
  window.addEventListener('keydown', function(e) {
    if (e.ctrlKey && (
      e.key === '+' || 
      e.key === '-' || 
      e.key === '=' || 
      e.key === '_' || 
      e.key === '0' || 
      e.keyCode === 187 || 
      e.keyCode === 189 || 
      e.keyCode === 107 || 
      e.keyCode === 109 || 
      e.keyCode === 96 || 
      e.keyCode === 48
    )) {
      e.preventDefault();
    }
  });

  // Cegah gesture pinch zoom di Safari iOS & macOS trackpad
  document.addEventListener('gesturestart', function(e) {
    e.preventDefault();
  });
  document.addEventListener('gesturechange', function(e) {
    e.preventDefault();
  });
  document.addEventListener('gestureend', function(e) {
    e.preventDefault();
  });

  // Cegah multi-touch pinch di layar smartphone/tablet
  document.addEventListener('touchstart', function(e) {
    if (e.touches && e.touches.length > 1) {
      e.preventDefault();
    }
  }, { passive: false });

  // Cegah double-tap to zoom pada perangkat mobile
  var lastTouchEnd = 0;
  document.addEventListener('touchend', function(e) {
    var now = Date.now();
    if (now - lastTouchEnd <= 300) {
      e.preventDefault();
    }
    lastTouchEnd = now;
  }, false);
})();
</script>

<script>
// Sesuaikan posisi logo saat scroll agar selalu utuh & tidak terpotong saat sticky header aktif
(function() {
  var headerEl = document.querySelector('header');
  if (!headerEl) return;
  function updateHeaderOnScroll() {
    headerEl.classList.toggle('is-scrolled', window.scrollY > 20);
  }
  window.addEventListener('scroll', updateHeaderOnScroll, { passive: true });
  updateHeaderOnScroll();
})();
</script>

@stack('scripts')
</body>
</html>