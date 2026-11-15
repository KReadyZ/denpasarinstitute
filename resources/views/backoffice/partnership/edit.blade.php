@extends('backoffice.layouts.app')

@section('title', 'Edit Pilar Kemitraan')

@section('content')
<div class="container-fluid" style="padding:24px;max-width:1100px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <a href="{{ route('backoffice.partnership-pillar.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div>
                <h4 style="margin:0;font-weight:700;">Edit Pilar Kemitraan: {{ $pillar->title }}</h4>
                <small class="text-muted">ID: {{ $pillar->id }} &bull; Slug: <code>{{ $pillar->slug }}</code></small>
            </div>
        </div>
        <div>
            @if($pillar->slug)
                <a href="{{ url('/partner-with-di/' . $pillar->slug) }}" target="_blank" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-external-link-alt"></i> Pratinjau Halaman Detail
                </a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> Ada beberapa kesalahan input. Mohon periksa kembali isian form Anda.
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('backoffice.partnership-pillar.update', $pillar->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nav Tabs --}}
        <ul class="nav nav-tabs mb-4" id="pillarTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active font-weight-bold" id="card-tab" data-bs-toggle="tab" data-bs-target="#tab-card" type="button" role="tab">
                    <i class="fas fa-id-card me-1 text-danger"></i> 1. Kartu Utama
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link font-weight-bold" id="detail-tab" data-bs-toggle="tab" data-bs-target="#tab-detail" type="button" role="tab">
                    <i class="fas fa-image me-1 text-danger"></i> 2. Foto &amp; Halaman Detail
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link font-weight-bold" id="services-tab" data-bs-toggle="tab" data-bs-target="#tab-services" type="button" role="tab">
                    <i class="fas fa-list-check me-1 text-danger"></i> 3. Poin Layanan ({{ count($pillar->services ?? []) }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link font-weight-bold" id="highlights-tab" data-bs-toggle="tab" data-bs-target="#tab-highlights" type="button" role="tab">
                    <i class="fas fa-award me-1 text-danger"></i> 4. Keunggulan ({{ count($pillar->highlights ?? []) }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link font-weight-bold" id="cta-tab" data-bs-toggle="tab" data-bs-target="#tab-cta" type="button" role="tab">
                    <i class="fas fa-bullhorn me-1 text-danger"></i> 5. Call to Action (CTA)
                </button>
            </li>
        </ul>

        <div class="tab-content" id="pillarTabContent">

            {{-- TAB 1: KARTU UTAMA --}}
            <div class="tab-pane fade show active" id="tab-card" role="tabpanel">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-dark"><i class="fas fa-th-large text-danger me-2"></i>Pengaturan Kartu di Halaman Kemitraan</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label class="form-label font-weight-bold">Nomor <span class="text-danger">*</span></label>
                                <input type="text" name="number" class="form-control" value="{{ old('number', $pillar->number) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Judul Pilar <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $pillar->title) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold">Slug URL (URL Friendly)</label>
                                <input type="text" name="slug" class="form-control font-monospace" value="{{ old('slug', $pillar->slug) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Label Tag Pita <span class="text-danger">*</span></label>
                                <input type="text" name="tag" class="form-control" value="{{ old('tag', $pillar->tag) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Ikon FontAwesome (Contoh: fa-microscope)</label>
                                <input type="text" name="icon" class="form-control" value="{{ old('icon', $pillar->icon) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Deskripsi Singkat Kartu <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="3" required>{{ old('description', $pillar->description) }}</textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Ganti Foto Kartu Utama</label>
                                <input type="file" name="image_file" class="form-control" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, WebP (Maks: 3MB). Biarkan kosong jika tidak diganti.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Atau Path File Kartu</label>
                                <input type="text" name="image" class="form-control font-monospace" value="{{ old('image', $pillar->image) }}">
                                @if($pillar->image)
                                    <div class="mt-2">
                                        <small class="text-muted">Pratinjau Foto Kartu:</small><br>
                                        <img src="{{ asset($pillar->image) }}" alt="Card Preview" style="height:70px;border-radius:6px;border:1px solid #ddd;object-fit:cover;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label font-weight-bold">Link URL Tujuan (Learn more)</label>
                                <input type="text" name="link_url" class="form-control font-monospace" value="{{ old('link_url', $pillar->link_url) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold">Teks Tombol</label>
                                <input type="text" name="link_text" class="form-control" value="{{ old('link_text', $pillar->link_text ?? 'Learn more') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold">Urutan Tampil <span class="text-danger">*</span></label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', $pillar->order) }}" required>
                            </div>
                            <div class="col-md-8 d-flex align-items-center">
                                <div class="form-check mt-4">
                                    <input type="checkbox" name="is_active" class="form-check-input" id="isActiveCheck" value="1" {{ old('is_active', $pillar->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label font-weight-bold" for="isActiveCheck">
                                        Aktifkan Pilar (Tampilkan di halaman Kemitraan)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 2: FOTO & HALAMAN DETAIL --}}
            <div class="tab-pane fade" id="tab-detail" role="tabpanel">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-dark"><i class="fas fa-desktop text-danger me-2"></i>Pengaturan Header &amp; Showcase Halaman Detail</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Subtitle / Tagline Pilar</label>
                                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $pillar->subtitle) }}" placeholder="Contoh: Research, Innovation & Consulting">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Badge Hero</label>
                                <input type="text" name="badge" class="form-control" value="{{ old('badge', $pillar->badge) }}" placeholder="Contoh: Kemitraan • Research & Innovation">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Judul Besar Hero (Mendukung HTML &lt;span&gt;)</label>
                            <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $pillar->hero_title) }}" placeholder="Contoh: Research, Innovation &amp; &lt;span&gt;Consulting&lt;/span&gt;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Deskripsi Pengantar Hero</label>
                            <textarea name="hero_sub" class="form-control" rows="3">{{ old('hero_sub', $pillar->hero_sub) }}</textarea>
                        </div>

                        <hr class="my-4">

                        <h6 class="font-weight-bold text-danger mb-3"><i class="fas fa-camera me-1"></i>Foto Showcase &amp; Badge Kolom Kiri Halaman Detail</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Unggah Foto Showcase Baru (AI / Asli)</label>
                                <input type="file" name="detail_image_file" class="form-control" accept="image/*">
                                <small class="text-muted">Rekomendasi orientasi portrait (3:4, min. 768x1024px). Format: JPG, PNG, WebP.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Atau Path File Foto Detail</label>
                                <input type="text" name="detail_image" class="form-control font-monospace" value="{{ old('detail_image', $pillar->detail_image) }}">
                                @if($pillar->detail_image)
                                    <div class="mt-2">
                                        <small class="text-muted">Pratinjau Foto Detail Saat Ini:</small><br>
                                        <img src="{{ asset($pillar->detail_image) }}" alt="Detail Image Preview" style="height:110px;border-radius:8px;border:2px solid #fee2e2;object-fit:cover;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Judul Tag Foto (Kotak Putih Bawah Foto)</label>
                                <input type="text" name="image_tag" class="form-control" value="{{ old('image_tag', $pillar->image_tag) }}" placeholder="Contoh: Pemberdayaan Berkelanjutan">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Subtitle Tag Foto</label>
                                <input type="text" name="image_sub" class="form-control" value="{{ old('image_sub', $pillar->image_sub) }}" placeholder="Contoh: Dampak sosial nyata berbasis kearifan lokal nusantara">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Teks Pengantar Ruang Lingkup Layanan</label>
                            <textarea name="intro" class="form-control" rows="2">{{ old('intro', $pillar->intro) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 3: 8 POIN LAYANAN --}}
            <div class="tab-pane fade" id="tab-services" role="tabpanel">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark"><i class="fas fa-list-ul text-danger me-2"></i>8 Poin Layanan &amp; Ruang Lingkup Kolaborasi</h5>
                            <small class="text-muted">Poin-poin ini tampil di kolom kanan halaman detail.</small>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @php
                            $services = old('services', $pillar->services ?? []);
                            // Pastikan minimal ada 8 slot
                            while(count($services) < 8) {
                                $services[] = ['icon' => 'fa-check', 'title' => '', 'desc' => ''];
                            }
                        @endphp

                        <div class="row g-3">
                            @foreach($services as $idx => $svc)
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-3 bg-light" style="position:relative;">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="badge bg-danger">Poin #{{ $idx + 1 }}</span>
                                            <div style="width:160px;">
                                                <input type="text" name="services[{{ $idx }}][icon]" class="form-control form-control-sm font-monospace" value="{{ $svc['icon'] ?? 'fa-check' }}" placeholder="Ikon fa-...">
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" name="services[{{ $idx }}][title]" class="form-control form-control-sm font-weight-bold" value="{{ $svc['title'] ?? '' }}" placeholder="Judul Layanan">
                                        </div>
                                        <div>
                                            <textarea name="services[{{ $idx }}][desc]" class="form-control form-control-sm" rows="2" placeholder="Deskripsi layanan atau ruang lingkup...">{{ $svc['desc'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 4: 3 KEUNGGULAN (HIGHLIGHTS) --}}
            <div class="tab-pane fade" id="tab-highlights" role="tabpanel">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-dark"><i class="fas fa-star text-danger me-2"></i>3 Poin Keunggulan (Highlights)</h5>
                        <small class="text-muted">Tampil di 3 kartu keunggulan pada bagian bawah halaman detail.</small>
                    </div>
                    <div class="card-body p-4">
                        @php
                            $highlights = old('highlights', $pillar->highlights ?? []);
                            while(count($highlights) < 3) {
                                $highlights[] = ['icon' => 'fa-award', 'title' => '', 'desc' => ''];
                            }
                        @endphp

                        <div class="row g-3">
                            @foreach($highlights as $hIdx => $hl)
                                <div class="col-md-4">
                                    <div class="p-3 border rounded-3 bg-light">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="badge bg-dark">Keunggulan #{{ $hIdx + 1 }}</span>
                                            <div style="width:130px;">
                                                <input type="text" name="highlights[{{ $hIdx }}][icon]" class="form-control form-control-sm font-monospace" value="{{ $hl['icon'] ?? 'fa-award' }}" placeholder="Ikon">
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" name="highlights[{{ $hIdx }}][title]" class="form-control form-control-sm font-weight-bold" value="{{ $hl['title'] ?? '' }}" placeholder="Judul Keunggulan">
                                        </div>
                                        <div>
                                            <textarea name="highlights[{{ $hIdx }}][desc]" class="form-control form-control-sm" rows="3" placeholder="Penjelasan keunggulan...">{{ $hl['desc'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 5: CALL TO ACTION (CTA) --}}
            <div class="tab-pane fade" id="tab-cta" role="tabpanel">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-dark"><i class="fas fa-bullhorn text-danger me-2"></i>Banner Aksi / Call to Action (CTA) Bawah</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Judul Ajakan CTA</label>
                            <input type="text" name="cta_title" class="form-control" value="{{ old('cta_title', $pillar->cta_title) }}" placeholder="Contoh: Tertarik Berkolaborasi dalam Riset & Inovasi?">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Deskripsi Ajakan CTA</label>
                            <textarea name="cta_sub" class="form-control" rows="3">{{ old('cta_sub', $pillar->cta_sub) }}</textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label font-weight-bold">Template Pesan WhatsApp</label>
                                <input type="text" name="wa_text" class="form-control" value="{{ old('wa_text', $pillar->wa_text) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold">Label Tombol</label>
                                <input type="text" name="wa_btn" class="form-control" value="{{ old('wa_btn', $pillar->wa_btn ?? 'Form Kemitraan') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Submit Button --}}
        <div class="d-flex justify-content-end gap-2 mb-5">
            <a href="{{ route('backoffice.partnership-pillar.index') }}" class="btn btn-secondary px-4">
                Batal
            </a>
            <button type="submit" class="btn btn-danger px-4 font-weight-bold">
                <i class="fas fa-save me-1"></i> Simpan Semua Perubahan
            </button>
        </div>

    </form>
</div>
@endsection
