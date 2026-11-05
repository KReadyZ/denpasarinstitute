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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('backoffice.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nav Tabs --}}
        <ul class="nav nav-tabs mb-4" id="settingsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active font-weight-bold" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-pane" type="button" role="tab">
                    <i class="fas fa-address-book text-danger"></i> Kontak &amp; Footer
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link font-weight-bold" id="social-tab" data-bs-toggle="tab" data-bs-target="#social-pane" type="button" role="tab">
                    <i class="fas fa-share-alt text-danger"></i> Media Sosial
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link font-weight-bold" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-pane" type="button" role="tab">
                    <i class="fas fa-home text-danger"></i> Sambutan &amp; Moto Beranda
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link font-weight-bold" id="partner-tab" data-bs-toggle="tab" data-bs-target="#partner-pane" type="button" role="tab">
                    <i class="fas fa-handshake text-danger"></i> Halaman Kemitraan (Partner)
                </button>
            </li>
        </ul>

        <div class="tab-content" id="settingsTabContent">
            
            {{-- TAB 1: KONTAK & FOOTER --}}
            <div class="tab-pane fade show active" id="contact-pane" role="tabpanel">
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
                                <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? 'info@denpasarinstitute.id' }}">
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
                                <input type="email" name="contact_email_secretary" class="form-control" value="{{ $settings['contact_email_secretary'] ?? 'info@denpasarinstitute.com' }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label font-weight-bold">Teks Hak Cipta (Footer Copyright)</label>
                                <input type="text" name="footer_copyright" class="form-control" value="{{ $settings['footer_copyright'] ?? 'Denpasar Institute. Hak cipta dilindungi undang-undang.' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 2: MEDIA SOSIAL --}}
            <div class="tab-pane fade" id="social-pane" role="tabpanel">
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
            <div class="tab-pane fade" id="home-pane" role="tabpanel">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-quote-left text-danger"></i> Sambutan Lead Consultant &amp; Moto Teks Berjalan</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Nama Pimpinan / Lead Consultant</label>
                                <input type="text" name="sambutan_leader_name" class="form-control" value="{{ $settings['sambutan_leader_name'] ?? 'Prof. Dr. I Nengah Laba' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Label Tag Sambutan</label>
                                <input type="text" name="sambutan_leader_title" class="form-control" value="{{ $settings['sambutan_leader_title'] ?? 'Sambutan Lead Consultant' }}">
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
                                <label class="form-label font-weight-bold">Paragraf Sambutan 3 (Bagian "Selengkapnya")</label>
                                <textarea name="sambutan_p3" class="form-control summernote" rows="4">{{ $settings['sambutan_p3'] ?? 'Kami membuka peluang kerja sama dengan akademisi, peneliti, pendidik, praktisi, pemerintah, dunia usaha, dan berbagai pemangku kepentingan dalam mengembangkan potensi dan meningkatkan daya saing sumber daya manusia.' }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label font-weight-bold">Paragraf Sambutan 4 (Bagian "Selengkapnya")</label>
                                <textarea name="sambutan_p4" class="form-control summernote" rows="3">{{ $settings['sambutan_p4'] ?? 'Kami berharap website ini menjadi sumber informasi dan ruang kolaborasi untuk bersama-sama mewujudkan masa depan yang lebih baik.' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 4: HALAMAN KEMITRAAN (PARTNER) --}}
            <div class="tab-pane fade" id="partner-pane" role="tabpanel">
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
@endsection

