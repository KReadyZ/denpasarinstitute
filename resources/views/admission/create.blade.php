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
  .form-group textarea {
    padding: 12px 14px;
    border: 1.5px solid #cbd5e1;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
    color: #333;
    outline: none;
    transition: all 0.2s;
  }

  .form-group input:focus,
  .form-group textarea:focus {
    border-color: #CC0000;
    box-shadow: 0 0 0 3px rgba(204, 0, 0, 0.1);
  }

  .form-group select,
  .form-group select.program-select-custom,
  .program-select-custom {
    appearance: none !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    background-color: #ffffff !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%2364748b'%3E%3Cpath d='M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 16px center !important;
    background-size: 20px 20px !important;
    padding: 12px 46px 12px 16px !important;
    border: 1.5px solid #cbd5e1 !important;
    border-radius: 10px !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 0.92rem !important;
    font-weight: 500 !important;
    color: #1e293b !important;
    line-height: 1.5 !important;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03) !important;
    transition: all 0.2s ease !important;
    cursor: pointer !important;
    width: 100% !important;
    height: auto !important;
    outline: none !important;
  }

  .form-group select:hover,
  .program-select-custom:hover {
    border-color: #94a3b8 !important;
    background-color: #f8fafc !important;
  }

  .form-group select:focus,
  .program-select-custom:focus {
    border-color: #CC0000 !important;
    background-color: #ffffff !important;
    box-shadow: 0 0 0 4px rgba(204, 0, 0, 0.12) !important;
    outline: none !important;
  }

  .form-group select optgroup,
  .program-select-custom optgroup {
    font-weight: 700;
    color: #CC0000;
    background: #f1f5f9;
    padding: 8px 10px;
    font-size: 0.85rem;
  }

  .form-group select option,
  .program-select-custom option {
    font-weight: 400;
    color: #1e293b;
    background: #ffffff;
    padding: 10px 14px;
    font-size: 0.9rem;
  }

  .form-group.error select,
  .form-group.error select.program-select-custom,
  .form-group.error .program-select-custom {
    border-color: #ef4444 !important;
    background-color: #fef2f2 !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23ef4444'%3E%3Cpath d='M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z'/%3E%3C/svg%3E") !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15) !important;
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
    gap: 16px;
  }

  .program-item {
    display: flex;
    gap: 14px;
    align-items: flex-end;
    position: relative;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    padding: 16px 18px;
    border-radius: 12px;
    transition: all 0.2s ease;
  }

  .program-item:hover,
  .program-item:focus-within {
    background: #ffffff;
    border-color: #CC0000;
    box-shadow: 0 4px 16px rgba(204, 0, 0, 0.08);
  }

  .program-field-group {
    display: grid;
    grid-template-columns: 1fr 1.3fr;
    gap: 14px;
    flex: 1;
    width: 100%;
  }

  .field-col {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .field-sublabel {
    font-size: 0.8rem;
    font-weight: 700;
    color: #334155;
    display: flex;
    align-items: center;
    gap: 6px;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.3px;
  }

  .divisi-select-custom,
  .program-select-custom {
    width: 100%;
    height: 48px;
    padding: 10px 14px;
    border: 1.5px solid #cbd5e1;
    border-radius: 8px;
    font-size: 0.92rem;
    font-family: 'Poppins', sans-serif;
    color: #1e293b;
    background-color: #ffffff;
    transition: all 0.2s ease;
  }

  .divisi-select-custom:focus,
  .program-select-custom:focus {
    border-color: #CC0000;
    outline: none;
    box-shadow: 0 0 0 3px rgba(204, 0, 0, 0.12);
  }

  .program-select-custom:disabled {
    background-color: #f1f5f9;
    color: #94a3b8;
    border-color: #e2e8f0;
    cursor: not-allowed;
  }

  .btn-add-program {
    background: #ffffff;
    color: #CC0000;
    border: 1.5px dashed #CC0000;
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
    font-family: 'Poppins', sans-serif;
  }

  .btn-add-program:hover {
    background: #CC0000;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(204, 0, 0, 0.2);
  }

  .btn-remove-program {
    width: 44px;
    height: 48px;
    padding: 0;
    border: 1px solid #fecaca;
    background: #fee2e2;
    color: #dc2626;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    transition: all 0.2s;
    flex-shrink: 0;
    margin-bottom: 0;
  }

  .btn-remove-program:hover {
    background: #dc2626;
    color: #ffffff;
    border-color: #dc2626;
    transform: scale(1.05);
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

    .program-field-group {
      grid-template-columns: 1fr;
      gap: 12px;
    }

    .program-item {
      flex-direction: column;
      align-items: stretch;
      gap: 12px;
    }

    .btn-remove-program {
      width: 100%;
      height: 42px;
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

  /* Compact Summernote Style for Deskripsi Pembayaran */
  .note-editor-compact.note-frame {
    border: 1px solid #cbd5e1 !important;
    border-radius: 8px !important;
    overflow: hidden !important;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
  }
  .note-editor-compact.note-frame .note-toolbar {
    background: #f8fafc !important;
    border-bottom: 1px solid #e2e8f0 !important;
    padding: 3px 6px !important;
  }
  .note-editor-compact.note-frame .note-toolbar .note-btn {
    padding: 2px 7px !important;
    font-size: 0.76rem !important;
    line-height: 1.2 !important;
    border-radius: 4px !important;
  }
  .note-editor-compact.note-frame .note-editing-area .note-editable {
    min-height: 85px !important;
    height: 110px !important;
    max-height: 160px !important;
    font-size: 0.85rem !important;
    line-height: 1.45 !important;
    padding: 8px 12px !important;
    color: #334155 !important;
  }
  .note-editor-compact.note-frame .note-statusbar {
    display: none !important;
  }
</style>

@php
  $admTitle = \App\Models\SiteSetting::get('admission_form_title', 'Formulir Pendaftaran');
  $admSubtitle = \App\Models\SiteSetting::get('admission_form_subtitle', 'Daftar sebagai peserta program Denpasar Institute');
  $admNotice = \App\Models\SiteSetting::get('admission_form_notice', '<strong>Petunjuk:</strong> Silakan isi semua kolom yang bertanda <span style="color: #CC0000;">*</span> (wajib diisi). Data Anda akan kami verifikasi sebelum konfirmasi pendaftaran.');
  $admDefaultFee = \App\Models\SiteSetting::get('admission_default_fee', '250.000');
  $rekBca = \App\Models\SiteSetting::get('bank_bca_rek', '7720918899');
  $holderBca = \App\Models\SiteSetting::get('bank_bca_holder', 'Denpasar Institute');
  $rekBni = \App\Models\SiteSetting::get('bank_bni_rek', '0819192837');
  $holderBni = \App\Models\SiteSetting::get('bank_bni_holder', 'Yayasan Denpasar Institute');
  $rekMandiri = \App\Models\SiteSetting::get('bank_mandiri_rek', '1450018293812');
  $holderMandiri = \App\Models\SiteSetting::get('bank_mandiri_holder', 'Denpasar Institute');
  $rekBri = \App\Models\SiteSetting::get('bank_bri_rek', '001701002891534');
  $holderBri = \App\Models\SiteSetting::get('bank_bri_holder', 'Denpasar Institute');
  $qrisTitle = \App\Models\SiteSetting::get('qris_title', 'QRIS Resmi Denpasar Institute (NMID: ID102003891829)');
  $qrisDesc = \App\Models\SiteSetting::get('qris_desc', 'Menerima pembayaran dari seluruh aplikasi m-Banking (BCA, Mandiri, BNI, BRI, dll) serta E-Wallet (GoPay, OVO, Dana, ShopeePay, LinkAja).');
  $qrisImage = \App\Models\SiteSetting::get('qris_image');
  $tunaiTitle = \App\Models\SiteSetting::get('tunai_title', 'Loket Pembayaran Kampus Denpasar Institute');
  $tunaiAddress = \App\Models\SiteSetting::get('tunai_address', 'Jl. Gatot Subroto VI No. 27, Dauh Puri Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali 80231 (Senin - Sabtu: 08.00 - 17.00 WITA).');
  $securityNotice = \App\Models\SiteSetting::get('transfer_security_notice', 'Pastikan transfer ditujukan ke rekening resmi atas nama Denpasar Institute. Simpan bukti transfer Anda.');
  $waAdmin = \App\Models\SiteSetting::get('admission_wa_admin', '0821-4481-4593');
  $waAdminClean = preg_replace('/[^0-9]/', '', (string)$waAdmin);
  $waAdminLink = str_starts_with($waAdminClean, '0') ? '62' . substr($waAdminClean, 1) : $waAdminClean;
  $waService = \App\Models\SiteSetting::get('admission_wa_service', '0823-1866-6547');
  $waServiceClean = preg_replace('/[^0-9]/', '', (string)$waService);
  $waServiceLink = str_starts_with($waServiceClean, '0') ? '62' . substr($waServiceClean, 1) : $waServiceClean;
  $admEmail = \App\Models\SiteSetting::get('admission_email', 'info@denpasarinstitute.id');
@endphp

<div class="admission-hero">
  <div class="admission-container">
    <h1>{{ $admTitle }}</h1>
    <p>{{ $admSubtitle }}</p>
  </div>
</div>

<div class="admission-container">
  @if (isset($errors) && $errors->any())
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
    {!! $admNotice !!}
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

      @php
        $divisiProgramMap = [];
        $programToDivisiMap = [];
        foreach ($divisiList as $div) {
            $divisiProgramMap[$div->id] = [
                'id' => $div->id,
                'nama' => $div->nama,
                'programs' => $div->programs->map(fn($p) => [
                    'id' => $p->id,
                    'nama' => $p->nama,
                ])->values()->all(),
            ];
            foreach ($div->programs as $p) {
                $programToDivisiMap[$p->id] = $div->id;
            }
        }
        $oldProgramIds = array_values(array_filter((array) old('program_ids', [])));
      @endphp

      {{-- Program yang Diikuti (Field Isian Langsung dengan Autocomplete) --}}
      <div class="form-section">
        <h3 class="form-section-title">
          Program yang Diikuti
          <span class="required">*</span>
        </h3>

        <div class="form-row full">
          <div class="form-group @error('program_name') error @enderror @error('program_ids') error @enderror">
            <label for="program_input">Nama Program / Kursus yang Diikuti <span class="required">*</span></label>
            <input
              type="text"
              name="program_name"
              id="program_input"
              list="programListSuggestions"
              class="form-control"
              placeholder="Ketik atau pilih nama program yang ingin diikuti (contoh: Kursus Bahasa Jepang, Digital Marketing, dll)..."
              value="{{ old('program_name', (isset($programs) && count(old('program_ids', [])) > 0 ? optional($programs->firstWhere('id', old('program_ids')[0]))->nama : '')) }}"
              required
              autocomplete="off"
            >
            <datalist id="programListSuggestions">
              @if(isset($programs))
                @foreach($programs as $prog)
                  <option value="{{ $prog->nama }}">{{ $prog->divisi->nama ?? 'Denpasar Institute' }}</option>
                @endforeach
              @endif
            </datalist>
            @error('program_name')
              <div class="error-message"><i class="fas fa-times-circle"></i> {{ $message }}</div>
            @enderror
            @error('program_ids')
              <div class="error-message"><i class="fas fa-times-circle"></i> {{ $message }}</div>
            @enderror
            <small>Ketik nama program yang ingin Anda ikuti atau pilih rekomendasi dari daftar yang muncul secara otomatis.</small>
          </div>
        </div>
      </div>

      <div class="form-section">
        <h3 class="form-section-title">Transfer Bank &amp; Bukti Pembayaran (Opsional)</h3>

        <div class="form-row">
          <div class="form-group @error('nominal_pembayaran') error @enderror">
            <label id="nominal_label">Nominal yang Ditransfer (Rp)</label>
            <input
              type="text"
              name="nominal_pembayaran"
              id="nominal_pembayaran"
              value="{{ old('nominal_pembayaran', $admDefaultFee) }}"
              placeholder="Contoh: {{ $admDefaultFee }}"
              oninput="let v = this.value.replace(/[^0-9]/g, ''); if(v) this.value = new Intl.NumberFormat('id-ID').format(v);"
            >
            @error('nominal_pembayaran')
              <div class="error-message"><i class="fas fa-times-circle"></i> {{ $message }}</div>
            @enderror
            <small id="nominal_subtext">Ketik nominal pembayaran yang telah ditransfer (contoh: {{ $admDefaultFee }})</small>
          </div>

          <div class="form-group @error('metode_pembayaran') error @enderror">
            <label>Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode_pembayaran" class="form-control">
              <optgroup label="-- Pembayaran Penuh (Lunas) --">
                <option value="Transfer Bank BNI (Rekening Resmi)" {{ old('metode_pembayaran') === 'Transfer Bank BNI (Rekening Resmi)' || !old('metode_pembayaran') ? 'selected' : '' }}>Transfer Bank BNI (Rekening Resmi)</option>
                <option value="QRIS / E-Wallet" {{ old('metode_pembayaran') === 'QRIS / E-Wallet' ? 'selected' : '' }}>QRIS / E-Wallet</option>
                <option value="Tunai (Cash)" {{ old('metode_pembayaran') === 'Tunai (Cash)' ? 'selected' : '' }}>Tunai di Kampus Denpasar Institute</option>
              </optgroup>
              <optgroup label="-- Pembayaran DP (Down Payment / Uang Muka) --">
                <option value="DP (Uang Muka) - Transfer Bank BNI" {{ old('metode_pembayaran') === 'DP (Uang Muka) - Transfer Bank BNI' ? 'selected' : '' }}>DP (Uang Muka) - Transfer Bank BNI</option>
                <option value="DP (Uang Muka) - QRIS / E-Wallet" {{ old('metode_pembayaran') === 'DP (Uang Muka) - QRIS / E-Wallet' ? 'selected' : '' }}>DP (Uang Muka) - QRIS / E-Wallet</option>
                <option value="DP (Uang Muka) - Tunai di Kampus" {{ old('metode_pembayaran') === 'DP (Uang Muka) - Tunai di Kampus' ? 'selected' : '' }}>DP (Uang Muka) - Tunai di Kampus</option>
              </optgroup>
            </select>
            <small id="metode_subtext">Pilih metode transfer Bank BNI resmi atau opsi alternatif.</small>
          </div>
        </div>

        {{-- Card Informasi Rekening Tujuan Transfer Resmi Bank BNI --}}
        <div class="tujuan-transfer-wrap my-3" id="box_tujuan_transfer">
          <div class="card border-0 rounded-3 shadow-sm overflow-hidden" style="background: #f8fafc; border: 1px solid #e2e8f0 !important;">
            <div class="card-header border-bottom py-2.5 px-3 bg-white d-flex align-items-center justify-content-between">
              <span class="small fw-bold text-dark d-flex align-items-center">
                <i class="fas fa-building-columns text-danger me-2"></i> Rekening Resmi Tujuan Transfer
              </span>
              <span class="badge rounded-pill" style="font-size: 0.72rem; background: #fee2e2; color: #b91c1c;">
                Rekening Resmi Terverifikasi
              </span>
            </div>
            <div class="card-body p-3">
              {{-- Rekening Utama: Bank BNI Saja --}}
              <div id="list_rekening_bank">
                <div class="p-3 rounded-2 bg-white border border-danger-subtle d-flex flex-wrap justify-content-between align-items-center gap-2" style="border-left: 4px solid #dc2626 !important;">
                  <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                      <span class="badge bg-danger text-white px-2 py-0.5" style="font-size: 0.75rem; font-weight: 700;">BANK BNI</span>
                      <span class="small text-muted fw-semibold">Rekening Penerimaan Resmi Denpasar Institute</span>
                    </div>
                    <div class="font-monospace fw-bold fs-5 text-dark" id="rek_bni" style="letter-spacing: 0.5px;">{{ $rekBni }}</div>
                    <div class="text-secondary small mt-0.5"><i class="fas fa-user-check text-success me-1"></i> a.n. <strong>{{ $holderBni }}</strong></div>
                  </div>
                  <div>
                    <button type="button" class="btn btn-outline-danger btn-sm py-1.5 px-3 fw-semibold btn-copy-rek" data-target="{{ $rekBni }}" title="Salin nomor rekening BNI">
                      <i class="far fa-copy me-1"></i> <span class="btn-copy-text">Salin No. Rekening</span>
                    </button>
                  </div>
                </div>
              </div>

              {{-- Instruksi QRIS --}}
              <div id="info_qris" class="p-3 rounded-3 bg-white border mt-2 shadow-sm text-center" style="display: none;">
                <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                  <i class="fas fa-qrcode text-danger fs-5"></i>
                  <span class="fw-bold small text-dark">{{ $qrisTitle }}</span>
                </div>
                <div class="text-muted small mb-3" style="font-size: 0.78rem;">
                  {{ $qrisDesc }}
                </div>

                @if($qrisImage)
                  <div class="p-3 bg-light rounded-3 border d-inline-block mx-auto my-1 shadow-sm" style="max-width: 280px;">
                    <div class="badge bg-danger mb-2 px-2.5 py-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                      <i class="fas fa-camera me-1"></i> SCAN UNTUK BAYAR
                    </div>
                    <div class="bg-white p-2 rounded-2 border shadow-sm">
                      <img src="{{ asset('storage/' . $qrisImage) }}" alt="QRIS Denpasar Institute" class="img-fluid rounded" style="max-height: 250px; width: auto; object-fit: contain;">
                    </div>
                    <div class="mt-2 text-muted" style="font-size: 0.72rem;">
                      <a href="{{ asset('storage/' . $qrisImage) }}" target="_blank" class="text-decoration-none text-danger fw-semibold">
                        <i class="fas fa-search-plus me-1"></i> Lihat Gambar Penuh
                      </a>
                    </div>
                  </div>
                @else
                  <div class="p-3 bg-light rounded-3 border text-center text-muted small my-2">
                    <i class="fas fa-qrcode fa-2x mb-1 text-secondary opacity-50"></i>
                    <div>Foto QRIS belum diunggah oleh admin melalui Backoffice.</div>
                  </div>
                @endif

                <div class="text-muted fst-italic mt-2" style="font-size: 0.73rem;">
                  <i class="fas fa-info-circle text-primary me-1"></i>
                  Buka aplikasi mobile banking (BCA, Mandiri, BNI, BRI) atau e-wallet (GoPay, OVO, Dana, ShopeePay), pilih menu <strong>Scan / Bayar QRIS</strong>, lalu scan barcode di atas.
                </div>
              </div>

              {{-- Instruksi Tunai --}}
              <div id="info_tunai" class="p-2.5 rounded-2 bg-white border mt-2" style="display: none;">
                <div class="d-flex align-items-center gap-2 mb-1">
                  <i class="fas fa-map-marker-alt text-danger fs-5"></i>
                  <span class="fw-bold small text-dark">{{ $tunaiTitle }}</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">
                  {{ $tunaiAddress }}
                </div>
              </div>

              <div class="mt-2 text-muted fst-italic d-flex align-items-center gap-1.5" style="font-size: 0.73rem;">
                <i class="fas fa-shield-alt text-success"></i>
                <span>{{ $securityNotice }}</span>
              </div>
            </div>
          </div>
        </div>

        {{-- Deskripsi / Catatan Pembayaran --}}
        <div class="form-row full">
          <div class="form-group @error('deskripsi_pembayaran') error @enderror">
            <label for="deskripsi_pembayaran">Deskripsi / Catatan Pembayaran</label>
            <textarea
              name="deskripsi_pembayaran"
              id="deskripsi_pembayaran"
              rows="3"
              class="form-control"
              placeholder="Contoh: Transfer via m-Banking BNI a.n. Pengirim / Berita: Pendaftaran Kursus..."
              style="resize: vertical; min-height: 85px;"
            >{{ old('deskripsi_pembayaran') }}</textarea>
            @error('deskripsi_pembayaran')
              <div class="error-message"><i class="fas fa-times-circle"></i> {{ $message }}</div>
            @enderror
            <small>Ketik keterangan tambahan transfer, nama pemilik rekening pengirim, atau catatan pembayaran (opsional).</small>
          </div>
        </div>

        {{-- Unggah Bukti Transfer --}}
        <div class="form-row full">
          <div class="form-group @error('bukti_bayar_pendaftaran') error @enderror">
            <label>Unggah Bukti Transfer / Pembayaran</label>
            <input
              type="file"
              name="bukti_bayar_pendaftaran"
              id="bukti_bayar_pendaftaran"
              accept="image/jpeg,image/jpg,image/png,application/pdf"
            >
            @error('bukti_bayar_pendaftaran')
              <div class="error-message"><i class="fas fa-times-circle"></i> {{ $message }}</div>
            @enderror
            <small>Unggah foto resi/struk transfer BNI, bukti m-Banking, atau tangkapan layar pembayaran pendaftaran (Maks. 2MB). Format: JPG, JPEG, PNG, PDF.</small>
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
      <a href="https://wa.me/{{ $waAdminLink }}" target="_blank" style="color: #25d366; font-weight: 600; text-decoration: none;">
        <i class="fab fa-whatsapp"></i> WhatsApp Admin ({{ $waAdmin }})
      </a>
      &nbsp;&nbsp;|&nbsp;&nbsp;
      <a href="https://wa.me/{{ $waServiceLink }}" target="_blank" style="color: #25d366; font-weight: 600; text-decoration: none;">
        <i class="fab fa-whatsapp"></i> WhatsApp Layanan ({{ $waService }})
      </a>
      &nbsp;&nbsp;|&nbsp;&nbsp;
      <a href="mailto:{{ $admEmail }}" style="color: #f5811f; font-weight: 600; text-decoration: none;">
        <i class="fas fa-envelope"></i> Email ({{ $admEmail }})
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

    // Summernote Ukuran Kecil (Compact) untuk Deskripsi / Catatan Pembayaran
    $form.find('.js-summernote-compact').each(function () {
      var $el = $(this);
      if ($el.next('.note-editor').length || $el.data('summernote')) {
        return;
      }
      $el.summernote({
        height: 100,
        placeholder: 'Tuliskan keterangan transfer, nama bank & pemilik rekening pengirim, atau catatan...',
        toolbar: [
          ['font', ['bold', 'italic', 'underline', 'clear']],
          ['para', ['ul', 'ol']],
          ['insert', ['link']]
        ],
        callbacks: {
          onInit: function() {
            $el.next('.note-editor').addClass('note-editor-compact');
          }
        }
      });
    });

    $form.off('submit.admissionValidate').on('submit.admissionValidate', function (e) {
      var programVal = $.trim($('#program_input').val() || '');
      if (!programVal) {
        e.preventDefault();
        alert('Silakan isi atau pilih nama program yang ingin Anda ikuti!');
        $('#program_input').closest('.form-group').addClass('error');
        $('html, body').animate({
          scrollTop: $('#program_input').offset().top - 120
        }, 300);
        $('#program_input').focus();
        return false;
      }
    });

    $('#program_input').on('input change', function() {
      if ($.trim($(this).val())) {
        $(this).closest('.form-group').removeClass('error');
      }
    });

    function updateMetodePembayaranUI() {
      var val = $('#metode_pembayaran').val() || '';
      if (val.indexOf('DP') !== -1) {
        $('#nominal_label').html('Nominal DP / Uang Muka (Rp) <span style="font-size:0.75rem; color:#b45309; font-weight:normal;">(Bertahap)</span>');
        $('#nominal_subtext').html('<span style="color:#b45309; font-weight:600;"><i class="fas fa-info-circle me-1"></i> Opsi DP aktif:</span> Silakan tentukan nominal uang muka yang Anda transfer.');
      } else {
        $('#nominal_label').text('Nominal yang Ditransfer (Rp)');
        $('#nominal_subtext').text('Ketik nominal pembayaran yang telah ditransfer (contoh: 250.000)');
      }

      // Tampilkan tujuan transfer berdasarkan metode
      if (val.indexOf('QRIS') !== -1) {
        $('#info_qris').slideDown(150);
        $('#info_tunai').slideUp(150);
        $('#list_rekening_bank').slideUp(150);
      } else if (val.indexOf('Tunai') !== -1) {
        $('#info_tunai').slideDown(150);
        $('#info_qris').slideUp(150);
        $('#list_rekening_bank').slideUp(150);
      } else {
        $('#list_rekening_bank').slideDown(150);
        $('#info_qris').slideUp(150);
        $('#info_tunai').slideUp(150);
      }
    }

    $('#metode_pembayaran').on('change', updateMetodePembayaranUI);
    updateMetodePembayaranUI();

    // Copy Nomor Rekening
    $(document).off('click.copyRek').on('click.copyRek', '.btn-copy-rek', function (e) {
      e.preventDefault();
      var target = $(this).data('target');
      var $btn = $(this);
      if (navigator.clipboard) {
        navigator.clipboard.writeText(target).then(function () {
          $btn.find('.btn-copy-text').text('Tersalin!');
          $btn.addClass('btn-success text-white').removeClass('btn-outline-danger');
          setTimeout(function () {
            $btn.find('.btn-copy-text').text('Salin No. Rekening');
            $btn.removeClass('btn-success text-white').addClass('btn-outline-danger');
          }, 2000);
        });
      }
    });

    $form.off('click.admissionReset').on('click.admissionReset', 'button[type="reset"]', function (e) {
      e.preventDefault();
      $form[0].reset();
      updateMetodePembayaranUI();
    });
  }

  $(document).ready(initAdmissionForm);
  $(document).on('turbo:load turbo:render livewire:navigated', initAdmissionForm);
})();
</script>
@endpush