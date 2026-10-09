@extends('layouts.app')

@section('title', 'Form Pendaftaran - Denpasar Institute')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs5.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<style>
.admission-hero {
  background: linear-gradient(135deg, #CC0000 0%, #E30000 100%);
  color: #fff;
  padding: 140px 20px 60px;
  text-align: center;
  margin-bottom: 60px;
  position: relative;
  z-index: 1;
}

  .admission-hero h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 12px;
    line-height: 1.2;
  }

  .admission-hero p {
    font-size: 1.1rem;
    opacity: 0.95;
    margin: 0;
  }

  .admission-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 20px;
    margin-bottom: 80px;
  }

  .admission-card {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 48px 40px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  }

  .form-section {
    margin-bottom: 40px;
  }

  .form-section-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #CC0000;
  }

  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 24px;
  }

  .form-row.full {
    grid-template-columns: 1fr;
  }

  .form-group {
    display: flex;
    flex-direction: column;
  }

  .form-group label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    display: flex;
    gap: 4px;
  }

  .form-group label .required {
    color: #CC0000;
  }

  .form-group input,
  .form-group textarea,
  .form-group select {
    padding: 12px 14px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
    color: #333;
    outline: none;
    transition: all 0.2s;
  }

  .form-group input:focus,
  .form-group textarea:focus,
  .form-group select:focus {
    border-color: #CC0000;
    box-shadow: 0 0 0 3px rgba(204, 0, 0, 0.1);
  }

  .form-group textarea {
    resize: vertical;
    min-height: 120px;
  }

  .form-group small {
    font-size: 0.8rem;
    color: #999;
    margin-top: 6px;
  }

  .form-group.error input,
  .form-group.error textarea,
  .form-group.error select {
    border-color: #dc2626;
    background: #fef2f2;
  }

  .error-message {
    color: #dc2626;
    font-size: 0.8rem;
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 4px;
  }

  .error-message i {
    font-size: 0.75rem;
  }

  .program-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .program-item {
    display: flex;
    gap: 10px;
    align-items: flex-start;
  }

  .program-item select {
    flex: 1;
  }

  .btn-remove-program {
    width: 44px;
    height: 44px;
    padding: 0;
    border: 1px solid #dc2626;
    background: #fecaca;
    color: #dc2626;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    transition: all 0.2s;
    flex-shrink: 0;
    margin-top: 0;
  }

  .btn-remove-program:hover {
    background: #dc2626;
    color: #fff;
  }

  .btn-add-program {
    background: #3b82f6;
    color: #fff;
    border: none;
    padding: 10px 16px;
    border-radius: 6px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
    font-family: 'Poppins', sans-serif;
    align-self: flex-start;
  }

  .btn-add-program:hover {
    background: #2563eb;
    transform: translateY(-2px);
  }

  .checkbox-group {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px 20px;
    margin-top: 16px;
  }

  .checkbox-item {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .checkbox-item input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: #CC0000;
  }

  .checkbox-item label {
    margin: 0;
    cursor: pointer;
    font-size: 0.9rem;
    color: #555;
  }

  .form-actions {
    display: flex;
    gap: 12px;
    margin-top: 48px;
    padding-top: 24px;
    border-top: 1px solid #e0e0e0;
  }

  .btn {
    padding: 12px 32px;
    border-radius: 6px;
    font-size: 0.95rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'Poppins', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .btn-submit {
    background: #CC0000;
    color: #fff;
    flex: 1;
  }

  .btn-submit:hover {
    background: #a80000;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(204, 0, 0, 0.3);
  }

  .btn-reset {
    background: #f3f4f6;
    color: #333;
  }

  .btn-reset:hover {
    background: #e5e7eb;
  }

  .alert {
    padding: 16px 20px;
    border-radius: 6px;
    margin-bottom: 24px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
  }

  .alert-success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
  }

  .alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
  }

  .alert-info {
    background: #dbeafe;
    color: #1e40af;
    border: 1px solid #bfdbfe;
  }

  .info-box {
    background: #f0f9ff;
    border-left: 4px solid #0284c7;
    padding: 16px 20px;
    border-radius: 6px;
    margin-bottom: 32px;
  }

  .info-box p {
    font-size: 0.9rem;
    color: #0c4a6e;
    margin: 0;
    line-height: 1.6;
  }

  .info-box strong {
    font-weight: 600;
  }

  .note-editor.note-airframe, .note-editor.note-frame {
    border: 1px solid #d1d5db !important;
    border-radius: 6px !important;
  }

  .note-editor.note-frame .note-editing-area .note-editable {
    min-height: 200px !important;
    padding: 12px 14px !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 0.9rem !important;
    color: #333 !important;
  }

  .note-editor.note-frame .note-toolbar {
    background: #f8f9fa !important;
    border-bottom: 1px solid #e5e7eb !important;
    padding: 8px 12px !important;
  }

  .note-editor.note-frame .note-toolbar .note-btn {
    background: #fff !important;
    border: 1px solid #d1d5db !important;
    color: #333 !important;
  }

  .note-editor.note-frame .note-toolbar .note-btn:hover {
    background: #e5e7eb !important;
  }

  .note-editor.note-frame .note-toolbar .note-btn.active {
    background: #CC0000 !important;
    color: #fff !important;
    border-color: #CC0000 !important;
  }

  @media (max-width: 768px) {
    .admission-hero {
      padding: 40px 20px;
      margin-bottom: 40px;
    }

    .admission-hero h1 {
      font-size: 1.8rem;
    }

    .admission-card {
      padding: 24px 20px;
    }

    .form-row {
      grid-template-columns: 1fr;
      gap: 16px;
    }

    .checkbox-group {
      grid-template-columns: 1fr;
      gap: 10px;
    }

    .program-item {
      flex-direction: column;
    }

    .btn-remove-program {
      width: 100%;
    }

    .form-actions {
      flex-direction: column;
    }

    .btn {
      justify-content: center;
    }

    .btn-submit,
    .btn-reset {
      flex: auto;
    }

    .note-editor.note-frame .note-editing-area .note-editable {
      min-height: 150px !important;
    }
  }
