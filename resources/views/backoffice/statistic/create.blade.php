@extends('backoffice.layouts.app')

@section('title', 'Tambah Statistik')

@section('content')
<div class="container-fluid" style="padding:24px;max-width:640px;">
    <h4>Tambah Statistik</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('backoffice.statistic.store') }}" method="POST">
                @csrf
                @include('backoffice.statistic._form')
                <button type="submit" class="btn btn-danger">Simpan</button>
                <a href="{{ route('backoffice.statistic.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection