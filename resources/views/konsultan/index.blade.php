@extends('layouts.app')

@section('title', 'Konsultan — Denpasar Institute')

@section('extra-style')
.konsultan-hero {
    background: linear-gradient(135deg, #CC0000 0%, #8a0000 60%, #1a1a1a 100%);
    padding: 140px 0 80px;
    position: relative;
    overflow: hidden;
    text-align: center;
}
.konsultan-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        radial-gradient(circle at 15% 50%, rgba(245,196,0,0.12) 0%, transparent 45%),
        radial-gradient(circle at 85% 20%, rgba(255,255,255,0.06) 0%, transparent 40%);
    pointer-events: none;
    z-index: 0;
}
.konsultan-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(45deg, rgba(255,255,255,0.02) 1px, transparent 1px),
        linear-gradient(-45deg, rgba(255,255,255,0.02) 1px, transparent 1px);
    background-size: 50px 50px;
    z-index: 0;
}
.konsultan-hero-inner {
    position: relative;
    z-index: 5;
    max-width: 700px;
    margin: 0 auto;
    padding: 0 20px;
}
.konsultan-hero-eyebrow {
    display: inline-block;
    background: rgba(245,196,0,0.18);
    border: 1px solid rgba(245,196,0,0.4);
    color: #F5C400;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    padding: 5px 18px;
    border-radius: 20px;
    margin-bottom: 20px;
}
.konsultan-hero h1 {
    font-size: 3rem;
    font-weight: 800;
    color: #fff;
    margin: 0 0 16px;
    line-height: 1.15;
    letter-spacing: -0.5px;
    position: relative;
    z-index: 5;
}
.konsultan-hero h1 em {
    font-style: normal;
    color: #F5C400;
}
.konsultan-hero p {
    font-size: 1rem;
    color: rgba(255,255,255,0.75);
    line-height: 1.8;
    margin: 0;
    position: relative;
    z-index: 5;
}

/* ===== SEARCH BAR ===== */
.konsultan-search-wrap {
    background: #fff;
    padding: 28px 0 0;
    border-bottom: 1px solid #eee;
}
.konsultan-search-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
}
.konsultan-search-left {
    display: flex;
    align-items: center;
    gap: 14px;
    flex: 1;
    max-width: 820px;
    flex-wrap: wrap;
}
.konsultan-search-form {
    display: flex;
    gap: 0;
    flex: 1;
    min-width: 280px;
    max-width: 460px;
    border: 1.5px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    transition: border-color 0.2s;
}
.konsultan-search-form:focus-within {
    border-color: #CC0000;
}
.konsultan-search-form input {
    flex: 1;
    border: none;
    padding: 11px 16px;
    font-family: 'Poppins', sans-serif;
    font-size: 0.85rem;
    color: #333;
    outline: none;
    background: #fff;
}
.konsultan-search-form button {
    background: #CC0000;
    border: none;
    padding: 11px 20px;
    color: #fff;
    font-size: 0.9rem;
    cursor: pointer;
    transition: background 0.2s;
}
.konsultan-search-form button:hover { background: #a80000; }
.btn-daftar-konsultan {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #CC0000;
    color: #fff !important;
    padding: 11px 22px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s ease;
    white-space: nowrap;
    box-shadow: 0 4px 12px rgba(204, 0, 0, 0.2);
}
.btn-daftar-konsultan:hover {
    background: #a80000;
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(204, 0, 0, 0.32);
}
.konsultan-count {
    font-size: 0.83rem;
    color: #888;
    font-weight: 500;
}
.konsultan-count strong { color: #CC0000; }

/* ===== GRID KONSULTAN ===== */
.konsultan-section {
    background: #f8f8f8;
    padding: 48px 0 72px;
}
.konsultan-grid {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
}

/* ===== KARTU KONSULTAN ===== */
.k-card {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #ebebeb;
    transition: transform 0.3s cubic-bezier(0.4,0,0.2,1), box-shadow 0.3s;
    cursor: pointer;
    display: block;
    text-decoration: none;
    color: inherit;
}
.k-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 20px 48px rgba(204,0,0,0.12);
}
.k-card-banner {
    position: relative;
    height: 110px;
    overflow: hidden;
    background: linear-gradient(135deg, #CC0000, #8a0000);
}
.k-card-banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.75;
    display: block;
}
.k-card-banner-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, transparent 30%, rgba(0,0,0,0.4) 100%);
}

