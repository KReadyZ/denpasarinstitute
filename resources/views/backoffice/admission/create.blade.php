@extends('backoffice.layouts.app')

@section('title', 'Tambah Peserta Program (Admission)')
@section('page-title', 'Tambah Peserta Program')

@section('content')

<div class="card">
  <div class="card-header">
    <div>
      <h3 style="margin:0;"><i class="fas fa-graduation-cap"></i> Form Pendaftaran Peserta Program (Admission)</h3>
      <p style="color:#666; font-size:0.82rem; margin:4px 0 0;">Input manual calon peserta yang mendaftar program kursus/pelatihan di Denpasar Institute.</p>
    </div>
  </div>
  <div class="card-body">
    <form action="{{ route('backoffice.admission.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-row">
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
        </div>
        <div class="form-group">
          <label>HP/WA</label>
          <input type="text" name="hp_wa" value="{{ old('hp_wa') }}" required>
        </div>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
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
      <div class="form-group">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
          <label style="margin:0; font-weight:700;">Daftar Program yang Diikuti <span style="color:#dc2626;">*</span></label>
          <button type="button" class="btn btn-outline-danger btn-sm" id="btnAddProgram" style="font-weight:600; font-size:0.82rem; padding:4px 12px; border-radius:6px;">
            <i class="fas fa-plus"></i> Tambah Program Lain
          </button>
        </div>
        <div id="programContainer" style="display:flex; flex-direction:column; gap:12px;">
          @if(count($oldProgramIds) > 0)
            @foreach($oldProgramIds as $oldProgId)
              @php
                $selectedDivId = $programToDivisiMap[$oldProgId] ?? null;
                $availableProgs = $selectedDivId && isset($divisiProgramMap[$selectedDivId]) ? $divisiProgramMap[$selectedDivId]['programs'] : [];
              @endphp
              <div class="program-item d-flex gap-2 align-items-center">
                <select class="form-control js-divisi-select" style="flex:1;">
                  <option value="">-- 1. Pilih Divisi --</option>
                  @foreach($divisiList as $div)
                    <option value="{{ $div->id }}" {{ $selectedDivId == $div->id ? 'selected' : '' }}>
                      {{ $div->nama }} ({{ $div->programs->count() }} Program)
                    </option>
                  @endforeach
                </select>
                <select name="program_ids[]" class="form-control js-program-select" style="flex:1.3;" required {{ $selectedDivId ? '' : 'disabled' }}>
                  <option value="">-- 2. Pilih Program --</option>
                  @foreach($availableProgs as $pItem)
                    <option value="{{ $pItem['id'] }}" {{ $pItem['id'] == $oldProgId ? 'selected' : '' }}>
                      {{ $pItem['nama'] }}
                    </option>
                  @endforeach
                </select>
                <button type="button" class="btn-remove-program" title="Hapus">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            @endforeach
          @else
            <div class="program-item d-flex gap-2 align-items-center">
              <select class="form-control js-divisi-select" style="flex:1;">
                <option value="">-- 1. Pilih Divisi Lembaga --</option>
                @foreach($divisiList as $div)
                  <option value="{{ $div->id }}">{{ $div->nama }} ({{ $div->programs->count() }} Program)</option>
                @endforeach
              </select>
              <select name="program_ids[]" class="form-control js-program-select" style="flex:1.3;" required disabled>
                <option value="">-- 2. Pilih Program (Pilih Divisi Dulu) --</option>
              </select>
              <button type="button" class="btn-remove-program" style="display:none;" title="Hapus">
                <i class="fas fa-times"></i>
              </button>
            </div>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label>Special Request</label>
        <textarea name="special_request" id="special_request">{{ old('special_request') }}</textarea>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Nominal Pembayaran (Rp)</label>
          <input
            type="text"
            name="nominal_pembayaran"
            value="{{ old('nominal_pembayaran', '250.000') }}"
            placeholder="Contoh: 250.000"
            oninput="let v = this.value.replace(/[^0-9]/g, ''); if(v) this.value = new Intl.NumberFormat('id-ID').format(v);"
          >
          <small>Nominal biaya yang dibayarkan</small>
        </div>
        <div class="form-group">
          <label>Metode Pembayaran</label>
          <select name="metode_pembayaran" class="form-control">
            <optgroup label="-- Pelunasan Penuh --">
              <option value="Transfer Bank (BCA / Mandiri / BNI / BRI)" {{ old('metode_pembayaran') === 'Transfer Bank (BCA / Mandiri / BNI / BRI)' ? 'selected' : '' }}>Transfer Bank (BCA / Mandiri / BNI / BRI)</option>
              <option value="QRIS / E-Wallet" {{ old('metode_pembayaran') === 'QRIS / E-Wallet' ? 'selected' : '' }}>QRIS / E-Wallet</option>
              <option value="Tunai (Cash)" {{ old('metode_pembayaran') === 'Tunai (Cash)' ? 'selected' : '' }}>Tunai di Kampus Denpasar Institute</option>
            </optgroup>
            <optgroup label="-- Pembayaran DP / Uang Muka --">
              <option value="DP (Uang Muka) - Transfer Bank" {{ old('metode_pembayaran') === 'DP (Uang Muka) - Transfer Bank' ? 'selected' : '' }}>DP (Uang Muka) - Transfer Bank</option>
              <option value="DP (Uang Muka) - QRIS / E-Wallet" {{ old('metode_pembayaran') === 'DP (Uang Muka) - QRIS / E-Wallet' ? 'selected' : '' }}>DP (Uang Muka) - QRIS / E-Wallet</option>
              <option value="DP (Uang Muka) - Tunai di Kampus" {{ old('metode_pembayaran') === 'DP (Uang Muka) - Tunai di Kampus' ? 'selected' : '' }}>DP (Uang Muka) - Tunai di Kampus</option>
            </optgroup>
          </select>
          <small>Metode yang digunakan peserta (tersedia opsi Lunas atau DP)</small>
        </div>
      </div>

      <div class="form-group">
        <label>Upload Bukti Pembayaran / Transfer (jika ada)</label>
        <input type="file" name="bukti_bayar_pendaftaran" accept="image/jpeg,image/jpg,image/png,application/pdf">
        <small>Format: PDF, JPG, JPEG, PNG (Maks. 2MB)</small>
      </div>

      <div class="form-group">
        <label>Informasi tentang Denpasar Institute diperoleh dari</label>
        <div class="form-check-wrap form-check-grid">
          @foreach(['Keluarga','Teman','Lembaga Tempat Belajar atau Kerja','Media Sosial','Situs Denpasar Institute','Pameran Pendidikan','Lainnya'] as $sumber)
          <div class="form-check-line">
            <input type="checkbox" name="sumber_informasi[]" value="{{ $sumber }}" id="sumber{{ Str::slug($sumber) }}">
            <label for="sumber{{ Str::slug($sumber) }}">{{ $sumber }}</label>
          </div>
          @endforeach
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="{{ route('backoffice.admission.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>

