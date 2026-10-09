@extends('layouts.app')
@section('title', 'Tambah Data - Bursa SDM')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs5.min.css" rel="stylesheet">

<style>
  .note-editor.note-airframe, .note-editor.note-frame {
    border: 1px solid #ddd !important;
    border-radius: 6px !important;
  }
  .note-editor.note-frame .note-editing-area .note-editable {
    min-height: 160px !important;
    padding: 10px !important;
    font-size: 0.9rem !important;
    color: #333 !important;
  }
  .note-editor.note-frame .note-toolbar {
    background: #f8f9fa !important;
    border-bottom: 1px solid #e5e7eb !important;
    padding: 6px 10px !important;
  }
</style>

<section style="padding:60px 0;">
  <div class="container" style="max-width:650px;">
    <h2 style="font-weight:800; margin-bottom:6px;">
      Tambah {{ $tipe === 'perusahaan' ? 'Perusahaan' : 'Individu' }}
    </h2>
    <p style="color:#666; font-size:0.85rem; margin-bottom:24px;">
      Data Anda akan diverifikasi oleh admin sebelum tampil di halaman publik.
    </p>

    @if($errors->any())
      <div class="alert" style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:6px;margin-bottom:16px;">
        <ul style="margin:0;padding-left:18px;">
          @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('bursa-sdm.store') }}" enctype="multipart/form-data" id="bursaSdmForm">
      @csrf
      <input type="hidden" name="tipe" value="{{ $tipe }}">

      <div class="form-group" style="margin-bottom:14px;">
        <label>{{ $tipe === 'perusahaan' ? 'Nama Perusahaan' : 'Nama Lengkap' }} *</label>
        <input type="text" name="nama" value="{{ old('nama') }}" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
      </div>

      <div class="form-group" style="margin-bottom:14px;">
        <label>Kategori</label>
        <input type="text" name="kategori" value="{{ old('kategori') }}" placeholder="mis. IT, Marketing, Finance" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
      </div>

      <div class="form-group" style="margin-bottom:14px;">
        <label>No. WhatsApp *</label>
        <input type="text" name="no_wa" value="{{ old('no_wa') }}" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
      </div>

      <div class="form-group" style="margin-bottom:14px;">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
      </div>

      @if($tipe === 'perusahaan')
        <div class="form-group" style="margin-bottom:14px;">
          <label>Bidang Usaha</label>
          <input type="text" name="bidang_usaha" value="{{ old('bidang_usaha') }}" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
        </div>
      @else
        <div class="form-group" style="margin-bottom:14px;">
          <label>Keahlian</label>
          <input type="text" name="keahlian" value="{{ old('keahlian') }}" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
        </div>
        <div class="form-group" style="margin-bottom:14px;">
          <label>Posisi yang Dicari</label>
          <input type="text" name="posisi_dicari" value="{{ old('posisi_dicari') }}" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
        </div>
      @endif

      <div class="form-group" style="margin-bottom:14px;">
        <label>Alamat</label>
        <input type="text" name="alamat" value="{{ old('alamat') }}" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
      </div>

      <div class="form-group" style="margin-bottom:14px;">
        <label>Website / LinkedIn</label>
        <input type="text" name="website" value="{{ old('website') }}" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
      </div>

      <div class="form-group" style="margin-bottom:14px;">
        <label>Deskripsi</label>
        <textarea class="js-summernote" name="deskripsi" rows="4" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">{{ old('deskripsi') }}</textarea>
      </div>

      <div class="form-group" style="margin-bottom:20px;">
        <label>{{ $tipe === 'perusahaan' ? 'Logo Perusahaan' : 'CV / Portofolio' }}</label>
        <input
          type="file"
          name="foto"
          accept="{{ $tipe === 'perusahaan' ? 'image/jpeg,image/jpg,image/png' : '.pdf,.doc,.docx,image/jpeg,image/jpg,image/png' }}"
          style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;"
        >
        <small style="font-size:0.78rem;color:#999;display:block;margin-top:6px;">
          @if($tipe === 'perusahaan')
            Format: JPG, JPEG, PNG (Maks. 2MB)
          @else
            Format: PDF, DOC, DOCX, JPG, JPEG, PNG (Maks. 2MB)
          @endif
        </small>
      </div>

      <button type="submit" class="btn-more" style="width:100%; border:none; cursor:pointer;">Kirim Data</button>
    </form>
  </div>
</section>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs5.min.js"></script>

<script>
(function () {
  function initBursaSdmForm() {
    var $form = $('#bursaSdmForm');
    if (!$form.length || $form.data('bursa-sdm-initialized')) {
      return;
    }
    $form.data('bursa-sdm-initialized', true);

    $form.find('.js-summernote').each(function () {
      var $el = $(this);
      if ($el.next('.note-editor').length || $el.data('summernote')) {
        return;
      }
      $el.summernote({
        height: 180,
        placeholder: 'Tuliskan deskripsi singkat...',
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['link']],
          ['view', ['codeview', 'help']]
        ]
      });
    });
  }

  $(document).ready(initBursaSdmForm);
  $(document).on('turbo:load turbo:render livewire:navigated', initBursaSdmForm);
})();
</script>
@endpush