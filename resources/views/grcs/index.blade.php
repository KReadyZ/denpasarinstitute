@extends('layouts.app')

@section('title', 'GRCS Club — Denpasar Institute')

@section('extra-style')
.grcs-hero {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #3a0000 100%);
    padding: 140px 0 80px;
    position: relative;
    overflow: hidden;
    text-align: center;
}
.grcs-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        radial-gradient(circle at 20% 60%, rgba(245,196,0,0.1) 0%, transparent 45%),
        radial-gradient(circle at 80% 30%, rgba(204,0,0,0.15) 0%, transparent 40%);
    pointer-events: none;
    z-index: 0;
}
.grcs-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(45deg, rgba(245,196,0,0.03) 1px, transparent 1px),
        linear-gradient(-45deg, rgba(245,196,0,0.03) 1px, transparent 1px);
    background-size: 50px 50px;
    z-index: 0;
}
.grcs-hero-inner {
    position: relative;
    z-index: 5;
    max-width: 700px;
    margin: 0 auto;
    padding: 0 20px;
}

.grcs-hero h1 {
    font-size: 3rem;
    font-weight: 800;
    color: #fff;
    margin: 0 0 16px;
    line-height: 1.15;
    position: relative;
    z-index: 5;
}
.grcs-hero h1 em {
    font-style: normal;
    color: #F5C400;
}
.grcs-hero p {
    font-size: 1rem;
    color: rgba(255,255,255,0.7);
    line-height: 1.8;
    margin: 0;
    position: relative;
    z-index: 5;
}

/* ===== SEARCH BAR ===== */
.grcs-search-wrap {
    background: #222;
    padding: 0;
    border-bottom: 1px solid #333;
}
.grcs-search-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
}
.grcs-search-left {
    display: flex;
    align-items: center;
    gap: 14px;
    flex: 1;
    max-width: 820px;
    flex-wrap: wrap;
}
.grcs-search-form {
    display: flex;
    gap: 0;
    flex: 1;
    min-width: 280px;
    max-width: 460px;
    border: 1.5px solid #444;
    border-radius: 8px;
    overflow: hidden;
    transition: border-color 0.2s;
}
.grcs-search-form:focus-within { border-color: #F5C400; }
.grcs-search-form input {
    flex: 1;
    border: none;
    padding: 11px 16px;
    font-family: 'Poppins', sans-serif;
    font-size: 0.85rem;
    color: #fff;
    background: #333;
    outline: none;
}
.grcs-search-form input::placeholder { color: #888; }
.grcs-search-form button {
    background: #F5C400;
    border: none;
    padding: 11px 20px;
    color: #1a1a1a;
    font-size: 0.9rem;
    cursor: pointer;
    transition: background 0.2s;
}
.grcs-search-form button:hover { background: #d4a800; }
.btn-daftar-grcs {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #F5C400;
    color: #1a1a1a !important;
    padding: 11px 22px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.25s ease;
    white-space: nowrap;
    box-shadow: 0 4px 14px rgba(245, 196, 0, 0.25);
}
.btn-daftar-grcs:hover {
    background: #e0b000;
    color: #1a1a1a !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(245, 196, 0, 0.4);
}
.grcs-count {
    font-size: 0.83rem;
    color: #aaa;
    font-weight: 500;
}
.grcs-count strong { color: #F5C400; }

/* ===== GRID ANGGOTA ===== */
.grcs-pub-section {
    background: #1a1a1a;
    padding: 48px 0 72px;
}
.grcs-pub-grid {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
}

/* ===== KARTU GRCS ===== */
.g-card {
    background: #2a2a2a;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #3a3a3a;
    transition: transform 0.3s cubic-bezier(0.4,0,0.2,1), box-shadow 0.3s, border-color 0.3s;
    cursor: pointer;
    display: block;
    text-decoration: none;
    color: inherit;
}
.g-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 20px 48px rgba(0,0,0,0.5);
    border-color: #F5C400;
}
.g-card-banner {
    position: relative;
    height: 110px;
    overflow: hidden;
    background: linear-gradient(135deg, #2d2d2d, #1a1a1a);
}
.g-card-banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.6;
    display: block;
}
.g-card-banner-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, transparent 30%, rgba(0,0,0,0.6) 100%);
}
.g-card-banner-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #F5C400;
    color: #1a1a1a;
    font-size: 0.62rem;
    font-weight: 800;
    padding: 3px 10px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    z-index: 2;
}

