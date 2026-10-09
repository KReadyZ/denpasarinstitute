@extends('backoffice.layouts.app')

@section('title', 'Edit Admission')
@section('page-title', 'Edit Data Pendaftaran')

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

      <div class="form-group">
        <label>Daftar Program</label>
        <div class="form-check-wrap">
          @foreach($programs as $program)
          <div class="form-check-line">
            <input type="checkbox" name="program_ids[]" value="{{ $program->id }}" id="program{{ $program->id }}"
              {{ $admission->programs->contains($program->id) ? 'checked' : '' }}>
            <label for="program{{ $program->id }}">{{ $program->nama }}</label>
          </div>
          @endforeach
        </div>
      </div>

      <div class="form-group">
        <label>Special Request</label>
        <textarea name="special_request" id="special_request">{{ old('special_request', $admission->special_request) }}</textarea>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Upload Bukti Biaya Pendaftaran (jika ada)</label>
          @if($admission->bukti_bayar_pendaftaran)
            <div><a href="{{ asset('storage/' . $admission->bukti_bayar_pendaftaran) }}" target="_blank">Lihat file saat ini</a></div>
          @endif
          <input type="file" name="bukti_bayar_pendaftaran">
          <small>Max 2MB, kosongkan jika tidak ingin mengubah</small>
        </div>
        <div class="form-group">
          <label>Upload Bukti Biaya Program (jika ada)</label>
          @if($admission->bukti_bayar_program)
            <div><a href="{{ asset('storage/' . $admission->bukti_bayar_program) }}" target="_blank">Lihat file saat ini</a></div>
          @endif
          <input type="file" name="bukti_bayar_program">
          <small>Max 2MB, kosongkan jika tidak ingin mengubah</small>
        </div>
      </div>

      <div class="form-group">
        <label>Informasi tentang Denpasar Institute diperoleh dari</label>
        <div class="form-check-wrap">
          @foreach(['Keluarga','Teman','Lembaga Tempat Belajar atau Kerja','Media Sosial','Situs Denpasar Institute','Pameran Pendidikan','Lainnya'] as $sumber)
          <div class="form-check-line">
            <input type="checkbox" name="sumber_informasi[]" value="{{ $sumber }}" id="sumber{{ Str::slug($sumber) }}"
              {{ in_array($sumber, $admission->sumber_informasi ?? []) ? 'checked' : '' }}>
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
  });
</script>
@endpush