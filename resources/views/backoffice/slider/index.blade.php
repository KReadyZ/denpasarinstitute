@extends('backoffice.layouts.app')
@use('Illuminate\Support\Str')
@section('title', 'Kelola Hero Slider')
@section('page-title', 'Hero Slider')

@section('content')
<div class="container-fluid p-0">
  {{-- Card Pengaturan Mode Slider di Beranda --}}
  <div class="card shadow-sm border-0 mb-4" style="border-left: 4px solid #CC0000 !important;">
    <div class="card-body p-4">
      <div class="row align-items-center">
        <div class="col-lg-8 mb-3 mb-lg-0">
          <div class="d-flex align-items-start gap-3">
            <div class="icon-circle bg-light text-danger p-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px; flex-shrink: 0; font-size: 1.25rem;">
              <i class="fas fa-random"></i>
            </div>
            <div>
              <h5 class="font-weight-bold text-dark mb-1">Mode Tampilan Hero Slider di Beranda</h5>
              <p class="text-muted small mb-0">
                Tentukan bagaimana foto banner dan slide divisi ditampilkan kepada pengunjung di halaman depan website saat memuat ulang (<em>reload</em>).
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 text-lg-right">
          <form id="sliderModeForm" action="{{ route('backoffice.slider.mode') }}" method="POST" class="d-inline-block text-left bg-light p-2 rounded border">
            @csrf
            <div class="custom-control custom-radio mb-1">
              <input type="radio" id="modeRandom" name="mode" value="random" class="custom-control-input" {{ ($sliderMode ?? 'random') === 'random' ? 'checked' : '' }} onchange="submitSliderMode(this.value)">
              <label class="custom-control-label font-weight-bold text-dark small" for="modeRandom" style="cursor: pointer;">
                <i class="fas fa-random text-danger mr-1"></i> Acak Setiap Reload (Random)
              </label>
            </div>
            <div class="custom-control custom-radio">
              <input type="radio" id="modeOrdered" name="mode" value="ordered" class="custom-control-input" {{ ($sliderMode ?? 'random') === 'ordered' ? 'checked' : '' }} onchange="submitSliderMode(this.value)">
              <label class="custom-control-label font-weight-bold text-dark small" for="modeOrdered" style="cursor: pointer;">
                <i class="fas fa-sort-numeric-down text-primary mr-1"></i> Tetap Sesuai Urutan (1, 2, 3..)
              </label>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Card Tabel Daftar Slide --}}
  <div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div class="d-flex align-items-center gap-2">
        <h5 class="font-weight-bold text-dark mb-0">
          <i class="fas fa-images text-danger mr-2"></i> Daftar Slide Beranda
        </h5>
        @if(($sliderMode ?? 'random') === 'random')
          <span class="badge badge-success px-2 py-1" style="font-size: 0.76rem;" id="activeModeBadge">
            <i class="fas fa-random mr-1"></i> Mode: Acak Setiap Reload
          </span>
        @else
          <span class="badge badge-primary px-2 py-1" style="font-size: 0.76rem;" id="activeModeBadge">
            <i class="fas fa-sort-numeric-down mr-1"></i> Mode: Sesuai Nomor Urut
          </span>
        @endif
      </div>
      <div class="d-flex gap-2">
        <a href="/" target="_blank" class="btn btn-outline-secondary btn-sm font-weight-bold">
          <i class="fas fa-external-link-alt mr-1"></i> Lihat Beranda Website
        </a>
        <a href="{{ route('backoffice.slider.create') }}" class="btn btn-danger btn-sm font-weight-bold shadow-sm">
          <i class="fas fa-plus mr-1"></i> Tambah Slide Baru
        </a>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th style="width: 80px;">Urutan</th>
              <th style="width: 140px;">Background</th>
              <th>Judul &amp; Deskripsi</th>
              <th style="width: 100px;">Tipe</th>
              <th style="width: 100px;">Status</th>
              <th style="width: 140px; text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($sliders as $slider)
            <tr>
              <td>
                <span class="badge badge-light border text-dark font-weight-bold" style="font-size: 0.82rem;" title="Nomor urut slide">
                  #{{ $slider->order }}
                </span>
              </td>
              <td>
                @if($slider->background_image)
                  <img src="{{ $slider->background_image_url }}" class="img-preview" alt="{{ $slider->title }}" style="width: 110px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0;">
                @else
                  <span class="badge badge-light text-muted border">Tanpa Foto</span>
                @endif
              </td>
              <td>
                <strong class="text-dark d-block mb-1" style="font-size: 0.95rem;">{{ $slider->title }}</strong>
                @if($slider->subtitle)
                  <small class="text-muted d-block" style="line-height: 1.4;">{{ Str::limit(strip_tags($slider->subtitle), 80) }}</small>
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
              <td style="text-align: center;">
                <div class="d-inline-flex gap-1">
                  <a href="{{ route('backoffice.slider.edit', $slider) }}" class="btn btn-warning btn-sm" title="Edit Slide">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <form method="POST" action="{{ route('backoffice.slider.destroy', $slider) }}"
                    onsubmit="return confirmDelete(event, this, 'Hapus slide ini?')" style="display: inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Slide">
                      <i class="fas fa-trash"></i> Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" style="text-align:center;color:#aaa;padding:40px;">
                <i class="fas fa-images fa-2x mb-2 d-block text-muted"></i>
                Belum ada data slide hero. Silakan klik tombol "Tambah Slide Baru".
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  function submitSliderMode(modeValue) {
    fetch('{{ route("backoffice.slider.mode") }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ mode: modeValue })
    })
    .then(async response => {
      const data = await response.json();
      if (!response.ok) throw data;
      return data;
    })
    .then(data => {
      const badge = document.getElementById('activeModeBadge');
      if (badge) {
        if (data.mode === 'random') {
          badge.className = 'badge badge-success px-2 py-1';
          badge.innerHTML = '<i class="fas fa-random mr-1"></i> Mode: Acak Setiap Reload';
        } else {
          badge.className = 'badge badge-primary px-2 py-1';
          badge.innerHTML = '<i class="fas fa-sort-numeric-down mr-1"></i> Mode: Sesuai Nomor Urut';
        }
      }

      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'success',
          title: 'Pengaturan Disimpan',
          text: data.message,
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
      }
    })
    .catch(err => {
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: 'Gagal memperbarui mode slider.',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
      }
    });
  }
</script>
@endpush
@endsection
