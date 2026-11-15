@extends('backoffice.layouts.app')

@section('title', 'Edit Admission')
@section('page-title', 'Edit Data Pendaftaran')

@push('styles')
<style>
  #programContainer {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .program-item {
    display: flex;
    gap: 10px;
    align-items: center;
  }

  .program-item select {
    flex: 1;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    font-size: 0.85rem;
    padding: 8px 12px;
  }

  .program-item select optgroup {
    font-weight: 700;
    color: #CC0000;
    background: #f8fafc;
  }

  .btn-remove-program {
    width: 36px;
    height: 36px;
    padding: 0;
    border: 1px solid #fca5a5;
    background: #fef2f2;
    color: #dc2626;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    transition: all 0.2s;
    flex-shrink: 0;
  }

  .btn-remove-program:hover {
    background: #dc2626;
    color: #fff;
    border-color: #dc2626;
  }
</style>
@endpush

@section('content')

<div class="card">
  <div class="card-header">
    <h3>Form Pendaftaran</h3>
    <div>
      @if($admission->status == 'approved')
        <span class="badge badge-approved">Terverifikasi</span>
      @elseif($admission->status == 'rejected')
        <span class="badge badge-rejected">Ditolak</span>
      @else
        <span class="badge badge-pending">Pending</span>
      @endif
    </div>
  </div>
  <div class="card-body">
    <form action="{{ route('backoffice.admission.update', $admission->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-row">
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $admission->nama_lengkap) }}" required>
        </div>
        <div class="form-group">
          <label>HP/WA</label>
          <input type="text" name="hp_wa" value="{{ old('hp_wa', $admission->hp_wa) }}" required>
        </div>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $admission->email) }}" required>
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
        $selectedProgramIds = old('program_ids', $admission->programs->pluck('id')->toArray());
        if (!is_array($selectedProgramIds)) {
            $selectedProgramIds = [];
        }
      @endphp

      <div class="form-group">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
          <label style="margin:0; font-weight:700;">Daftar Program yang Diikuti <span style="color:#dc2626;">*</span></label>
          <button type="button" class="btn btn-outline-danger btn-sm" id="btnAddProgram" style="font-weight:600; font-size:0.82rem; padding:4px 12px; border-radius:6px;">
            <i class="fas fa-plus"></i> Tambah Program Lain
          </button>
        </div>
        <div id="programContainer" style="display:flex; flex-direction:column; gap:12px;">
          @forelse($selectedProgramIds as $progId)
            @php
              $selectedDivId = $programToDivisiMap[$progId] ?? null;
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
                  <option value="{{ $pItem['id'] }}" {{ $pItem['id'] == $progId ? 'selected' : '' }}>
                    {{ $pItem['nama'] }}
                  </option>
                @endforeach
              </select>
              <button type="button" class="btn-remove-program" title="Hapus">
                <i class="fas fa-times"></i>
              </button>
            </div>
          @empty
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
          @endforelse
        </div>
        <small class="text-muted" style="display:block; margin-top:6px; font-size:0.78rem;">
          <i class="fas fa-info-circle text-danger me-1"></i> Peserta dapat memilih lebih dari satu program. Klik tombol <strong>+ Tambah Program Lain</strong> untuk menambah baris.
        </small>
      </div>

      <div class="form-group">
        <label>Special Request</label>
        <textarea name="special_request" id="special_request">{{ old('special_request', $admission->special_request) }}</textarea>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Nominal Pembayaran (Rp)</label>
          <input
            type="text"
            name="nominal_pembayaran"
            value="{{ old('nominal_pembayaran', number_format($admission->nominal_pembayaran ?? 250000, 0, ',', '.')) }}"
            placeholder="Contoh: 250.000"
            oninput="let v = this.value.replace(/[^0-9]/g, ''); if(v) this.value = new Intl.NumberFormat('id-ID').format(v);"
          >
          <small>Nominal biaya pendaftaran yang dibayarkan</small>
        </div>
        <div class="form-group">
          <label>Metode Pembayaran</label>
          <select name="metode_pembayaran" class="form-control">
            <optgroup label="-- Pelunasan Penuh --">
              <option value="Transfer Bank (BCA / Mandiri / BNI / BRI)" {{ old('metode_pembayaran', $admission->metode_pembayaran) === 'Transfer Bank (BCA / Mandiri / BNI / BRI)' ? 'selected' : '' }}>Transfer Bank (BCA / Mandiri / BNI / BRI)</option>
              <option value="QRIS / E-Wallet" {{ old('metode_pembayaran', $admission->metode_pembayaran) === 'QRIS / E-Wallet' ? 'selected' : '' }}>QRIS / E-Wallet</option>
              <option value="Tunai (Cash)" {{ old('metode_pembayaran', $admission->metode_pembayaran) === 'Tunai (Cash)' ? 'selected' : '' }}>Tunai di Kampus Denpasar Institute</option>
            </optgroup>
            <optgroup label="-- Pembayaran DP / Uang Muka --">
              <option value="DP (Uang Muka) - Transfer Bank" {{ old('metode_pembayaran', $admission->metode_pembayaran) === 'DP (Uang Muka) - Transfer Bank' ? 'selected' : '' }}>DP (Uang Muka) - Transfer Bank</option>
              <option value="DP (Uang Muka) - QRIS / E-Wallet" {{ old('metode_pembayaran', $admission->metode_pembayaran) === 'DP (Uang Muka) - QRIS / E-Wallet' ? 'selected' : '' }}>DP (Uang Muka) - QRIS / E-Wallet</option>
              <option value="DP (Uang Muka) - Tunai di Kampus" {{ old('metode_pembayaran', $admission->metode_pembayaran) === 'DP (Uang Muka) - Tunai di Kampus' ? 'selected' : '' }}>DP (Uang Muka) - Tunai di Kampus</option>
            </optgroup>
          </select>
          <small>Metode yang digunakan peserta (tersedia opsi Lunas atau DP)</small>
        </div>
      </div>

      @php
        $existingBukti = $admission->bukti_bayar_pendaftaran ?? $admission->bukti_bayar_program;
      @endphp
      <div class="form-group">
        <label>Upload Bukti Pembayaran / Transfer (jika ada)</label>
        @if($existingBukti)
          <div style="margin-bottom: 8px;">
            <a href="{{ asset('storage/' . $existingBukti) }}" target="_blank" class="btn btn-sm btn-outline-primary" style="padding: 4px 10px; font-size: 0.8rem; border-radius: 4px; display: inline-flex; align-items: center; gap: 6px;">
              <i class="fas fa-file-invoice-dollar"></i> Lihat Bukti Pembayaran Saat Ini
            </a>
          </div>
        @endif
        <input type="file" name="bukti_bayar_pendaftaran" accept="image/jpeg,image/jpg,image/png,application/pdf">
        <small class="text-muted">Maks. 2MB (Format: JPG, JPEG, PNG, PDF). Kosongkan jika tidak ingin mengubah file bukti pembayaran.</small>
      </div>

      <div class="form-group">
        <label>Informasi tentang Denpasar Institute diperoleh dari</label>
        <div class="form-check-wrap form-check-grid">
          @php
            $rawSumber = $admission->sumber_informasi;
            if (is_string($rawSumber)) {
                $decoded = json_decode($rawSumber, true);
                $rawSumber = is_array($decoded) ? $decoded : [$rawSumber];
            }
            $sumberList = is_array($rawSumber)
              ? $rawSumber
              : ($rawSumber instanceof \Illuminate\Support\Collection ? $rawSumber->toArray() : (array)($rawSumber ?? []));
          @endphp
          @foreach(['Keluarga','Teman','Lembaga Tempat Belajar atau Kerja','Media Sosial','Situs Denpasar Institute','Pameran Pendidikan','Lainnya'] as $sumber)
          <div class="form-check-line">
            <input type="checkbox" name="sumber_informasi[]" value="{{ $sumber }}" id="sumber{{ Str::slug($sumber) }}"
              {{ in_array($sumber, $sumberList) ? 'checked' : '' }}>
            <label for="sumber{{ Str::slug($sumber) }}">{{ $sumber }}</label>
          </div>
          @endforeach
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="{{ route('backoffice.admission.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>

@endsection

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