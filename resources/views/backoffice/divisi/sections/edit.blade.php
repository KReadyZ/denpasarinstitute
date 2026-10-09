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
                    <label for="image">Gambar Section (Opsional)</label>
                    @if($section->image)
                        <div style="margin-bottom: 8px;">
                            <img src="{{ asset('storage/' . $section->image) }}" style="width: 150px; height: auto; border-radius: 4px;">
                            <p style="font-size: 0.85rem; color: #666; margin-top: 4px;">Gambar saat ini</p>
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    <small style="display:block; color:#666; margin-top: 6px;">Maks: 2MB (JPG, PNG, GIF)</small>
                    @error('image') <small style="color:red;">{{ $message }}</small> @enderror
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
</script>
@endpush

@endsection