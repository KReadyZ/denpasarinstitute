@extends('layouts.app')

@section('title', $event->title . ' - Denpasar Institute')

@section('content')
<style>
    .article-wrapper {
        max-width: 1200px !important;
        margin: 0 auto !important;
        padding: 185px 20px 60px !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        overflow: visible !important;
        display: block !important;
        width: 100% !important;
    }
    .article-grid {
        display: grid !important;
        grid-template-columns: 2.4fr 1fr !important;
        gap: 36px !important;
        align-items: flex-start !important;
        width: 100% !important;
    }

    .article-main {
        width: 100% !important;
        display: block !important;
    }

    .article-sidebar {
        width: 100% !important;
        display: block !important;
        position: sticky !important;
        top: 20px !important;
    }

    .article-top-banner {
        width: 100%;
        height: 90px;
        margin-bottom: 22px;
        border-radius: 4px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        user-select: none;
        background: #f5f5f5;
        position: relative;
        z-index: 1;
    }
    .article-top-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        transition: transform 0.3s ease, filter 0.3s ease;
        user-select: none;
        pointer-events: none;
    }
    .article-top-banner:hover img {
        transform: scale(1.05);
        filter: brightness(1.1);
    }
    .article-top-banner:active img {
        transform: scale(0.98);
    }

    .article-title {
        font-size: 1.55rem;
        font-weight: 800;
        color: #333;
        line-height: 1.35;
        margin: 0 0 14px;
    }
    .article-kategori-badge {
        display: inline-block;
        background: #F5C400;
        color: #1a1a1a;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        margin-bottom: 14px;
    }
    .article-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 18px;
        font-size: 0.82rem;
        color: #777;
        margin-bottom: 22px;
    }
    .article-meta span { display: flex; align-items: center; gap: 6px; }
    .article-meta .badge-views {
        background: #555;
        color: #fff;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 2px 9px;
        border-radius: 3px;
    }

    .article-image-wrap {
        margin-bottom: 8px;
        width: 100%;
        aspect-ratio: 16 / 9;
        overflow: hidden;
        border-radius: 4px;
    }
    .article-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
    }
    .article-image-caption {
        font-size: 0.8rem;
        color: #999;
        line-height: 1.5;
        margin: 8px 0 28px;
    }

    .article-body {
        font-size: 0.96rem;
        line-height: 1.85;
        color: #333;
    }
    .article-body p { margin: 0 0 18px; }
    .article-body img { max-width: 100%; height: auto; border-radius: 4px; }

    .article-bottom-meta {
        display: flex;
        gap: 18px;
        font-size: 0.82rem;
        color: #777;
        margin-top: 10px;
        padding-top: 18px;
        border-top: 1px solid #eee;
    }
    .article-bottom-meta span { display: flex; align-items: center; gap: 6px; }

    .article-bottom-banner {
        margin-top: 26px;
        height: 90px;
        border-radius: 4px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        user-select: none;
        background: #f5f5f5;
        position: relative;
        z-index: 1;
    }
    .article-bottom-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        transition: transform 0.3s ease, filter 0.3s ease;
        user-select: none;
        pointer-events: none;
    }
    .article-bottom-banner:hover img {
        transform: scale(1.05);
        filter: brightness(1.1);
    }
    .article-bottom-banner:active img {
        transform: scale(0.98);
    }

    .sharing-corner-title {
        background: #CC0000;
        color: #fff;
        font-weight: 700;
        font-size: 1rem;
        padding: 12px 18px;
        margin-bottom: 18px;
        border-radius: 2px;
    }
    .sharing-corner-item {
        display: flex;
        gap: 14px;
        padding-bottom: 16px;
        margin-bottom: 16px;
        border-bottom: 1px solid #eee;
        text-decoration: none;
        color: inherit;
    }
    .sharing-corner-item:last-child { border-bottom: none; }
    .sharing-corner-thumb {
        width: 76px;
        height: 60px;
        flex-shrink: 0;
        border-radius: 3px;
        overflow: hidden;
        background: #f0f0f0;
    }
    .sharing-corner-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .sharing-corner-thumb .thumb-placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        color: #bbb;
    }
    .sharing-corner-cat {
        display: block;
        color: #CC0000;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .sharing-corner-title-text {
        font-size: 0.85rem;
        font-weight: 700;
        color: #333;
        line-height: 1.4;
    }
    .sharing-corner-item:hover .sharing-corner-title-text { color: #CC0000; }

    .sidebar-cta {
        display: block;
        background: #F5C400;
        color: #1a1a1a;
        text-align: center;
        font-weight: 800;
        font-size: 0.9rem;
        padding: 12px;
        border-radius: 4px;
        margin: 8px 0 24px;
        text-decoration: none;
    }
    .sidebar-cta:hover { background: #e0b000; }

    .sidebar-ads {
        background: #f5f5f5;
        border: 1px solid #eee;
        border-radius: 4px;
        margin-bottom: 18px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        user-select: none;
        position: relative;
        z-index: 1;
        min-height: 80px;
    }
    .sidebar-ads img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        transition: transform 0.3s ease, filter 0.3s ease;
        user-select: none;
        pointer-events: none;
    }
    .sidebar-ads:hover img {
        transform: scale(1.05);
        filter: brightness(1.08);
    }
    .sidebar-ads:active img {
        transform: scale(0.98);
    }

    @media (max-width: 991px) and (min-width: 769px) {
        .article-wrapper {
            padding-top: 110px !important;
        }
    }

    @media (max-width: 768px) {
        .article-wrapper {
            padding-top: 24px !important;
        }
        .article-grid { 
            grid-template-columns: 1fr !important;
        }
        .article-title { font-size: 1.3rem; }
        .article-sidebar { 
            margin-top: 0 !important;
            position: static !important;
            top: auto !important;
        }
    }
</style>

<div class="article-wrapper">

    <div class="article-top-banner" onclick="window.open('https://www.kemendikdasmen.go.id/', '_blank')">
        <img src="{{ asset('image/banner-kmd.png') }}" alt="Kementerian Pendidikan Tinggi, Sains, dan Teknologi" style="pointer-events: none;">
    </div>

    @if($event->kategori)
    <span class="article-kategori-badge">{{ $event->kategori }}</span>
    @endif

    <h1 class="article-title">{{ $event->title }}</h1>

    <div class="article-meta">
        <span><i class="far fa-comment-dots"></i> Dibaca: <span class="badge-views">{{ $event->views }}</span> Pengunjung</span>
        <span><i class="far fa-clock"></i> {{ $event->published_at ? $event->published_at->format('d F Y') : '-' }}</span>
        <span><i class="far fa-user"></i> Kontributor: {{ $event->kontributor ?? '-' }}</span>
    </div>

    <div class="article-grid">

        {{-- ===== KOLOM UTAMA ===== --}}
        <div class="article-main">

            @if($event->image)
            <div class="article-image-wrap">
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}">
            </div>
            @endif

            <div class="article-body">
                {!! $event->content !!}
            </div>

            <div class="article-bottom-meta">
                <span><i class="far fa-comment-dots"></i> Dibaca: <span class="badge-views">{{ $event->views }}</span> Pengunjung</span>
                <span><i class="far fa-clock"></i> {{ $event->published_at ? $event->published_at->format('d F Y') : '-' }}</span>
            </div>

            {{-- BANNER BRIN --}}
            <div class="article-bottom-banner" onclick="window.open('https://www.brin.go.id/', '_blank')">
                <img src="{{ asset('image/banner-brin.png') }}" alt="Badan Riset dan Inovasi Nasional Republik Indonesia" style="pointer-events: none;">
            </div>

        </div>

        {{-- ===== SIDEBAR SHARING CORNER ===== --}}
        <aside class="article-sidebar">
            <div class="sharing-corner-title">Sharing Corner</div>

            @forelse($eventLain as $lain)
            <a href="{{ route('event.show', $lain->id) }}" class="sharing-corner-item">
                <div class="sharing-corner-thumb">
                    @if($lain->image)
                        <img src="{{ asset('storage/' . $lain->image) }}" alt="{{ $lain->title }}">
                    @else
                        <div class="thumb-placeholder"><i class="far fa-calendar"></i></div>
                    @endif
                </div>
                <div>
                    <span class="sharing-corner-cat">{{ $lain->kategori ?? 'Event' }}</span>
                    <div class="sharing-corner-title-text">{{ $lain->title }}</div>
                </div>
            </a>
            @empty
            <p style="font-size:0.85rem; color:#999;">Belum ada event lainnya.</p>
            @endforelse

            <a href="{{ route('event.index') }}" class="sidebar-cta">Selengkapnya</a>

            <div class="sidebar-ads" onclick="window.open('https://www.brin.go.id/', '_blank')">
                <img src="{{ asset('image/banner-brin.png') }}" alt="Divisi Riset dan Inovasi BRIN" style="pointer-events: none;">
            </div>
        </aside>

    </div>
</div>
@endsection