</style>

<div class="admission-hero">
  <div class="admission-container">
    <h1>Formulir Pendaftaran</h1>
    <p>Daftar sebagai peserta program Denpasar Institute</p>
  </div>
</div>

<div class="admission-container">
  @if ($errors->any())
    <div class="alert alert-error">
      <i class="fas fa-exclamation-circle"></i>
      <div>
        <strong>Terjadi kesalahan!</strong>
        <ul style="margin: 8px 0 0; padding-left: 20px;">
          @foreach ($errors->all() as $error)
            <li style="font-size: 0.9rem;">{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif

  @if (session('success'))
    <div class="alert alert-success">
      <i class="fas fa-check-circle"></i>
      <div>
        <strong>Berhasil!</strong>
        <p style="margin: 4px 0 0;">{{ session('success') }}</p>
      </div>
    </div>
  @endif

  <div class="info-box">
    <p><strong>Petunjuk:</strong> Silakan isi semua kolom yang bertanda <span style="color: #CC0000;">*</span> (wajib diisi). Data Anda akan kami verifikasi sebelum konfirmasi pendaftaran.</p>
  </div>

  <div class="admission-card">
    <form action="{{ route('admission.store') }}" method="POST" enctype="multipart/form-data" id="admissionForm">
      @csrf

      <div class="form-section">
        <h3 class="form-section-title">Data Pribadi</h3>

        <div class="form-row">
          <div class="form-group @error('nama_lengkap') error @enderror">
            <label>
              Nama Lengkap
              <span class="required">*</span>
            </label>
            <input
              type="text"
              name="nama_lengkap"
              value="{{ old('nama_lengkap') }}"
              placeholder="Masukkan nama lengkap Anda"
              required
            >
            @error('nama_lengkap')
              <div class="error-message"><i class="fas fa-times-circle"></i> {{ $message }}</div>
            @enderror
          </div>

          <div class="form-group @error('hp_wa') error @enderror">
            <label>
              Nomor HP/WhatsApp
              <span class="required">*</span>
            </label>
            <input
              type="text"
              name="hp_wa"
              value="{{ old('hp_wa') }}"
              placeholder="Contoh: 0812-3456-7890"
              required
            >
            @error('hp_wa')
              <div class="error-message"><i class="fas fa-times-circle"></i> {{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="form-row full">
          <div class="form-group @error('email') error @enderror">
            <label>
              Email
              <span class="required">*</span>
            </label>
            <input
              type="email"
              name="email"
              value="{{ old('email') }}"
              placeholder="Masukkan email yang aktif"
              required
            >
            @error('email')
              <div class="error-message"><i class="fas fa-times-circle"></i> {{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <div class="form-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
          <h3 class="form-section-title" style="margin-bottom: 0; padding-bottom: 0; border-bottom: none;">
            Program yang Diikuti
            <span class="required">*</span>
          </h3>
          <button type="button" class="btn-add-program js-btn-add-program">
            <i class="fas fa-plus"></i> Tambah Program
          </button>
        </div>

        <div class="form-group @error('program_ids') error @enderror">
          <div class="program-container js-program-container" data-programs="{{ $programs->map(fn($p) => ['id' => $p->id, 'nama' => $p->nama])->toJson() }}">
            <div class="program-item">
              <select name="program_ids[]" class="form-control" required>
                <option value=""> Pilih Program </option>
                @foreach($programs as $program)
                  <option value="{{ $program->id }}">{{ $program->nama }}</option>
                @endforeach
              </select>
              <button type="button" class="btn-remove-program js-btn-remove-program" style="display: none;" title="Hapus Program">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          @error('program_ids')
            <div class="error-message"><i class="fas fa-times-circle"></i> {{ $message }}</div>
          @enderror
          <small>Pilih minimal 1 program</small>
        </div>
      </div>

      <div class="form-section">
        <h3 class="form-section-title">Informasi Tambahan</h3>

        <div class="form-row full">
          <div class="form-group @error('special_request') error @enderror">
            <label>Catatan atau Permintaan Khusus</label>
            <textarea
              class="js-summernote"
              name="special_request"
              placeholder="Tuliskan pertanyaan atau permintaan khusus Anda (opsional)"
            >{{ old('special_request') }}</textarea>
            @error('special_request')
              <div class="error-message"><i class="fas fa-times-circle"></i> {{ $message }}</div>
            @enderror
            <small>Maks. 5000 karakter</small>
          </div>
        </div>
      </div>

      <div class="form-section">
        <h3 class="form-section-title">Bukti Pembayaran (Opsional)</h3>

        <div class="form-row">
          <div class="form-group @error('bukti_bayar_pendaftaran') error @enderror">
            <label>Bukti Pembayaran Biaya Pendaftaran</label>
            <input
              type="file"
              name="bukti_bayar_pendaftaran"
              accept="image/jpeg,image/jpg,image/png,application/pdf"
            >
            @error('bukti_bayar_pendaftaran')
              <div class="error-message"><i class="fas fa-times-circle"></i> {{ $message }}</div>
            @enderror
            <small>Format: PDF, JPG, JPEG, PNG (Maks. 2MB)</small>
          </div>

          <div class="form-group @error('bukti_bayar_program') error @enderror">
            <label>Bukti Pembayaran Biaya Program</label>
            <input
              type="file"
              name="bukti_bayar_program"
              accept="image/jpeg,image/jpg,image/png,application/pdf"
            >
            @error('bukti_bayar_program')
              <div class="error-message"><i class="fas fa-times-circle"></i> {{ $message }}</div>
            @enderror
            <small>Format: PDF, JPG, JPEG, PNG (Maks. 2MB)</small>
          </div>
        </div>
      </div>

      <div class="form-section">
        <h3 class="form-section-title">Sumber Informasi</h3>
        <p style="font-size: 0.9rem; color: #666; margin-bottom: 16px;">Dari mana Anda mengetahui tentang Denpasar Institute?</p>

        <div class="checkbox-group">
          @foreach(['Keluarga', 'Teman', 'Lembaga Tempat Belajar atau Kerja', 'Media Sosial', 'Situs Denpasar Institute', 'Pameran Pendidikan', 'Lainnya'] as $source)
            <div class="checkbox-item">
              <input
                type="checkbox"
                name="sumber_informasi[]"
                value="{{ $source }}"
                id="source_{{ Str::slug($source) }}"
                {{ in_array($source, old('sumber_informasi', [])) ? 'checked' : '' }}
              >
              <label for="source_{{ Str::slug($source) }}">{{ $source }}</label>
            </div>
          @endforeach
        </div>
      </div>

      <div class="form-actions">
        <button type="reset" class="btn btn-reset">
          <i class="fas fa-redo"></i> Ulang
        </button>
        <button type="submit" class="btn btn-submit">
          <i class="fas fa-check"></i> Kirim Pendaftaran
        </button>
      </div>
    </form>
  </div>

  <div style="margin-top: 48px; text-align: center; color: #666; font-size: 0.9rem;">
    <p>Ada pertanyaan? Hubungi kami melalui:</p>
    <p>
      <a href="https://wa.me/6287865309966" target="_blank" style="color: #25d366; font-weight: 600; text-decoration: none;">
        <i class="fab fa-whatsapp"></i> WhatsApp Admin
      </a>
      &nbsp;&nbsp;|&nbsp;&nbsp;
      <a href="mailto:info@denpasarinstitute.id" style="color: #f5811f; font-weight: 600; text-decoration: none;">
        <i class="fas fa-envelope"></i> Email
      </a>
    </p>
  </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

<script>
(function () {
  function initAdmissionForm() {
    var $form = $('#admissionForm');
    if (!$form.length || $form.data('admission-initialized')) {
      return;
    }
    $form.data('admission-initialized', true);

    $form.find('.js-summernote').each(function () {
      var $el = $(this);
      if ($el.next('.note-editor').length || $el.data('summernote')) {
        return;
      }
      $el.summernote({
        height: 250,
        placeholder: 'Tuliskan pertanyaan atau permintaan khusus Anda...',
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['fontname', ['fontname']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture']],
          ['view', ['codeview', 'help']]
        ],
        fontNames: ['Arial', 'Courier New', 'Georgia', 'Helvetica', 'Poppins', 'Tahoma', 'Times New Roman'],
        fontNamesIgnoreCheck: ['Poppins'],
        disableDragAndDrop: false
      });
    });

    var $container = $form.find('.js-program-container');
    var programs = $container.data('programs') || [];

    function updateRemoveButtons() {
      var $items = $container.find('.program-item');
      $items.each(function () {
        $(this).find('.js-btn-remove-program').css('display', $items.length > 1 ? 'flex' : 'none');
      });
    }

    function createProgramItem() {
      var $div = $('<div class="program-item"></div>');
      var $select = $('<select name="program_ids[]" class="form-control" required></select>');
      $select.append('<option value=""> Pilih Program </option>');

      programs.forEach(function (prog) {
        $select.append($('<option></option>').attr('value', prog.id).text(prog.nama));
      });

      var $btn = $('<button type="button" class="btn-remove-program js-btn-remove-program" title="Hapus Program"><i class="fas fa-times"></i></button>');

      $div.append($select).append($btn);
      return $div;
    }

    $form.off('click.admissionAddProgram').on('click.admissionAddProgram', '.js-btn-add-program', function (e) {
      e.preventDefault();
      $container.append(createProgramItem());
      updateRemoveButtons();
    });

    $form.off('click.admissionRemoveProgram').on('click.admissionRemoveProgram', '.js-btn-remove-program', function (e) {
      e.preventDefault();
      $(this).closest('.program-item').remove();
      updateRemoveButtons();
    });

    updateRemoveButtons();

    $form.off('submit.admissionValidate').on('submit.admissionValidate', function (e) {
      var hasSelection = false;
      $container.find('select').each(function () {
        if ($(this).val()) {
          hasSelection = true;
        }
      });

      if (!hasSelection) {
        e.preventDefault();
        alert('Pilih minimal 1 program terlebih dahulu!');
        return false;
      }
    });

    $form.off('click.admissionReset').on('click.admissionReset', 'button[type="reset"]', function (e) {
      e.preventDefault();
      $form.find('.js-summernote').summernote('code', '');
      $form[0].reset();
      $container.find('select').prop('selectedIndex', 0);
      $container.find('.program-item').not(':first').remove();
      updateRemoveButtons();
    });
  }

  $(document).ready(initAdmissionForm);
  $(document).on('turbo:load turbo:render livewire:navigated', initAdmissionForm);
})();
</script>
@endpush