.g-card-photo-wrap {
    position: relative;
    display: flex;
    justify-content: center;
    margin-top: -44px;
    z-index: 2;
}
.g-card-photo {
    width: 88px;
    height: 88px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #2a2a2a;
    box-shadow: 0 6px 20px rgba(0,0,0,0.4);
    display: block;
    background: #333;
}

.g-card-body {
    padding: 12px 18px 20px;
    text-align: center;
}
.g-card-name {
    font-size: 0.9rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 4px;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.g-card-role {
    font-size: 0.72rem;
    color: #F5C400;
    font-weight: 600;
    margin-bottom: 4px;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.g-card-inst {
    font-size: 0.72rem;
    color: #888;
    margin-bottom: 14px;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.g-card-footer {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding-top: 12px;
    border-top: 1px solid #3a3a3a;
}
.g-card-btn {
    display: inline-block;
    background: transparent;
    color: #F5C400;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 4px 14px;
    border-radius: 20px;
    border: 1px solid rgba(245,196,0,0.4);
    letter-spacing: 0.3px;
    transition: all 0.2s;
    text-decoration: none;
}
.g-card-btn:hover {
    background: #F5C400;
    color: #1a1a1a;
}

/* ===== EMPTY STATE ===== */
.g-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
    color: #555;
}
.g-empty i { font-size: 3rem; display: block; margin-bottom: 14px; color: #333; }
.g-empty p { font-size: 0.9rem; }

/* ===== PAGINATION (manual, angka saja) ===== */
.g-pagination {
    max-width: 1200px;
    margin: 40px auto 0;
    padding: 0 20px;
    display: flex;
    justify-content: center;
}
.g-pagination ul.pagination {
    display: flex;
    align-items: center;
    gap: 6px;
    list-style: none;
    padding: 0;
    margin: 0;
    flex-wrap: wrap;
}
.g-pagination .page-item .page-link {
    width: 38px;
    height: 38px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.82rem;
    font-weight: 600;
    border: 1.5px solid #3a3a3a;
    color: #aaa;
    background: #2a2a2a;
    text-decoration: none;
    transition: all 0.2s;
    cursor: pointer;
}
.g-pagination .page-item.active .page-link,
.g-pagination .page-item .page-link:hover {
    background: #F5C400;
    border-color: #F5C400;
    color: #1a1a1a;
}
.g-pagination .page-item.disabled .page-link {
    opacity: 0.3;
    pointer-events: none;
}

/* ===== BREADCRUMB ===== */
.g-breadcrumb {
    background: #1a1a1a;
    padding: 12px 0;
    border-bottom: 1px solid #2a2a2a;
}
.g-breadcrumb-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.78rem;
    color: #666;
}
.g-breadcrumb-inner a { color: #F5C400; font-weight: 500; text-decoration: none; }
.g-breadcrumb-inner a:hover { text-decoration: underline; }
.g-breadcrumb-inner i { font-size: 0.6rem; }
.g-breadcrumb-inner span { color: #888; }

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
    .grcs-pub-grid { grid-template-columns: repeat(3, 1fr); }
    .grcs-hero { padding: 120px 0 70px; }
    .grcs-hero h1 { font-size: 2.4rem; }
}
@media (max-width: 768px) {
    .grcs-pub-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
    .grcs-hero { padding: 100px 0 60px; }
    .grcs-hero h1 { font-size: 2rem; }
    .grcs-search-inner { flex-direction: column; align-items: stretch; gap: 14px; }
    .grcs-search-left { flex-direction: column; align-items: stretch; max-width: 100%; gap: 12px; }
    .grcs-search-form { max-width: 100%; }
    .btn-daftar-grcs { justify-content: center; }
}
@media (max-width: 480px) {
    .grcs-pub-grid { grid-template-columns: 1fr; }
    .grcs-hero { padding: 90px 0 50px; }
}
@endsection

@section('content')

<section class="grcs-hero">
    <div class="grcs-hero-inner">
        <h1><em>GRCS Club</em><br>Denpasar Institute</h1>
        <p>Komunitas aktif peneliti, akademisi, dan profesional muda yang berkolaborasi dalam riset, pengembangan SDM, dan inovasi berbasis ilmu pengetahuan.</p>
    </div>
</section>

<div class="grcs-search-wrap">
    <div class="grcs-search-inner">
        <div class="grcs-search-left">
            <form class="grcs-search-form" method="GET" action="{{ route('grcs.index') }}">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari anggota, institusi, atau divisi..."
                >
                <button type="submit" title="Cari"><i class="fas fa-search"></i></button>
            </form>
            <a href="{{ route('panduan-pendaftaran') }}?role=grcs" class="btn-daftar-grcs">
                <i class="fas fa-user-plus"></i> Daftar Anggota GRCS Club
            </a>
        </div>
        <div class="grcs-count">
            Menampilkan <strong>{{ $members->total() }}</strong> anggota aktif
        </div>
    </div>
</div>

{{-- GRID ANGGOTA --}}
<section class="grcs-pub-section">
    <div class="grcs-pub-grid">

        @forelse($members as $m)
            <a href="{{ route('grcs.show', $m->id) }}" class="g-card">
                {{-- Banner --}}
                <div class="g-card-banner">
                    @if($m->background)
                        <img src="{{ asset('storage/' . $m->background) }}" alt="Background">
                    @endif
                    <div class="g-card-banner-overlay"></div>
                    @if($m->membership_type)
                        <span class="g-card-banner-badge">{{ ucfirst($m->membership_type) }}</span>
                    @endif
                </div>

                <div class="g-card-photo-wrap">
                    @if($m->foto)
                        <img src="{{ asset('storage/' . $m->foto) }}" alt="{{ $m->name }}" class="g-card-photo">
                    @elseif($m->avatar)
                        <img src="{{ asset('storage/' . $m->avatar) }}" alt="{{ $m->name }}" class="g-card-photo">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($m->name) }}&background=F5C400&color=1a1a1a&size=200" alt="{{ $m->name }}" class="g-card-photo">
                    @endif
                </div>

                <div class="g-card-body">
                    <div class="g-card-name">{{ $m->name }}</div>
                    @if($m->position)
                        <div class="g-card-role">{{ $m->position }}</div>
                    @endif
                    @if($m->institution)
                        <div class="g-card-inst">{{ $m->institution }}</div>
                    @endif

                    <div class="g-card-footer">
                        <span class="g-card-btn">Lihat Profil</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="g-empty">
                <i class="fas fa-users-slash"></i>
                <p>
                    @if(request('q'))
                        Tidak ada anggota yang sesuai dengan pencarian "<strong>{{ request('q') }}</strong>".
                    @else
                        Belum ada data anggota GRCS Club yang tersedia.
                    @endif
                </p>
                @if(request('q'))
                    <a href="{{ route('grcs.index') }}" style="color:#F5C400;font-size:0.82rem;font-weight:600;">
                        ← Lihat semua anggota
                    </a>
                @endif
            </div>
        @endforelse

    </div>

    {{-- PAGINATION MANUAL: angka saja, tanpa teks "Showing X to Y of Z" --}}
    @if ($members->hasPages())
        @php
            $gPaginator = $members->appends(request()->query());
            $gCurrent   = $gPaginator->currentPage();
            $gLast      = $gPaginator->lastPage();
        @endphp
        <div class="g-pagination">
            <ul class="pagination">
                {{-- Prev --}}
                @if ($gPaginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $gPaginator->previousPageUrl() }}" rel="prev">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Nomor halaman --}}
                @for ($i = 1; $i <= $gLast; $i++)
                    <li class="page-item {{ $i == $gCurrent ? 'active' : '' }}">
                        @if ($i == $gCurrent)
                            <span class="page-link">{{ $i }}</span>
                        @else
                            <a class="page-link" href="{{ $gPaginator->url($i) }}">{{ $i }}</a>
                        @endif
                    </li>
                @endfor

                {{-- Next --}}
                @if ($gPaginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $gPaginator->nextPageUrl() }}" rel="next">
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