.k-card-photo-wrap {
    position: relative;
    display: flex;
    justify-content: center;
    margin-top: -44px;
    z-index: 2;
}
.k-card-photo {
    width: 88px;
    height: 88px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    display: block;
    background: #f0f0f0;
}

.k-card-body {
    padding: 12px 18px 20px;
    text-align: center;
}
.k-card-name {
    font-size: 0.9rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 4px;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.k-card-inst {
    font-size: 0.73rem;
    color: #CC0000;
    font-weight: 600;
    margin-bottom: 6px;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.k-card-pos {
    font-size: 0.72rem;
    color: #888;
    margin-bottom: 14px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.5;
}
.k-card-footer {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding-top: 12px;
    border-top: 1px solid #f0f0f0;
}
.k-card-social a {
    color: #CC0000;
    font-size: 0.82rem;
    opacity: 0.7;
    transition: opacity 0.2s, transform 0.2s;
    display: inline-block;
}
.k-card-social a:hover {
    opacity: 1;
    transform: translateY(-2px);
}
.k-card-btn {
    display: inline-block;
    background: #CC0000;
    color: #fff;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 4px 14px;
    border-radius: 20px;
    letter-spacing: 0.3px;
    transition: background 0.2s;
    text-decoration: none;
}
.k-card-btn:hover { background: #a80000; color: #fff; }

/* ===== EMPTY STATE ===== */
.k-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
    color: #aaa;
}
.k-empty i { font-size: 3rem; display: block; margin-bottom: 14px; color: #e0e0e0; }
.k-empty p { font-size: 0.9rem; }

/* ===== PAGINATION (manual, angka saja) ===== */
.k-pagination {
    max-width: 1200px;
    margin: 40px auto 0;
    padding: 0 20px;
    display: flex;
    justify-content: center;
}
.k-pagination ul.pagination {
    display: flex;
    align-items: center;
    gap: 6px;
    list-style: none;
    padding: 0;
    margin: 0;
    flex-wrap: wrap;
}
.k-pagination .page-item .page-link {
    width: 38px;
    height: 38px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.82rem;
    font-weight: 600;
    border: 1.5px solid #e0e0e0;
    color: #555;
    background: #fff;
    text-decoration: none;
    transition: all 0.2s;
    cursor: pointer;
}
.k-pagination .page-item.active .page-link,
.k-pagination .page-item .page-link:hover {
    background: #CC0000;
    border-color: #CC0000;
    color: #fff;
}
.k-pagination .page-item.disabled .page-link {
    opacity: 0.4;
    pointer-events: none;
}

/* ===== BREADCRUMB ===== */
.k-breadcrumb {
    background: #fff;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}
.k-breadcrumb-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.78rem;
    color: #999;
}
.k-breadcrumb-inner a { color: #CC0000; font-weight: 500; text-decoration: none; }
.k-breadcrumb-inner a:hover { text-decoration: underline; }
.k-breadcrumb-inner i { font-size: 0.6rem; }

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
    .konsultan-grid { grid-template-columns: repeat(3, 1fr); }
    .konsultan-hero { padding: 120px 0 70px; }
    .konsultan-hero h1 { font-size: 2.4rem; }
}
@media (max-width: 768px) {
    .konsultan-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
    .konsultan-hero { padding: 100px 0 60px; }
    .konsultan-hero h1 { font-size: 2rem; }
    .konsultan-search-inner { flex-direction: column; align-items: stretch; gap: 14px; }
    .konsultan-search-left { flex-direction: column; align-items: stretch; max-width: 100%; gap: 12px; }
    .konsultan-search-form { max-width: 100%; }
    .btn-daftar-konsultan { justify-content: center; }
}
@media (max-width: 480px) {
    .konsultan-grid { grid-template-columns: 1fr; }
    .konsultan-hero { padding: 90px 0 50px; }
}
@endsection

@section('content')

{{-- HERO --}}
<section class="konsultan-hero">
    <div class="konsultan-hero-inner">
        <h1>Para <em>Konsultan</em><br>Denpasar Institute</h1>
        <p>Didukung oleh para ahli berpengalaman dari berbagai bidang akademisi, praktisi, dan profesional yang berdedikasi mendorong riset dan pengembangan SDM Indonesia.</p>
    </div>
</section>

{{-- SEARCH --}}
<div class="konsultan-search-wrap">
    <div class="konsultan-search-inner">
        <div class="konsultan-search-left">
            <form class="konsultan-search-form" method="GET" action="{{ route('konsultan.index') }}">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari konsultan, institusi, atau bidang keahlian..."
                >
                <button type="submit" title="Cari"><i class="fas fa-search"></i></button>
            </form>
            <a href="{{ route('backoffice.register') }}?role=konsultan" class="btn-daftar-konsultan">
                <i class="fas fa-user-plus"></i> Daftar Anggota Konsultan
            </a>
        </div>
        <div class="konsultan-count">
            Menampilkan <strong>{{ $konsultans->total() }}</strong> konsultan aktif
        </div>
    </div>
</div>

{{-- GRID --}}
<section class="konsultan-section">
    <div class="konsultan-grid">

        @forelse($konsultans as $k)
            <a href="{{ route('konsultan.show', $k->id) }}" class="k-card">
                {{-- Banner atas --}}
                <div class="k-card-banner">
                    @if($k->background)
                        <img src="{{ asset('storage/' . $k->background) }}" alt="Background">
                    @endif
                    <div class="k-card-banner-overlay"></div>
                </div>

                {{-- Foto lingkaran --}}
                <div class="k-card-photo-wrap">
                    @if($k->foto)
                        <img
                            src="{{ asset('storage/' . $k->foto) }}"
                            alt="{{ $k->name }}"
                            class="k-card-photo"
                        >
                    @elseif($k->avatar)
                        <img
                            src="{{ asset('storage/' . $k->avatar) }}"
                            alt="{{ $k->name }}"
                            class="k-card-photo"
                        >
                    @else
                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode($k->name) }}&background=CC0000&color=fff&size=200"
                            alt="{{ $k->name }}"
                            class="k-card-photo"
                        >
                    @endif
                </div>

                {{-- Nama, Institusi, Posisi --}}
                <div class="k-card-body">
                    <div class="k-card-name">{{ $k->name }}</div>
                    @if($k->institution)
                        <div class="k-card-inst">{{ $k->institution }}</div>
                    @endif
                    @if($k->position)
                        <div class="k-card-pos">{{ $k->position }}</div>
                    @endif

                    <div class="k-card-footer">
                        @if(!empty($k->instagram) || !empty($k->facebook) || !empty($k->linkedin) || !empty($k->website))
                            <div class="k-card-social" style="display:flex;gap:6px;">
                                @if(!empty($k->instagram))
                                    <a href="{{ $k->instagram }}" target="_blank" onclick="event.stopPropagation()">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @endif
                                @if(!empty($k->facebook))
                                    <a href="{{ $k->facebook }}" target="_blank" onclick="event.stopPropagation()">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                @endif
                                @if(!empty($k->linkedin))
                                    <a href="{{ $k->linkedin }}" target="_blank" onclick="event.stopPropagation()">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                @endif
                                @if(!empty($k->website))
                                    <a href="{{ $k->website }}" target="_blank" onclick="event.stopPropagation()">
                                        <i class="fas fa-globe"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                        <span class="k-card-btn">Lihat Profil</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="k-empty">
                <i class="fas fa-user-slash"></i>
                <p>
                    @if(request('q'))
                        Tidak ada konsultan yang sesuai dengan pencarian "<strong>{{ request('q') }}</strong>".
                    @else
                        Belum ada data konsultan yang tersedia.
                    @endif
                </p>
                @if(request('q'))
                    <a href="{{ route('konsultan.index') }}" style="color:#CC0000;font-size:0.82rem;font-weight:600;">
                        ← Lihat semua konsultan
                    </a>
                @endif
            </div>
        @endforelse

    </div>

    {{-- PAGINATION MANUAL: angka saja, tanpa teks "Showing X to Y of Z" --}}
    @if ($konsultans->hasPages())
        @php
            $kPaginator = $konsultans->appends(request()->query());
            $kCurrent   = $kPaginator->currentPage();
            $kLast      = $kPaginator->lastPage();
        @endphp
        <div class="k-pagination">
            <ul class="pagination">
                {{-- Prev --}}
                @if ($kPaginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $kPaginator->previousPageUrl() }}" rel="prev">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Nomor halaman --}}
                @for ($i = 1; $i <= $kLast; $i++)
                    <li class="page-item {{ $i == $kCurrent ? 'active' : '' }}">
                        @if ($i == $kCurrent)
                            <span class="page-link">{{ $i }}</span>
                        @else
                            <a class="page-link" href="{{ $kPaginator->url($i) }}">{{ $i }}</a>
                        @endif
                    </li>
                @endfor

                {{-- Next --}}
                @if ($kPaginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $kPaginator->nextPageUrl() }}" rel="next">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                    </li>
                @endif
            </ul>
        </div>
    @endif
</section>

@endsection