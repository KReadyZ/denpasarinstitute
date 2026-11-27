@extends('backoffice.layouts.app')

@section('title', 'Edit Section - ' . $divisi->nama)
@section('page-title', 'Edit Section: ' . $section->section_name)

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Form Edit Section</h3>
        <small style="color: #666;">Divisi: <strong>{{ $divisi->nama }}</strong></small>
    </div>
    <div class="card-body">
        
        <form action="{{ route('backoffice.sections.update', [$divisi->id, $section->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="section_name">Nama Section <span style="color:red;">*</span></label>
                <input type="text" name="section_name" id="section_name" class="form-control" 
                       value="{{ old('section_name', $section->section_name) }}" required>
                @error('section_name') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="design_style">Gaya Design <span style="color:red;">*</span></label>
                    <select name="design_style" id="design_style" class="form-control" required>
                        @foreach($designOptions as $key => $label)
                            <option value="{{ $key }}" {{ old('design_style', $section->design_style) === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('design_style') <small style="color:red;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="position_after">Posisi Section <span style="color:red;">*</span></label>
                    <select name="position_after" id="position_after" class="form-control" required>
                        @foreach($positionOptions as $key => $label)
                            <option value="{{ $key }}" {{ old('position_after', $section->position_after) === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('position_after') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="urutan">Urutan Tampil</label>
                    <input type="number" name="urutan" id="urutan" class="form-control" 
                           value="{{ old('urutan', $section->urutan) }}" min="0">
                </div>

                <div class="form-group">
                    <label for="image">Foto Utama Section</label>
                    @if($section->image)
                        <div style="margin-bottom: 8px;">
                            <img src="{{ asset('storage/' . $section->image) }}" style="width: 150px; height: auto; border-radius: 4px; border: 1px solid #ddd;">
                            <p style="font-size: 0.85rem; color: #666; margin-top: 4px;">Foto utama saat ini</p>
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    <small style="display:block; color:#666; margin-top: 6px;">Maks: 10MB (JPG, PNG, WEBP, GIF)</small>
                    @error('image') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- MULTI-IMAGE UPLOAD KHUSUS SLIDER (BANYAK FOTO) --}}
            <div class="card mt-3 mb-4" style="background: #fff8f8; border: 1.5px dashed #CC0000; border-radius: 8px; box-shadow: none;">
                <div class="card-body" style="padding: 20px;">
                    <h4 style="margin: 0 0 6px; color: #CC0000; font-size: 1.05rem; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-images"></i> Galeri Foto Slider Keunggulan (Bisa Masukkan Banyak Foto)
                    </h4>
                    <p style="font-size: 0.86rem; color: #555; margin-bottom: 14px;">
                        Foto-foto ini akan berputar otomatis secara bergantian pada slider Keunggulan Divisi di website. Anda dapat mengunggah banyak foto sekaligus.
                    </p>

                    @php
                        $sliderPhotos = is_array($section->slider_images) ? $section->slider_images : [];
                    @endphp

                    @if(count($sliderPhotos) > 0)
                        <label style="font-weight: 600; font-size: 0.88rem; margin-bottom: 8px; display: block; color: #333;">
                            Foto Slider Tersimpan ({{ count($sliderPhotos) }} foto):
                        </label>
                        <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">
                            @foreach($sliderPhotos as $sImg)
                                <div class="slider-img-item" id="slide-box-{{ md5($sImg) }}" style="position: relative; width: 130px; height: 95px; border-radius: 6px; overflow: hidden; border: 1.5px solid #e2e8f0; background: #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.06);">
                                    <img src="{{ asset('storage/' . $sImg) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    <button type="button" 
                                            onclick="deleteSliderPhoto('{{ $divisi->id }}', '{{ $section->id }}', '{{ $sImg }}', 'slide-box-{{ md5($sImg) }}')"
                                            style="position: absolute; top: 4px; right: 4px; background: rgba(220,53,69,0.95); color: #fff; border: none; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.72rem; transition: transform 0.15s;" 
                                            onmouseover="this.style.transform='scale(1.15)'"
                                            onmouseout="this.style.transform='scale(1)'"
                                            title="Hapus foto ini dari slider">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="font-size: 0.85rem; color: #777; margin-bottom: 14px; font-style: italic; background: #fff; padding: 10px 14px; border-radius: 6px; border: 1px solid #eee;">
                            <i class="fas fa-info-circle text-info"></i> Belum ada foto galeri tambahan yang diunggah. Saat ini slider menampilkan foto utama, background divisi, dan banner pilar. Silakan unggah foto kegiatan/dokumentasi divisi di bawah ini.
                        </div>
                    @endif

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="slider_images" style="font-weight: 600; font-size: 0.9rem; color: #111;">
                            <i class="fas fa-plus-circle text-danger"></i> Tambah Foto Slider Baru (Bisa Pilih Banyak Foto Sekaligus)
                        </label>
                        <input type="file" name="slider_images[]" id="slider_images" class="form-control" accept="image/*" multiple style="background: #fff;">
                        <small style="color: #666; display: block; margin-top: 6px; line-height: 1.5;">
                            <i class="fas fa-keyboard"></i> Tips: Tekan & tahan tombol <strong>Ctrl</strong> (atau <strong>Cmd</strong> di Mac) saat memilih file untuk memilih lebih dari 1 foto sekaligus. Format: JPG, PNG, WEBP (Maks: 10MB per foto).
                        </small>
                        @error('slider_images.*') <small style="color:red; display:block;">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="content">Konten Section <span style="color:red;">*</span></label>
                <textarea name="content" id="content" class="form-control summernote-editor" required>{!! old('content', $section->content) !!}</textarea>
                @error('content') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group" style="display: flex; align-items: center; padding-top: 12px;">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $section->is_active) ? 'checked' : '' }}>
                <label for="is_active" style="margin-left: 8px; font-weight: normal; cursor: pointer;">
                    Aktifkan Section (Tampil di website)
                </label>
            </div>

            <div class="form-group" style="margin-top: 24px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Section</button>
                <a href="{{ route('backoffice.sections.index', $divisi->id) }}" class="btn btn-secondary">Kembali</a>
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
$(document).ready(function() {
    $('.summernote-editor').summernote({
        height: 300,
        minHeight: 200,
        maxHeight: 500,
        focus: false,
        placeholder: 'Masukkan konten section...',
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
        ],
        fontNames: ['Arial', 'Arial Black', 'Courier New', 'Georgia', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Trebuchet MS', 'Verdana', 'Poppins'],
        fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '22', '24', '28', '32', '36', '48'],
        callbacks: {
            onInit: function() {
                console.log('Summernote initialized');
            }
        }
    });
});

function deleteSliderPhoto(divisiId, sectionId, imagePath, elementId) {
    if (!confirm('Hapus foto ini dari galeri slider?')) return;

    fetch(`/backoffice/divisi/${divisiId}/sections/${sectionId}/slider-image`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ image_path: imagePath })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const el = document.getElementById(elementId);
            if (el) {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 250);
            }
        } else {
            alert(data.message || 'Gagal menghapus foto.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan saat menghapus foto slider.');
    });
}
</script>
@endpush

@endsection