@extends('layouts.app')
@section('title', $item->nama)

@section('extra-style')
  .bursa-detail-section {
    padding: 150px 0 60px;
  }
  @media (max-width: 991px) and (min-width: 769px) {
    .bursa-detail-section {
      padding: 100px 0 50px;
    }
  }
  @media (max-width: 768px) {
    .bursa-detail-section {
      padding: 36px 0 50px;
    }
  }
@endsection

@section('content')
<section class="bursa-detail-section">
  <div class="container" style="max-width:750px;">
    <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://via.placeholder.com/750x350' }}"
         style="width:100%; border-radius:8px; margin-bottom:20px;">
    <span class="news-card-cat">{{ $item->kategori }}</span>
    <h1 style="font-weight:800; margin:6px 0 16px;">{{ $item->nama }}</h1>
    <p style="color:#555; line-height:1.8;">{{ $item->deskripsi }}</p>

    <div style="margin-top:24px; border-top:1px solid #eee; padding-top:20px;">
      @if($item->tipe === 'perusahaan')
        <p><strong>Bidang Usaha:</strong> {{ $item->bidang_usaha }}</p>
      @else
        <p><strong>Keahlian:</strong> {{ $item->keahlian }}</p>
        <p><strong>Posisi Dicari:</strong> {{ $item->posisi_dicari }}</p>
      @endif
      <p><strong>Alamat:</strong> {{ $item->alamat }}</p>
      @if($item->website)<p><strong>Website:</strong> {{ $item->website }}</p>@endif
    </div>

    <a href="https://wa.me/62{{ ltrim($item->no_wa,'0') }}" target="_blank" class="btn-wa" style="margin-top:20px;">
      <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
    </a>
  </div>
</section>
@endsection