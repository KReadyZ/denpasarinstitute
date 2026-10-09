@extends('backoffice.layouts.app')

@section('title', 'Tambah Admission')
@section('page-title', 'Tambah Data Pendaftaran')

@section('content')

<div class="card">
  <div class="card-header">
    <h3>Form Pendaftaran</h3>
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

      <div class="form-group">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
          <label style="margin:0;">Daftar Program</label>
          <button type="button" class="btn btn-info" id="btnAddProgram">
            <i class="fas fa-plus"></i> Tambah Program
          </button>
        </div>
        <div id="programContainer">
          <div class="program-item">
            <select name="program_ids[]" class="form-control" required>
              <option value="">Pilih Program</option>
              @foreach($programs as $program)
              <option value="{{ $program->id }}">{{ $program->nama }}</option>
              @endforeach
            </select>
            <button type="button" class="btn-remove-program" style="display:none;" title="Hapus">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Special Request</label>
        <textarea name="special_request" id="special_request">{{ old('special_request') }}</textarea>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Upload Bukti Biaya Pendaftaran (jika ada)</label>
          <input type="file" name="bukti_bayar_pendaftaran">
          <small>Max 2MB</small>
        </div>
        <div class="form-group">
          <label>Upload Bukti Biaya Program (jika ada)</label>
          <input type="file" name="bukti_bayar_program">
          <small>Max 2MB</small>
        </div>
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

    // Dynamic Program Selection
    const container = document.getElementById('programContainer');
    const btnAdd = document.getElementById('btnAddProgram');
    const programsData = {!! json_encode($programs) !!};

    function updateRemoveButtons() {
      const items = container.querySelectorAll('.program-item');
      items.forEach((item, idx) => {
        const btn = item.querySelector('.btn-remove-program');
        if (items.length > 1) {
          btn.style.display = 'flex';
        } else {
          btn.style.display = 'none';
        }
      });
    }

    function createProgramItem() {
      const div = document.createElement('div');
      div.className = 'program-item';
      
      const select = document.createElement('select');
      select.name = 'program_ids[]';
      select.className = 'form-control';
      select.required = true;
      select.innerHTML = '<option value="">-- Pilih Program --</option>';
      
      programsData.forEach(prog => {
        const option = document.createElement('option');
        option.value = prog.id;
        option.textContent = prog.nama;
        select.appendChild(option);
      });

      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'btn-remove-program';
      btn.title = 'Hapus';
      btn.innerHTML = '<i class="fas fa-times"></i>';
      btn.onclick = function(e) {
        e.preventDefault();
        div.remove();
        updateRemoveButtons();
      };

      div.appendChild(select);
      div.appendChild(btn);
      return div;
    }

    btnAdd.addEventListener('click', function(e) {
      e.preventDefault();
      container.appendChild(createProgramItem());
      updateRemoveButtons();
    });

    updateRemoveButtons();

    document.querySelectorAll('.btn-remove-program').forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        this.closest('.program-item').remove();
        updateRemoveButtons();
      });
    });
  });
</script>
@endpush