@extends('layouts.app')
@section('title', 'Bursa SDM - Denpasar Institute')

@section('extra-style')
  .bursa-catalog-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    text-align: left;
  }
  @media (max-width: 992px) {
    .bursa-catalog-grid {
      grid-template-columns: repeat(2, 1fr) !important;
      gap: 18px;
    }
  }
  @media (max-width: 640px) {
    .bursa-catalog-grid {
      grid-template-columns: 1fr !important;
      gap: 16px;
    }
  }
  .bursa-header-section {
    padding: 190px 0 70px;
    background: linear-gradient(180deg,#f7f9fc,#fff);
  }
  @media (max-width: 991px) and (min-width: 769px) {
    .bursa-header-section {
      padding: 120px 0 50px !important;
    }
  }
  @media (max-width: 768px) {
    .bursa-header-section {
      padding: 40px 0 50px !important;
    }
  }
@endsection

@section('content')
<section class="bursa-header-section" style="padding: 190px 0 70px; background: linear-gradient(180deg,#f7f9fc,#fff);">
  <div class="container" style="text-align:center;">

    <h1 style="font-size:2.4rem; font-weight:800; color:var(--dark); margin-bottom:10px;">Bursa SDM</h1>
    <p style="color:#666; font-size:0.95rem; max-width:680px; margin:0 auto 18px;">
      Platform ini memudahkan pemberi kerja mempublikasikan lowongan pekerjaan dan membantu pencari kerja menampilkan keahlian mereka kepada perusahaan yang sesuai.
    </p>

    <div style="display:flex; justify-content:center; gap:10px; margin-bottom:24px;">
      <a href="{{ route('bursa-sdm.index', ['tipe' => 'perusahaan']) }}"
         style="padding:10px 26px; border-radius:8px; font-weight:700; font-size:0.88rem;
                border:1px solid var(--border);
                background:{{ $tipe === 'perusahaan' ? 'var(--red)' : '#fff' }};
                color:{{ $tipe === 'perusahaan' ? '#fff' : 'var(--dark)' }};">
        Job Provider
      </a>
      <a href="{{ route('bursa-sdm.index', ['tipe' => 'individu']) }}"
         style="padding:10px 26px; border-radius:8px; font-weight:700; font-size:0.88rem;
                border:1px solid var(--border);
                background:{{ $tipe === 'individu' ? 'var(--red)' : '#fff' }};
                color:{{ $tipe === 'individu' ? '#fff' : 'var(--dark)' }};">
        Job Seeker
      </a>
    </div>

    <form method="GET" action="{{ route('bursa-sdm.index') }}" style="max-width:600px; margin:0 auto 24px;">
      <input type="hidden" name="tipe" value="{{ $tipe }}">
      <input type="text" name="search" value="{{ $search }}" placeholder="Search"
        style="width:100%; padding:14px 18px; border:1px solid var(--border); border-radius:30px; font-size:0.88rem; font-family:Poppins,sans-serif; outline:none;">
    </form>

    <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:10px; margin-bottom:36px;">
      <a href="{{ route('bursa-sdm.index', ['tipe'=>$tipe]) }}"
         style="padding:9px 20px; border-radius:30px; font-size:0.82rem; font-weight:600;
                background:{{ !$kategori || $kategori==='all' ? 'var(--red)' : '#fff' }};
                color:{{ !$kategori || $kategori==='all' ? '#fff' : 'var(--dark)' }};
                border:1px solid var(--border);">
        All
      </a>
      @foreach($kategoriList as $k)
        <a href="{{ route('bursa-sdm.index', ['tipe'=>$tipe,'kategori'=>$k]) }}"
           style="padding:9px 20px; border-radius:30px; font-size:0.82rem; font-weight:600;
                  background:{{ $kategori===$k ? 'var(--red)' : '#fff' }};
                  color:{{ $kategori===$k ? '#fff' : 'var(--dark)' }};
                  border:1px solid var(--border);">
          {{ $k }}
        </a>
      @endforeach
    </div>

    <div style="display:flex; justify-content:center; flex-wrap:wrap; gap:12px; margin-bottom:40px;">
      <a href="{{ route('bursa-sdm.create', 'perusahaan') }}"
         style="display:inline-flex; align-items:center; gap:8px; background:var(--yellow); color:var(--dark); font-weight:800;
                padding:13px 28px; border-radius:6px; font-size:0.88rem; text-decoration:none;">
        <i class="fas fa-plus"></i> Add Job Provider
      </a>
      <a href="{{ route('bursa-sdm.create', 'individu') }}"
         style="display:inline-flex; align-items:center; gap:8px; background:var(--yellow); color:var(--dark); font-weight:800;
                padding:13px 28px; border-radius:6px; font-size:0.88rem; text-decoration:none;">
        <i class="fas fa-plus"></i> Add Job Seeker
      </a>
    </div>

    @if(session('success'))
      <div class="alert" style="background:#dcfce7;color:#166534;max-width:600px;margin:0 auto 24px;text-align:left;">{{ session('success') }}</div>
    @endif

    <div class="bursa-catalog-grid">
      @forelse($data as $item)
        <div class="news-card">
          <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://via.placeholder.com/400x200?text=No+Image' }}" alt="{{ $item->nama }}">
          <div class="news-card-body">
            <span class="news-card-cat">{{ $item->kategori ?? ($tipe === 'perusahaan' ? 'Perusahaan' : 'Individu') }}</span>
            <div class="news-card-title">{{ $item->nama }}</div>
            <div class="news-card-excerpt">{{ Str::limit(strip_tags($item->deskripsi), 110) }}</div>
            <div class="news-card-footer">
              <span class="news-date">{{ $item->created_at->format('d M Y') }}</span>
              <a href="{{ route('bursa-sdm.show', $item->slug) }}" class="btn-read">Detail</a>
            </div>
          </div>
        </div>
      @empty
        <div style="grid-column:1/-1; text-align:center; padding:50px; color:#999;">
          Belum ada data {{ $tipe }} yang tersedia.
        </div>
      @endforelse
    </div>

    <div style="margin-top:36px;">{{ $data->links() }}</div>
  </div>
</section>
@endsection