@endsection

@push('styles')
<style>
  #programContainer {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .program-item {
    display: flex;
    gap: 8px;
    align-items: flex-start;
  }

  .program-item select {
    flex: 1;
  }

  .btn-remove-program {
    width: 36px;
    height: 36px;
    padding: 0;
    border: 1px solid #dc2626;
    background: #fecaca;
    color: #dc2626;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    transition: all 0.2s;
    flex-shrink: 0;
    margin-top: 0;
  }

  .btn-remove-program:hover {
    background: #dc2626;
    color: #fff;
  }

  .form-control {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    font-family: Poppins, sans-serif;
    font-size: 0.83rem;
    outline: none;
    transition: border-color 0.2s;
  }

  .form-control:focus {
    border-color: var(--red);
  }

  /* Multi-column layout untuk checklist panjang */
  .form-check-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px 20px;
  }
  .form-check-grid .form-check-line {
    padding: 0;
    margin: 0;
    border: none;
  }
  .form-check-grid .form-check-line input[type="checkbox"] {
    margin-right: 6px;
    cursor: pointer;
  }
  .form-check-grid .form-check-line label {
    margin-bottom: 0;
    font-weight: 500;
    cursor: pointer;
    font-size: 0.82rem;
  }

  @media (max-width: 1024px) {
    .form-check-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 10px 16px;
    }
  }
  @media (max-width: 576px) {
    .form-check-grid {
      grid-template-columns: 1fr;
      gap: 8px;
    }
    .program-item {
      flex-direction: column;
    }
    .btn-remove-program {
      width: 100%;
    }
  }
