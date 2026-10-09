@extends('backoffice.layouts.app')

@section('title', 'Edit Statistik')

@section('content')
<div class="container-fluid" style="padding:24px;max-width:640px;">
    <h4>Edit Statistik</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('backoffice.statistic.update', $statistic->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('backoffice.statistic._form', ['statistic' => $statistic])
                <button type="submit" class="btn btn-danger">Update</button>
                <a href="{{ route('backoffice.statistic.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection