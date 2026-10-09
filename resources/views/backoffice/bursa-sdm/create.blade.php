@extends('backoffice.layouts.app')
@section('page-title', 'Tambah Data Bursa SDM')

@section('content')
<div class="card">
  <div class="card-header"><h3>Tambah Data Bursa SDM</h3></div>
  <div class="card-body">

    @if($errors->any())
      <div class="alert alert-error">
        <ul style="margin:0;padding-left:18px;">
          @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('backoffice.bursa-sdm.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="form-row">
        <div class="form-group">
          <label>Tipe *</label>
          <select name="tipe" id="tipeSelect" required onchange="toggleTipeFields()">
            <option value="">-- Pilih Tipe --</option>
            <option value="perusahaan" {{ old('tipe') === 'perusahaan' ? 'selected' : '' }}>Perusahaan</option>
            <option value="individu" {{ old('tipe') === 'individu' ? 'selected' : '' }}>Individu</option>
          </select>
        </div>
        <div class="form-group">
          <label>Nama *</label>
          <input type="text" name="nama" value="{{ old('nama') }}" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>No. WhatsApp *</label>
          <input type="text" name="no_wa" value="{{ old('no_wa') }}" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email') }}">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Kategori</label>
          <input type="text" name="kategori" value="{{ old('kategori') }}" placeholder="mis. IT, Marketing">
        </div>
        <div class="form-group">
          <label>Website / LinkedIn</label>
          <input type="text" name="website" value="{{ old('website') }}">
        </div>
      </div>

      <div id="fieldPerusahaan" style="display:none;">
        <div class="form-group">
          <label>Bidang Usaha</label>
          <input type="text" name="bidang_usaha" value="{{ old('bidang_usaha') }}">
        </div>
      </div>

      <div id="fieldIndividu" style="display:none;">
        <div class="form-row">
          <div class="form-group">
            <label>Keahlian</label>
            <input type="text" name="keahlian" value="{{ old('keahlian') }}">
          </div>
          <div class="form-group">
            <label>Posisi Dicari</label>
            <input type="text" name="posisi_dicari" value="{{ old('posisi_dicari') }}">
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Alamat</label>
        <input type="text" name="alamat" value="{{ old('alamat') }}">
      </div>

      <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control summernote-editor" rows="4">{{ old('deskripsi') }}</textarea>
      </div>

      <div class="form-group">
        <label id="fotoLabel">Foto / Logo</label>
        <input type="file" name="foto" id="fotoInput" accept="image/jpeg,image/jpg,image/png">
        <small id="fotoHint" style="display:block;color:#999;font-size:0.8rem;margin-top:4px;">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Status *</label>
          <select name="status" required>
            <option value="approved" selected>Approved (langsung tampil)</option>
            <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
          </select>
        </div>
        <div class="form-group" style="display:flex; align-items:center; gap:8px; margin-top:22px;">
          <input type="checkbox" name="is_active" value="1" checked style="width:auto;">
          <label style="margin:0;">Tampilkan di halaman publik</label>
        </div>
      </div>

      <div style="display:flex; gap:10px; margin-top:10px;">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        <a href="{{ route('backoffice.bursa-sdm.index') }}" class="btn btn-secondary">Batal</a>
      </div>
    </form>

  </div>
</div>

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs5.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs5.min.js"></script>

<script>
  function toggleTipeFields() {
    const tipe = document.getElementById('tipeSelect').value;
    document.getElementById('fieldPerusahaan').style.display = tipe === 'perusahaan' ? 'block' : 'none';
    document.getElementById('fieldIndividu').style.display = tipe === 'individu' ? 'block' : 'none';

    const fotoInput = document.getElementById('fotoInput');
    const fotoLabel = document.getElementById('fotoLabel');
    const fotoHint = document.getElementById('fotoHint');

    if (tipe === 'individu') {
      fotoInput.setAttribute('accept', '.pdf,.doc,.docx,image/jpeg,image/jpg,image/png');
      fotoLabel.textContent = 'CV / Portofolio';
      fotoHint.textContent = 'Format: PDF, DOC, DOCX, JPG, JPEG, PNG (Maks. 2MB)';
    } else {
      fotoInput.setAttribute('accept', 'image/jpeg,image/jpg,image/png');
      fotoLabel.textContent = 'Foto / Logo';
      fotoHint.textContent = 'Format: JPG, JPEG, PNG (Maks. 2MB)';
    }
  }

  $(document).ready(function() {
    $('#deskripsi').summernote({
      height: 250,
      minHeight: 150,
      maxHeight: 400,
      focus: false,
      placeholder: 'Masukkan deskripsi...',
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ]
    });
  });
</script>
@endpush

@endsection