</style>
@endpush

@push('scripts')
<script>
  $(document).ready(function () {
    $('#special_request').summernote({
      height: 180,
      toolbar: [
        ['style', ['bold', 'italic', 'underline']],
        ['para', ['ul', 'ol']],
        ['insert', ['link']]
      ]
    });

    // Cascading Divisi -> Program Selection
    const container = document.getElementById('programContainer');
    const btnAdd = document.getElementById('btnAddProgram');
    const divisiPrograms = {!! json_encode($divisiProgramMap) !!};

    function updateRemoveButtons() {
      const items = container.querySelectorAll('.program-item');
      items.forEach((item) => {
        const btn = item.querySelector('.btn-remove-program');
        if (btn) {
          btn.style.display = items.length > 1 ? 'inline-flex' : 'none';
        }
      });
    }

    function setupRowEvents(item) {
      const divSelect = item.querySelector('.js-divisi-select');
      const progSelect = item.querySelector('.js-program-select');
      const btnRemove = item.querySelector('.btn-remove-program');

      if (divSelect) {
        divSelect.addEventListener('change', function () {
          const divId = this.value;
          progSelect.innerHTML = '';

          if (divId && divisiPrograms[divId] && divisiPrograms[divId].programs.length > 0) {
            const d = divisiPrograms[divId];
            const defOpt = document.createElement('option');
            defOpt.value = '';
            defOpt.textContent = '-- 2. Pilih Program di ' + d.nama + ' (' + d.programs.length + ' Pilihan) --';
            progSelect.appendChild(defOpt);

            d.programs.forEach(p => {
              const opt = document.createElement('option');
              opt.value = p.id;
              opt.textContent = p.nama;
              progSelect.appendChild(opt);
            });

            progSelect.disabled = false;
            progSelect.focus();
          } else {
            const defOpt = document.createElement('option');
            defOpt.value = '';
            defOpt.textContent = '-- 2. Pilih Program (Pilih Divisi Dulu) --';
            progSelect.appendChild(defOpt);
            progSelect.disabled = true;
          }
        });
      }

      if (btnRemove) {
        btnRemove.addEventListener('click', function (e) {
          e.preventDefault();
          item.remove();
          updateRemoveButtons();
        });
      }
    }

    function createProgramItem() {
      const div = document.createElement('div');
      div.className = 'program-item d-flex gap-2 align-items-center';

      const divSelect = document.createElement('select');
      divSelect.className = 'form-control js-divisi-select';
      divSelect.style.flex = '1';
      divSelect.innerHTML = '<option value="">-- 1. Pilih Divisi Lembaga --</option>';
      Object.values(divisiPrograms).forEach(d => {
        const opt = document.createElement('option');
        opt.value = d.id;
        opt.textContent = d.nama + ' (' + d.programs.length + ' Program)';
        divSelect.appendChild(opt);
      });

      const progSelect = document.createElement('select');
      progSelect.name = 'program_ids[]';
      progSelect.className = 'form-control js-program-select';
      progSelect.style.flex = '1.3';
      progSelect.required = true;
      progSelect.disabled = true;
      progSelect.innerHTML = '<option value="">-- 2. Pilih Program (Pilih Divisi Dulu) --</option>';

      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'btn-remove-program';
      btn.title = 'Hapus';
      btn.innerHTML = '<i class="fas fa-times"></i>';

      div.appendChild(divSelect);
      div.appendChild(progSelect);
      div.appendChild(btn);

      setupRowEvents(div);
      return div;
    }

    container.querySelectorAll('.program-item').forEach(setupRowEvents);

    if (btnAdd) {
      btnAdd.addEventListener('click', function(e) {
        e.preventDefault();
        container.appendChild(createProgramItem());
        updateRemoveButtons();
      });
    }

    updateRemoveButtons();
  });
</script>
@endpush