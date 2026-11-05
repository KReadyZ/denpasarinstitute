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
    body { margin: 0; font-family: "Poppins", sans-serif; background: #fff; color: var(--text); font-size: 15.5px; }
    a { text-decoration: none; }
    img { display: block; }

    /* Google Translate Banner & Element Suppression */
    .goog-te-banner-frame,
    .goog-te-banner-frame.skiptranslate,
    iframe.goog-te-banner-frame,
    iframe.skiptranslate,
    iframe[id*=":1.container"],
    iframe[id*=":2.container"],
    iframe[id*="container"],
    .VIpgJd-ZVi9od-ORHb-OEVmcd,
    .VIpgJd-ZVi9od-aZ2wEe-wOHMyf,
    .VIpgJd-ZVi9od-aZ2wEe-OiiCO,
    .VIpgJd-ZVi9od-xl07Ob-OEVmcd {
      display: none !important;
      visibility: hidden !important;
      height: 0 !important;
      width: 0 !important;
      max-height: 0 !important;
      opacity: 0 !important;
      pointer-events: none !important;
      border: 0 !important;
    }
    html { top: 0px !important; margin-top: 0px !important; scroll-behavior: smooth; scroll-padding-top: 110px; overflow-x: hidden; }
    body { top: 0px !important; position: static !important; margin-top: 0px !important; overflow-x: hidden; }
    .goog-text-highlight { background: none !important; background-color: transparent !important; border: none !important; box-shadow: none !important; }
    .goog-tooltip, #goog-gt-tt, .goog-te-balloon-frame { display: none !important; visibility: hidden !important; }
    .goog-tooltip:hover { display: none !important; }
    font { background: transparent !important; }

    .topbar { background: var(--red); color: #fff; font-size: 0.85rem; padding: 7px 0; }
    .topbar-inner { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 6px; }
    .topbar a { color: #fff; opacity: 0.9; }
    .topbar a:hover { opacity: 1; text-decoration: underline; }
    .topbar-right { display: flex; align-items: center; gap: 12px; }
    .topbar-portal-link { background: rgba(255, 255, 255, 0.2); padding: 3px 10px; border-radius: 4px; font-weight: 600; font-size: 0.8rem; color: #fff !important; text-decoration: none !important; display: inline-flex; align-items: center; gap: 5px; transition: background 0.2s; }
    .topbar-portal-link:hover { background: rgba(255, 255, 255, 0.35); text-decoration: none !important; }
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
      top: -44px;
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
      height: 255px;
      width: auto;
      transform: scaleX(1.15);
      transform-origin: center center;
      filter: drop-shadow(0 6px 16px rgba(0,0,0,0.3));
      pointer-events: none;
      user-select: none;
      -webkit-user-drag: none;
      cursor: default;
      transition: height 0.25s cubic-bezier(0.4, 0, 0.2, 1), transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    header.is-scrolled .nav-logo-center img {
      height: 120px;
      transform: scaleX(1.12);
    }
    .nav-left, .nav-right {
      display: flex; align-items: center; gap: 2px;
      list-style: none; margin: 0; padding: 0;
    }
    .nav-left { flex: 1; justify-content: flex-start; }
    .nav-right { flex: 1; justify-content: flex-end; }
    .nav-left li, .nav-right li { position: relative; }
    .nav-left a, .nav-right a {
      color: var(--dark); font-weight: 500; font-size: 0.92rem; font-weight: 600;
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
      padding: 8px 16px; font-size: 0.88rem; color: var(--dark);
      font-weight: 500; border-radius: 0;
      transition: background 0.15s, color 0.15s;
    }
    .dropdown-menu a:hover { background: #fff5f5; color: var(--red); }
    .dropdown-menu a::after { display: none !important; }
    .dropdown-menu a i { width: 16px; text-align: center; color: var(--red); font-size: 0.78rem; flex-shrink: 0; }
    .dropdown-divider { height: 1px; background: var(--border); margin: 4px 0; }
    
    .lang-select {
      font-family: Poppins, sans-serif; font-size: 0.88rem; font-weight: 500;
      border: 1px solid var(--border); border-radius: 4px; padding: 6px 10px;
      color: var(--dark); background: #fff; cursor: pointer; outline: none;
      transition: border-color 0.2s;
      max-height: 350px;
      overflow-y: auto;
      min-width: 160px;
    }
    .lang-select:hover, .lang-select:focus { border-color: var(--red); }
    .lang-select option { padding: 4px 8px; }

    /* Custom Language Dropdown with Real Country Flags (CLICK-ONLY, NO HOVER) */
    .custom-lang-dropdown {
      position: relative;
      display: inline-flex;
      align-items: center;
    }
    .lang-trigger-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #ffffff;
      border: 1.5px solid #e2e8f0;
      border-radius: 20px;
      padding: 6px 13px;
      color: var(--dark);
      font-family: 'Poppins', sans-serif;
      font-size: 0.86rem;
      font-weight: 600;
      cursor: pointer;
      outline: none;
      transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
      user-select: none;
      line-height: 1;
    }
    .lang-trigger-btn:hover {
      border-color: #cbd5e1;
      background: #f8fafc;
    }
    .custom-lang-dropdown.is-open .lang-trigger-btn {
      border-color: var(--red) !important;
      background: #fff8f8 !important;
      box-shadow: 0 0 0 3px rgba(204, 0, 0, 0.12) !important;
    }
    .lang-flag-img {
      width: 22px;
      height: 15px;
      object-fit: cover;
      border-radius: 3px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.18);
      border: 1px solid rgba(0,0,0,0.08);
      display: inline-block;
      vertical-align: middle;
      flex-shrink: 0;
    }
    .lang-name-text {
      color: var(--dark);
      font-weight: 600;
      letter-spacing: 0.2px;
      display: flex;
      align-items: center;
      gap: 4px;
    }
    .lang-trigger-btn .lang-chevron {
      font-size: 0.65rem;
      color: #64748b;
      transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
      margin-left: 2px;
    }
    .custom-lang-dropdown.is-open .lang-trigger-btn .lang-chevron {
      transform: rotate(180deg);
      color: var(--red);
    }

    /* Dropdown Menu - STRICTLY CLICK-TRIGGERED, ZERO HOVER FLICKER */
    .custom-lang-dropdown .lang-dropdown-menu {
      position: absolute;
      top: calc(100% + 10px);
      right: 0;
      width: 320px;
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-top: 3.5px solid var(--red);
      border-radius: 12px;
      box-shadow: 0 18px 45px -4px rgba(0, 0, 0, 0.18), 0 4px 12px rgba(0, 0, 0, 0.06);
      z-index: 2500;
      display: flex;
      flex-direction: column;
      opacity: 0;
      visibility: hidden;
      pointer-events: none;
      transform: translateY(12px) scale(0.97);
      transform-origin: top right;
      transition: opacity 0.2s cubic-bezier(0.16, 1, 0.3, 1),
                  transform 0.2s cubic-bezier(0.16, 1, 0.3, 1),
                  visibility 0.2s cubic-bezier(0.16, 1, 0.3, 1);
      overflow: hidden;
    }
    .custom-lang-dropdown.is-open .lang-dropdown-menu {
      opacity: 1;
      visibility: visible;
      pointer-events: auto;
      transform: translateY(0) scale(1);
    }

    .lang-dropdown-header {
      padding: 11px 16px 9px;
      border-bottom: 1px solid #f1f5f9;
      font-size: 0.78rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.6px;
      color: #64748b;
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: #f8fafc;
    }
    .lang-header-title {
      display: flex;
      align-items: center;
      gap: 7px;
      color: #1e293b;
    }
    .lang-header-title i {
      color: var(--red);
      font-size: 0.9rem;
    }
    .lang-header-count {
      font-size: 0.7rem;
      background: rgba(204, 0, 0, 0.08);
      color: var(--red);
      padding: 2px 8px;
      border-radius: 12px;
      font-weight: 700;
    }

    .lang-search-wrap {
      padding: 8px 12px;
      background: #ffffff;
      border-bottom: 1px solid #f1f5f9;
      position: relative;
    }
    .lang-search-icon {
      position: absolute;
      left: 22px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 0.78rem;
      color: #94a3b8;
      pointer-events: none;
    }
    .lang-search-input {
      width: 100%;
      padding: 7px 10px 7px 32px;
      font-size: 0.82rem;
      border: 1px solid #cbd5e1;
      border-radius: 6px;
      outline: none;
      font-family: 'Poppins', sans-serif;
      background: #f8fafc;
      transition: all 0.2s;
    }
    .lang-search-input:focus {
      background: #fff;
      border-color: var(--red);
      box-shadow: 0 0 0 2.5px rgba(204, 0, 0, 0.12);
    }

    .lang-dropdown-list {
      overflow-y: auto;
      max-height: 310px;
      padding: 4px 0;
      margin: 0;
      list-style: none;
    }
    .lang-dropdown-list::-webkit-scrollbar { width: 5px; }
    .lang-dropdown-list::-webkit-scrollbar-track { background: #f8fafc; }
    .lang-dropdown-list::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .lang-dropdown-list::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    .lang-opt-item {
      width: 100%;
      display: flex;
      align-items: center;
      gap: 11px;
      padding: 8px 14px;
      background: transparent;
      border: none;
      border-bottom: 1px solid #f8fafc;
      color: #1e293b;
      font-family: 'Poppins', sans-serif;
      font-size: 0.84rem;
      font-weight: 500;
      text-align: left;
      cursor: pointer;
      transition: background 0.15s, color 0.15s;
    }
    .lang-opt-item:last-child { border-bottom: none; }
    .lang-opt-item:hover { background: #fff5f5; color: var(--red); }
    .lang-opt-info {
      flex: 1;
      display: flex;
      flex-direction: column;
      line-height: 1.25;
      overflow: hidden;
    }
    .lang-opt-name {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      font-weight: 500;
    }
    .lang-opt-native-sub {
      font-size: 0.71rem;
      color: #64748b;
    }
    .lang-opt-native-badge {
      font-size: 0.72rem;
      color: #94a3b8;
      font-weight: 600;
      background: #f1f5f9;
      padding: 2px 6px;
      border-radius: 4px;
    }
    .lang-opt-item.is-selected {
      background: #fff1f1;
      color: var(--red);
      font-weight: 700;
    }
    .lang-opt-item.is-selected .lang-opt-name { font-weight: 700; color: var(--red); }
    .lang-opt-item.is-selected .lang-opt-native-badge {
      background: #ffe4e6;
      color: var(--red);
    }
    .lang-opt-check {
      color: var(--red);
      font-size: 0.78rem;
      opacity: 0;
      transition: opacity 0.15s;
    }
    .lang-opt-item.is-selected .lang-opt-check { opacity: 1; }

    .lang-empty-msg {
      padding: 24px 16px;
      text-align: center;
      color: #94a3b8;
      font-size: 0.84rem;
    }
    .lang-empty-msg i {
      font-size: 1.3rem;
      margin-bottom: 6px;
      display: block;
      color: #cbd5e1;
    }

    .lang-text-full { display: inline; }
    .lang-text-short { display: none; }
    @media (max-width: 1080px) and (min-width: 769px) {
      .lang-text-full { display: none; }
      .lang-text-short { display: inline; }
      .lang-trigger-btn { padding: 4px 9px; font-size: 0.78rem; gap: 5px; }
      .lang-flag-img { width: 18px; height: 13px; }
      .lang-dropdown-menu { width: 270px; }
    }

    /* Mobile Language Switcher Styles (CLICK-ONLY) */
    .mobile-lang-wrap {
      padding: 16px 0 12px;
      border-top: 1px solid #f1f5f9;
      margin-top: 8px;
    }
    .mobile-lang-title {
      font-size: 0.78rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.6px;
      color: #64748b;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .mobile-lang-trigger {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 14px;
      background: #f8fafc;
      border: 1.5px solid #e2e8f0;
      border-radius: 8px;
      font-family: 'Poppins', sans-serif;
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--dark);
      cursor: pointer;
      transition: all 0.2s;
    }
    .mobile-lang-trigger:hover,
    .mobile-lang-trigger.is-open {
      border-color: var(--red);
      background: #fff8f8;
    }
    .mobile-lang-trigger-left {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .mobile-lang-chevron {
      font-size: 0.75rem;
      color: #64748b;
      transition: transform 0.25s;
    }
    .mobile-lang-trigger.is-open .mobile-lang-chevron {
      transform: rotate(180deg);
      color: var(--red);
    }
    .mobile-lang-list {
      margin-top: 8px;
      background: #ffffff;
      border: 1.5px solid #e2e8f0;
      border-radius: 8px;
      max-height: 270px;
      overflow-y: auto;
      display: none;
      box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }
    .mobile-lang-list.is-open {
      display: block;
    }
    .mobile-lang-opt {
      width: 100%;
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 12px;
      background: transparent;
      border: none;
      border-bottom: 1px solid #f1f5f9;
      font-family: 'Poppins', sans-serif;
      font-size: 0.86rem;
      color: #334155;
      text-align: left;
      cursor: pointer;
    }
    .mobile-lang-opt:last-child {
      border-bottom: none;
    }
    .mobile-lang-opt:hover {
      background: #fff5f5;
      color: var(--red);
    }
    .mobile-lang-opt.is-selected {
      background: #fff1f1;
      color: var(--red);
      font-weight: 700;
    }

    .hamburger-btn { display: none; flex-direction: column; justify-content: center; gap: 5px; cursor: pointer; z-index: 1400; padding: 4px; flex-shrink: 0; background: none; border: none; outline: none; position: absolute; right: 20px; }
    .hamburger-btn span { display: block; width: 26px; height: 3px; background: var(--red); border-radius: 3px; transition: all 0.35s ease; transform-origin: center; }
    .hamburger-btn.is-active span:nth-child(1) { transform: translateY(8px) rotate(45deg); }
    .hamburger-btn.is-active span:nth-child(2) { opacity: 0; transform: scaleX(0); }
    .hamburger-btn.is-active span:nth-child(3) { transform: translateY(-8px) rotate(-45deg); }
    .menu-backdrop { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.55); z-index: 1200; opacity: 0; transition: opacity 0.35s; }
    .menu-backdrop.is-active { display: block; opacity: 1; }
    .mobile-menu { position: fixed; top: 0; right: -100%; width: 80%; max-width: 320px; height: 100vh; background: #fff; padding: 72px 24px 32px; transition: right 0.38s cubic-bezier(0.4,0,0.2,1); z-index: 1300; overflow-y: auto; box-sizing: border-box; display: flex; flex-direction: column; gap: 0; border-left: 4px solid var(--red); }
    .mobile-menu.is-active { right: 0; }
    .mobile-nav { list-style: none; padding: 0; margin: 0; }
    .mobile-nav li { border-bottom: 1px solid #eee; }
    .mobile-nav a { display: block; color: var(--dark); font-size: 16px; font-weight: 600; text-decoration: none; padding: 12px 0; transition: color 0.2s, padding-left 0.2s; }
    .mobile-nav a:hover { color: var(--red); padding-left: 8px; }
    .mobile-nav a.active { color: var(--red); font-weight: 700; }
    .mobile-nav-sub { padding-left: 16px; list-style: none; }
    .mobile-nav-sub a { font-size: 14.5px; font-weight: 400; }

    @media (max-width: 991px) and (min-width: 769px) {
      .nav-left a, .nav-right a {
        font-size: 0.74rem;
        padding: 5px 6px;
      }
      .nav-logo-center {
        top: -43px;
      }
      .nav-logo-center img {
        height: 185px;
        transform: scaleX(1.14);
      }
      header.is-scrolled .nav-logo-center {
        top: -5px;
      }
      header.is-scrolled .nav-logo-center img {
        height: 100px;
        transform: scaleX(1.12);
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
        transform: scaleX(1.1) !important;
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
    .footer-logo-name { font-size: 1.3rem; font-weight: 800; color: var(--yellow); margin-bottom: 10px; }
    .footer-desc { font-size: 0.9rem; line-height: 1.7; color: rgba(255,255,255,0.6); margin-bottom: 16px; }
    .footer-social { display: flex; gap: 10px; }
    .footer-social a { width: 34px; height: 34px; border-radius: 50%; background: rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.84rem; transition: 0.2s; }
    .footer-social a:hover { background: var(--red); }
    .footer-col h4 { font-size: 0.98rem; font-weight: 700; color: #fff; margin-bottom: 14px; padding-bottom: 8px; border-bottom: 2px solid var(--red); }
    .footer-links { list-style: none; padding: 0; margin: 0; }
    .footer-links li { margin-bottom: 7px; }
    .footer-links a { color: rgba(255,255,255,0.6); font-size: 0.9rem; transition: 0.2s; }
    .footer-links a:hover { color: var(--yellow); padding-left: 4px; }
    .footer-contact-item { display: flex; gap: 10px; align-items: flex-start; margin-bottom: 10px; }
    .footer-contact-item i { color: var(--yellow); font-size: 0.84rem; margin-top: 3px; flex-shrink: 0; }
    .footer-contact-item span, .footer-contact-item a { font-size: 0.9rem; color: rgba(255,255,255,0.6); line-height: 1.5; text-decoration: none; transition: color 0.2s; }
    .footer-contact-item a:hover { color: var(--yellow); }
    .footer-bottom-bar { border-top: 1px solid rgba(255,255,255,0.08); margin-top: 40px; padding: 16px 20px; max-width: 1200px; margin-left: auto; margin-right: auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
    .footer-bottom-bar p { font-size: 0.84rem; color: rgba(255,255,255,0.4); margin: 0; }
    .footer-bottom-bar a { font-size: 0.84rem; color: rgba(255,255,255,0.4); }
    .footer-bottom-bar a:hover { color: var(--yellow); }

    #backToTop { position: fixed; bottom: 28px; right: 28px; background: var(--red); color: #fff; border: none; width: 42px; height: 42px; border-radius: 50%; font-size: 1rem; cursor: pointer; opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 500; display: flex; align-items: center; justify-content: center; }
    #backToTop.show { opacity: 1; visibility: visible; }
    #backToTop:hover { background: #a80000; transform: translateY(-3px); }
    .contact-widget { position: fixed; bottom: 28px; right: 78px; z-index: 500; display: flex; flex-direction: column; align-items: flex-end; }
    .cw-toggle {
      position: relative;
      display: inline-flex; align-items: center; justify-content: flex-start;
      height: 44px; width: 44px;
      padding: 0;
      background: #25d366; color: #fff; border: none; border-radius: 44px;
      cursor: pointer; box-shadow: 0 4px 14px rgba(37,211,102,0.4);
      transition: width 0.38s cubic-bezier(.4,0,.2,1), background 0.25s, transform 0.25s, box-shadow 0.25s;
      overflow: hidden;
      font-family: 'Poppins', sans-serif;
    }
    .cw-toggle:hover { transform: translateY(-3px); box-shadow: 0 6px 18px rgba(37,211,102,0.5); }
    .cw-toggle.cw-wide { width: 148px; }
    .cw-toggle.cw-open { background: #1aad54; width: 44px !important; }
    .cw-icon-wrap { flex-shrink: 0; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; position: relative; }
    .cw-icon-wrap i { font-size: 1.25rem; color: #fff; display: inline-flex; align-items: center; justify-content: center; position: relative; opacity: 1; transform: scale(1) rotate(0deg); transition: opacity 0.2s ease, transform 0.2s ease; }
    .cw-icon-wrap i.cw-icon-leaving { opacity: 0; transform: scale(0.5) rotate(-25deg); }
    .cw-icon-wrap i.cw-icon-entering { opacity: 0; transform: scale(0.5) rotate(25deg); }
    .cw-label { font-size: 0.84rem; font-weight: 700; color: #fff; white-space: nowrap; max-width: 0; opacity: 0; overflow: hidden; margin-left: -2px; transition: max-width 0.38s cubic-bezier(.4,0,.2,1), opacity 0.22s ease; pointer-events: none; }
    .cw-toggle.cw-wide .cw-label { max-width: 100px; opacity: 1; pointer-events: auto; }
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

<div id="google_translate_element" style="position: absolute; left: -9999px; top: -9999px; width: 1px; height: 1px; opacity: 0; pointer-events: none; overflow: hidden;"></div>

<div class="topbar">
  <div class="topbar-inner">
    <span class="topbar-left">Denpasar, Bali Indonesia &nbsp;|&nbsp; <a href="mailto:info@denpasarinstitute.id">info@denpasarinstitute.id</a></span>
    <div class="topbar-right">
      <a href="{{ route('backoffice.login') }}" class="topbar-portal-link"><i class="fas fa-user-lock"></i> Portal Anggota</a>
      <div class="topbar-social">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>
  </div>
</div>

@php
  $navLeft = \App\Models\NavigationItem::location('navbar_left')->where('is_active', true)->get();
  $navRight = \App\Models\NavigationItem::location('navbar_right')->where('is_active', true)->get();
  $footerKomunitas = \App\Models\NavigationItem::location('footer_komunitas')->where('is_active', true)->get();
  $allDivisi = \App\Models\Divisi::where('is_active', true)->orderBy('urutan', 'asc')->get();
  $siteLanguages = [
    // Prioritas & Asia Tenggara / Timur
    ['code' => 'id',    'name' => 'Indonesia',            'native' => 'Bahasa Indonesia', 'short' => 'ID', 'flag' => 'id'],
    ['code' => 'en',    'name' => 'English',              'native' => 'English (US/UK)',  'short' => 'EN', 'flag' => 'gb'],
    ['code' => 'ms',    'name' => 'Bahasa Melayu',        'native' => 'Melayu',           'short' => 'MS', 'flag' => 'my'],
    ['code' => 'zh-CN', 'name' => 'Mandarin (Chinese)',   'native' => '简体中文',         'short' => 'ZH', 'flag' => 'cn'],
    ['code' => 'ja',    'name' => 'Jepang (Japanese)',    'native' => '日本語',            'short' => 'JA', 'flag' => 'jp'],
    ['code' => 'ko',    'name' => 'Korea (Korean)',       'native' => '한국어',            'short' => 'KO', 'flag' => 'kr'],
    ['code' => 'ar',    'name' => 'Arab (Arabic)',        'native' => 'العربية',          'short' => 'AR', 'flag' => 'sa'],
    ['code' => 'hi',    'name' => 'India (Hindi)',        'native' => 'हिन्दी',            'short' => 'HI', 'flag' => 'in'],
    ['code' => 'th',    'name' => 'Thailand (Thai)',      'native' => 'ไทย',             'short' => 'TH', 'flag' => 'th'],
    ['code' => 'vi',    'name' => 'Vietnam (Vietnamese)', 'native' => 'Tiếng Việt',       'short' => 'VI', 'flag' => 'vn'],
    ['code' => 'tl',    'name' => 'Filipino (Tagalog)',   'native' => 'Tagalog',          'short' => 'TL', 'flag' => 'ph'],
    ['code' => 'my',    'name' => 'Myanmar (Burmese)',    'native' => 'မြန်မာ',          'short' => 'MY', 'flag' => 'mm'],
    ['code' => 'km',    'name' => 'Kamboja (Khmer)',      'native' => 'ភាសាខ្មែរ',        'short' => 'KM', 'flag' => 'kh'],
    ['code' => 'lo',    'name' => 'Laos (Lao)',           'native' => 'ພາສາລາວ',          'short' => 'LO', 'flag' => 'la'],

    // Eropa & Dunia Barat
    ['code' => 'de',    'name' => 'Jerman (Deutsch)',     'native' => 'Deutsch',          'short' => 'DE', 'flag' => 'de'],
    ['code' => 'fr',    'name' => 'Prancis (Français)',   'native' => 'Français',         'short' => 'FR', 'flag' => 'fr'],
    ['code' => 'nl',    'name' => 'Belanda (Nederlands)', 'native' => 'Nederlands',       'short' => 'NL', 'flag' => 'nl'],
    ['code' => 'es',    'name' => 'Spanyol (Español)',    'native' => 'Español',          'short' => 'ES', 'flag' => 'es'],
    ['code' => 'it',    'name' => 'Italia (Italiano)',    'native' => 'Italiano',         'short' => 'IT', 'flag' => 'it'],
    ['code' => 'pt',    'name' => 'Portugis (Português)', 'native' => 'Português',        'short' => 'PT', 'flag' => 'pt'],
    ['code' => 'ru',    'name' => 'Rusia (Russian)',      'native' => 'Русский',          'short' => 'RU', 'flag' => 'ru'],
    ['code' => 'tr',    'name' => 'Turki (Türkçe)',       'native' => 'Türkçe',           'short' => 'TR', 'flag' => 'tr'],
    ['code' => 'pl',    'name' => 'Polandia (Polski)',    'native' => 'Polski',           'short' => 'PL', 'flag' => 'pl'],
    ['code' => 'uk',    'name' => 'Ukraina (Ukrainian)',  'native' => 'Українська',       'short' => 'UK', 'flag' => 'ua'],
    ['code' => 'sv',    'name' => 'Swedia (Svenska)',     'native' => 'Svenska',          'short' => 'SV', 'flag' => 'se'],
    ['code' => 'no',    'name' => 'Norwegia (Norsk)',     'native' => 'Norsk',            'short' => 'NO', 'flag' => 'no'],
    ['code' => 'da',    'name' => 'Denmark (Dansk)',      'native' => 'Dansk',            'short' => 'DA', 'flag' => 'dk'],
    ['code' => 'fi',    'name' => 'Finlandia (Suomi)',    'native' => 'Suomi',            'short' => 'FI', 'flag' => 'fi'],
    ['code' => 'el',    'name' => 'Yunani (Greek)',       'native' => 'Ελληνικά',         'short' => 'EL', 'flag' => 'gr'],
    ['code' => 'cs',    'name' => 'Ceko (Čeština)',       'native' => 'Čeština',          'short' => 'CS', 'flag' => 'cz'],
    ['code' => 'hu',    'name' => 'Hungaria (Magyar)',    'native' => 'Magyar',           'short' => 'HU', 'flag' => 'hu'],
    ['code' => 'ro',    'name' => 'Rumania (Română)',     'native' => 'Română',           'short' => 'RO', 'flag' => 'ro'],
    ['code' => 'sk',    'name' => 'Slowakia (Slovenčina)','native' => 'Slovenčina',       'short' => 'SK', 'flag' => 'sk'],
    ['code' => 'hr',    'name' => 'Kroasia (Hrvatski)',   'native' => 'Hrvatski',         'short' => 'HR', 'flag' => 'hr'],
    ['code' => 'sr',    'name' => 'Serbia (Српски)',      'native' => 'Српски',           'short' => 'SR', 'flag' => 'sr'],
    ['code' => 'bg',    'name' => 'Bulgaria (Bulgarian)', 'native' => 'Български',        'short' => 'BG', 'flag' => 'bg'],

    // Asia Selatan, Timur Tengah & Afrika
    ['code' => 'bn',    'name' => 'Bengali (Bangla)',     'native' => 'বাংলা',            'short' => 'BN', 'flag' => 'bd'],
    ['code' => 'fa',    'name' => 'Persia (Farsi)',       'native' => 'فارسی',           'short' => 'FA', 'flag' => 'ir'],
    ['code' => 'he',    'name' => 'Ibrani (Hebrew)',      'native' => 'עברית',           'short' => 'HE', 'flag' => 'il'],
    ['code' => 'ur',    'name' => 'Urdu',                 'native' => 'اردو',            'short' => 'UR', 'flag' => 'pk'],
    ['code' => 'ta',    'name' => 'Tamil',                'native' => 'தமிழ்',            'short' => 'TA', 'flag' => 'lk'],
    ['code' => 'sw',    'name' => 'Swahili (Kiswahili)',  'native' => 'Kiswahili',        'short' => 'SW', 'flag' => 'ke'],
    ['code' => 'af',    'name' => 'Afrikaans',            'native' => 'Afrikaans',        'short' => 'AF', 'flag' => 'za'],
  ];
@endphp
<header>
  <div class="header-inner">

    <ul class="nav-left">
      @foreach($navLeft as $item)
        @if(str_contains(strtolower($item->title), 'divisi'))
          <li class="has-dropdown">
            <a href="{{ $item->url }}"
               class="{{ request()->routeIs('divisi.*') ? 'active' : '' }}">
              {{ $item->title }}
            </a>
            <ul class="dropdown-menu">
              @foreach($allDivisi as $d)
                <li>
                  <a href="/divisi/{{ $d->slug }}">{{ $d->nama }}</a>
                </li>
              @endforeach
            </ul>
          </li>
        @else
          <li>
            <a href="{{ $item->url }}" target="{{ $item->target }}"
               class="{{ (request()->is(ltrim($item->url, '//')) || (request()->routeIs('home') && ($item->url === '/' || $item->url === ''))) ? 'active' : '' }}">
              {{ $item->title }}
            </a>
          </li>
        @endif
      @endforeach
    </ul>

    <div class="nav-logo-center">
      <img src="/image/logo_DI.png" alt="Denpasar Institute"
        onerror="this.style.display='none';this.parentElement.innerHTML='<span style=\'font-size:1.1rem;font-weight:800;color:var(--red)\'>DI</span>'">
    </div>

    <ul class="nav-right">
      @foreach($navRight as $item)
        <li>
          <a href="{{ $item->url }}" target="{{ $item->target }}"
             class="{{ (request()->is(ltrim($item->url, '/\/')) || request()->is(ltrim($item->url, '/\/') . '/*')) ? 'active' : '' }}">
            {{ $item->title }}
          </a>
        </li>
      @endforeach
            <li class="custom-lang-dropdown" id="customLangDropdownDesktop">
        <button type="button" class="lang-trigger-btn" id="langTriggerDesktop" onclick="toggleDesktopLangMenu(event)" aria-label="Pilih Bahasa" aria-haspopup="true">
          <img id="langCurrentFlagDesktop" src="/image/flags/id.png" alt="ID" class="lang-flag-img" onerror="this.onerror=null;this.src='https://flagcdn.com/w40/id.png';">
          <span class="lang-name-text">
            <span class="lang-text-full" id="langCurrentLabelDesktopFull">Indonesia</span>
            <span class="lang-text-short" id="langCurrentLabelDesktopShort">ID</span>
          </span>
          <i class="fas fa-chevron-down lang-chevron"></i>
        </button>

        <div class="lang-dropdown-menu" id="langMenuDesktop" onclick="event.stopPropagation()">
          <div class="lang-dropdown-header">
            <div class="lang-header-title">
              <i class="fas fa-globe"></i>
              <span>Pilih Bahasa</span>
            </div>
            <span class="lang-header-count">43 Bahasa</span>
          </div>

          <div class="lang-search-wrap">
            <i class="fas fa-search lang-search-icon"></i>
            <input type="text" class="lang-search-input" id="langSearchDesktop" placeholder="Cari bahasa / Search..." oninput="filterLangList(this.value, 'desktop')" autocomplete="off">
          </div>

          <ul class="lang-dropdown-list" id="langMenuListDesktop">
            @foreach($siteLanguages as $l)
              <li>
                <button type="button" class="lang-opt-item {{ $l['code'] === 'id' ? 'is-selected' : '' }}" data-code="{{ $l['code'] }}" data-search="{{ strtolower($l['name'] . ' ' . $l['native'] . ' ' . $l['short']) }}" onclick="changeLanguage('{{ $l['code'] }}')">
                  <img src="/image/flags/{{ $l['flag'] }}.png" class="lang-flag-img" alt="{{ $l['short'] }}" onerror="this.onerror=null;this.src='https://flagcdn.com/w40/{{ $l['flag'] }}.png';">
                  <div class="lang-opt-info">
                    <span class="lang-opt-name">{{ $l['name'] }}</span>
                    @if(!empty($l['native']) && $l['native'] !== $l['name'])
                      <span class="lang-opt-native-sub">{{ $l['native'] }}</span>
                    @endif
                  </div>
                  <span class="lang-opt-native-badge">{{ $l['short'] }}</span>
                  <i class="fas fa-check lang-opt-check"></i>
                </button>
              </li>
            @endforeach
          </ul>

          <div class="lang-empty-msg" id="langEmptyDesktop" style="display:none;">
            <i class="fas fa-search"></i>
            Bahasa tidak ditemukan
          </div>
        </div>

        <!-- Hidden sync select for script compatibility -->
        <select class="lang-select" id="langSelectDesktop" style="display:none;" onchange="changeLanguage(this.value)">
          @foreach($siteLanguages as $l)
            <option value="{{ $l['code'] }}">{{ $l['name'] }}</option>
          @endforeach
        </select></li>
    </ul>

    <button class="hamburger-btn" id="hamburgerBtn" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>

<div class="menu-backdrop" id="menuBackdrop"></div>

<div class="mobile-menu" id="mobileMenu">
  <ul class="mobile-nav">
    @foreach($navLeft as $item)
      @if(str_contains(strtolower($item->title), 'divisi'))
        <li>
          <a href="{{ $item->url }}" class="{{ request()->routeIs('divisi.*') ? 'active' : '' }}">
            {{ $item->title }}
          </a>
        </li>
        <ul class="mobile-nav-sub">
          @foreach($allDivisi as $d)
            <li><a href="/divisi/{{ $d->slug }}">{{ $d->nama }}</a></li>
          @endforeach
        </ul>
      @else
        <li>
          <a href="{{ $item->url }}" target="{{ $item->target }}" class="{{ (request()->is(ltrim($item->url, '/\/')) || (request()->routeIs('home') && ($item->url === '/' || $item->url === ''))) ? 'active' : '' }}">
            {{ $item->title }}
          </a>
        </li>
      @endif
    @endforeach
    @foreach($navRight as $item)
      <li>
        <a href="{{ $item->url }}" target="{{ $item->target }}" class="{{ (request()->is(ltrim($item->url, '/\/')) || request()->is(ltrim($item->url, '/\/') . '/*')) ? 'active' : '' }}">
          {{ $item->title }}
        </a>
      </li>
    @endforeach
    <li style="margin-top:8px;padding-top:8px;border-top:1px dashed #ddd;">
      <a href="{{ route('backoffice.login') }}" style="color:var(--red);font-weight:700;">
        <i class="fas fa-user-shield"></i> Portal Anggota &amp; Login
      </a>
    </li>
        <li class="mobile-lang-wrap">
      <div class="mobile-lang-title"><i class="fas fa-globe"></i> Pilih Bahasa (43 Bahasa)</div>
      <button type="button" class="mobile-lang-trigger" id="langTriggerMobile" onclick="toggleMobileLangMenu(event)">
        <span class="mobile-lang-trigger-left">
          <img id="langCurrentFlagMobile" src="/image/flags/id.png" alt="ID" class="lang-flag-img" onerror="this.onerror=null;this.src='https://flagcdn.com/w40/id.png';">
          <span id="langCurrentLabelMobile">Indonesia</span>
        </span>
        <i class="fas fa-chevron-down mobile-lang-chevron" id="mobileLangChevron"></i>
      </button>

      <div class="mobile-lang-list" id="mobileLangList" onclick="event.stopPropagation()">
        <div class="lang-search-wrap" style="padding: 6px 10px;">
          <input type="text" class="lang-search-input" id="langSearchMobile" placeholder="Cari bahasa..." oninput="filterLangList(this.value, 'mobile')" autocomplete="off" style="padding: 6px 8px 6px 28px; font-size: 0.8rem;">
          <i class="fas fa-search lang-search-icon" style="left: 20px;"></i>
        </div>
        <div id="mobileLangItemsScroll" style="max-height: 220px; overflow-y: auto;">
          @foreach($siteLanguages as $l)
            <button type="button" class="mobile-lang-opt {{ $l['code'] === 'id' ? 'is-selected' : '' }}" data-code="{{ $l['code'] }}" data-search="{{ strtolower($l['name'] . ' ' . $l['native'] . ' ' . $l['short']) }}" onclick="changeLanguage('{{ $l['code'] }}')">
              <img src="/image/flags/{{ $l['flag'] }}.png" class="lang-flag-img" alt="{{ $l['short'] }}" onerror="this.onerror=null;this.src='https://flagcdn.com/w40/{{ $l['flag'] }}.png';">
              <div style="flex:1; line-height: 1.25; overflow: hidden; text-align: left;">
                <div style="font-weight: 500; font-size: 0.86rem;">{{ $l['name'] }}</div>
                @if(!empty($l['native']) && $l['native'] !== $l['name'])
                  <div style="font-size: 0.7rem; color: #64748b;">{{ $l['native'] }}</div>
                @endif
              </div>
              <span style="font-size:0.72rem;color:#94a3b8;font-weight:600;background:#f1f5f9;padding:2px 6px;border-radius:4px;">{{ $l['short'] }}</span>
              <i class="fas fa-check lang-opt-check" style="color:var(--red);font-size:0.75rem;"></i>
            </button>
          @endforeach
        </div>
        <div class="lang-empty-msg" id="langEmptyMobile" style="display:none; padding: 14px; font-size: 0.8rem;">
          Bahasa tidak ditemukan
        </div>
      </div>
      <!-- Hidden sync select for script compatibility -->
      <select class="lang-select" id="langSelectMobile" style="display:none;" onchange="changeLanguage(this.value)">
        @foreach($siteLanguages as $l)
          <option value="{{ $l['code'] }}">{{ $l['name'] }}</option>
        @endforeach
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
        <a href="{{ \App\Models\SiteSetting::get('social_facebook', '#') }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
        <a href="{{ \App\Models\SiteSetting::get('social_instagram', '#') }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
        <a href="{{ \App\Models\SiteSetting::get('social_youtube', '#') }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a>
        <a href="{{ \App\Models\SiteSetting::get('social_linkedin', '#') }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a>
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
        @foreach($footerKomunitas as $fItem)
          <li><a href="{{ $fItem->url }}" target="{{ $fItem->target }}">{{ $fItem->title }}</a></li>
        @endforeach
      </ul>
    </div>
    <div class="footer-col">
      <h4>Kontak</h4>
      <div class="footer-contact-item"><i class="fas fa-map-marker-alt"></i><span>{{ \App\Models\SiteSetting::get('contact_address', 'Denpasar, Bali - Indonesia') }}</span></div>
      <div class="footer-contact-item"><i class="fas fa-envelope"></i><span>{{ \App\Models\SiteSetting::get('contact_email', 'info@denpasarinstitute.id') }}</span></div>
      <div class="footer-contact-item">
        <i class="fab fa-whatsapp"></i>
        <div style="display: flex; flex-direction: column; gap: 3px;">
          @php
            $p1 = \App\Models\SiteSetting::get('contact_phone_1', '+62 821-4481-4593');
            $p2 = \App\Models\SiteSetting::get('contact_phone_2', '+62 823-1866-6547');
            $p1Clean = preg_replace('/[^0-9]/', '', $p1);
            $p2Clean = preg_replace('/[^0-9]/', '', $p2);
          @endphp
          <a href="https://wa.me/{{ $p1Clean }}" target="_blank" rel="noopener noreferrer" style="white-space: nowrap;">{{ $p1 }}</a>
          @if(!empty($p2))
            <a href="https://wa.me/{{ $p2Clean }}" target="_blank" rel="noopener noreferrer" style="white-space: nowrap;">{{ $p2 }}</a>
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom-bar">
    <p>{{ \App\Models\SiteSetting::get('footer_copyright', '© ' . date('Y') . ' Denpasar Institute. Hak cipta dilindungi undang-undang.') }}</p>
    <div style="display:flex;gap:16px;">
      <a href="#">Kebijakan Privasi</a>
      <a href="#">Syarat &amp; Ketentuan</a>
    </div>
  </div>
</footer>

<div class="contact-widget" id="contactWidget">
  <div class="cw-menu" id="cwMenu">
    <a href="https://wa.me/6282144814593" class="cw-item" target="_blank" rel="noopener noreferrer">
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
  <button class="cw-toggle cw-wide" id="cwToggle" aria-label="Contact us" aria-expanded="false">
    <span class="cw-icon-wrap" id="cwIconWrap"><i class="fas fa-comment-dots" id="cwIcon"></i></span>
    <span class="cw-label" id="cwLabel">Contact us</span>
  </button>
</div>
<button id="backToTop"><i class="fas fa-arrow-up"></i></button>

<script type="text/javascript">
// Immediate cleanup if current language is Indonesian
(function() {
  var saved = localStorage.getItem('google_translate_lang');
  if (!saved || saved === 'id') {
    var host = window.location.hostname;
    var domains = ['', host, '.' + host];
    var paths = ['/', window.location.pathname];
    for (var i = 0; i < domains.length; i++) {
      for (var j = 0; j < paths.length; j++) {
        var d = domains[i] ? '; domain=' + domains[i] : '';
        document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=' + paths[j] + d;
      }
    }
  }
})();

// Google Translate Configuration
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'id',
    includedLanguages: 'id,en,de,it,hi,ja,ko,zh-CN,ar,fr,es,ru,nl,th,vi,ms,pt',
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
    autoDisplay: false,
    multilanguagePage: false
  }, 'google_translate_element');
}

// Cookie Helpers
function setGoogTransCookie(lang) {
  const cookieVal = '/id/' + lang;
  const host = window.location.hostname;
  document.cookie = 'googtrans=' + cookieVal + '; path=/; max-age=31536000';
  if (host && host !== 'localhost' && host !== '127.0.0.1') {
    document.cookie = 'googtrans=' + cookieVal + '; path=/; domain=' + host + '; max-age=31536000';
    document.cookie = 'googtrans=' + cookieVal + '; path=/; domain=.' + host + '; max-age=31536000';
  }
}

function clearGoogTransCookie() {
  const host = window.location.hostname;
  const domains = ['', host, '.' + host];
  const paths = ['/', window.location.pathname];
  domains.forEach(d => {
    paths.forEach(p => {
      const domainStr = d ? '; domain=' + d : '';
      document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=' + p + domainStr;
    });
  });
}

const LANG_DATA = {
  'id':    { name: 'Indonesia', flag: '/image/flags/id.png', short: 'ID' },
  'en':    { name: 'English', flag: '/image/flags/gb.png', short: 'EN' },
  'ms':    { name: 'Bahasa Melayu', flag: '/image/flags/my.png', short: 'MS' },
  'zh-CN': { name: 'Mandarin', flag: '/image/flags/cn.png', short: 'ZH' },
  'ja':    { name: '日本語', flag: '/image/flags/jp.png', short: 'JA' },
  'ko':    { name: '한국어', flag: '/image/flags/kr.png', short: 'KO' },
  'ar':    { name: 'العربية', flag: '/image/flags/sa.png', short: 'AR' },
  'hi':    { name: 'हिन्दी', flag: '/image/flags/in.png', short: 'HI' },
  'th':    { name: 'ไทย', flag: '/image/flags/th.png', short: 'TH' },
  'vi':    { name: 'Tiếng Việt', flag: '/image/flags/vn.png', short: 'VI' },
  'tl':    { name: 'Filipino', flag: '/image/flags/ph.png', short: 'TL' },
  'my':    { name: 'မြန်မာ', flag: '/image/flags/mm.png', short: 'MY' },
  'km':    { name: 'ភាសាខ្មែរ', flag: '/image/flags/kh.png', short: 'KM' },
  'lo':    { name: 'ພາສາລາວ', flag: '/image/flags/la.png', short: 'LO' },
  'de':    { name: 'Deutsch', flag: '/image/flags/de.png', short: 'DE' },
  'fr':    { name: 'Français', flag: '/image/flags/fr.png', short: 'FR' },
  'nl':    { name: 'Nederlands', flag: '/image/flags/nl.png', short: 'NL' },
  'es':    { name: 'Español', flag: '/image/flags/es.png', short: 'ES' },
  'it':    { name: 'Italiano', flag: '/image/flags/it.png', short: 'IT' },
  'pt':    { name: 'Português', flag: '/image/flags/pt.png', short: 'PT' },
  'ru':    { name: 'Русский', flag: '/image/flags/ru.png', short: 'RU' },
  'tr':    { name: 'Türkçe', flag: '/image/flags/tr.png', short: 'TR' },
  'pl':    { name: 'Polski', flag: '/image/flags/pl.png', short: 'PL' },
  'uk':    { name: 'Українська', flag: '/image/flags/ua.png', short: 'UK' },
  'sv':    { name: 'Svenska', flag: '/image/flags/se.png', short: 'SV' },
  'no':    { name: 'Norsk', flag: '/image/flags/no.png', short: 'NO' },
  'da':    { name: 'Dansk', flag: '/image/flags/dk.png', short: 'DA' },
  'fi':    { name: 'Suomi', flag: '/image/flags/fi.png', short: 'FI' },
  'el':    { name: 'Ελληνικά', flag: '/image/flags/gr.png', short: 'EL' },
  'cs':    { name: 'Čeština', flag: '/image/flags/cz.png', short: 'CS' },
  'hu':    { name: 'Magyar', flag: '/image/flags/hu.png', short: 'HU' },
  'ro':    { name: 'Română', flag: '/image/flags/ro.png', short: 'RO' },
  'sk':    { name: 'Slovenčina', flag: '/image/flags/sk.png', short: 'SK' },
  'hr':    { name: 'Hrvatski', flag: '/image/flags/hr.png', short: 'HR' },
  'sr':    { name: 'Српски', flag: '/image/flags/rs.png', short: 'SR' },
  'bg':    { name: 'Български', flag: '/image/flags/bg.png', short: 'BG' },
  'bn':    { name: 'বাংলা', flag: '/image/flags/bd.png', short: 'BN' },
  'fa':    { name: 'فارسی', flag: '/image/flags/ir.png', short: 'FA' },
  'he':    { name: 'עברית', flag: '/image/flags/il.png', short: 'HE' },
  'ur':    { name: 'اردو', flag: '/image/flags/pk.png', short: 'UR' },
  'ta':    { name: 'தமிழ்', flag: '/image/flags/lk.png', short: 'TA' },
  'sw':    { name: 'Kiswahili', flag: '/image/flags/ke.png', short: 'SW' },
  'af':    { name: 'Afrikaans', flag: '/image/flags/za.png', short: 'AF' }
};

function updateCustomLangUI(langCode) {
  const code = (langCode && LANG_DATA[langCode]) ? langCode : 'id';
  const data = LANG_DATA[code];

  const dFlag = document.getElementById('langCurrentFlagDesktop');
  const dLabelFull = document.getElementById('langCurrentLabelDesktopFull');
  const dLabelShort = document.getElementById('langCurrentLabelDesktopShort');
  if (dFlag) {
    dFlag.src = data.flag;
    dFlag.alt = data.short;
  }
  if (dLabelFull) dLabelFull.textContent = data.name;
  if (dLabelShort) dLabelShort.textContent = data.short;

  const mFlag = document.getElementById('langCurrentFlagMobile');
  const mLabel = document.getElementById('langCurrentLabelMobile');
  if (mFlag) {
    mFlag.src = data.flag;
    mFlag.alt = data.short;
  }
  if (mLabel) mLabel.textContent = data.name;

  document.querySelectorAll('.lang-opt-item, .mobile-lang-opt').forEach(function(btn) {
    const isSel = btn.getAttribute('data-code') === code;
    btn.classList.toggle('is-selected', isSel);
  });
}

// TOGGLE STRICTLY ON CLICK
function toggleDesktopLangMenu(e) {
  if (e) {
    e.stopPropagation();
    e.preventDefault();
  }
  const dropdown = document.getElementById('customLangDropdownDesktop');
  if (!dropdown) return;
  const wasOpen = dropdown.classList.contains('is-open');
  dropdown.classList.toggle('is-open');

  if (!wasOpen) {
    setTimeout(function() {
      const searchInput = document.getElementById('langSearchDesktop');
      if (searchInput) searchInput.focus();
    }, 80);
  }
}

function toggleMobileLangMenu(e) {
  if (e) {
    e.stopPropagation();
    e.preventDefault();
  }
  const trigger = document.getElementById('langTriggerMobile');
  const list = document.getElementById('mobileLangList');
  if (trigger && list) {
    trigger.classList.toggle('is-open');
    list.classList.toggle('is-open');
    if (list.classList.contains('is-open')) {
      setTimeout(function() {
        const searchInput = document.getElementById('langSearchMobile');
        if (searchInput) searchInput.focus();
      }, 80);
    }
  }
}

function filterLangList(query, listType) {
  const q = (query || '').toLowerCase().trim();
  const isMobile = listType === 'mobile';
  const selector = isMobile ? '.mobile-lang-opt' : '.lang-opt-item';
  const container = isMobile ? document.getElementById('mobileLangItemsScroll') : document.getElementById('langMenuListDesktop');
  const emptyMsg = document.getElementById(isMobile ? 'langEmptyMobile' : 'langEmptyDesktop');
  if (!container) return;

  const items = container.querySelectorAll(selector);
  let visibleCount = 0;
  items.forEach(function(item) {
    const text = (item.getAttribute('data-search') || item.textContent).toLowerCase();
    const matches = !q || text.indexOf(q) !== -1;
    if (item.parentElement && item.parentElement.tagName === 'LI') {
      item.parentElement.style.display = matches ? '' : 'none';
    } else {
      item.style.display = matches ? 'flex' : 'none';
    }
    if (matches) visibleCount++;
  });

  if (emptyMsg) {
    emptyMsg.style.display = visibleCount === 0 ? 'block' : 'none';
  }
}

// Close when clicking anywhere outside
document.addEventListener('click', function(e) {
  const dropdown = document.getElementById('customLangDropdownDesktop');
  if (dropdown && !dropdown.contains(e.target)) {
    dropdown.classList.remove('is-open');
  }
});

// Close on Escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    const dropdown = document.getElementById('customLangDropdownDesktop');
    if (dropdown) dropdown.classList.remove('is-open');
    const mobileTrigger = document.getElementById('langTriggerMobile');
    const mobileList = document.getElementById('mobileLangList');
    if (mobileTrigger) mobileTrigger.classList.remove('is-open');
    if (mobileList) mobileList.classList.remove('is-open');
  }
});
// Change Language Function
function changeLanguage(langCode) {
  const desktopSelect = document.getElementById('langSelectDesktop');
  const mobileSelect = document.getElementById('langSelectMobile');
  const dropdown = document.getElementById('customLangDropdownDesktop');
  if (dropdown) dropdown.classList.remove('is-open');

  // If empty or Indonesian ('id'), reset to original Indonesian without translating
  if (!langCode || langCode === '' || langCode === 'id') {
    localStorage.removeItem('google_translate_lang');
    clearGoogTransCookie();
    if (desktopSelect) desktopSelect.value = 'id';
    if (mobileSelect) mobileSelect.value = 'id';
    updateCustomLangUI('id');
    
    // Clear Google combo
    const combo = document.querySelector('.goog-te-combo');
    if (combo) {
      combo.value = '';
      combo.dispatchEvent(new Event('change', { bubbles: true }));
    }
    window.location.reload();
    return;
  }

  // Save selected language & sync selects
  localStorage.setItem('google_translate_lang', langCode);
  if (desktopSelect) desktopSelect.value = langCode;
  if (mobileSelect) mobileSelect.value = langCode;
  updateCustomLangUI(langCode);

  // Set the translation cookie
  setGoogTransCookie(langCode);

  // Trigger Google Translate combo box if present
  const combo = document.querySelector('.goog-te-combo');
  if (combo) {
    combo.value = langCode;
    combo.dispatchEvent(new Event('change', { bubbles: true }));
  } else {
    let attempts = 0;
    const interval = setInterval(function() {
      attempts++;
      const c = document.querySelector('.goog-te-combo');
      if (c) {
        clearInterval(interval);
        c.value = langCode;
        c.dispatchEvent(new Event('change', { bubbles: true }));
      } else if (attempts >= 20) {
        clearInterval(interval);
        window.location.reload();
      }
    }, 150);
  }
}

// Sync UI on load
document.addEventListener('DOMContentLoaded', function() {
  const savedLang = localStorage.getItem('google_translate_lang');
  const desktopSelect = document.getElementById('langSelectDesktop');
  const mobileSelect = document.getElementById('langSelectMobile');

  if (savedLang && savedLang !== 'id') {
    if (desktopSelect) desktopSelect.value = savedLang;
    if (mobileSelect) mobileSelect.value = savedLang;
    updateCustomLangUI(savedLang);
    setGoogTransCookie(savedLang);

    // Ensure Google Translate combo matches saved language once loaded
    let attempts = 0;
    const interval = setInterval(function() {
      attempts++;
      const combo = document.querySelector('.goog-te-combo');
      if (combo) {
        clearInterval(interval);
        if (combo.value !== savedLang) {
          combo.value = savedLang;
          combo.dispatchEvent(new Event('change', { bubbles: true }));
        }
      } else if (attempts >= 25) {
        clearInterval(interval);
      }
    }, 150);
  } else {
    clearGoogTransCookie();
    if (desktopSelect) desktopSelect.value = 'id';
    if (mobileSelect) mobileSelect.value = 'id';
    updateCustomLangUI('id');
  }

  // Active suppression of Google Translate top banner & body offset
  function suppressGoogleBanner() {
    if (document.body && document.body.style.top && document.body.style.top !== '0px') {
      document.body.style.setProperty('top', '0px', 'important');
    }
    if (document.documentElement && document.documentElement.style.top && document.documentElement.style.top !== '0px') {
      document.documentElement.style.setProperty('top', '0px', 'important');
    }
    const banners = document.querySelectorAll('.goog-te-banner-frame, iframe.skiptranslate, .VIpgJd-ZVi9od-ORHb-OEVmcd, iframe[id*="container"], iframe[id*=":"]');
    banners.forEach(function(b) {
      b.style.setProperty('display', 'none', 'important');
      b.style.setProperty('visibility', 'hidden', 'important');
      b.style.setProperty('height', '0px', 'important');
      b.style.setProperty('width', '0px', 'important');
      b.style.setProperty('opacity', '0', 'important');
      b.style.setProperty('pointer-events', 'none', 'important');
    });
  }

  if (window.MutationObserver) {
    var bannerObserver = new MutationObserver(suppressGoogleBanner);
    bannerObserver.observe(document.documentElement, {
      attributes: true,
      attributeFilter: ['style', 'class'],
      childList: true,
      subtree: true
    });
  }
  window.addEventListener('load', suppressGoogleBanner);
  setInterval(suppressGoogleBanner, 100);
});
</script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>
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
      iconEl.className = (s.brand ? 'fab' : 'fas') + ' ' + s.icon + ' cw-icon-entering';
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

@include('partials.tentang-modal')

@stack('scripts')
</body>
</html>