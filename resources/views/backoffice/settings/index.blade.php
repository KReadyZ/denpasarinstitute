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

        <form action="{{ route('backoffice.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="current_tab" id="current_tab" value="{{ request('tab', 'contact') }}">

        {{-- Nav Tabs --}}
        <ul class="nav nav-tabs mb-4" id="settingsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ request('tab', 'contact') === 'contact' ? 'active' : '' }} font-weight-bold" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-pane" type="button" role="tab">
                    <i class="fas fa-address-book text-danger"></i> Kontak &amp; Footer
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ request('tab') === 'social' ? 'active' : '' }} font-weight-bold" id="social-tab" data-bs-toggle="tab" data-bs-target="#social-pane" type="button" role="tab">
                    <i class="fas fa-share-alt text-danger"></i> Media Sosial
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ request('tab') === 'home' ? 'active' : '' }} font-weight-bold" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-pane" type="button" role="tab">
                    <i class="fas fa-home text-danger"></i> Sambutan &amp; Moto Beranda
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ request('tab') === 'partner' ? 'active' : '' }} font-weight-bold" id="partner-tab" data-bs-toggle="tab" data-bs-target="#partner-pane" type="button" role="tab">
                    <i class="fas fa-handshake text-danger"></i> Halaman Kemitraan (Partner)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ request('tab') === 'admission' ? 'active' : '' }} font-weight-bold" id="admission-tab" data-bs-toggle="tab" data-bs-target="#admission-pane" type="button" role="tab">
                    <i class="fas fa-file-pen text-danger"></i> Editor Form Pendaftaran (Admission)
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

            {{-- TAB 5: FORM PENDAFTARAN (ADMISSION) --}}
            <div class="tab-pane fade {{ request('tab') === 'admission' ? 'show active' : '' }}" id="admission-pane" role="tabpanel">
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

                {{-- Card 2: Rekening Bank Resmi Tujuan Transfer --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-building-columns text-danger"></i> Rekening Tujuan Transfer Resmi</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            {{-- Bank BCA --}}
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-primary">Nomor Rekening Bank BCA</label>
                                <input type="text" name="bank_bca_rek" class="form-control font-monospace" value="{{ $settings['bank_bca_rek'] ?? '7720918899' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-primary">Atas Nama Bank BCA</label>
                                <input type="text" name="bank_bca_holder" class="form-control" value="{{ $settings['bank_bca_holder'] ?? 'Denpasar Institute' }}">
                            </div>

                            {{-- Bank BNI --}}
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-danger">Nomor Rekening Bank BNI</label>
                                <input type="text" name="bank_bni_rek" class="form-control font-monospace" value="{{ $settings['bank_bni_rek'] ?? '0819192837' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-danger">Atas Nama Bank BNI</label>
                                <input type="text" name="bank_bni_holder" class="form-control" value="{{ $settings['bank_bni_holder'] ?? 'Yayasan Denpasar Institute' }}">
                            </div>

                            {{-- Bank Mandiri --}}
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold" style="color:#b45309;">Nomor Rekening Bank Mandiri</label>
                                <input type="text" name="bank_mandiri_rek" class="form-control font-monospace" value="{{ $settings['bank_mandiri_rek'] ?? '1450018293812' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold" style="color:#b45309;">Atas Nama Bank Mandiri</label>
                                <input type="text" name="bank_mandiri_holder" class="form-control" value="{{ $settings['bank_mandiri_holder'] ?? 'Denpasar Institute' }}">
                            </div>

                            {{-- Bank BRI --}}
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-info">Nomor Rekening Bank BRI</label>
                                <input type="text" name="bank_bri_rek" class="form-control font-monospace" value="{{ $settings['bank_bri_rek'] ?? '001701002891534' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-info">Atas Nama Bank BRI</label>
                                <input type="text" name="bank_bri_holder" class="form-control" value="{{ $settings['bank_bri_holder'] ?? 'Denpasar Institute' }}">
                            </div>

                            <div class="col-12">
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
                                <input type="email" name="admission_email" class="form-control" value="{{ $settings['admission_email'] ?? 'info@denpasarinstitute.id' }}">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Track active tab
        const tabBtns = document.querySelectorAll('#settingsTab button[data-bs-toggle="tab"]');
        const currentTabInput = document.getElementById('current_tab');

        tabBtns.forEach(btn => {
            btn.addEventListener('shown.bs.tab', function (e) {
                const targetId = e.target.getAttribute('data-bs-target').replace('#', '').replace('-pane', '');
                if (currentTabInput) {
                    currentTabInput.value = targetId;
                }
            });
        });

        // Auto switch tab if URL has ?tab=...
        const urlParams = new URLSearchParams(window.location.search);
        const activeTabParam = urlParams.get('tab');
        if (activeTabParam) {
            const targetBtn = document.getElementById(activeTabParam + '-tab');
            if (targetBtn) {
                const bsTab = new bootstrap.Tab(targetBtn);
                bsTab.show();
            }
        }
    });
</script>
@endpush
@endsection

