@extends('backoffice.layouts.app')
@section('title', 'Tambah Slide')
@section('page-title', 'Tambah Slide Baru')

@section('content')
<div class="card">
  <div class="card-header">
    <h3><i class="fas fa-plus"></i> Form Tambah Slide</h3>
    <a href="{{ route('backoffice.slider.index') }}" class="btn btn-secondary">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
  </div>
  <div class="card-body">
    @if($errors->any())
      <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('backoffice.slider.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-row">
        <div class="form-group">
          <label>Tipe Slide *</label>
          <select name="type" required id="typeSelect" onchange="toggleDivisiField()">
            <option value="divisi">Divisi</option>
            <option value="banner">Banner / Event</option>
          </select>
        </div>
        <div class="form-group" id="divisiNameWrap">
          <label>Nama Divisi</label>
          <input type="text" name="divisi_name" value="{{ old('divisi_name') }}"
            placeholder="cth: Riset dan Inovasi">
        </div>
      </div>
      <div class="form-group">
        <label>Judul Slide *</label>
        <input type="text" name="title" value="{{ old('title') }}"
          placeholder="Judul yang muncul di slider" required>
      </div>
      <div class="form-group">
        <label>Subjudul / Deskripsi</label>
        <textarea name="subtitle" rows="3"
          placeholder="Teks deskripsi singkat di bawah judul">{{ old('subtitle') }}</textarea>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Gambar Background</label>
          <input type="file" name="background_image" accept="image/*">
          <small style="color:#888;font-size:0.72rem;">
            Format: JPG/PNG/WEBP. Rekomendasi: 1920×1080px
          </small>
        </div>
        <div class="form-group">
          <label>Logo / Ikon Divisi</label>
          <input type="file" name="logo_image" accept="image/*">
          <small style="color:#888;font-size:0.72rem;">
            Format: PNG transparan direkomendasikan
          </small>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Teks Tombol</label>
          <input type="text" name="button_text"
            value="{{ old('button_text', 'Selengkapnya') }}">
        </div>
        <div class="form-group">
          <label>URL Tombol</label>
          <input type="text" name="button_url"
            value="{{ old('button_url', '#') }}"
            placeholder="/divisi/riset-dan-inovasi">
        </div>
      </div>

      <p style="font-size:0.8rem;font-weight:700;margin-bottom:10px;">
        Statistik (opsional, maksimal 6 item)
      </p>

      <div id="statsWrapper"></div>

      <button type="button" class="btn btn-secondary" id="addStatBtn" onclick="addStat()" style="margin-bottom:20px;">
        <i class="fas fa-plus"></i> Tambah Statistik
      </button>

      <div class="form-row">
        <div class="form-group">
          <label>Urutan Tampil</label>
          <input type="number" name="order"
            value="{{ old('order', $nextOrder) }}" min="0">
          <small style="color:#888;font-size:0.72rem;">
            Angka kecil = tampil lebih dahulu
          </small>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="is_active">
            <option value="1" selected>Aktif</option>
            <option value="0">Nonaktif</option>
          </select>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Simpan Slide
      </button>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
function toggleDivisiField() {
  var type = document.getElementById('typeSelect').value;
  document.getElementById('divisiNameWrap').style.display =
    type === 'divisi' ? 'block' : 'none';
}
toggleDivisiField();

const MAX_STATS = 6;
let statIndex = 0;

function addStat(number = '', label = '') {
  if (statIndex >= MAX_STATS) {
    alert('Maksimal 6 statistik.');
    return;
  }

  const wrapper = document.getElementById('statsWrapper');
  const idx = statIndex;

  const row = document.createElement('div');
  row.className = 'form-row-3';
  row.id = 'statRow' + idx;
  row.style.alignItems = 'end';
  row.innerHTML = `
    <div class="form-group">
      <label>Angka ${idx + 1}</label>
      <input type="text" name="stats[${idx}][number]" value="${number}" placeholder="50+">
    </div>
    <div class="form-group">
      <label>Label ${idx + 1}</label>
      <input type="text" name="stats[${idx}][label]" value="${label}" placeholder="Proyek Riset">
    </div>
    <div>
      <button type="button" class="btn btn-secondary" onclick="removeStat(${idx})">
        <i class="fas fa-trash"></i>
      </button>
    </div>
  `;

  wrapper.appendChild(row);
  statIndex++;
  updateAddBtnState();
}

function removeStat(idx) {
  const row = document.getElementById('statRow' + idx);
  if (row) row.remove();
  updateAddBtnState();
}

function updateAddBtnState() {
  const remaining = document.querySelectorAll('#statsWrapper .form-row-3').length;
  document.getElementById('addStatBtn').style.display = remaining >= MAX_STATS ? 'none' : 'inline-block';
}

// Mulai dengan 1 baris kosong biar form nggak terasa kosong total
addStat();
</script>
@endpush