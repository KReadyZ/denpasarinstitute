@extends('layouts.app')

@section('title', 'Panduan Cara Mendaftar Anggota & Konsultan — Denpasar Institute')

@section('extra-style')
.panduan-page-wrap {
    padding-top: 150px;
    padding-bottom: 70px;
    background: #fdfdfd;
}
@media (max-width: 768px) {
    .panduan-page-wrap {
        padding-top: 90px;
        padding-bottom: 40px;
    }
}
@endsection

@section('content')
<div class="panduan-page-wrap">
    @include('partials.alur-pendaftaran', ['theme' => 'light'])
</div>
@endsection
