@extends('backoffice.layouts.app')

@section('title', 'Tambah Testimoni')
@section('page-title', 'Tambah Testimoni')

@section('content')
<div class="card" style="max-width:700px;">
    <div class="card-header">
        <h3><i class="fas fa-plus-circle" style="color:#CC0000;"></i> Tambah Testimoni</h3>
        <a href="{{ route('backoffice.testimonial.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('backoffice.testimonial.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label>Nama <span style="color:#CC0000;">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                    @error('name')<small style="color:#CC0000;">{{ $message }}</small>@enderror
                </div>
                <div class="form-group">
                    <label>Role / Jabatan</label>
                    <input type="text" name="role" value="{{ old('role') }}" placeholder="cth: Direktur HR">
                    @error('role')<small style="color:#CC0000;">{{ $message }}</small>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tag</label>
                    <input type="text" name="tag" value="{{ old('tag') }}" placeholder="cth: Konsultan">
                    @error('tag')<small style="color:#CC0000;">{{ $message }}</small>@enderror
                </div>
                <div class="form-group">
                    <label>Rating <span style="color:#CC0000;">*</span></label>
                    <select name="rating" required>
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ old('rating', 5) == $i ? 'selected' : '' }}>
                                {{ $i }} Bintang
                            </option>
                        @endfor
                    </select>
                    @error('rating')<small style="color:#CC0000;">{{ $message }}</small>@enderror
                </div>
            </div>

            <div class="form-group">
                <label>Kutipan / Testimoni <span style="color:#CC0000;">*</span></label>
                <textarea name="quote" rows="4" required placeholder="Tuliskan testimoni...">{{ old('quote') }}</textarea>
                @error('quote')<small style="color:#CC0000;">{{ $message }}</small>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Avatar / Foto</label>
                    <input type="file" name="avatar" accept="image/*" onchange="previewAvatar(this)">
                    @error('avatar')<small style="color:#CC0000;">{{ $message }}</small>@enderror
                    <div id="avatar-preview" style="margin-top:8px;display:none;">
                        <img id="preview-img" src="" style="width:60px;height:60px;border-radius:50%;object-fit:cover;border:2px solid #e5e7eb;">
                    </div>
                </div>
                <div class="form-group">
                    <label>Urutan Tampil</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}" min="0">
                    @error('order')<small style="color:#CC0000;">{{ $message }}</small>@enderror
                </div>
            </div>

            <div class="form-group">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input type="checkbox" name="is_approved" value="1" {{ old('is_approved') ? 'checked' : '' }}
                           style="width:auto;">
                    Langsung tampilkan di website
                </label>
            </div>

            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('backoffice.testimonial.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('avatar-preview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection