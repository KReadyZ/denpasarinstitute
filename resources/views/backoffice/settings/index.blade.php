@extends('backoffice.layouts.app')

@section('title', 'Pengaturan Website & Konten')

@section('content')
<div class="container-fluid" style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <h4 style="margin:0;font-weight:700;">Pengaturan Website, Konten &amp; Footer</h4>
            <small class="text-muted">Ubah informasi kontak, nomor WhatsApp, media sosial, teks sambutan, moto, serta konten kemitraan secara terpusat.</small>
        </div>
    </div>

        @php
            $currentTab = request('tab', 'contact');
        @endphp

        <form action="{{ route('backoffice.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="current_tab" id="current_tab" value="{{ $currentTab }}">

        {{-- Nav Tabs --}}
        <ul class="nav nav-tabs mb-4" id="settingsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $currentTab === 'contact' ? 'active' : '' }} font-weight-bold" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-pane" type="button" role="tab">
                    <i class="fas fa-sliders-h text-danger"></i> Logo, Kontak &amp; Footer
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $currentTab === 'social' ? 'active' : '' }} font-weight-bold" id="social-tab" data-bs-toggle="tab" data-bs-target="#social-pane" type="button" role="tab">
                    <i class="fas fa-share-alt text-danger"></i> Media Sosial
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $currentTab === 'home' ? 'active' : '' }} font-weight-bold" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-pane" type="button" role="tab">
                    <i class="fas fa-home text-danger"></i> Sambutan &amp; Moto Beranda
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $currentTab === 'partner' ? 'active' : '' }} font-weight-bold" id="partner-tab" data-bs-toggle="tab" data-bs-target="#partner-pane" type="button" role="tab">
                    <i class="fas fa-handshake text-danger"></i> Halaman Kemitraan (Partner)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $currentTab === 'admission' ? 'active' : '' }} font-weight-bold" id="admission-tab" data-bs-toggle="tab" data-bs-target="#admission-pane" type="button" role="tab">
                    <i class="fas fa-file-pen text-danger"></i> Editor Form Pendaftaran (Admission)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $currentTab === 'popup' ? 'active' : '' }} font-weight-bold" id="popup-tab" data-bs-toggle="tab" data-bs-target="#popup-pane" type="button" role="tab">
                    <i class="fas fa-bullhorn text-danger"></i> Pop Up Banner Beranda
                </button>
            </li>
        </ul>

        <div class="tab-content" id="settingsTabContent">
            
            {{-- TAB 1: LOGO, KONTAK & FOOTER --}}
            <div class="tab-pane fade {{ $currentTab === 'contact' ? 'show active' : '' }}" id="contact-pane" role="tabpanel">
                {{-- Card: Logo Website --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-image text-danger"></i> Logo Resmi Denpasar Institute (Website &amp; Backoffice)</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row align-items-center g-3">
                            <div class="col-12 col-md-4 text-center">
                                @if(!empty($settings['site_logo']))
                                    <div class="position-relative d-inline-block p-3 border rounded-3 bg-light shadow-sm text-center w-100">
                                        <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo DI" class="img-fluid" style="max-height: 90px; object-fit: contain;">
                                        <div class="mt-2"><span class="badge bg-success">Logo Kustom Aktif</span></div>
                                        <div class="form-check mt-2 text-start small">
                                            <input class="form-check-input" type="checkbox" name="remove_site_logo" value="1" id="removeSiteLogo">
                                            <label class="form-check-label text-danger fw-bold" for="removeSiteLogo">
                                                <i class="fas fa-trash-alt me-1"></i> Hapus &amp; Kembalikan ke Logo Default
                                            </label>
                                        </div>
                                    </div>
                                @else
                                    <div class="p-3 border border-dashed rounded-3 bg-light text-center">
                                        <img src="{{ asset('image/Logo_DI.png') }}" alt="Logo DI Default" class="img-fluid mb-2" style="max-height: 85px; object-fit: contain;">
                                        <div><span class="badge bg-secondary">Logo Bawaan Sistem</span></div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12 col-md-8">
                                <label class="form-label font-weight-bold">Unggah Logo Baru</label>
                                <input type="file" name="site_logo" class="form-control mb-2" accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml">
                                <small class="text-muted d-block">
                                    Format yang didukung: <strong>PNG (disarankan transparan), JPG, WEBP, SVG</strong>. Ukuran maksimal 2 MB.
                                </small>
                                <small class="text-success d-block fw-semibold mt-1">
                                    <i class="fas fa-check-circle me-1"></i> Logo ini otomatis akan tampil pada navbar atas website, sidebar backoffice, favicon browser, dan dokumen resmi sistem.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-map-marker-alt text-danger"></i> Informasi Kontak &amp; Footer</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Alamat Kantor / Institusi</label>
                                <input type="text" name="contact_address" class="form-control" value="{{ $settings['contact_address'] ?? 'Denpasar, Bali - Indonesia' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Email Utama Website</label>
                                <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? 'partner@denpasarinstitute.com' }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">WhatsApp Sekretariat (1)</label>
                                <input type="text" name="contact_phone_1" class="form-control" value="{{ $settings['contact_phone_1'] ?? '+62 821-4481-4593' }}">
                                <small class="text-muted">Tampil pada footer dan widget kontak.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">WhatsApp Sekretariat (2)</label>
                                <input type="text" name="contact_phone_2" class="form-control" value="{{ $settings['contact_phone_2'] ?? '+62 823-1866-6547' }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">WhatsApp Lead Consultant</label>
                                <input type="text" name="contact_wa_lead_consultant" class="form-control" value="{{ $settings['contact_wa_lead_consultant'] ?? '+62 813-3764-4463' }}">
                                <small class="text-muted">Tampil pada pilihan popup floating widget.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Email Kontak Sekretariat</label>
                                <input type="email" name="contact_email_secretary" class="form-control" value="{{ $settings['contact_email_secretary'] ?? 'partner@denpasarinstitute.com' }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label font-weight-bold">Teks Hak Cipta (Footer Copyright)</label>
                                <input type="text" name="footer_copyright" class="form-control" value="{{ $settings['footer_copyright'] ?? 'Denpasar Institute. Hak cipta dilindungi undang-undang.' }}">
                            </div>

                            <div class="col-12 mt-4 pt-3 border-top">
                                <h6 class="font-weight-bold text-danger mb-2"><i class="fas fa-handshake"></i> Bagian Kolaborasi (Section "Mari Berkolaborasi" di Beranda)</h6>
                                <small class="text-muted d-block mb-3">Pengaturan judul, slogan, dan teks ajakan kolaborasi yang tampil di bagian bawah halaman depan (sebelum footer).</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Judul Ajakan Kolaborasi</label>
                                <input type="text" name="contact_collab_title" class="form-control" value="{{ $settings['contact_collab_title'] ?? 'Mari Berkolaborasi' }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Slogan / Motto Kolaborasi</label>
                                <input type="text" name="contact_collab_motto" class="form-control" value="{{ $settings['contact_collab_motto'] ?? '"Transforming Ideas into Action"' }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label font-weight-bold">Deskripsi Ajakan Kolaborasi</label>
                                <textarea name="contact_collab_desc" class="form-control" rows="3">{{ $settings['contact_collab_desc'] ?? 'Kami percaya kemajuan terbaik lahir dari kolaborasi. Bersama Denpasar Institute, kita wujudkan inovasi yang memberi dampak nyata bagi masyarakat dan bangsa.' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 2: MEDIA SOSIAL --}}
            <div class="tab-pane fade {{ $currentTab === 'social' ? 'show active' : '' }}" id="social-pane" role="tabpanel">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-share-alt text-danger"></i> Tautan Media Sosial (Footer)</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold"><i class="fab fa-facebook text-primary"></i> Link Facebook</label>
                                <input type="text" name="social_facebook" class="form-control" placeholder="https://facebook.com/..." value="{{ $settings['social_facebook'] ?? '#' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold"><i class="fab fa-instagram text-danger"></i> Link Instagram</label>
                                <input type="text" name="social_instagram" class="form-control" placeholder="https://instagram.com/..." value="{{ $settings['social_instagram'] ?? '#' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold"><i class="fab fa-youtube text-danger"></i> Link YouTube</label>
                                <input type="text" name="social_youtube" class="form-control" placeholder="https://youtube.com/..." value="{{ $settings['social_youtube'] ?? '#' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold"><i class="fab fa-linkedin text-info"></i> Link LinkedIn</label>
                                <input type="text" name="social_linkedin" class="form-control" placeholder="https://linkedin.com/..." value="{{ $settings['social_linkedin'] ?? '#' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 3: SAMBUTAN & MOTO BERANDA --}}
            <div class="tab-pane fade {{ $currentTab === 'home' ? 'show active' : '' }}" id="home-pane" role="tabpanel">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-quote-left text-danger"></i> Sambutan &amp; Moto Teks Berjalan</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            {{-- Foto Pak Laba --}}
                            <div class="col-12 mb-2 pb-3 border-bottom">
                                <label class="form-label font-weight-bold">
                                    <i class="fas fa-user-tie text-danger me-1"></i> Foto Pimpinan / Lead Consultant (Prof. Dr. I Nengah Laba)
                                </label>
                                <div class="row align-items-center g-3">
                                    <div class="col-12 col-md-3 text-center">
                                        @if(!empty($settings['sambutan_leader_photo']))
                                            <div class="position-relative d-inline-block p-2 border rounded-3 bg-light shadow-sm text-center w-100">
                                                <img src="{{ asset('storage/' . $settings['sambutan_leader_photo']) }}" alt="Foto Pak Laba" class="img-fluid rounded" style="max-height: 160px; object-fit: contain;">
                                                <div class="mt-2"><span class="badge bg-success">Foto Kustom Aktif</span></div>
                                                <div class="form-check mt-2 text-start small">
                                                    <input class="form-check-input" type="checkbox" name="remove_sambutan_leader_photo" value="1" id="removeLeaderPhoto">
                                                    <label class="form-check-label text-danger fw-bold" for="removeLeaderPhoto">
                                                        <i class="fas fa-trash-alt me-1"></i> Hapus &amp; Gunakan Foto Default
                                                    </label>
                                                </div>
                                            </div>
                                        @else
                                            <div class="p-2 border border-dashed rounded-3 bg-light text-center">
                                                <img src="{{ asset('image/prof_nengah_laba.png') }}" alt="Foto Default Pak Laba" class="img-fluid rounded mb-2" style="max-height: 150px; object-fit: contain;">
                                                <div><span class="badge bg-secondary">Foto Bawaan Sistem</span></div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <label class="form-label font-weight-bold small">Unggah Foto Pimpinan Baru</label>
                                        <input type="file" name="sambutan_leader_photo" class="form-control mb-2" accept="image/png,image/jpeg,image/jpg,image/webp">
                                        <small class="text-muted d-block">
                                            Format yang didukung: <strong>PNG, JPG, WEBP</strong> (maks. 2 MB). Disarankan menggunakan foto potret vertikal dengan latar belakang rapi/transparan.
                                        </small>
                                        <small class="text-success d-block fw-semibold mt-1">
                                            <i class="fas fa-check-circle me-1"></i> Foto ini otomatis akan tampil pada kotak sambutan utama pimpinan di beranda website.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Nama Pimpinan / Lead Consultant</label>
                                <input type="text" name="sambutan_leader_name" class="form-control" value="{{ $settings['sambutan_leader_name'] ?? 'Prof. Dr. I Nengah Laba' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Label Tag Sambutan</label>
                                <input type="text" name="sambutan_leader_title" class="form-control" value="{{ $settings['sambutan_leader_title'] ?? 'Sambutan' }}" placeholder="Contoh: Sambutan">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label font-weight-bold">Moto (Teks Berjalan Berputar / Infinite Marquee)</label>
                                <input type="text" name="sambutan_motto" class="form-control" value="{{ $settings['sambutan_motto'] ?? 'Transforming Ideas into Action' }}">
                                <small class="text-muted">Teks ini yang berjalan otomatis di kotak moto bawah foto pimpinan.</small>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label font-weight-bold">Judul Sambutan</label>
                                <input type="text" name="sambutan_welcome_title" class="form-control" value="{{ $settings['sambutan_welcome_title'] ?? 'Selamat Datang di Official Website Denpasar Institute' }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label font-weight-bold">Paragraf Sambutan 1</label>
                                <textarea name="sambutan_p1" class="form-control summernote" rows="4">{{ $settings['sambutan_p1'] ?? 'Denpasar Institute merupakan Lembaga Riset & Pengembangan SDM yang berkomitmen mendorong kemajuan ilmu pengetahuan, inovasi, publikasi ilmiah, peningkatan kompetensi, dan pemberdayaan masyarakat.' }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label font-weight-bold">Paragraf Sambutan 2</label>
                                <textarea name="sambutan_p2" class="form-control summernote" rows="4">{{ $settings['sambutan_p2'] ?? 'Melalui kolaborasi nasional dan internasional, kami membangun ekosistem riset, pembelajaran, dan inovasi yang inklusif, profesional, serta berkelanjutan untuk menghasilkan kontribusi nyata bagi masyarakat.' }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label font-weight-bold">Paragraf Sambutan 3 (Bagian "Read More")</label>
                                <textarea name="sambutan_p3" class="form-control summernote" rows="4">{{ $settings['sambutan_p3'] ?? 'Kami membuka peluang kerja sama dengan akademisi, peneliti, pendidik, praktisi, pemerintah, dunia usaha, dan berbagai pemangku kepentingan dalam mengembangkan potensi dan meningkatkan daya saing sumber daya manusia.' }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label font-weight-bold">Paragraf Sambutan 4 (Bagian "Read More")</label>
                                <textarea name="sambutan_p4" class="form-control summernote" rows="3">{{ $settings['sambutan_p4'] ?? 'Kami berharap website ini menjadi sumber informasi dan ruang kolaborasi untuk bersama-sama mewujudkan masa depan yang lebih baik.' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 4: HALAMAN KEMITRAAN (PARTNER) --}}
            <div class="tab-pane fade {{ $currentTab === 'partner' ? 'show active' : '' }}" id="partner-pane" role="tabpanel">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-handshake text-danger"></i> Konten Halaman Kemitraan (Partner with DI)</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Judul Hero Banner Kemitraan</label>
                                <input type="text" name="partner_hero_title" class="form-control" value="{{ $settings['partner_hero_title'] ?? 'Partnership, Community & Global Engagement' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Tagline Sub-Judul Kemitraan</label>
                                <input type="text" name="partner_hero_tagline" class="form-control" value="{{ $settings['partner_hero_tagline'] ?? 'Connecting Knowledge, Research, Industry, and Communities.' }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label font-weight-bold">Deskripsi Pengantar Kemitraan (Hero Description)</label>
                                <textarea name="partner_hero_desc" class="form-control summernote" rows="5">{{ $settings['partner_hero_desc'] ?? 'Partnership, Community & Global Engagement merupakan wadah pengembangan kerja sama dan kolaborasi Denpasar Institute dengan berbagai institusi pendidikan, pemerintah, dunia usaha, industri, dan komunitas di tingkat nasional maupun internasional. Melalui kemitraan strategis, kami mendorong pertukaran pengetahuan, pengembangan riset, inovasi, dan peningkatan kualitas sumber daya manusia.' }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Judul Kotak Ajakan Kerjasama (Bottom CTA)</label>
                                <input type="text" name="partner_cta_title" class="form-control" value="{{ $settings['partner_cta_title'] ?? 'Siap Berkolaborasi Bersama Denpasar Institute?' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Nomor WhatsApp Hotline Kemitraan</label>
                                <input type="text" name="partner_cta_wa_phone" class="form-control" value="{{ $settings['partner_cta_wa_phone'] ?? '6282144814593' }}">
                                <small class="text-muted">Format angka tanpa tanda + atau spasi (contoh: 6282144814593).</small>
                            </div>

                            <div class="col-12">
                                <label class="form-label font-weight-bold">Deskripsi Kotak Ajakan Kerjasama (Bottom CTA)</label>
                                <textarea name="partner_cta_desc" class="form-control summernote" rows="3">{{ $settings['partner_cta_desc'] ?? 'Diskusikan peluang kemitraan strategis, riset bersama, pelatihan institusi, maupun kolaborasi global bersama tim kami.' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 5: FORM PENDAFTARAN (ADMISSION) --}}
            <div class="tab-pane fade {{ $currentTab === 'admission' ? 'show active' : '' }}" id="admission-pane" role="tabpanel">
                {{-- Card 1: Header & Banner Formulir --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-heading text-danger"></i> Header &amp; Petunjuk Formulir Pendaftaran</h5>
                        <a href="{{ route('admission.create') }}" target="_blank" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-external-link-alt"></i> Buka Halaman Formulir
                        </a>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Judul Utama Formulir (Hero Title)</label>
                                <input type="text" name="admission_form_title" class="form-control" value="{{ $settings['admission_form_title'] ?? 'Formulir Pendaftaran' }}">
                                <small class="text-muted">Teks judul besar di bagian atas halaman formulir.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Subjudul Formulir (Hero Subtitle)</label>
                                <input type="text" name="admission_form_subtitle" class="form-control" value="{{ $settings['admission_form_subtitle'] ?? 'Daftar sebagai peserta program Denpasar Institute' }}">
                                <small class="text-muted">Teks pengantar di bawah judul formulir.</small>
                            </div>

                            <div class="col-12">
                                <label class="form-label font-weight-bold">Kotak Petunjuk Formulir (Info Notice)</label>
                                <textarea name="admission_form_notice" class="form-control summernote" rows="3">{{ $settings['admission_form_notice'] ?? '<strong>Petunjuk:</strong> Silakan isi semua kolom yang bertanda <span style="color: #CC0000;">*</span> (wajib diisi). Data Anda akan kami verifikasi sebelum konfirmasi pendaftaran.' }}</textarea>
                                <small class="text-muted">Teks petunjuk yang berada di dalam kotak biru sebelum data pribadi.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Biaya Pendaftaran Standar (Rp)</label>
                                <input type="text" name="admission_default_fee" class="form-control" value="{{ $settings['admission_default_fee'] ?? '250.000' }}">
                                <small class="text-muted">Nominal default biaya pendaftaran peserta baru (contoh: 250.000).</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card: Visibilitas Pilihan Metode Pembayaran di Form --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-sliders-h text-danger"></i> Visibilitas Metode Pembayaran di Form Pendaftaran</h5>
                        <span class="badge badge-info px-2 py-1"><i class="fas fa-eye mr-1"></i> Kontrol Tampilan Publik</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-light border py-2 px-3 small mb-3 text-secondary">
                            <i class="fas fa-info-circle text-primary mr-1"></i>
                            Metode <strong>Transfer Bank BNI (Rekening Resmi)</strong> selalu aktif sebagai metode pembayaran utama. Anda dapat menampilkan atau menyembunyikan pilihan metode lainnya di bawah ini kapan saja:
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold">Opsi QRIS / E-Wallet</label>
                                <select name="admission_show_qris" class="form-control">
                                    <option value="0" {{ ($settings['admission_show_qris'] ?? '0') == '0' ? 'selected' : '' }}>Sembunyikan (Hanya BNI yang Tampil)</option>
                                    <option value="1" {{ ($settings['admission_show_qris'] ?? '0') == '1' ? 'selected' : '' }}>Tampilkan di Form Pendaftaran</option>
                                </select>
                                <small class="text-muted">Menampilkan opsi scan barcode QRIS di form.</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold">Opsi Bayar Tunai di Kampus</label>
                                <select name="admission_show_tunai" class="form-control">
                                    <option value="0" {{ ($settings['admission_show_tunai'] ?? '0') == '0' ? 'selected' : '' }}>Sembunyikan (Hanya BNI yang Tampil)</option>
                                    <option value="1" {{ ($settings['admission_show_tunai'] ?? '0') == '1' ? 'selected' : '' }}>Tampilkan di Form Pendaftaran</option>
                                </select>
                                <small class="text-muted">Menampilkan opsi bayar tunai di loket kampus.</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold">Opsi Pembayaran DP (Uang Muka)</label>
                                <select name="admission_show_dp" class="form-control">
                                    <option value="0" {{ ($settings['admission_show_dp'] ?? '0') == '0' ? 'selected' : '' }}>Sembunyikan (Hanya Bayar Penuh / Lunas)</option>
                                    <option value="1" {{ ($settings['admission_show_dp'] ?? '0') == '1' ? 'selected' : '' }}>Tampilkan di Form Pendaftaran</option>
                                </select>
                                <small class="text-muted">Menampilkan kelompok opsi uang muka / cicilan DP.</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Rekening Bank Resmi Tujuan Transfer --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-building-columns text-danger"></i> Rekening Tujuan Transfer Resmi</h5>
                        <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i> BNI Tampil di Form Pendaftaran</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info py-2 px-3 small mb-3">
                            <i class="fas fa-info-circle mr-1"></i>
                            <strong>Catatan:</strong> Saat ini form pendaftaran publik dikhususkan menampilkan <strong>Bank BNI</strong> sebagai rekening resmi transfer. Anda dapat mengubah nomor rekening dan atas nama BNI di bawah ini kapan saja. Rekening lainnya (BCA, Mandiri, BRI) tetap tersimpan sebagai data rekening alternatif lembaga.
                        </div>

                        <div class="row g-3">
                            {{-- Bank BNI (Utama / Tampil di Form) --}}
                            <div class="col-12 mb-2">
                                <div class="p-3 rounded border border-danger bg-light">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <label class="form-label font-weight-bold text-danger mb-0 fs-6">
                                            <i class="fas fa-star text-warning mr-1"></i> Bank BNI (Rekening Utama Form Pendaftaran)
                                        </label>
                                        <span class="badge badge-danger">Aktif di Publik</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="small text-muted font-weight-bold">Nomor Rekening Bank BNI</label>
                                            <input type="text" name="bank_bni_rek" class="form-control font-monospace font-weight-bold" value="{{ $settings['bank_bni_rek'] ?? '0819192837' }}" placeholder="Contoh: 0819192837">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="small text-muted font-weight-bold">Atas Nama Bank BNI</label>
                                            <input type="text" name="bank_bni_holder" class="form-control font-weight-bold" value="{{ $settings['bank_bni_holder'] ?? 'Yayasan Denpasar Institute' }}" placeholder="Contoh: Yayasan Denpasar Institute">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Bank BCA --}}
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-primary">Nomor Rekening Bank BCA <small class="text-muted">(Alternatif)</small></label>
                                <input type="text" name="bank_bca_rek" class="form-control font-monospace" value="{{ $settings['bank_bca_rek'] ?? '7720918899' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-primary">Atas Nama Bank BCA</label>
                                <input type="text" name="bank_bca_holder" class="form-control" value="{{ $settings['bank_bca_holder'] ?? 'Denpasar Institute' }}">
                            </div>

                            {{-- Bank Mandiri --}}
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold" style="color:#b45309;">Nomor Rekening Bank Mandiri <small class="text-muted">(Alternatif)</small></label>
                                <input type="text" name="bank_mandiri_rek" class="form-control font-monospace" value="{{ $settings['bank_mandiri_rek'] ?? '1450018293812' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold" style="color:#b45309;">Atas Nama Bank Mandiri</label>
                                <input type="text" name="bank_mandiri_holder" class="form-control" value="{{ $settings['bank_mandiri_holder'] ?? 'Denpasar Institute' }}">
                            </div>

                            {{-- Bank BRI --}}
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-info">Nomor Rekening Bank BRI <small class="text-muted">(Alternatif)</small></label>
                                <input type="text" name="bank_bri_rek" class="form-control font-monospace" value="{{ $settings['bank_bri_rek'] ?? '001701002891534' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-info">Atas Nama Bank BRI</label>
                                <input type="text" name="bank_bri_holder" class="form-control" value="{{ $settings['bank_bri_holder'] ?? 'Denpasar Institute' }}">
                            </div>

                            <div class="col-12 mt-2">
                                <label class="form-label font-weight-bold">Teks Catatan Keamanan Transfer</label>
                                <input type="text" name="transfer_security_notice" class="form-control" value="{{ $settings['transfer_security_notice'] ?? 'Pastikan transfer ditujukan ke rekening resmi atas nama Denpasar Institute. Simpan bukti transfer Anda.' }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 3: QRIS & Pembayaran Tunai --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-qrcode text-danger"></i> Panduan QRIS &amp; Pembayaran Tunai</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Judul / NMID QRIS</label>
                                <input type="text" name="qris_title" class="form-control" value="{{ $settings['qris_title'] ?? 'QRIS Resmi Denpasar Institute (NMID: ID102003891829)' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Judul Loket Tunai</label>
                                <input type="text" name="tunai_title" class="form-control" value="{{ $settings['tunai_title'] ?? 'Loket Pembayaran Kampus Denpasar Institute' }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Deskripsi / Keterangan QRIS</label>
                                <textarea name="qris_desc" class="form-control" rows="3">{{ $settings['qris_desc'] ?? 'Menerima pembayaran dari seluruh aplikasi m-Banking (BCA, Mandiri, BNI, BRI, dll) serta E-Wallet (GoPay, OVO, Dana, ShopeePay, LinkAja).' }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Alamat Loket Tunai Kampus</label>
                                <textarea name="tunai_address" class="form-control" rows="3">{{ $settings['tunai_address'] ?? 'Jl. Gatot Subroto VI No. 27, Dauh Puri Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali 80231 (Senin - Sabtu: 08.00 - 17.00 WITA).' }}</textarea>
                            </div>

                            {{-- Upload Foto / Barcode QRIS --}}
                            <div class="col-12 mt-3 pt-3 border-top">
                                <label class="form-label font-weight-bold d-flex align-items-center gap-2">
                                    <i class="fas fa-image text-danger"></i> Foto / Gambar Barcode QRIS (Untuk Tampil di Form Pendaftaran):
                                </label>
                                <div class="row align-items-center g-3">
                                    <div class="col-12 col-md-4">
                                        @if(!empty($settings['qris_image']))
                                            <div class="position-relative d-inline-block p-2 border rounded-3 bg-light shadow-sm text-center w-100">
                                                <img src="{{ asset('storage/' . $settings['qris_image']) }}" alt="Foto QRIS" class="img-fluid rounded" style="max-height: 190px; object-fit: contain;">
                                                <div class="form-check mt-2 text-start small">
                                                    <input class="form-check-input" type="checkbox" name="remove_qris_image" value="1" id="removeQrisImg">
                                                    <label class="form-check-label text-danger fw-bold" for="removeQrisImg">
                                                        <i class="fas fa-trash-alt me-1"></i> Hapus Foto QRIS Ini
                                                    </label>
                                                </div>
                                            </div>
                                        @else
                                            <div class="p-4 border border-dashed rounded-3 bg-light text-center text-muted small">
                                                <i class="fas fa-qrcode fa-3x mb-2 text-secondary opacity-50"></i>
                                                <div>Belum ada foto QRIS yang diunggah</div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <input type="file" name="qris_image" class="form-control mb-2" accept="image/jpeg,image/png,image/jpg,image/webp">
                                        <small class="text-muted d-block">
                                            Upload file foto barcode QRIS resmi Denpasar Institute (format: JPG, PNG, WEBP, maks. 2MB).
                                        </small>
                                        <small class="text-success d-block fw-semibold mt-1">
                                            <i class="fas fa-check-circle me-1"></i> Foto ini otomatis akan tampil langsung di halaman formulir pendaftaran saat calon siswa/peserta memilih opsi pembayaran <strong>QRIS / E-Wallet</strong>.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 4: Kontak Bantuan Pendaftaran (Footer Form) --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-headset text-danger"></i> Kontak Bantuan Pendaftaran</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold">WhatsApp Admin Pendaftaran</label>
                                <input type="text" name="admission_wa_admin" class="form-control" value="{{ $settings['admission_wa_admin'] ?? '0821-4481-4593' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold">WhatsApp Layanan Informasi</label>
                                <input type="text" name="admission_wa_service" class="form-control" value="{{ $settings['admission_wa_service'] ?? '0823-1866-6547' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold">Email Informasi Pendaftaran</label>
                                <input type="email" name="admission_email" class="form-control" value="{{ $settings['admission_email'] ?? 'partner@denpasarinstitute.com' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 6: POPUP BANNER BERANDA --}}
            <div class="tab-pane fade {{ $currentTab === 'popup' ? 'show active' : '' }}" id="popup-pane" role="tabpanel">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-bullhorn text-danger"></i> Popup Banner Pengumuman / Promosi Beranda</h5>
                        <span class="badge bg-danger text-white px-3 py-2">Banner Sewaktu-waktu</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-primary border py-3 px-3 mb-4 d-flex align-items-center gap-2">
                            <i class="fas fa-info-circle fa-lg text-primary"></i>
                            <div>
                                <strong>Fitur Pop Up Banner Beranda:</strong> Banner ini akan muncul otomatis di halaman depan website ketika pengunjung membuka beranda setelah jeda waktu detik yang ditentukan. Pengunjung dapat menutupnya (tombol X) atau mengkliknya untuk menuju link yang Anda tetapkan.
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold">Status Popup Banner</label>
                                <select name="popup_banner_active" class="form-control form-select">
                                    <option value="1" {{ ($settings['popup_banner_active'] ?? '1') == '1' ? 'selected' : '' }}>Aktif (Tampilkan Pop Up)</option>
                                    <option value="0" {{ ($settings['popup_banner_active'] ?? '1') == '0' ? 'selected' : '' }}>Nonaktif (Sembunyikan)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Judul Banner Pengumuman</label>
                                <input type="text" name="popup_banner_title" class="form-control" value="{{ $settings['popup_banner_title'] ?? 'Pendaftaran & Kolaborasi Denpasar Institute' }}" placeholder="Judul banner...">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold">Jeda Muncul (Detik)</label>
                                <input type="number" name="popup_banner_delay" class="form-control" value="{{ $settings['popup_banner_delay'] ?? '2' }}" min="0" max="60">
                                <small class="text-muted">Waktu tunggu sebelum pop up muncul.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Link Tujuan Klik Banner</label>
                                <input type="text" name="popup_banner_url" class="form-control" value="{{ $settings['popup_banner_url'] ?? '/admission' }}" placeholder="Contoh: /admission atau https://...">
                                <small class="text-muted">Halaman yang terbuka saat pengunjung mengklik foto/gambar banner.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Upload Foto / Gambar Banner</label>
                                @if(!empty($settings['popup_banner_image']))
                                    <div class="mb-2 p-2 border rounded bg-light d-flex align-items-center gap-3">
                                        <img src="{{ asset('storage/' . $settings['popup_banner_image']) }}" alt="Banner" style="max-height: 70px; border-radius: 6px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remove_popup_banner_image" value="1" id="removePopupBanner">
                                            <label class="form-check-label text-danger small font-weight-bold" for="removePopupBanner">
                                                <i class="fas fa-trash-alt me-1"></i> Hapus Gambar Banner
                                            </label>
                                        </div>
                                    </div>
                                @endif
                                <input type="file" name="popup_banner_image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp">
                                <small class="text-muted">Format: JPG, PNG, WEBP (maks. 3MB). Disarankan rasio banner / poster.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Sticky Submit Button --}}
        <div class="card shadow-sm border-0 sticky-bottom" style="z-index:100;background:rgba(255,255,255,0.95);backdrop-filter:blur(6px);">
            <div class="card-body py-3 d-flex justify-content-between align-items-center">
                <span class="text-muted"><i class="fas fa-info-circle"></i> Klik tombol simpan untuk memperbarui pengaturan di semua halaman website.</span>
                <button type="submit" class="btn btn-danger btn-lg px-5 font-weight-bold">
                    <i class="fas fa-save"></i> Simpan Semua Perubahan
                </button>
            </div>
        </div>

    </form>
</div>

@push('styles')
<style>
    /* Hilangkan delay animasi fade agar perpindahan tab terjadi seketika (instant 0ms) */
    #settingsTabContent > .tab-pane {
        transition: none !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Track active tab and update current_tab input & URL instantly
        const tabBtns = document.querySelectorAll('#settingsTab button[data-bs-toggle="tab"]');
        const currentTabInput = document.getElementById('current_tab');

        tabBtns.forEach(btn => {
            btn.addEventListener('shown.bs.tab', function (e) {
                const targetId = e.target.getAttribute('data-bs-target').replace('#', '').replace('-pane', '');
                if (currentTabInput) {
                    currentTabInput.value = targetId;
                }
                // Update URL parameter secara langsung tanpa reload halaman
                if (window.history.replaceState) {
                    const url = new URL(window.location);
                    url.searchParams.set('tab', targetId);
                    window.history.replaceState({}, '', url);
                }
            });
        });
    });
</script>
@endpush
@endsection

