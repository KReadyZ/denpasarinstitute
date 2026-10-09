@extends('backoffice.layouts.app')
@use('Illuminate\Support\Facades\Storage')
@use('Illuminate\Support\Str')
@section('title', 'Kelola Hero Slider')
@section('page-title', 'Hero Slider')

@section('content')
<div class="card">
  <div class="card-header">
    <h3><i class="fas fa-images"></i> Daftar Slide</h3>
    <a href="{{ route('backoffice.slider.create') }}" class="btn btn-primary">
      <i class="fas fa-plus"></i> Tambah Slide
    </a>
  </div>
  <div class="card-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Urutan</th>
            <th>Background</th>
            <th>Judul</th>
            <th>Tipe</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($sliders as $slider)
          <tr>
            <td><strong>{{ $slider->order }}</strong></td>
            <td>
              @if($slider->background_image)
                <img src="{{ Storage::url($slider->background_image) }}" class="img-preview">
              @else
                <span style="font-size:0.73rem;color:#aaa;">Tidak ada</span>
              @endif
            </td>
            <td>
              <strong>{{ $slider->title }}</strong>
              @if($slider->subtitle)
                <br><small style="color:#888;">{{ Str::limit($slider->subtitle, 60) }}</small>
              @endif
            </td>
            <td>
              <span class="badge {{ $slider->type === 'banner' ? 'badge-banner' : 'badge-divisi' }}">
                {{ ucfirst($slider->type) }}
              </span>
            </td>
            <td>
              <span class="badge {{ $slider->is_active ? 'badge-active' : 'badge-inactive' }}">
                {{ $slider->is_active ? 'Aktif' : 'Nonaktif' }}
              </span>
            </td>
            <td style="display:flex;gap:6px;flex-wrap:wrap;">
              <a href="{{ route('backoffice.slider.edit', $slider) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form method="POST" action="{{ route('backoffice.slider.destroy', $slider) }}"
                onsubmit="return confirm('Hapus slide ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" style="text-align:center;color:#aaa;padding:30px;">Belum ada slide.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection