@extends('layouts.app')

@section('title', 'Denpasar Institute')

@section('extra-style')
    .hero-slider {
      position: relative;
      width: 100%;
      height: 85vh;
      min-height: 550px;
      overflow: hidden;
      background: #0a0a0a;
    }
    .slider-wrapper {
      display: flex;
      width: 100%;
      height: 100%;
      transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
      will-change: transform;
    }
    .slider-slide {
      min-width: 100%;
      height: 100%;
    }
    .div-hero-banner {
      width: 100%;
      height: 100%;
      background: #000000;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }
    .div-hero-banner::before {
      content: '';
      position: absolute;
      inset: 0;
      background: 
        radial-gradient(circle at 20% 50%, rgba(204,0,0,0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(139,0,0,0.4) 0%, transparent 50%),
        radial-gradient(circle at 50% 80%, rgba(220,20,60,0.2) 0%, transparent 50%);
      z-index: 1;
      animation: pulseGlow 4s ease-in-out infinite alternate;
    }
    .div-hero-banner::after {
      content: '';
      position: absolute;
      inset: 0;
      background-image: 
        linear-gradient(45deg, rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(-45deg, rgba(255,255,255,0.03) 1px, transparent 1px);
      background-size: 60px 60px, 60px 60px;
      z-index: 1;
      opacity: 0.5;
    }
    @keyframes pulseGlow {
      0% { opacity: 0.7; }
      50% { opacity: 1; }
      100% { opacity: 0.7; }
    }
    .div-hero-banner .particles {
      position: absolute;
      inset: 0;
      z-index: 1;
      overflow: hidden;
    }
    .div-hero-banner .particle {
      position: absolute;
      width: 4px;
      height: 4px;
      background: #CC0000;
      border-radius: 50%;
      animation: float 6s infinite ease-in-out;
      opacity: 0.6;
    }
    .div-hero-banner .particle:nth-child(odd) {
      background: #F5C400;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0) translateX(0); }
      25% { transform: translateY(-30px) translateX(20px); }
      50% { transform: translateY(-60px) translateX(-20px); }
      75% { transform: translateY(-30px) translateX(-10px); }
    }
    .div-hero-inner {
      position: relative;
      z-index: 2;
      text-align: center;
      max-width: 900px;
      padding: 24px 20px 0;
    }
    .div-hero-heading {
      font-size: 68px;
      font-weight: 800;
      color: white;
      line-height: 1.2;
      margin-bottom: 30px;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    .div-hero-heading span {
      color: #F5C400;
      position: relative;
      display: inline-block;
    }
    .div-hero-heading span::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      right: 0;
      height: 3px;
      background: #F5C400;
      border-radius: 2px;
    }
    .div-hero-sub {
      font-size: 20px;
      color: rgba(255, 255, 255, 0.8);
      line-height: 1.8;
      max-width: 700px;
      margin: 0 auto;
    }
    .hero {
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }
    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(0,0,0,0.85) 0%, rgba(140,0,0,0.6) 50%, rgba(0,0,0,0.85) 100%);
      z-index: 1;
    }
    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 900px;
      width: 90%;
      margin: 0 auto;
      text-align: center;
    }
    .hero-content.horizontal {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 30px;
    }
    .divisi-action-row {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
      width: 100%;
    }
    .divisi-logo {
      flex-shrink: 0;
    }
    .logo-img-container {
      width: auto;
      height: auto;
      max-width: none;
      background: #ffffff;
      backdrop-filter: none;
      border-radius: 50px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: 2px solid #ffffff;
      box-shadow: 0 10px 30px rgba(255, 255, 255, 0.4);
      transition: all 0.3s ease;
      overflow: hidden;
      padding: 10px 28px;
      text-decoration: none;
      cursor: pointer;
    }
    .logo-img-container img {
      width: auto;
      height: 30px;
      max-width: none;
      object-fit: contain;
      transition: all 0.3s ease;
    }
    .logo-img-container:hover {
      background: #ffffff;
      border-color: #F5C400;
      transform: scale(1.05);
      box-shadow: 0 15px 40px rgba(255, 255, 255, 0.7);
    }
    .logo-img-container:hover img {
      transform: scale(1.08);
    }
    .journal-text {
      flex: 1;
      color: white;
      width: 100%;
    }
    .journal-text h1 {
      font-size: 52px;
      font-weight: 700;
      margin-bottom: 16px;
      line-height: 1.2;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
      letter-spacing: -1px;
    }
    .journal-text p {
      font-size: 18px;
      line-height: 1.8;
      margin-bottom: 24px;
      opacity: 0.9;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }
    .divisi-stats {
      display: flex;
      gap: 40px;
      margin-bottom: 32px;
      justify-content: center;
      flex-wrap: wrap;
    }
    .stat-item-div {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .stat-number {
      font-size: 30px;
      font-weight: 700;
      color: #F5C400;
      line-height: 1.2;
    }
    .stat-label-div {
      font-size: 14px;
      opacity: 0.7;
      margin-top: 4px;
    }
    .btn-submit {
      display: inline-block;
      padding: 14px 36px;
      background: linear-gradient(135deg, #CC0000 0%, #a80000 100%);
      color: white;
      text-decoration: none;
      border-radius: 50px;
      font-weight: 600;
      font-size: 16px;
      letter-spacing: 1px;
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
      box-shadow: 0 10px 30px rgba(204,0,0,0.3);
    }
    .btn-submit:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 40px rgba(204,0,0,0.5);
      background: linear-gradient(135deg, #a80000 0%, #CC0000 100%);
    }
    .slider-btn-hero {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 55px;
      height: 55px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(10px);
      border: 2px solid rgba(255, 255, 255, 0.2);
      color: white;
      font-size: 18px;
      cursor: pointer;
      transition: all 0.3s ease;
      z-index: 10;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .slider-btn-hero:hover {
      background: rgba(204,0,0,0.4);
      border-color: #CC0000;
      transform: translateY(-50%) scale(1.1);
    }
    .slider-btn-hero.prev-hero { left: 25px; }
    .slider-btn-hero.next-hero { right: 25px; }
    .slider-dots-hero {
      position: absolute;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 12px;
      z-index: 10;
    }
    .dot-hero {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.3);
      border: 2px solid rgba(255, 255, 255, 0.5);
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .dot-hero.active-hero {
      background: #CC0000;
      border-color: #CC0000;
      transform: scale(1.3);
      box-shadow: 0 0 20px rgba(204,0,0,0.5);
    }
    @media (max-width: 1024px) {
      .hero-content.horizontal { gap: 25px; }
      .divisi-action-row { gap: 16px; }
      .logo-img-container { padding: 8px 24px; }
      .logo-img-container img { height: 28px; }
      .journal-text h1 { font-size: 42px; }
      .div-hero-heading { font-size: 52px; }
      .div-hero-sub { font-size: 18px; }
    }
    @media (max-width: 768px) {
      .hero-slider { height: auto; min-height: 0; }
      .slider-slide { min-height: 0; }
      .div-hero-banner {
        min-height: 460px;
        padding: 56px 20px 76px;
      }
      .hero {
        min-height: 460px;
        padding: 56px 0 76px;
      }
      .div-hero-inner { padding: 0; }
      .hero-content.horizontal { flex-direction: column !important; gap: 20px; text-align: center; padding: 0 6px; }
      .divisi-action-row { flex-direction: column; gap: 14px; }
      .logo-img-container { padding: 8px 20px; }
      .logo-img-container img { height: 24px; }
      .journal-text h1 { font-size: 34px; }
      .journal-text p { font-size: 16px; margin: 0 auto 20px; }
      .divisi-stats { justify-content: center; flex-wrap: wrap; gap: 20px; }
      .stat-number { font-size: 24px; }
      .btn-submit { padding: 12px 30px; font-size: 14px; }
      .div-hero-heading { font-size: 40px; }
      .div-hero-sub { font-size: 16px; }
      .slider-btn-hero { width: 42px; height: 42px; font-size: 13px; }
      .slider-btn-hero.prev-hero { left: 10px; }
      .slider-btn-hero.next-hero { right: 10px; }
      .slider-dots-hero { bottom: 16px; }
    }
    .hero-section { background: #fff; padding: 40px 0 50px; border-bottom: 1px solid var(--border); }
    .hero-grid { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 28px; align-items: start; }
    .label-tentang { display: inline-block; color: var(--red); font-weight: 700; font-size: 0.85rem; border-bottom: 2px solid var(--yellow); padding-bottom: 2px; margin-bottom: 16px; }
    .hero-title { font-size: 2.4rem; font-weight: 800; color: var(--dark); line-height: 1.2; margin: 0 0 18px; }
    .hero-desc { font-size: 0.9rem; line-height: 1.85; color: var(--text); margin-bottom: 20px; text-align: justify; }
    .hero-selengkapnya { color: var(--red); font-weight: 600; font-size: 0.88rem; border-bottom: 1px solid var(--red); }
    .hero-btns { display: flex; gap: 12px; margin-top: 24px; flex-wrap: wrap; }
    .btn-yellow { background: var(--yellow); color: var(--dark); padding: 11px 24px; border-radius: 4px; font-weight: 800; font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.5px; transition: 0.2s; display: inline-block; }
    .btn-yellow:hover { background: #e0b000; transform: translateY(-1px); }
    .hero-portal-card { grid-column: 1 / -1; margin-top: 10px; background: #fbfbfc; border: 1px solid #e9ecef; border-left: 5px solid var(--red); border-radius: 10px; padding: 22px 28px; box-shadow: 0 4px 16px rgba(0,0,0,0.04); text-align: center; }
    .portal-badge-label { font-size: 0.95rem; font-weight: 800; text-transform: uppercase; color: var(--red); letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 6px; }
    .portal-card-desc { font-size: 0.82rem; color: #666; margin-bottom: 16px; line-height: 1.5; }
    .portal-btn-top { display: flex; justify-content: center; margin-bottom: 12px; }
    .portal-btn-row { display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }
    .btn-portal-main { background: var(--red); color: #fff !important; font-size: 0.84rem; font-weight: 700; padding: 10px 26px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s ease; box-shadow: 0 3px 8px rgba(204,0,0,0.25); }
    .btn-portal-main:hover { background: #a80000; transform: translateY(-1px); box-shadow: 0 6px 14px rgba(204,0,0,0.3); }
    .btn-portal-secondary { background: var(--yellow); color: #1a1a1a !important; font-size: 0.82rem; font-weight: 700; padding: 10px 22px; border-radius: 6px; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 7px; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 3px 8px rgba(245,196,0,0.25); }
    .btn-portal-secondary:hover { background: #e0b000; transform: translateY(-1px); box-shadow: 0 6px 14px rgba(245,196,0,0.35); }
    @media (max-width: 640px) {
      .portal-btn-row { flex-direction: column; align-items: stretch; }
      .portal-btn-row .btn-portal-secondary { justify-content: center; width: 100%; }
      .portal-btn-top .btn-portal-main { justify-content: center; width: 100%; }
    }
    .col-header { background: var(--red); color: #fff; padding: 10px 16px; font-weight: 700; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; justify-content: space-between; }
    .col-header a { color: rgba(255,255,255,0.85); font-size: 0.75rem; font-weight: 500; }
    .event-list { border: 1px solid var(--border); border-top: none; }
    .event-item { display: flex; gap: 12px; padding: 10px 14px; border-bottom: 1px solid var(--border); transition: background 0.2s; align-items: flex-start; }
    .event-item:last-child { border-bottom: none; }
    .event-item:hover { background: #fff8f8; }
    .event-thumb { width: 68px; height: 56px; object-fit: cover; flex-shrink: 0; border-radius: 3px; }
    .event-cat { color: var(--red); font-size: 0.7rem; font-weight: 700; display: block; margin-bottom: 3px; }
    .event-title { font-size: 0.8rem; font-weight: 600; color: var(--dark); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .sharing-list { border: 1px solid var(--border); border-top: none; }
    .sharing-item { display: flex; gap: 12px; padding: 10px 14px; border-bottom: 1px solid var(--border); transition: background 0.2s; align-items: flex-start; }
    .sharing-item:last-child { border-bottom: none; }
    .sharing-item:hover { background: #fff8f8; }
    .sharing-thumb { width: 68px; height: 56px; object-fit: cover; flex-shrink: 0; border-radius: 3px; }
    .sharing-cat { font-size: 0.7rem; font-weight: 700; display: block; margin-bottom: 3px; }
    .sharing-cat.red { color: var(--red); }
    .sharing-cat.orange { color: #e05a00; }
    .sharing-title { font-size: 0.8rem; font-weight: 600; color: var(--dark); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .sharing-btn { padding: 10px 14px; border-top: 2px solid var(--yellow); }
    .sharing-btn a { display: block; text-align: center; padding: 8px; background: var(--yellow); color: var(--dark); font-weight: 800; font-size: 0.74rem; text-transform: uppercase; border-radius: 3px; transition: 0.2s; }
    .sharing-btn a:hover { background: #e0b000; }
    .stats-section { background: linear-gradient(135deg, #fafafa 0%, #ffffff 100%); padding: 70px 0 80px; position: relative; overflow: hidden; }
    .stats-section::before { content: ''; position: absolute; width: 400px; height: 400px; background: radial-gradient(circle, rgba(204,0,0,0.04) 0%, transparent 70%); top: -100px; left: -100px; pointer-events: none; z-index: 0; }
    .stats-section::after { content: ''; position: absolute; width: 350px; height: 350px; background: radial-gradient(circle, rgba(245,196,0,0.05) 0%, transparent 70%); bottom: -80px; right: -80px; pointer-events: none; z-index: 0; }
    .stats-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 1; }
    .stats-header { text-align: center; margin-bottom: 48px; }
    .stats-title { font-size: 2.2rem; font-weight: 800; color: #1a1a1a; margin: 0 0 8px; line-height: 1.2; }
    .stats-title em { font-style: normal; color: #CC0000; position: relative; }
    .stats-title em::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: #CC0000; opacity: 0.2; border-radius: 2px; }
    .stats-subtitle { font-size: 0.88rem; color: #777; margin: 0; font-weight: 400; }
    .stats-grid-new { display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px; }
    .stat-card { background: #fff; border-radius: 16px; padding: 28px 20px 24px; text-align: center; border: 1px solid #ebebeb; transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; cursor: default; }
    .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #CC0000, #F5C400); opacity: 0; transition: opacity 0.35s; }
    .stat-card:hover { transform: translateY(-8px); box-shadow: 0 20px 48px rgba(204,0,0,0.12); border-color: rgba(204,0,0,0.2); }
    .stat-card:hover::before { opacity: 1; }
    .stat-icon-wrap { width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, rgba(204,0,0,0.08) 0%, rgba(245,196,0,0.12) 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; transition: all 0.35s; }
    .stat-card:hover .stat-icon-wrap { background: linear-gradient(135deg, #CC0000 0%, #a80000 100%); transform: scale(1.1) rotate(-5deg); box-shadow: 0 8px 24px rgba(204,0,0,0.25); }
    .stat-icon-wrap i { font-size: 1.3rem; color: #CC0000; transition: all 0.35s; }
    .stat-card:hover .stat-icon-wrap i { color: #fff; }
    .stat-number-new { font-size: 2.4rem; font-weight: 800; color: #1a1a1a; line-height: 1; margin-bottom: 6px; transition: color 0.3s; }
    .stat-card:hover .stat-number-new { color: #CC0000; }
    .stat-label-new { font-size: 0.82rem; font-weight: 600; color: #666; margin: 0; text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-trend { display: inline-flex; align-items: center; gap: 4px; font-size: 0.7rem; font-weight: 700; color: #22c55e; margin-top: 10px; background: rgba(34,197,94,0.08); padding: 4px 10px; border-radius: 20px; }
    .stat-trend i { font-size: 0.6rem; }
    @media (max-width: 1024px) {
      .stats-grid-new { grid-template-columns: repeat(3, 1fr); gap: 16px; }
      .stats-title { font-size: 1.8rem; }
      .hero-grid { grid-template-columns: 1fr 1fr; }
      .hero-right { display: none; }
      .people-grid, .grcs-grid, .bursa-grid { grid-template-columns: repeat(2,1fr); }
    }
    @media (max-width: 768px) {
      .stats-grid-new { grid-template-columns: repeat(2, 1fr); gap: 14px; }
      .stat-card { padding: 22px 16px 20px; }
      .stat-number-new { font-size: 2rem; }
      .stat-icon-wrap { width: 48px; height: 48px; }
      .stat-icon-wrap i { font-size: 1.1rem; }
      .stats-title { font-size: 1.6rem; }
      .hero-grid { grid-template-columns: 1fr; }
      .hero-center { display: none; }
      .hero-title { font-size: 1.8rem; }
      .people-grid, .grcs-grid, .bursa-grid, .div-grid-2x2 { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
      .stats-grid-new { grid-template-columns: 1fr; gap: 12px; }
      .stats-section { padding: 50px 0 60px; }
    }
    .div-grid-2x2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .div-card-h { background: var(--red); border-radius: 14px; padding: 22px 22px 16px; display: flex; flex-direction: column; gap: 12px; transition: transform 0.25s ease, box-shadow 0.25s ease; cursor: pointer; }
    .div-card-h:hover { transform: translateY(-4px); box-shadow: 0 16px 36px rgba(204,0,0,0.3); }
    .div-card-h-left { display: flex; align-items: center; gap: 16px; }
    .div-avatar { width: 54px; height: 54px; border-radius: 50%; background: rgba(255,255,255,0.15); border: 2px solid rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; }
    .div-avatar img { width: 100%; height: 100%; object-fit: contain; padding: -2px; }
    .div-card-num { font-size: 0.67rem; font-weight: 700; color: rgba(255,255,255,0.55); text-transform: uppercase; letter-spacing: 1px; margin: 0 0 3px; }
    .div-card-name { font-size: 0.95rem; font-weight: 700; color: #fff; margin: 0; line-height: 1.3; }
    .div-card-desc { font-size: 0.79rem; color: rgba(255,255,255,0.82); line-height: 1.65; margin: 0; padding-top: 4px; border-top: 1px solid rgba(255,255,255,0.15); display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .div-card-footer { display: flex; align-items: center; justify-content: space-between; margin-top: auto; }
    .div-socials { display: flex; gap: 8px; }
    .div-socials a { color: rgba(255,255,255,0.55); font-size: 0.9rem; width: 28px; height: 28px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; transition: 0.2s; text-decoration: none; cursor: pointer; }
    .div-socials a:hover { color: #fff; background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.4); }
    .div-socials span { color: rgba(255,255,255,0.55); font-size: 0.9rem; width: 28px; height: 28px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; transition: 0.2s; cursor: pointer; }
    .div-socials span:hover { color: #fff; background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.4); }
    .div-badge { font-size: 0.68rem; font-weight: 700; color: var(--yellow); text-transform: uppercase; letter-spacing: 0.5px; padding: 3px 10px; border: 1px solid rgba(245,196,0,0.4); border-radius: 20px; background: rgba(245,196,0,0.1); }
    .konsultan-section { background: #f8fafc; padding: 65px 0; }
    .section-header-flex { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 16px; }
    .section-header-flex .section-header { margin-bottom: 0; }
    .section-action-link {
      display: inline-flex; align-items: center; gap: 8px; padding: 8px 20px;
      border-radius: 50px; font-size: 0.82rem; font-weight: 700; color: #CC0000;
      background: rgba(204,0,0,0.06); border: 1.5px solid rgba(204,0,0,0.2);
      text-decoration: none; transition: all 0.25s ease;
    }
    .section-action-link:hover {
      background: #CC0000; color: #fff; transform: translateY(-2px);
      box-shadow: 0 8px 18px rgba(204,0,0,0.22);
    }
    .people-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 20px; }
    .people-card {
      background: #fff; border-radius: 12px; padding: 22px 18px 16px;
      border: 1px solid #e5e7eb; border-top: 3.5px solid #CC0000;
      display: flex; flex-direction: column; text-decoration: none; color: inherit;
      transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; position: relative;
    }
    .people-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 14px 30px rgba(204,0,0,0.12);
      border-color: rgba(204,0,0,0.28);
      border-top-color: #CC0000;
    }
    .people-avatar {
      width: 66px; height: 66px; border-radius: 50%; overflow: hidden;
      border: 3px solid #CC0000; margin-bottom: 12px; background: #f3f4f6; flex-shrink: 0;
      box-shadow: 0 4px 10px rgba(204,0,0,0.15); transition: transform 0.3s ease;
    }
    .people-card:hover .people-avatar { transform: scale(1.05); }
    .people-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .people-name {
      font-size: 0.88rem; font-weight: 700; color: #111827; margin-bottom: 3px;
      line-height: 1.35; transition: color 0.2s ease;
    }
    .people-card:hover .people-name { color: #CC0000; }
    .people-inst {
      font-size: 0.74rem; color: #CC0000; margin-bottom: 8px; font-weight: 600;
      display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;
    }
    .people-desc {
      font-size: 0.77rem; color: #64748b; line-height: 1.6; margin-bottom: 14px;
      flex-grow: 1; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
    }
    .people-footer {
      display: flex; align-items: center; justify-content: space-between;
      border-top: 1px solid #f1f5f9; padding-top: 12px; margin-top: auto;
    }
    .people-social { display: flex; gap: 8px; }
    .people-social a {
      color: #64748b; font-size: 0.85rem; width: 28px; height: 28px; border-radius: 50%;
      background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center;
      justify-content: center; transition: all 0.2s ease; text-decoration: none;
    }
    .people-social a:hover {
      color: #fff; background: #CC0000; border-color: #CC0000; transform: translateY(-2px);
    }
    .people-view-badge {
      font-size: 0.72rem; font-weight: 700; color: #CC0000; display: inline-flex;
      align-items: center; gap: 5px; transition: transform 0.2s ease;
    }
    .people-card:hover .people-view-badge { transform: translateX(3px); }

    .grcs-section { background: #1a1a1a; padding: 60px 0; }
    .grcs-section .section-header h2 { color: #fff; }
    .grcs-section .section-line { background: var(--yellow); }
    .grcs-action-link {
      display: inline-flex; align-items: center; gap: 8px; padding: 8px 20px;
      border-radius: 50px; font-size: 0.82rem; font-weight: 700; color: var(--yellow);
      background: rgba(245,196,0,0.1); border: 1.5px solid rgba(245,196,0,0.3);
      text-decoration: none; transition: all 0.25s ease;
    }
    .grcs-action-link:hover {
      background: var(--yellow); color: #1a1a1a; transform: translateY(-2px);
      box-shadow: 0 8px 18px rgba(245,196,0,0.22);
    }
    .grcs-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 20px; }
    .grcs-card {
      background: #2a2a2a; border-radius: 10px; padding: 22px 18px 16px;
      border: 1px solid #3a3a3a; border-top: 3px solid var(--yellow);
      transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex; flex-direction: column; text-decoration: none;
      color: inherit; cursor: pointer; position: relative;
    }
    .grcs-card:hover {
      background: #323232; transform: translateY(-6px);
      box-shadow: 0 14px 28px rgba(0,0,0,0.5);
      border-color: rgba(245,196,0,0.4);
      border-top-color: var(--yellow);
    }
    .grcs-avatar {
      width: 66px; height: 66px; border-radius: 50%; overflow: hidden;
      border: 3px solid var(--yellow); margin-bottom: 12px; background: #333; flex-shrink: 0;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3); transition: transform 0.3s ease;
    }
    .grcs-card:hover .grcs-avatar { transform: scale(1.05); }
    .grcs-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .grcs-name {
      font-size: 0.88rem; font-weight: 700; color: #fff; margin-bottom: 3px;
      line-height: 1.35; transition: color 0.2s ease;
    }
    .grcs-card:hover .grcs-name { color: var(--yellow); }
    .grcs-role {
      font-size: 0.74rem; color: var(--yellow); margin-bottom: 8px; font-weight: 600;
      display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;
    }
    .grcs-desc {
      font-size: 0.77rem; color: #94a3b8; line-height: 1.6; margin-bottom: 14px;
      flex-grow: 1; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
    }
    .grcs-footer {
      display: flex; align-items: center; justify-content: space-between;
      border-top: 1px solid rgba(255,255,255,0.08); padding-top: 12px; margin-top: auto;
    }
    .grcs-social { display: flex; gap: 8px; }
    .grcs-social a, .grcs-social span {
      color: var(--yellow); font-size: 0.85rem; width: 28px; height: 28px; border-radius: 50%;
      background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); display: flex; align-items: center;
      justify-content: center; transition: all 0.2s ease; text-decoration: none; cursor: pointer;
    }
    .grcs-social a:hover, .grcs-social span:hover {
      color: #1a1a1a; background: var(--yellow); border-color: var(--yellow); transform: translateY(-2px);
    }
    .grcs-view-badge {
      font-size: 0.72rem; font-weight: 700; color: var(--yellow); display: inline-flex;
      align-items: center; gap: 5px; transition: transform 0.2s ease;
    }
    .grcs-card:hover .grcs-view-badge { transform: translateX(3px); }
    .grcs-controls button { border-color: var(--yellow); color: var(--yellow); background: transparent; }
    .grcs-controls button:hover { background: var(--yellow); color: #1a1a1a; }
    .grcs-dots .carousel-dot { background: #555; }
    .grcs-dots .carousel-dot.active { background: var(--yellow); }

    .bursa-section { background: #fff; padding: 65px 0; }
    .bursa-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 20px; }
    .bursa-card-new {
      background: #fbfbfb; border-radius: 12px; padding: 22px 18px 18px;
      border: 1px solid #e5e7eb; border-top: 3.5px solid #CC0000;
      transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex; flex-direction: column; gap: 10px;
      text-decoration: none; color: inherit; cursor: pointer; position: relative;
    }
    .bursa-card-new:hover {
      background: #fff; transform: translateY(-6px);
      box-shadow: 0 14px 30px rgba(204,0,0,0.12);
      border-color: rgba(204,0,0,0.28);
      border-top-color: #CC0000;
    }
    .bursa-card-icon-wrap {
      width: 50px; height: 50px; background: #CC0000; border-radius: 12px;
      display: flex; align-items: center; justify-content: center; margin-bottom: 4px;
      box-shadow: 0 6px 14px rgba(204,0,0,0.22); transition: transform 0.3s ease;
    }
    .bursa-card-new:hover .bursa-card-icon-wrap { transform: scale(1.08) rotate(3deg); }
    .bursa-card-icon-wrap i { color: #fff; font-size: 1.15rem; }
    .bursa-card-title {
      font-size: 0.92rem; font-weight: 700; color: #111827; margin: 0;
      line-height: 1.35; transition: color 0.2s ease;
    }
    .bursa-card-new:hover .bursa-card-title { color: #CC0000; }
    .bursa-card-div { font-size: 0.73rem; color: #CC0000; font-weight: 600; margin: 0; }
    .bursa-card-desc {
      font-size: 0.77rem; color: #64748b; line-height: 1.6; flex: 1;
      display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin: 0;
    }
    .bursa-card-footer {
      display: flex; align-items: center; justify-content: space-between;
      border-top: 1px solid #f1f5f9; padding-top: 12px; margin-top: auto;
    }
    .bursa-badge-new {
      display: inline-block; background: #F5C400; color: #1a1a1a;
      font-size: 0.67rem; font-weight: 800; padding: 4px 10px; border-radius: 4px;
      text-transform: uppercase; letter-spacing: 0.5px; width: fit-content;
    }
    .bursa-view-badge {
      font-size: 0.72rem; font-weight: 700; color: #CC0000; display: inline-flex;
      align-items: center; gap: 5px; transition: transform 0.2s ease;
    }
    .bursa-card-new:hover .bursa-view-badge { transform: translateX(3px); }
    .bursa-header-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .btn-bursa-header-primary {
      display: inline-flex; align-items: center; gap: 8px; padding: 9px 20px;
      border-radius: 50px; font-size: 0.82rem; font-weight: 700; background: #CC0000;
      color: #fff; text-decoration: none; transition: all 0.25s ease;
    }
    .btn-bursa-header-primary:hover {
      background: #a80000; transform: translateY(-2px); box-shadow: 0 8px 18px rgba(204,0,0,0.25); color: #fff;
    }
    .btn-bursa-header-secondary {
      display: inline-flex; align-items: center; gap: 8px; padding: 9px 18px;
      border-radius: 50px; font-size: 0.82rem; font-weight: 700; background: #fff;
      color: #374151; border: 1.5px solid #d1d5db; text-decoration: none; transition: all 0.25s ease;
    }
    .btn-bursa-header-secondary:hover {
      border-color: #CC0000; color: #CC0000; transform: translateY(-2px);
    }
    .bursa-social { display: flex; gap: 8px; }
    .bursa-social a {
      color: #64748b; font-size: 0.85rem; width: 28px; height: 28px; border-radius: 50%;
      background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center;
      justify-content: center; transition: all 0.2s ease; text-decoration: none;
    }
    .bursa-social a:hover {
      color: #fff; background: #CC0000; border-color: #CC0000; transform: translateY(-2px);
    }

    @media (max-width: 992px) {
      .people-grid, .grcs-grid, .bursa-grid { grid-template-columns: repeat(2,1fr) !important; gap: 16px; }
    }
    @media (max-width: 768px) {
      .people-grid, .grcs-grid, .bursa-grid { grid-template-columns: 1fr !important; gap: 14px; }
      .section-header-flex { flex-direction: column; align-items: flex-start; gap: 12px; }
      .bursa-header-actions { width: 100%; }
      .btn-bursa-header-primary, .btn-bursa-header-secondary { width: 100%; justify-content: center; }
    }
    .testi-section { background: #ffffff; padding: 80px 0 90px; position: relative; overflow: hidden; }
    .testi-section::before { content: ''; position: absolute; inset: 0; background-image: radial-gradient(circle, rgba(204,0,0,0.06) 1px, transparent 1px); background-size: 28px 28px; pointer-events: none; z-index: 0; }
    .testi-section::after { content: ''; position: absolute; width: 500px; height: 500px; background: radial-gradient(circle, rgba(204,0,0,0.07) 0%, transparent 70%); top: -80px; right: -80px; pointer-events: none; z-index: 0; }
    .testi-section > * { position: relative; z-index: 1; }
    .testi-inner { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
    .testi-header { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 52px; flex-wrap: wrap; gap: 20px; }
    .testi-title { font-size: 2.8rem; font-weight: 800; color: #1a1a1a; line-height: 1.1; margin: 0; }
    .testi-title em { font-style: normal; color: #CC0000; position: relative; }
    .testi-title em::after { content: ''; position: absolute; bottom: 2px; left: 0; right: 0; height: 3px; background: #CC0000; opacity: 0.2; border-radius: 2px; }
    .testi-nav-btns { display: flex; gap: 10px; flex-shrink: 0; }
    .testi-nav-btn { width: 46px; height: 46px; border-radius: 50%; border: 1.5px solid #e0e0e0; background: #fff; color: #999; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.25s ease; }
    .testi-nav-btn:hover { border-color: #CC0000; background: #CC0000; color: #fff; }
    .testi-track-wrap { overflow: hidden; margin: 0 -8px; }
    .testi-track { display: flex; transition: transform 0.55s cubic-bezier(0.4, 0, 0.2, 1); will-change: transform; }
    .testi-card { flex: 0 0 calc(50% - 16px); margin: 0 8px; background: #fff; border: 1px solid #ebebeb; border-radius: 16px; padding: 36px 32px 28px; position: relative; overflow: hidden; transition: border-color 0.3s, transform 0.3s, box-shadow 0.3s; cursor: default; }
    .testi-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: #CC0000; opacity: 0; transition: opacity 0.3s; }
    .testi-card:hover { border-color: rgba(204,0,0,0.2); transform: translateY(-5px); box-shadow: 0 20px 48px rgba(204,0,0,0.1); }
    .testi-card:hover::before { opacity: 1; }
    .testi-quote-mark { font-size: 5rem; line-height: 1; color: #CC0000; opacity: 0.12; font-family: Georgia, serif; position: absolute; top: 12px; right: 24px; user-select: none; }
    .testi-stars { display: flex; gap: 3px; margin-bottom: 16px; }
    .testi-stars i { color: #F5C400; font-size: 0.9rem; }
    .testi-stars i.empty { color: #e5e7eb; }
    .testi-quote { font-size: 0.9rem; color: #555; line-height: 1.85; margin: 0 0 28px; font-style: italic; }
    .testi-author { display: flex; align-items: center; gap: 14px; border-top: 1px solid #f0f0f0; padding-top: 20px; }
    .testi-avatar-wrap { position: relative; flex-shrink: 0; }
    .testi-avatar { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; display: block; border: 2px solid #ebebeb; }
    .testi-avatar-ring { position: absolute; inset: -4px; border-radius: 50%; border: 2px solid #CC0000; opacity: 0; transition: opacity 0.3s; }
    .testi-card:hover .testi-avatar-ring { opacity: 1; }
    .testi-author-name { font-size: 0.88rem; font-weight: 700; color: #1a1a1a; margin: 0 0 3px; }
    .testi-author-role { font-size: 0.73rem; color: #999; margin: 0; }
    .testi-tag { margin-left: auto; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #CC0000; background: rgba(204,0,0,0.07); border: 1px solid rgba(204,0,0,0.18); padding: 4px 12px; border-radius: 20px; white-space: nowrap; }
    .testi-dots { display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 40px; }
    .testi-dot { width: 8px; height: 8px; border-radius: 8px; background: #ddd; cursor: pointer; transition: all 0.3s ease; border: none; padding: 0; }
    .testi-dot.active { width: 28px; background: #CC0000; }
    .testi-cta-row { display: flex; align-items: center; justify-content: center; gap: 20px; margin-top: 52px; }
    .testi-cta-divider { flex: 1; height: 1px; background: #e8e8e8; max-width: 200px; }
    .testi-cta-btn { display: inline-flex; align-items: center; gap: 10px; background: #CC0000; color: #fff; font-family: 'Poppins', sans-serif; font-size: 0.84rem; font-weight: 700; padding: 13px 32px; border-radius: 50px; text-decoration: none; border: none; cursor: pointer; transition: all 0.25s ease; letter-spacing: 0.3px; }
    .testi-cta-btn:hover { background: #a80000; transform: translateY(-2px); box-shadow: 0 10px 28px rgba(204,0,0,0.28); }
    .testi-cta-btn i { font-size: 0.8rem; transition: transform 0.2s; }
    .testi-cta-btn:hover i { transform: translateX(3px); }
    @media (max-width: 768px) { .testi-card { flex: 0 0 calc(100% - 16px); } .testi-title { font-size: 2rem; } .testi-header { flex-direction: column; align-items: flex-start; } }
@endsection

@section('content')
<section class="hero-slider" id="heroSlider">
  <div class="slider-wrapper" id="sliderWrapper">
    @forelse($sliders as $slide)
      @if($slide->type === 'banner')
        <div class="slider-slide">
          <div class="div-hero-banner"
               @if($slide->background_image)
                 style="background-image:url('{{ asset('storage/' . $slide->background_image) }}'); background-size:cover; background-position:center;"
               @endif>
            <div class="particles" id="particlesContainer"></div>
            <div class="div-hero-inner">
              <h1 class="div-hero-heading">{!! $slide->title !!}</h1>
              @if($slide->subtitle)
                <p class="div-hero-sub">{{ $slide->subtitle }}</p>
              @endif
              @if($slide->button_text && $slide->button_url)
                <div style="margin-top:24px;">
                  <a href="{{ $slide->button_url }}" class="btn-submit">{{ $slide->button_text }}</a>
                </div>
              @endif
            </div>
          </div>
        </div>
      @else
        <div class="slider-slide">
          <div class="hero"
               @if($slide->background_image)
                 style="background-image:url('{{ asset('storage/' . $slide->background_image) }}');"
               @endif>
            <div class="hero-content horizontal">
              <div class="journal-text">
                <h1>{{ $slide->title }}</h1>
                @if($slide->subtitle)
                  <p>{{ $slide->subtitle }}</p>
                @endif
                @if(!empty($slide->stats) && is_array($slide->stats))
                  <div class="divisi-stats">
                    @foreach($slide->stats as $stat)
                      @if(!empty($stat['number']) || !empty($stat['label']))
                        <div class="stat-item-div">
                          <span class="stat-number">{{ $stat['number'] ?? '' }}</span>
                          <span class="stat-label-div">{{ $stat['label'] ?? '' }}</span>
                        </div>
                      @endif
                    @endforeach
                  </div>
                @endif
                <div class="divisi-action-row">
                  @if($slide->logo_image)
                    <div class="divisi-logo">
                      <a href="{{ $slide->button_url ?? '#divisi-detail' }}" class="logo-img-container">
                        <img src="{{ asset('storage/' . $slide->logo_image) }}" alt="{{ $slide->divisi_name ?? $slide->title }}">
                      </a>
                    </div>
                  @endif
                  @if($slide->button_text)
                    <a href="{{ $slide->button_url ?? '#divisi-detail' }}" class="btn-submit">{{ $slide->button_text }}</a>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif
    @empty
      <div class="slider-slide">
        <div class="div-hero-banner">
          <div class="particles" id="particlesContainer"></div>
          <div class="div-hero-inner">
            <h1 class="div-hero-heading">9 Divisi <span>Aktif</span><br>Denpasar Institute</h1>
            <p class="div-hero-sub">Satu ekosistem lengkap mulai dari riset ilmiah, publikasi, pengembangan SDM, teknologi, budaya, hingga kewirausahaan. Transforming Ideas into Action.</p>
          </div>
        </div>
      </div>
    @endforelse
  </div>
  <button class="slider-btn-hero prev-hero" id="prevBtnHero"><i class="fas fa-chevron-left"></i></button>
  <button class="slider-btn-hero next-hero" id="nextBtnHero"><i class="fas fa-chevron-right"></i></button>
  <div class="slider-dots-hero" id="sliderDotsHero"></div>
</section>

<section class="hero-section" id="about">
  <div class="hero-grid">
    <div class="hero-left">
      <span class="label-tentang">Tentang Kami</span>
      <h1 class="hero-title">Selamat Datang<br>di Denpasar<br>Institute</h1>
      <p class="hero-desc"><strong>Denpasar Institute</strong> adalah Lembaga Riset &amp; Pengembangan SDM. Kami menyediakan kerja sama Riset, Pengembangan SDM, kolaborasi kegiatan abdimas <em>(CSR Program)</em> dan Layanan Informasi Objektif. Prioritas kami bertumpu pada moto <strong><em>"Transforming Ideas into Action"</em></strong>, yakni menerjemahkan ide dan kebutuhan <em>partners</em> menjadi tindakan nyata. Kami <a href="#" class="hero-selengkapnya">selengkapnya...</a></p>
      <div class="hero-btns"><a href="#heroSlider" class="btn-yellow">Lihat Divisi</a><a href="#contact" class="btn-yellow" style="background:#fff;border:2px solid var(--yellow);color:var(--dark);">Hubungi Kami</a></div>
    </div>
    <div class="hero-center">
      <div class="col-header"><span>Event Terbaru</span><a href="{{ route('event.index') }}">Lihat Semua</a></div>
      <div class="event-list">
        @forelse(($latestEvents ?? collect())->take(6) as $evt)
          <div class="event-item">
            <img src="{{ $evt->image ? asset('storage/'.$evt->image) : 'https://images.unsplash.com/photo-1546054454-aa26e2b734c7?w=140&auto=format&fit=crop' }}" class="event-thumb" alt="{{ $evt->title }}">
            <div>
              <span class="event-cat">{{ $evt->kategori }}</span>
              <span class="event-title">{{ $evt->title }}</span>
            </div>
          </div>
        @empty
          <div class="event-item">
            <img src="https://images.unsplash.com/photo-1546054454-aa26e2b734c7?w=140&auto=format&fit=crop" class="event-thumb">
            <div>
              <span class="event-cat">Event</span>
              <span class="event-title">Belum ada event terbaru</span>
            </div>
          </div>
        @endforelse
      </div>
    </div>
    <div class="hero-right">
      <div class="col-header"><span>Berita &amp; Opini</span><a href="{{ route('berita.index') }}">Lihat Semua</a></div>
      <div class="sharing-list">
        @forelse(($latestBeritas ?? collect())->take(5) as $b)
          <div class="sharing-item">
            <img src="{{ $b->image ? asset('storage/'.$b->image) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=140&auto=format&fit=crop' }}" class="sharing-thumb" alt="{{ $b->title }}">
            <div>
              <span class="sharing-cat red">{{ $b->kategori }}</span>
              <span class="sharing-title">{{ $b->title }}</span>
            </div>
          </div>
        @empty
          <div class="sharing-item">
            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=140&auto=format&fit=crop" class="sharing-thumb">
            <div>
              <span class="sharing-cat red">Berita</span>
              <span class="sharing-title">Belum ada berita terbaru</span>
            </div>
          </div>
        @endforelse
      </div>
      <div class="sharing-btn"><a href="{{ route('berita.index') }}">Research &amp; News Sharing</a></div>
    </div>

    <div class="hero-portal-card">
      <div class="portal-badge-label">
        <i class="fas fa-file-signature"></i> Form Pendaftaran
      </div>
      <div class="portal-card-desc">
        Akses akun konsultan, administrasi kartu anggota, dan pendaftaran program serta keanggotaan.
      </div>
      <div class="portal-btn-top">
        @auth
          @if(auth()->user()->role === 'konsultan')
            <a href="{{ route('backoffice.konsultan.show', auth()->user()->id) }}" class="btn-portal-main">
              <i class="fas fa-user-tie"></i> Akun Konsultan
            </a>
          @elseif(auth()->user()->role === 'grcs')
            <a href="{{ route('backoffice.grcs.show', auth()->user()->id) }}" class="btn-portal-main">
              <i class="fas fa-users"></i> Akun GRCS
            </a>
          @else
            <a href="{{ route('backoffice.dashboard') }}" class="btn-portal-main">
              <i class="fas fa-th-large"></i> Dashboard
            </a>
          @endif
          <form action="{{ route('backoffice.logout') }}" method="POST" style="display:inline; margin-left:8px;">
            @csrf
            <button type="submit" class="btn-portal-secondary" title="Keluar"><i class="fas fa-sign-out-alt"></i> Keluar</button>
          </form>
        @else
          <a href="{{ route('backoffice.login') }}" class="btn-portal-main">
            <i class="fas fa-sign-in-alt"></i> Login
          </a>
        @endauth
      </div>
      <div class="portal-btn-row">
        <a href="{{ route('admission.create') }}" class="btn-portal-secondary">
          <i class="fas fa-graduation-cap"></i> Daftar Program
        </a>
        <a href="{{ route('pendaftaran.konsultan') }}" class="btn-portal-secondary">
          <i class="fas fa-user-tie"></i> Daftar Konsultan
        </a>
        <a href="{{ route('pendaftaran.grcs') }}" class="btn-portal-secondary">
          <i class="fas fa-users"></i> Daftar GRCS
        </a>
      </div>
    </div>
  </div>
</section>

<section class="stats-section" id="stats">
  <div class="stats-container">
    <div class="stats-header">
      <h2 class="stats-title">Denpasar Institute <em>dalam Angka</em></h2>
      <p class="stats-subtitle">Data statistik ini mencerminkan komitmen dan dampak nyata dari kami</p>
    </div>
    <div class="stats-grid-new">
      @forelse($statistics as $stat)
        <div class="stat-card">
          <div class="stat-icon-wrap"><i class="fas {{ $stat->icon }}"></i></div>
          <div class="stat-number-new count" data-target="{{ $stat->number }}">0</div>
          <p class="stat-label-new">{{ $stat->label }}</p>
          @if($stat->trend_percentage)
            <span class="stat-trend">
              <i class="fas fa-arrow-{{ $stat->trend_direction === 'up' ? 'up' : 'down' }}"></i>
              {{ $stat->trend_percentage }}%
            </span>
          @endif
        </div>
      @empty
        <p style="grid-column:1/-1;text-align:center;color:#999;">Belum ada data statistik.</p>
      @endforelse
    </div>
  </div>
</section>

<section id="divisi-detail" style="background: var(--gray); padding: 60px 0;">
  <div class="container">
    <div class="section-header"><span class="section-tag">Divisi</span><h2>Our Divisions</h2><div class="section-line"></div></div>
    <div class="carousel" id="divisionCarousel">
      <div class="carousel-inner-wrap" id="divisionInner">
        @php
            $divisiChunks = ($divisis ?? collect())->chunk(4);
            $divisiTotalSlides = max(1, $divisiChunks->count());
            $divisiNames = ['Riset dan Inovasi', 'Publikasi & HKI', 'Pengembangan SDM', 'Vokasi & Sertifikasi', 'Sains Data & Teknologi', 'Bahasa, Seni & Budaya', 'Kerja Sama & Hub. Int.', 'Konsultan', 'Karir & Kewirausahaan'];
            $divisiImages = ['/image/divisi-01-riset.png', '/image/divisi-02-publikasi.png', '/image/divisi-03-sdm.png', '/image/divisi-04-vokasi.png', '/image/divisi-05-data.png', '/image/divisi-06-budaya.png', '/image/divisi-07-kerjasama.png', '/image/divisi-08-konsultan.png', '/image/divisi-09-karir.png'];
            $divisiBadges = ['Penelitian', 'Publikasi', 'Pelatihan', 'Sertifikasi', 'Teknologi', 'Budaya', 'Internasional', 'Konsultasi', 'Karir'];
            $divisiDescs = [
                'Mendorong penelitian berkualitas tinggi dan inovasi berbasis bukti.',
                'Mengelola penerbitan jurnal, buku, layanan HKI dan paten.',
                'Pelatihan, workshop, seminar untuk meningkatkan kompetensi.',
                'Pendidikan vokasi dan program sertifikasi nasional & internasional.',
                'Solusi big data, AI, transformasi digital institusi.',
                'Pelestarian bahasa, riset budaya, digitalisasi warisan.',
                'Kemitraan global, pertukaran ilmu, beasiswa, kolaborasi riset.',
                'Konsultasi manajemen, kebijakan publik, riset terapan.',
                'Inkubasi bisnis, program wirausaha, pendampingan startup.'
            ];
            $divisiSlugs = ['riset-dan-inovasi', 'publikasi-hki', 'pengembangan-sdm', 'vokasi-sertifikasi', 'sains-data-teknologi', 'bahasa-seni-budaya', 'kerjasama-hub-int', 'konsultan', 'karir-kewirausahaan'];
        @endphp

        @forelse($divisiChunks as $chunkIndex => $chunk)
          <div class="carousel-slide"><div class="div-grid-2x2">
            @foreach($chunk as $divisi)
              <a href="{{ route('divisi.show', $divisi->slug ?? $divisiSlugs[$loop->parent->index * 4 + $loop->index] ?? '#') }}" class="div-card-h" style="text-decoration: none; cursor: pointer; display: flex; flex-direction: column; gap: 12px; padding: 22px 22px 16px; background: var(--red); border-radius: 14px; transition: transform 0.25s ease, box-shadow 0.25s ease;">
                <div class="div-card-h-left">
                  <div class="div-avatar">
                    @if($divisi->logo_image)
                      <img src="{{ asset('storage/' . $divisi->logo_image) }}" alt="{{ $divisi->nama }}">
                    @else
                      <img src="{{ $divisiImages[$loop->parent->index * 4 + $loop->index] ?? '/image/divisi-01-riset.png' }}" alt="{{ $divisi->nama ?? $divisiNames[$loop->parent->index * 4 + $loop->index] }}">
                    @endif
                  </div>
                  <div>
                    <p class="div-card-num">Divisi {{ str_pad($loop->parent->index * 4 + $loop->index + 1, 2, '0', STR_PAD_LEFT) }}</p>
                    <p class="div-card-name">{{ $divisi->nama ?? $divisiNames[$loop->parent->index * 4 + $loop->index] }}</p>
                  </div>
                </div>
                <p class="div-card-desc">{{ $divisi->deskripsi ? \Illuminate\Support\Str::limit(strip_tags($divisi->deskripsi), 100) : ($divisiDescs[$loop->parent->index * 4 + $loop->index] ?? '') }}</p>
                <div class="div-card-footer">
                  <div class="div-socials">
                    <span style="color: rgba(255,255,255,0.55); font-size: 0.9rem; display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.2); cursor: pointer; transition: 0.2s;">
                    </span>
                  </div>
                  <span class="div-badge">{{ $divisiBadges[$loop->parent->index * 4 + $loop->index] ?? 'Divisi' }}</span>
                </div>
              </a>
            @endforeach

            @if($loop->index === $divisiChunks->count() - 1 && $chunk->count() < 4)
              @for($i = 0; $i < 4 - $chunk->count(); $i++)
                <div class="div-card-h div-card-cta" style="display: flex; flex-direction: column; gap: 12px; padding: 22px 22px 16px; background: var(--red); border-radius: 14px; transition: transform 0.25s ease, box-shadow 0.25s ease; cursor: pointer;">
                  <div class="div-card-h-left">
                    <div class="div-avatar">
                      @if($i === 0)
                        <i class="fas fa-handshake" style="color: #fff; font-size: 24px;"></i>
                      @elseif($i === 1)
                        <i class="fas fa-star" style="color: #fff; font-size: 24px;"></i>
                      @else
                        <i class="fas fa-phone-alt" style="color: #fff; font-size: 24px;"></i>
                      @endif
                    </div>
                    <div>
                      <p class="div-card-num">
                        @if($i === 0)
                          Kolaborasi
                        @elseif($i === 1)
                          Keunggulan
                        @else
                          Kontak
                        @endif
                      </p>
                      <p class="div-card-name">
                        @if($i === 0)
                          Bergabung
                        @elseif($i === 1)
                          {{ $divisiChunks->count() === 1 ? $divisiChunks[0]->count() : 4 }} Divisi Aktif
                        @else
                          Hubungi Kami
                        @endif
                      </p>
                    </div>
                  </div>
                  <p class="div-card-desc">
                    @if($i === 0)
                      Jadilah bagian dari ekosistem riset & inovasi Denpasar Institute.
                    @elseif($i === 1)
                      One-stop solution riset, pengembangan SDM, inovasi institusi.
                    @else
                      Siap berdiskusi tentang kebutuhan riset & pengembangan Anda.
                    @endif
                  </p>
                  <div class="div-card-footer">
                    <div class="div-socials">
                      <a href="@if($i === 0)#contact @elseif($i === 1)#heroSlider @else https://wa.me/6282144814593 @endif" style="color: rgba(255,255,255,0.55); font-size: 0.9rem; width: 28px; height: 28px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; transition: 0.2s; text-decoration: none; cursor: pointer;">
                        @if($i === 0)
                          <i class="fas fa-envelope"></i>
                        @elseif($i === 1)
                          <i class="fas fa-th-large"></i>
                        @else
                          <i class="fab fa-whatsapp"></i>
                        @endif
                      </a>
                    </div>
                    <span class="div-badge">
                      @if($i === 0)
                        Daftar
                      @elseif($i === 1)
                        Pelajari
                      @else
                        Kirim Pesan
                      @endif
                    </span>
                  </div>
                </div>
              @endfor
            @endif
          </div></div>
        @empty
          <div class="carousel-slide"><div class="div-grid-2x2">
            @for($i = 0; $i < 9; $i++)
              @if($i < 8)
                <a href="{{ route('divisi.show', $divisiSlugs[$i] ?? '#') }}" class="div-card-h" style="text-decoration: none; cursor: pointer; display: flex; flex-direction: column; gap: 12px; padding: 22px 22px 16px; background: var(--red); border-radius: 14px; transition: transform 0.25s ease, box-shadow 0.25s ease;">
                  <div class="div-card-h-left">
                    <div class="div-avatar">
                      <img src="{{ $divisiImages[$i] }}" alt="{{ $divisiNames[$i] }}">
                    </div>
                    <div>
                      <p class="div-card-num">Divisi {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</p>
                      <p class="div-card-name">{{ $divisiNames[$i] }}</p>
                    </div>
                  </div>
                  <p class="div-card-desc">{{ $divisiDescs[$i] }}</p>
                  <div class="div-card-footer">
                    <div class="div-socials">
                      <span style="color: rgba(255,255,255,0.55); font-size: 0.9rem; display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.2); cursor: pointer; transition: 0.2s;">
                        <i class="fas fa-arrow-right"></i>
                      </span>
                    </div>
                    <span class="div-badge">{{ $divisiBadges[$i] }}</span>
                  </div>
                </a>
              @else
                <div class="div-card-h div-card-cta" style="display: flex; flex-direction: column; gap: 12px; padding: 22px 22px 16px; background: var(--red); border-radius: 14px; transition: transform 0.25s ease, box-shadow 0.25s ease; cursor: pointer;">
                  <div class="div-card-h-left">
                    <div class="div-avatar"><i class="fas fa-phone-alt" style="color: #fff; font-size: 24px;"></i></div>
                    <div>
                      <p class="div-card-num">Kontak</p>
                      <p class="div-card-name">Hubungi Kami</p>
                    </div>
                  </div>
                  <p class="div-card-desc">Siap berdiskusi tentang kebutuhan riset & pengembangan Anda.</p>
                  <div class="div-card-footer">
                    <div class="div-socials">
                      <a href="https://wa.me/6282144814593" style="color: rgba(255,255,255,0.55); font-size: 0.9rem; width: 28px; height: 28px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; transition: 0.2s; text-decoration: none; cursor: pointer;">
                        <i class="fab fa-whatsapp"></i>
                      </a>
                    </div>
                    <span class="div-badge">Kirim Pesan</span>
                  </div>
                </div>
              @endif
            @endfor
          </div></div>
        @endforelse
      </div>
      <div class="carousel-controls-row"><button id="divPrevBtn"><i class="fas fa-chevron-left"></i></button><button id="divNextBtn"><i class="fas fa-chevron-right"></i></button></div>
      <div class="carousel-dots" id="divisionDots"></div>
    </div>
  </div>
</section>

<section class="konsultan-section" id="konsultan">
  <div class="container">
    <div class="section-header-flex">
      <div class="section-header">
        <span class="section-tag">Tim Ahli</span>
        <h2>Konsultan</h2>
        <div class="section-line"></div>
      </div>
      <a href="{{ route('konsultan.index') }}" class="section-action-link">
        Lihat Semua Konsultan <i class="fas fa-arrow-right"></i>
      </a>
    </div>

    <div class="carousel" id="konsultanCarousel">
      <div class="carousel-inner-wrap" id="konsultanInner">
        @forelse(($konsultans ?? collect())->chunk(4) as $chunk)
          <div class="carousel-slide"><div class="people-grid">
            @foreach($chunk as $k)
              <a href="{{ route('konsultan.show', $k->id) }}" class="people-card" title="Lihat profil lengkap {{ $k->name }}">
                <div class="people-avatar">
                  <img src="{{ $k->foto ? asset('storage/'.$k->foto) : ($k->avatar ? asset('storage/'.$k->avatar) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=200&auto=format&fit=crop') }}" alt="{{ $k->name }}">
                </div>
                <div class="people-name">{{ $k->name }}</div>
                <div class="people-inst">{{ $k->institution ?? ($k->position ?? 'Konsultan Ahli') }}</div>
                <p class="people-desc">{{ \Illuminate\Support\Str::limit($k->bio ?? $k->keahlian_utama ?? 'Konsultan ahli dan akademisi di Denpasar Institute.', 110) }}</p>
                <div class="people-footer">
                  <div class="people-social">
                    @if($k->linkedin)
                      <span onclick="event.preventDefault(); event.stopPropagation(); window.open('{{ $k->linkedin }}', '_blank');" title="LinkedIn"><i class="fab fa-linkedin-in"></i></span>
                    @endif
                    @if($k->website)
                      <span onclick="event.preventDefault(); event.stopPropagation(); window.open('{{ $k->website }}', '_blank');" title="Website"><i class="fas fa-globe"></i></span>
                    @endif
                  </div>
                  <span class="people-view-badge">Lihat Profil <i class="fas fa-arrow-right"></i></span>
                </div>
              </a>
            @endforeach
          </div></div>
        @empty
          <div class="carousel-slide"><div class="people-grid">
            <p style="grid-column:1/-1;text-align:center;color:#999;">Belum ada data konsultan.</p>
          </div></div>
        @endforelse
      </div>
      <div class="carousel-controls-row"><button id="konsulPrevBtn"><i class="fas fa-chevron-left"></i></button><button id="konsulNextBtn"><i class="fas fa-chevron-right"></i></button></div>
      <div class="carousel-dots" id="konsultanDots"></div>
    </div>
  </div>
</section>

<section class="grcs-section" id="grcs">
  <div class="container">
    <div class="section-header-flex">
      <div class="section-header">
        <span class="section-tag" style="background:var(--yellow);color:var(--dark);">Komunitas</span>
        <h2>GRCS Club</h2>
        <div class="section-line"></div>
      </div>
      <a href="{{ route('grcs.index') }}" class="grcs-action-link">
        Lihat Semua Anggota <i class="fas fa-arrow-right"></i>
      </a>
    </div>
    <div class="carousel" id="grcsCarousel">
      <div class="carousel-inner-wrap" id="grcsInner">
        @forelse(($grcsMembers ?? collect())->chunk(4) as $chunk)
          <div class="carousel-slide"><div class="grcs-grid">
            @foreach($chunk as $g)
              <a href="{{ route('grcs.show', $g->id) }}" class="grcs-card" title="Lihat profil lengkap {{ $g->name }}">
                <div class="grcs-avatar">
                  <img src="{{ $g->foto ? asset('storage/'.$g->foto) : ($g->avatar ? asset('storage/'.$g->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($g->name).'&background=F5C400&color=1a1a1a&size=200') }}" alt="{{ $g->name }}">
                </div>
                <div class="grcs-name">{{ $g->name }}</div>
                <div class="grcs-role">{{ $g->position ?: ($g->institution ?: ($g->nama_instansi ?: ($g->provinsi ? 'Anggota — '.$g->provinsi : 'Anggota GRCS Club'))) }}</div>
                <p class="grcs-desc">{{ \Illuminate\Support\Str::limit($g->bio ?: ($g->profil ?: ($g->keahlian_utama ?: 'Anggota komunitas riset, tata kelola, dan kepatuhan GRCS Club di Denpasar Institute.')), 110) }}</p>
                <div class="grcs-footer">
                  <div class="grcs-social">
                    @if($g->linkedin)
                      <span onclick="event.preventDefault(); event.stopPropagation(); window.open('{{ $g->linkedin }}', '_blank');" title="LinkedIn"><i class="fab fa-linkedin-in"></i></span>
                    @endif
                    @if($g->website)
                      <span onclick="event.preventDefault(); event.stopPropagation(); window.open('{{ $g->website }}', '_blank');" title="Website"><i class="fas fa-globe"></i></span>
                    @endif
                  </div>
                  <span class="grcs-view-badge">Lihat Profil <i class="fas fa-arrow-right"></i></span>
                </div>
              </a>
            @endforeach
          </div></div>
        @empty
          <div class="carousel-slide"><div class="grcs-grid">
            <p style="grid-column:1/-1;text-align:center;color:#999;">Belum ada anggota GRCS Club.</p>
          </div></div>
        @endforelse
      </div>
      <div class="carousel-controls-row grcs-controls"><button id="grcsPrevBtn"><i class="fas fa-chevron-left"></i></button><button id="grcsNextBtn"><i class="fas fa-chevron-right"></i></button></div>
      <div class="carousel-dots grcs-dots" id="grcsDots"></div>
    </div>
  </div>
</section>

<section class="bursa-section" id="bursa">
  <div class="container">
    <div class="section-header-flex">
      <div>
        <div class="section-header">
          <span class="section-tag">Karir &amp; Talenta</span>
          <h2>Bursa SDM</h2>
          <div class="section-line"></div>
        </div>
        <p style="font-size:0.88rem; color:#64748b; margin-top:6px; margin-bottom:0; max-width:650px;">
          Platform ini memudahkan pemberi kerja mempublikasikan lowongan pekerjaan dan membantu pencari kerja menampilkan keahlian mereka kepada perusahaan yang sesuai.
        </p>
      </div>
      <div class="bursa-header-actions">
        <a href="{{ route('bursa-sdm.index') }}" class="btn-bursa-header-primary">
          <i class="fas fa-briefcase"></i> Lihat Semua Peluang
        </a>
        <a href="{{ route('bursa-sdm.create', 'perusahaan') }}" class="btn-bursa-header-secondary" title="Pasang info lowongan atau rekrutmen mitra">
          <i class="fas fa-plus-circle"></i> Pasang Lowongan
        </a>
      </div>
    </div>
    
    @php
        $bursaChunks = ($bursaSdmItems ?? collect())->chunk(4);
        $bursaTotalSlides = $bursaChunks->isNotEmpty() ? $bursaChunks->count() : 2;
    @endphp
    
    <div class="carousel" id="bursaCarousel">
      <div class="carousel-inner-wrap" id="bursaInner">
        @forelse($bursaChunks as $chunk)
          <div class="carousel-slide"><div class="bursa-grid">
            @foreach($chunk as $item)
              <a href="{{ route('bursa-sdm.show', $item->slug) }}" class="bursa-card-new" title="Lihat detail {{ $item->nama }}">
                <div class="bursa-card-icon-wrap">
                  @if($item->foto)
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" style="width:100%;height:100%;object-fit:cover;border-radius:12px;">
                  @else
                    <i class="fas {{ $item->tipe === 'perusahaan' ? 'fa-building' : 'fa-user-tie' }}"></i>
                  @endif
                </div>
                <div class="bursa-card-title">{{ $item->nama }}</div>
                <div class="bursa-card-div">
                  {{ $item->kategori ?? ($item->tipe === 'perusahaan' ? 'Perusahaan' : 'Individu') }}
                  @if($item->bidang_usaha)
                    &bull; {{ $item->bidang_usaha }}
                  @endif
                </div>
                
                @if($item->tipe === 'individu' && $item->keahlian)
                  <p class="bursa-card-desc">
                    <strong>Keahlian:</strong> {{ $item->keahlian }}
                    @if($item->posisi_dicari)
                      <br><strong>Posisi:</strong> {{ $item->posisi_dicari }}
                    @endif
                  </p>
                @else
                  <p class="bursa-card-desc">
                    {{ $item->deskripsi ? \Illuminate\Support\Str::limit($item->deskripsi, 110) : ($item->tipe === 'perusahaan' ? 'Mencari kandidat terbaik untuk bergabung dengan tim kami.' : 'Mencari peluang karir yang sesuai dengan keahlian.') }}
                  </p>
                @endif
                
                <div class="bursa-card-footer">
                  <span class="bursa-badge-new">{{ $item->tipe === 'perusahaan' ? 'Sedang Merekrut' : 'Talenta Tersedia' }}</span>
                  <span class="bursa-view-badge">Lihat Detail <i class="fas fa-arrow-right"></i></span>
                </div>
              </a>
            @endforeach
          </div></div>
        @empty
          <div class="carousel-slide"><div class="bursa-grid">
            <a href="{{ route('bursa-sdm.index') }}" class="bursa-card-new" title="Lihat peluang Research Assistant di Bursa SDM">
              <div class="bursa-card-icon-wrap"><i class="fas fa-flask"></i></div>
              <div class="bursa-card-title">Research Assistant</div>
              <div class="bursa-card-div">Divisi Riset &amp; Inovasi</div>
              <p class="bursa-card-desc">Mendukung kegiatan penelitian lapangan, pengolahan data saintifik, dan laboratorium riset.</p>
              <div class="bursa-card-footer">
                <span class="bursa-badge-new">Buka Lamaran</span>
                <span class="bursa-view-badge">Lihat Detail <i class="fas fa-arrow-right"></i></span>
              </div>
            </a>
            <a href="{{ route('bursa-sdm.index') }}" class="bursa-card-new" title="Lihat peluang Editor Jurnal Ilmiah di Bursa SDM">
              <div class="bursa-card-icon-wrap"><i class="fas fa-pen-nib"></i></div>
              <div class="bursa-card-title">Editor Jurnal Ilmiah</div>
              <div class="bursa-card-div">Divisi Publikasi &amp; HKI</div>
              <p class="bursa-card-desc">Editor berpengalaman dalam telaah manuskrip sains sosial, humaniora, dan penerbitan berkala.</p>
              <div class="bursa-card-footer">
                <span class="bursa-badge-new">Full-time</span>
                <span class="bursa-view-badge">Lihat Detail <i class="fas fa-arrow-right"></i></span>
              </div>
            </a>
            <a href="{{ route('bursa-sdm.index') }}" class="bursa-card-new" title="Lihat peluang Instruktur Pelatihan di Bursa SDM">
              <div class="bursa-card-icon-wrap"><i class="fas fa-chalkboard-teacher"></i></div>
              <div class="bursa-card-title">Instruktur Pelatihan</div>
              <div class="bursa-card-div">Divisi Pengembangan SDM</div>
              <p class="bursa-card-desc">Fasilitator pengembangan soft skill, sertifikasi kompetensi, kepemimpinan, dan vokasi.</p>
              <div class="bursa-card-footer">
                <span class="bursa-badge-new">Part-time</span>
                <span class="bursa-view-badge">Lihat Detail <i class="fas fa-arrow-right"></i></span>
              </div>
            </a>
            <a href="{{ route('bursa-sdm.index') }}" class="bursa-card-new" title="Lihat peluang Data Scientist di Bursa SDM">
              <div class="bursa-card-icon-wrap"><i class="fas fa-laptop-code"></i></div>
              <div class="bursa-card-title">Data Scientist</div>
              <div class="bursa-card-div">Divisi Sains Data &amp; Teknologi</div>
              <p class="bursa-card-desc">Ahli machine learning, pemodelan statistik prediktif, dan analitik data terapan.</p>
              <div class="bursa-card-footer">
                <span class="bursa-badge-new">Buka Lamaran</span>
                <span class="bursa-view-badge">Lihat Detail <i class="fas fa-arrow-right"></i></span>
              </div>
            </a>
          </div></div>
          <div class="carousel-slide"><div class="bursa-grid">
            <a href="{{ route('bursa-sdm.index') }}" class="bursa-card-new" title="Lihat peluang International Liaison di Bursa SDM">
              <div class="bursa-card-icon-wrap"><i class="fas fa-globe"></i></div>
              <div class="bursa-card-title">International Liaison</div>
              <div class="bursa-card-div">Divisi Kerja Sama Int.</div>
              <p class="bursa-card-desc">Penghubung kemitraan akademik &amp; industri global dengan institusi mitra internasional.</p>
              <div class="bursa-card-footer">
                <span class="bursa-badge-new">Kontrak</span>
                <span class="bursa-view-badge">Lihat Detail <i class="fas fa-arrow-right"></i></span>
              </div>
            </a>
            <a href="{{ route('bursa-sdm.index') }}" class="bursa-card-new" title="Lihat peluang Penerjemah Tersertifikasi di Bursa SDM">
              <div class="bursa-card-icon-wrap"><i class="fas fa-language"></i></div>
              <div class="bursa-card-title">Penerjemah Tersertifikasi</div>
              <div class="bursa-card-div">Divisi Bahasa, Seni &amp; Budaya</div>
              <p class="bursa-card-desc">Penerjemah profesional tersumpah dan penyunting dokumen akademik multi-bahasa.</p>
              <div class="bursa-card-footer">
                <span class="bursa-badge-new">Freelance</span>
                <span class="bursa-view-badge">Lihat Detail <i class="fas fa-arrow-right"></i></span>
              </div>
            </a>
            <a href="{{ route('bursa-sdm.index') }}" class="bursa-card-new" title="Lihat peluang Business Consultant di Bursa SDM">
              <div class="bursa-card-icon-wrap"><i class="fas fa-briefcase"></i></div>
              <div class="bursa-card-title">Business Consultant</div>
              <div class="bursa-card-div">Divisi Konsultan</div>
              <p class="bursa-card-desc">Konsultan manajemen, studi kelayakan bisnis, tata kelola, dan strategi institusi.</p>
              <div class="bursa-card-footer">
                <span class="bursa-badge-new">Full-time</span>
                <span class="bursa-view-badge">Lihat Detail <i class="fas fa-arrow-right"></i></span>
              </div>
            </a>
            <a href="{{ route('bursa-sdm.index') }}" class="bursa-card-new" title="Lihat peluang Startup Mentor di Bursa SDM">
              <div class="bursa-card-icon-wrap"><i class="fas fa-rocket"></i></div>
              <div class="bursa-card-title">Startup Mentor</div>
              <div class="bursa-card-div">Divisi Karir &amp; Kewirausahaan</div>
              <p class="bursa-card-desc">Mentor inkubator bisnis, pendampingan perintisan usaha, dan akselerasi wirausaha muda.</p>
              <div class="bursa-card-footer">
                <span class="bursa-badge-new">Part-time</span>
                <span class="bursa-view-badge">Lihat Detail <i class="fas fa-arrow-right"></i></span>
              </div>
            </a>
          </div></div>
        @endforelse
      </div>
      <div class="carousel-controls-row"><button id="bursaPrevBtn"><i class="fas fa-chevron-left"></i></button><button id="bursaNextBtn"><i class="fas fa-chevron-right"></i></button></div>
      <div class="carousel-dots" id="bursaDots"></div>
    </div>
  </div>
</section>

<section class="news-section" id="news">
  <div class="container">
    <div class="section-header"><span class="section-tag">Berita</span><h2>News &amp; Event</h2><div class="section-line"></div></div>
    <div class="news-grid">
      @forelse($latestBeritas ?? [] as $b)
        <a href="{{ route('berita.show', $b->id) }}" class="news-card" style="color:inherit;">
          <img src="{{ $b->image ? asset('storage/'.$b->image) : 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=600&auto=format&fit=crop' }}">
          <div class="news-card-body">
            <span class="news-card-cat">{{ $b->kategori }}</span>
            <h3 class="news-card-title">{{ $b->title }}</h3>
            <p class="news-card-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($b->content), 110) }}</p>
            <div class="news-card-footer">
              <span class="news-date"><i class="far fa-calendar-alt"></i> {{ $b->published_at ? $b->published_at->format('d M Y') : $b->created_at->format('d M Y') }}</span>
              <span class="btn-read">Baca</span>
            </div>
          </div>
        </a>
      @empty
        <p style="grid-column:1/-1;text-align:center;color:#999;">Belum ada berita terbaru.</p>
      @endforelse
    </div>
    <div class="news-more"><a href="{{ route('berita.index') }}" class="btn-more">Lihat Semua Berita</a></div>
  </div>
</section>

<section class="testi-section" id="testimonial">
  <div class="testi-inner">
    <div class="testi-header">
      <div>
        <h2 class="testi-title">Apresiasi <em>Mereka</em></h2>
      </div>
      <div class="testi-nav-btns">
        <button class="testi-nav-btn" id="testiPrev" aria-label="Sebelumnya"><i class="fas fa-chevron-left"></i></button>
        <button class="testi-nav-btn" id="testiNext" aria-label="Selanjutnya"><i class="fas fa-chevron-right"></i></button>
      </div>
    </div>

    <div class="testi-track-wrap">
      <div class="testi-track" id="testiTrack">
        @forelse($testimonials as $t)
        <div class="testi-card">
          <span class="testi-quote-mark">"</span>
          <div class="testi-stars">
            @for($i = 1; $i <= 5; $i++)
              <i class="fas fa-star {{ $i <= $t->rating ? '' : 'empty' }}"></i>
            @endfor
          </div>
          <p class="testi-quote">{{ $t->quote }}</p>
          <div class="testi-author">
            <div class="testi-avatar-wrap">
              @if($t->avatar)
                <img src="{{ asset('storage/' . $t->avatar) }}" class="testi-avatar" alt="{{ $t->name }}">
              @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($t->name) }}&background=CC0000&color=fff&size=100" class="testi-avatar" alt="{{ $t->name }}">
              @endif
              <div class="testi-avatar-ring"></div>
            </div>
            <div>
              <p class="testi-author-name">{{ $t->name }}</p>
              <p class="testi-author-role">{{ $t->role ?? '' }}</p>
            </div>
            @if($t->tag)
              <span class="testi-tag">{{ $t->tag }}</span>
            @endif
          </div>
        </div>
        @empty
        <div class="testi-card">
          <span class="testi-quote-mark">"</span>
          <div class="testi-stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <p class="testi-quote">Terimakasih DI yang telah mengajarkan dan membimbing saya dalam pengolahan data SPSS yang akan berkaitan nantinya dengan penyelesaian tugas akhir (skripsi). Penjelasannya sangat mudah dipahami.</p>
          <div class="testi-author">
            <div class="testi-avatar-wrap">
              <img src="https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=200&auto=format&fit=crop" class="testi-avatar" alt="Ni Nyoman Sri Wahyuni">
              <div class="testi-avatar-ring"></div>
            </div>
            <div><p class="testi-author-name">Ni Nyoman Sri Wahyuni</p><p class="testi-author-role">Pegawai Swasta</p></div>
            <span class="testi-tag">Sains Data</span>
          </div>
        </div>
        <div class="testi-card">
          <span class="testi-quote-mark">"</span>
          <div class="testi-stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <p class="testi-quote">Terima kasih DI telah mengajarkan dan membimbing saya tentang ilmu pengolaan data (SPSS), ilmu tersebut sangat berguna dalam membuat skripsi. Saya sangat merekomendasikan program ini.</p>
          <div class="testi-author">
            <div class="testi-avatar-wrap">
              <img src="https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=200&auto=format&fit=crop" class="testi-avatar" alt="Kadek Ayu Yuliantini">
              <div class="testi-avatar-ring"></div>
            </div>
            <div><p class="testi-author-name">Kadek Ayu Yuliantini</p><p class="testi-author-role">Mahasiswa</p></div>
            <span class="testi-tag">Riset</span>
          </div>
        </div>
        @endforelse
      </div>
    </div>

    <div class="testi-dots" id="testiDots"></div>

    <div class="testi-cta-row">
      <div class="testi-cta-divider"></div>
      <button class="testi-cta-btn" id="openTestiModal">
        <i class="fas fa-plus"></i> Bagikan Pengalaman Anda
      </button>
      <div class="testi-cta-divider"></div>
    </div>
  </div>
</section>

<div id="testiModalOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;padding:20px;">
  <div style="background:#fff;border-radius:16px;width:100%;max-width:540px;padding:36px 32px;position:relative;max-height:90vh;overflow-y:auto;">
    <button id="closeTestiModal" style="position:absolute;top:16px;right:16px;background:none;border:none;font-size:1.3rem;cursor:pointer;color:#999;">&times;</button>
    <h3 style="font-size:1.1rem;font-weight:700;margin:0 0 4px;color:#111;">Bagikan Pengalaman Anda</h3>
    <p style="font-size:0.8rem;color:#9ca3af;margin:0 0 24px;">Testimoni akan ditampilkan setelah diverifikasi oleh tim kami.</p>

    @if(session('success'))
      <div style="background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:0.83rem;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('testimonial.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
        <div>
          <label style="font-size:0.75rem;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Nama Lengkap *</label>
          <input type="text" name="name" value="{{ old('name') }}" required
                 style="width:100%;padding:9px 12px;border:1px solid #e5e7eb;border-radius:8px;font-size:0.83rem;font-family:Poppins,sans-serif;outline:none;">
          @error('name')<small style="color:#CC0000;">{{ $message }}</small>@enderror
        </div>
        <div>
          <label style="font-size:0.75rem;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Pekerjaan / Jabatan</label>
          <input type="text" name="role" value="{{ old('role') }}" placeholder="cth: Mahasiswa"
                 style="width:100%;padding:9px 12px;border:1px solid #e5e7eb;border-radius:8px;font-size:0.83rem;font-family:Poppins,sans-serif;outline:none;">
        </div>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
        <div>
          <label style="font-size:0.75rem;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Bidang / Tag</label>
          <input type="text" name="tag" value="{{ old('tag') }}" placeholder="cth: Riset, Vokasi"
                 style="width:100%;padding:9px 12px;border:1px solid #e5e7eb;border-radius:8px;font-size:0.83rem;font-family:Poppins,sans-serif;outline:none;">
        </div>
        <div>
          <label style="font-size:0.75rem;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Rating *</label>
          <select name="rating" required style="width:100%;padding:9px 12px;border:1px solid #e5e7eb;border-radius:8px;font-size:0.83rem;font-family:Poppins,sans-serif;outline:none;">
            @for($i = 5; $i >= 1; $i--)
              <option value="{{ $i }}" {{ old('rating', 5) == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
            @endfor
          </select>
        </div>
      </div>

      <div style="margin-bottom:14px;">
        <label style="font-size:0.75rem;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Testimoni *</label>
        <textarea name="quote" rows="4" required placeholder="Ceritakan pengalaman Anda bersama Denpasar Institute..."
                  style="width:100%;padding:9px 12px;border:1px solid #e5e7eb;border-radius:8px;font-size:0.83rem;font-family:Poppins,sans-serif;outline:none;resize:vertical;">{{ old('quote') }}</textarea>
        @error('quote')<small style="color:#CC0000;">{{ $message }}</small>@enderror
      </div>

      <div style="margin-bottom:20px;">
        <label style="font-size:0.75rem;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Foto (opsional)</label>
        <input type="file" name="avatar" accept="image/*"
               style="font-size:0.8rem;font-family:Poppins,sans-serif;">
        @error('avatar')<small style="color:#CC0000;">{{ $message }}</small>@enderror
      </div>

      <button type="submit"
              style="width:100%;padding:12px;background:#CC0000;color:#fff;border:none;border-radius:8px;font-weight:700;font-size:0.88rem;font-family:Poppins,sans-serif;cursor:pointer;transition:background 0.2s;">
        <i class="fas fa-paper-plane"></i> Kirim Testimoni
      </button>
    </form>
  </div>
</div>

<section class="contact-section" id="contact">
  <div class="contact-grid">
    <div class="contact-left">
      <h2>Mari Berkolaborasi</h2>
      <p>Kami percaya kemajuan terbaik lahir dari kolaborasi. Bersama Denpasar Institute, kita wujudkan inovasi yang memberi dampak nyata bagi masyarakat dan bangsa.</p>
      <p class="highlight">"Transforming Ideas into Action"</p>
      <div style="display:flex;gap:14px;margin-top:10px;flex-wrap:wrap;">
        <div style="display:flex;align-items:flex-start;gap:8px;color:rgba(255,255,255,0.85);font-size:0.84rem;">
          <i class="fab fa-whatsapp" style="color:#25d366;font-size:1.1rem;margin-top:2px;"></i>
          <div style="display:flex;flex-direction:column;gap:3px;">
            <a href="https://wa.me/6282144814593" target="_blank" rel="noopener noreferrer" style="color:inherit;text-decoration:none;white-space:nowrap;">+62 821-4481-4593</a>
            <a href="https://wa.me/6282318666547" target="_blank" rel="noopener noreferrer" style="color:inherit;text-decoration:none;white-space:nowrap;">+62 823-1866-6547</a>
          </div>
        </div>
        <div style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.85);font-size:0.84rem;"><i class="fas fa-envelope" style="color:var(--yellow);"></i>info@denpasarinstitute.id</div>
      </div>
    </div>
    <div>
      <div class="contact-form-wrap">
        <h3>Kirim Pesan</h3>
        <p>Tim kami akan merespons dengan cepat dan profesional.</p>
        <div id="whatsappForm">
          <div class="form-row">
            <div class="form-group"><label>Nama Lengkap *</label><input type="text" id="fullname" placeholder="Nama lengkap"></div>
            <div class="form-group"><label>Email *</label><input type="email" id="email" placeholder="Alamat email"></div>
          </div>
          <div class="form-row">
            <div class="form-group"><label>Institusi *</label><input type="text" id="institution" placeholder="Institusi Anda"></div>
            <div class="form-group"><label>Bidang Keahlian</label><input type="text" id="expertise" placeholder="Bidang profesional"></div>
          </div>
          <div class="form-group"><label>Subjek *</label><input type="text" id="subject" placeholder="Judul singkat pesan"></div>
          <div class="form-group"><label>Pesan *</label><textarea id="message" rows="4" placeholder="Tuliskan pesan Anda..." style="resize:vertical;"></textarea></div>
          <button type="button" class="btn-wa" onclick="sendWA()"><i class="fab fa-whatsapp"></i> Kirim via WhatsApp</button>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  (function() {
    var container = document.getElementById('particlesContainer');
    if (!container) return;
    for (var i = 0; i < 30; i++) {
      var particle = document.createElement('div');
      particle.classList.add('particle');
      particle.style.left = Math.random() * 100 + '%';
      particle.style.top = Math.random() * 100 + '%';
      particle.style.animationDelay = Math.random() * 6 + 's';
      particle.style.animationDuration = (Math.random() * 6 + 4) + 's';
      container.appendChild(particle);
    }
  })();

  (function() {
    var wrapper = document.getElementById('sliderWrapper');
    if (!wrapper) return;
    var slides = wrapper.querySelectorAll('.slider-slide');
    var prevBtn = document.getElementById('prevBtnHero');
    var nextBtn = document.getElementById('nextBtnHero');
    var dotsContainer = document.getElementById('sliderDotsHero');
    var currentSlide = 0;
    var totalSlides = slides.length;
    var autoTimer = null;

    for (var i = 0; i < totalSlides; i++) {
      var dot = document.createElement('div');
      dot.classList.add('dot-hero');
      if (i === 0) dot.classList.add('active-hero');
      (function(idx) {
        dot.addEventListener('click', function() { goToSlide(idx); });
      })(i);
      dotsContainer.appendChild(dot);
    }
    var dots = document.querySelectorAll('.dot-hero');

    function goToSlide(index) {
      currentSlide = (index + totalSlides) % totalSlides;
      wrapper.style.transform = 'translateX(-' + (currentSlide * 100) + '%)';
      dots.forEach(function(d, idx) { d.classList.toggle('active-hero', idx === currentSlide); });
      resetAuto();
    }

    function resetAuto() {
      if (autoTimer) clearInterval(autoTimer);
      autoTimer = setInterval(function() { goToSlide(currentSlide + 1); }, 5000);
    }

    prevBtn.addEventListener('click', function() { goToSlide(currentSlide - 1); });
    nextBtn.addEventListener('click', function() { goToSlide(currentSlide + 1); });

    var sliderEl = document.getElementById('heroSlider');
    sliderEl.addEventListener('mouseenter', function() { clearInterval(autoTimer); });
    sliderEl.addEventListener('mouseleave', function() { resetAuto(); });

    document.addEventListener('keydown', function(e) {
      if (e.key === 'ArrowLeft') goToSlide(currentSlide - 1);
      if (e.key === 'ArrowRight') goToSlide(currentSlide + 1);
    });

    var touchStartX = 0;
    wrapper.addEventListener('touchstart', function(e) { touchStartX = e.changedTouches[0].screenX; });
    wrapper.addEventListener('touchend', function(e) {
      var diff = touchStartX - e.changedTouches[0].screenX;
      if (diff > 50) goToSlide(currentSlide + 1);
      if (diff < -50) goToSlide(currentSlide - 1);
    });

    resetAuto();
  })();

  function initCarousel(innerId, dotsId, totalSlides, autoInterval) {
    var inner = document.getElementById(innerId);
    var dotsContainer = document.getElementById(dotsId);
    if (!inner || !dotsContainer) return null;
    var current = 0; var timer = null;
    function renderDots() {
      dotsContainer.innerHTML = '';
      for (var i = 0; i < totalSlides; i++) {
        var dot = document.createElement('div');
        dot.classList.add('carousel-dot');
        if (i === current) dot.classList.add('active');
        (function(idx) { dot.addEventListener('click', function() { goTo(idx); }); })(i);
        dotsContainer.appendChild(dot);
      }
    }
    function goTo(index) {
      current = (index + totalSlides) % totalSlides;
      inner.style.transform = 'translateX(-' + (current * 100) + '%)';
      var dots = dotsContainer.querySelectorAll('.carousel-dot');
      dots.forEach(function(d, idx) { d.classList.toggle('active', idx === current); });
      resetTimer();
    }
    function slide(direction) { goTo(current + direction); }
    function startTimer() { if (timer) clearInterval(timer); timer = setInterval(function() { slide(1); }, autoInterval); }
    function resetTimer() { if (timer) clearInterval(timer); startTimer(); }
    renderDots(); startTimer();
    return { slide: slide, goTo: goTo };
  }

  var divCar = initCarousel('divisionInner', 'divisionDots', {{ $divisiTotalSlides }}, 5000);
  document.getElementById('divPrevBtn').addEventListener('click', function() { divCar && divCar.slide(-1); });
  document.getElementById('divNextBtn').addEventListener('click', function() { divCar && divCar.slide(1); });

  var konsultanTotalSlides = {{ max(1, (($konsultans ?? collect())->chunk(4))->count()) }};
  var konCar = initCarousel('konsultanInner', 'konsultanDots', konsultanTotalSlides, 4500);
  document.getElementById('konsulPrevBtn').addEventListener('click', function() { konCar && konCar.slide(-1); });
  document.getElementById('konsulNextBtn').addEventListener('click', function() { konCar && konCar.slide(1); });

  var grcsTotalSlides = {{ max(1, (($grcsMembers ?? collect())->chunk(4))->count()) }};
  var grcsCar = initCarousel('grcsInner', 'grcsDots', grcsTotalSlides, 4000);
  document.getElementById('grcsPrevBtn').addEventListener('click', function() { grcsCar && grcsCar.slide(-1); });
  document.getElementById('grcsNextBtn').addEventListener('click', function() { grcsCar && grcsCar.slide(1); });

  var bursaTotalSlides = {{ $bursaTotalSlides }};
  var bursaCar = initCarousel('bursaInner', 'bursaDots', bursaTotalSlides, 4200);
  document.getElementById('bursaPrevBtn').addEventListener('click', function() { bursaCar && bursaCar.slide(-1); });
  document.getElementById('bursaNextBtn').addEventListener('click', function() { bursaCar && bursaCar.slide(1); });

  (function() {
    var track = document.getElementById('testiTrack');
    var dotsWrap = document.getElementById('testiDots');
    var prevBtn = document.getElementById('testiPrev');
    var nextBtn = document.getElementById('testiNext');
    var cards = track ? track.querySelectorAll('.testi-card') : [];
    var current = 0;
    var autoTimer = null;

    function isMobile() { return window.innerWidth <= 768; }

    function getItemsPerView() { return isMobile() ? 1 : 2; }

    function getTotalSlides() {
      var perView = getItemsPerView();
      return Math.ceil(cards.length / perView);
    }

    function renderDots() {
      if (!dotsWrap) return;
      var count = getTotalSlides();
      dotsWrap.innerHTML = '';
      for (var i = 0; i < count; i++) {
        var btn = document.createElement('button');
        btn.className = 'testi-dot' + (i === current ? ' active' : '');
        btn.setAttribute('aria-label', 'Slide ' + (i + 1));
        (function(idx) { btn.addEventListener('click', function() { goTo(idx); }); })(i);
        dotsWrap.appendChild(btn);
      }
    }

    function goTo(idx) {
      var count = getTotalSlides();
      current = (idx + count) % count;
      var perView = getItemsPerView();
      var pct = current * (100 / (cards.length / perView));
      if (cards.length <= perView) {
        pct = 0;
      }
      track.style.transform = 'translateX(-' + pct + '%)';
      var dots = dotsWrap.querySelectorAll('.testi-dot');
      dots.forEach(function(d, i) { d.classList.toggle('active', i === current); });
      resetAuto();
    }

    function resetAuto() {
      if (autoTimer) clearInterval(autoTimer);
      if (cards.length > getItemsPerView()) {
        autoTimer = setInterval(function() { goTo(current + 1); }, 5000);
      }
    }

    if (track && cards.length) {
      if (prevBtn) prevBtn.addEventListener('click', function() { goTo(current - 1); });
      if (nextBtn) nextBtn.addEventListener('click', function() { goTo(current + 1); });
      renderDots();
      resetAuto();

      var resizeTimer;
      window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
          current = 0;
          renderDots();
          goTo(0);
          resetAuto();
        }, 250);
      });
    }
  })();

  function runCounters() {
    document.querySelectorAll('.stat-card .count').forEach(function(el) {
      var target = +el.getAttribute('data-target');
      var cur = 0;
      var step = Math.max(1, Math.floor(target / 80));
      function tick() {
        cur = Math.min(target, cur + step);
        el.textContent = cur.toLocaleString();
        if (cur < target) setTimeout(tick, 15);
      }
      tick();
    });
  }

  var statsSection = document.querySelector('.stats-section');
  if (statsSection) {
    new IntersectionObserver(function(entries, obs) {
      entries.forEach(function(e) {
        if (e.isIntersecting) {
          runCounters();
          obs.disconnect();
        }
      });
    }, { threshold: 0.4 }).observe(statsSection);
  }

  function sendWA() {
    var n = document.getElementById('fullname').value || '';
    var e = document.getElementById('email').value || '';
    var i = document.getElementById('institution').value || '';
    var s = document.getElementById('subject').value || '';
    var m = document.getElementById('message').value || '';
    if (!n || !e || !i || !s || !m) { alert('Harap isi semua kolom yang wajib diisi!'); return; }
    var msg = 'Pesan Baru dari Denpasar Institute Website\n\nNama: ' + n + '\nEmail: ' + e + '\nInstitusi: ' + i + '\nSubjek: ' + s + '\n\nPesan:\n' + m;
    window.open('https://wa.me/6282144814593?text=' + encodeURIComponent(msg), '_blank');
  }
  window.sendWA = sendWA;
</script>
@endpush