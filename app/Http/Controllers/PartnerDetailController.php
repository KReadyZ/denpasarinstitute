<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PartnershipPillar;
use App\Models\PartnershipSubmission;
use App\Models\SiteSetting;

class PartnerDetailController extends Controller
{
    /**
     * Data konfigurasi lengkap 6 Pilar Kemitraan
     */
    public static function getPillarsList(): array
    {
        return [
            'research-and-innovation' => [
                'pillar_id'   => 1,
                'section_code'=> 'Research & Innovation',
                'subtitle'    => 'Research, Innovation & Consulting',
                'badge'       => 'Kemitraan • Research & Innovation',
                'hero_title'  => 'Research, Innovation & <span>Consulting</span>',
                'hero_sub'    => 'Menyediakan layanan penelitian terapan, konsultasi metodologi, kajian kebijakan publik, dan pengembangan inovasi terpadu untuk menghasilkan solusi strategis yang berdampak nyata bagi masyarakat, institusi, dan dunia usaha.',
                'image'       => 'image/partners/research-innovation-detail.jpg',
                'fallback_image' => 'image/partners/riset-inovasi.png',
                'image_tag'   => 'Fasilitas Riset Terakreditasi',
                'image_sub'   => 'Kolaborasi saintifik berstandar nasional & internasional',
                'intro'       => 'Ruang lingkup layanan dan fokus kolaborasi strategis pada pilar <strong>Research, Innovation & Consulting</strong> Denpasar Institute:',
                'services'    => [
                    [
                        'icon'  => 'fa-handshake',
                        'title' => 'Research Collaboration',
                        'desc'  => 'Kemitraan riset bersama antar universitas, lembaga penelitian, pemerintah daerah, dan korporasi multinasional.',
                    ],
                    [
                        'icon'  => 'fa-comments',
                        'title' => 'Research Consultancy',
                        'desc'  => 'Konsultasi komprehensif mulai dari desain riset, metodologi kuantitatif/kualitatif, hingga strategi diseminasi hasil.',
                    ],
                    [
                        'icon'  => 'fa-lightbulb',
                        'title' => 'Applied Research',
                        'desc'  => 'Riset terapan berorientasi solusi nyata untuk menjawab permasalahan spesifik di bidang industri, sosial, dan ekonomi.',
                    ],
                    [
                        'icon'  => 'fa-file-contract',
                        'title' => 'Policy Research & Studies',
                        'desc'  => 'Kajian kebijakan publik, evaluasi dampak regulasi, naskah akademik, dan penyusunan rekomendasi strategis.',
                    ],
                    [
                        'icon'  => 'fa-award',
                        'title' => 'Research Grant Assistance',
                        'desc'  => 'Pendampingan perumusan proposal hibah kompetitif, manajemen proyek penelitian, dan pertanggungjawaban saintifik.',
                    ],
                    [
                        'icon'  => 'fa-chart-line',
                        'title' => 'Feasibility Studies',
                        'desc'  => 'Studi kelayakan kelangsungan bisnis, proyek infrastruktur, investasi daerah, dan pemetaan potensi wilayah.',
                    ],
                    [
                        'icon'  => 'fa-tasks',
                        'title' => 'Monitoring & Evaluation',
                        'desc'  => 'Audit independen, monitoring berkala, dan evaluasi dampak pelaksanaan program CSR maupun program kerja pemerintah.',
                    ],
                    [
                        'icon'  => 'fa-database',
                        'title' => 'Data Analysis Services',
                        'desc'  => 'Pengolahan data tingkat lanjut, pemodelan ekonometrika, analitik data besar (big data), dan visualisasi data interaktif.',
                    ],
                ],
                'highlights'  => [
                    [
                        'icon'  => 'fa-user-graduate',
                        'title' => 'Tim Peneliti Berkualifikasi',
                        'desc'  => 'Didukung oleh akademisi bergelar Doktor dan Profesor serta konsultan berpengalaman di berbagai sektor industri.',
                    ],
                    [
                        'icon'  => 'fa-shield-alt',
                        'title' => 'Metodologi Teruji',
                        'desc'  => 'Menjunjung tinggi integritas akademik, objektivitas data, dan standar etika riset internasional.',
                    ],
                    [
                        'icon'  => 'fa-rocket',
                        'title' => 'Solusi Aplikatif & Nyata',
                        'desc'  => 'Output penelitian tidak hanya teoritis, melainkan siap diimplementasikan untuk pertumbuhan berkelanjutan institusi Anda.',
                    ],
                ],
                'cta_title'   => 'Tertarik Berkolaborasi dalam Riset & Inovasi?',
                'cta_sub'     => 'Hubungi tim kemitraan kami atau isi formulir kemitraan untuk mendiskusikan kebutuhan studi kelayakan, riset kolaborasi, maupun pendampingan proyek strategis.',
                'wa_text'     => 'Halo Denpasar Institute, saya tertarik untuk berkolaborasi mengenai Research, Innovation & Consulting.',
                'wa_btn'      => 'Form Kemitraan',
            ],

            'industry-partnership' => [
                'pillar_id'   => 2,
                'section_code'=> 'Industry Partnership',
                'subtitle'    => 'Corporate Collaboration & Industry Linkages',
                'badge'       => 'Kemitraan • Industry Partnership',
                'hero_title'  => 'Industry Partnership & <span>Collaboration</span>',
                'hero_sub'    => 'Membangun kerja sama strategis dengan dunia usaha, industri (DUDI), dan pemerintah guna memperkuat daya saing, menyelaraskan riset, serta melahirkan sinergi inovasi yang saling menguntungkan.',
                'image'       => 'image/partners/kemitraan-industri.png',
                'fallback_image' => 'image/partners/kemitraan-industri.png',
                'image_tag'   => 'Kemitraan Dunia Usaha & Industri',
                'image_sub'   => 'Sinergi nyata antara korporasi, akademisi, dan pemerintah',
                'intro'       => 'Ruang lingkup layanan dan fokus kolaborasi strategis pada pilar <strong>Industry Partnership</strong> Denpasar Institute:',
                'services'    => [
                    [
                        'icon'  => 'fa-handshake',
                        'title' => 'Corporate Social Responsibility (CSR)',
                        'desc'  => 'Perancangan, pendampingan eksekusi lapangan, dan asesmen dampak program CSR perusahaan yang terukur dan tepat sasaran.',
                    ],
                    [
                        'icon'  => 'fa-industry',
                        'title' => 'Industry-Academia Collaboration',
                        'desc'  => 'Penyelarasan kebutuhan riset, teknologi, dan inovasi industri dengan kapabilitas akademisi perguruan tinggi.',
                    ],
                    [
                        'icon'  => 'fa-user-tie',
                        'title' => 'Internship & Apprenticeship Placement',
                        'desc'  => 'Penyaluran program magang bersertifikat dan penyiapan talenta muda kompeten yang siap berkarier di industri mitra.',
                    ],
                    [
                        'icon'  => 'fa-chalkboard-teacher',
                        'title' => 'Customized Corporate Upskilling',
                        'desc'  => 'Pelatihan eksklusif berbasis kebutuhan spesifik (tailored training) untuk meningkatkan produktivitas dan kapabilitas SDM perusahaan.',
                    ],
                    [
                        'icon'  => 'fa-briefcase',
                        'title' => 'Business Advisory & Tech Transfer',
                        'desc'  => 'Konsultasi manajemen bisnis, strategi ekspansi pasar, adopsi teknologi terapan, dan transformasi digital institusi.',
                    ],
                    [
                        'icon'  => 'fa-cogs',
                        'title' => 'Joint Product Commercialization',
                        'desc'  => 'Kolaborasi riset pengembangan prototipe, pengujian pasar, hingga komersialisasi produk inovatif bersama mitra korporasi.',
                    ],
                    [
                        'icon'  => 'fa-users',
                        'title' => 'Talent Acquisition & Talent Pipeline',
                        'desc'  => 'Penyediaan talenta profesional, konsultan ahli, dan tenaga kerja bersertifikat yang terkurasi melalui ekosistem Bursa SDM.',
                    ],
                    [
                        'icon'  => 'fa-network-wired',
                        'title' => 'Strategic Business Matchmaking',
                        'desc'  => 'Fasilitasi forum temu bisnis, konsorsium industri, dan jejaring kolaborasi strategis multi-pihak berskala nasional.',
                    ],
                ],
                'highlights'  => [
                    [
                        'icon'  => 'fa-building',
                        'title' => 'Jejaring Industri Luas',
                        'desc'  => 'Terhubung aktif dengan berbagai sektor korporasi perbankan, manufaktur, perhotelan, logistik, dan industri kreatif.',
                    ],
                    [
                        'icon'  => 'fa-bullseye',
                        'title' => 'Solusi Kustom & Aplikatif',
                        'desc'  => 'Setiap program kemitraan dirancang khusus menjawab tantangan riil dan target kinerja spesifik perusahaan.',
                    ],
                    [
                        'icon'  => 'fa-chart-line',
                        'title' => 'Dampak Bisnis Terukur',
                        'desc'  => 'Mengedepankan evaluasi kinerja yang jelas untuk memastikan efisiensi investasi dan keberlanjutan kerja sama.',
                    ],
                ],
                'cta_title'   => 'Siap Bermitra dan Bersinergi Bersama Industri Anda?',
                'cta_sub'     => 'Diskusikan peluang kemitraan korporasi, program CSR berkelanjutan, atau peningkatan kompetensi SDM perusahaan Anda bersama kami.',
                'wa_text'     => 'Halo Denpasar Institute, saya tertarik untuk berkolaborasi mengenai Industry Partnership.',
                'wa_btn'      => 'Form Kemitraan',
            ],

            'professional-development' => [
                'pillar_id'   => 3,
                'section_code'=> 'Professional Development',
                'subtitle'    => 'Capacity Building & Professional Certification',
                'badge'       => 'Kemitraan • Professional Development',
                'hero_title'  => 'Professional Development & <span>Capacity Building</span>',
                'hero_sub'    => 'Menyelenggarakan program sertifikasi profesi terakreditasi, pelatihan kepemimpinan intensif, dan pembinaan kompetensi berkelanjutan untuk mencetak SDM unggul berdaya saing global.',
                'image'       => 'image/partners/pengembangan-profesional.png',
                'fallback_image' => 'image/partners/pengembangan-profesional.png',
                'image_tag'   => 'Pusat Pelatihan & Sertifikasi',
                'image_sub'   => 'Pengembangan kompetensi berstandar BNSP dan internasional',
                'intro'       => 'Ruang lingkup layanan dan program pengembangan keahlian pada pilar <strong>Professional Development</strong> Denpasar Institute:',
                'services'    => [
                    [
                        'icon'  => 'fa-certificate',
                        'title' => 'Competency Certification Programs',
                        'desc'  => 'Uji kompetensi dan fasilitasi sertifikasi profesi terstandarisasi untuk memastikan pengakuan keahlian secara formal.',
                    ],
                    [
                        'icon'  => 'fa-chess-king',
                        'title' => 'Executive Leadership Training',
                        'desc'  => 'Pelatihan kepemimpinan strategis, pengambilan keputusan berbasis data, dan manajemen perubahan bagi jajaran pimpinan.',
                    ],
                    [
                        'icon'  => 'fa-chalkboard-teacher',
                        'title' => 'Educator & Lecturer Upskilling',
                        'desc'  => 'Peningkatan kompetensi pedagogik, metodologi riset modern, penulisan manuskrip, dan pemanfaatan edutech bagi pendidik.',
                    ],
                    [
                        'icon'  => 'fa-tools',
                        'title' => 'Vocational Skills & Masterclass',
                        'desc'  => 'Lokakarya praktis vokasional di bidang teknologi informasi, perhotelan, manajemen bisnis, dan keahlian terapan.',
                    ],
                    [
                        'icon'  => 'fa-building',
                        'title' => 'Tailored In-House Training (IHT)',
                        'desc'  => 'Pelatihan terpadu yang disesuaikan secara khusus dengan kultur kerja dan target kinerja operasional instansi mitra.',
                    ],
                    [
                        'icon'  => 'fa-microphone-alt',
                        'title' => 'Public Speaking & Communication',
                        'desc'  => 'Penguasaan komunikasi publik berkelas, teknik presentasi persuasif eksekutif, dan keahlian negosiasi tingkat tinggi.',
                    ],
                    [
                        'icon'  => 'fa-clipboard-check',
                        'title' => 'HR Assessment & Skill-Gap Analysis',
                        'desc'  => 'Asesmen komprehensif untuk memetakan potensi pegawai, bakat terpendam, serta analisis kebutuhan pelatihan kerja.',
                    ],
                    [
                        'icon'  => 'fa-sync-alt',
                        'title' => 'Continuous Professional Education',
                        'desc'  => 'Program pembelajaran berkelanjutan berkala untuk pembaruan regulasi industri, etika profesi, dan tren keahlian masa depan.',
                    ],
                ],
                'highlights'  => [
                    [
                        'icon'  => 'fa-award',
                        'title' => 'Instruktur Berlisensi Resmi',
                        'desc'  => 'Dipandu langsung oleh praktisi senior, asesor kompetensi bersertifikat, dan akademisi terkemuka.',
                    ],
                    [
                        'icon'  => 'fa-laptop-code',
                        'title' => 'Metode Pembelajaran Interaktif',
                        'desc'  => 'Menggabungkan teori mutakhir, simulasi kasus nyata, serta pendampingan langsung hingga tuntas.',
                    ],
                    [
                        'icon'  => 'fa-stamp',
                        'title' => 'Kredensial Diakui Nasional',
                        'desc'  => 'Sertifikat kelulusan resmi yang memiliki bobot kredibilitas tinggi bagi pengembangan jenjang karier profesional.',
                    ],
                ],
                'cta_title'   => 'Tingkatkan Kompetensi Tim dan SDM Institusi Anda Sekarang',
                'cta_sub'     => 'Konsultasikan paket pelatihan in-house, sertifikasi profesi, maupun program pengembangan talenta terbaik bersama kami.',
                'wa_text'     => 'Halo Denpasar Institute, saya tertarik untuk berkolaborasi mengenai Professional Development.',
                'wa_btn'      => 'Form Kemitraan',
            ],

            'community-empowerment' => [
                'pillar_id'   => 4,
                'section_code'=> 'Community Empowerment',
                'subtitle'    => 'Community Development & Social Impact Initiatives',
                'badge'       => 'Kemitraan • Community Empowerment',
                'hero_title'  => 'Community Empowerment & <span>Social Impact</span>',
                'hero_sub'    => 'Mengakselerasi kemandirian dan kesejahteraan masyarakat melalui pengabdian berbasis riset terapan, pemberdayaan desa, literasi teknologi, dan inkubasi usaha mikro berkelanjutan.',
                'image'       => 'image/partners/pemberdayaan-masyarakat.png',
                'fallback_image' => 'image/partners/pemberdayaan-masyarakat.png',
                'image_tag'   => 'Pemberdayaan Berkelanjutan',
                'image_sub'   => 'Dampak sosial nyata berbasis kearifan lokal nusantara',
                'intro'       => 'Ruang lingkup inisiatif sosial dan program pada pilar <strong>Community Empowerment</strong> Denpasar Institute:',
                'services'    => [
                    [
                        'icon'  => 'fa-landmark',
                        'title' => 'Village Community Development',
                        'desc'  => 'Pendampingan desa mandiri, inovasi tata kelola unit usaha BUMDes, dan optimalisasi potensi ekonomi pedesaan.',
                    ],
                    [
                        'icon'  => 'fa-store',
                        'title' => 'MSME & Micro-Enterprise Incubation',
                        'desc'  => 'Inkubasi dan pendampingan UMKM dalam standardisasi mutu produk, pengemasan higienis, branding, dan akses pasar.',
                    ],
                    [
                        'icon'  => 'fa-mobile-alt',
                        'title' => 'Digital Literacy & Tech Enablement',
                        'desc'  => 'Pelatihan literasi digital praktis, pemanfaatan e-commerce, dan sistem pencatatan keuangan modern bagi komunitas.',
                    ],
                    [
                        'icon'  => 'fa-palette',
                        'title' => 'Cultural Heritage & Creative Economy',
                        'desc'  => 'Pelestarian seni budaya tradisional yang disinergikan dengan penciptaan produk ekonomi kreatif bernilai tambah tinggi.',
                    ],
                    [
                        'icon'  => 'fa-leaf',
                        'title' => 'Sustainable Community Tourism',
                        'desc'  => 'Pengembangan desa wisata berbasis ekologi dan budaya (eco-village), hospitalitas ramah lingkungan, dan pemandu lokal.',
                    ],
                    [
                        'icon'  => 'fa-heartbeat',
                        'title' => 'Community Health & Eco-Campaigns',
                        'desc'  => 'Program edukasi sanitasi lingkungan, mitigasi pengelolaan sampah terpadu, serta ketahanan pangan keluarga.',
                    ],
                    [
                        'icon'  => 'fa-female',
                        'title' => 'Women & Youth Empowerment',
                        'desc'  => 'Pelatihan kewirausahaan mandiri bagi pemuda lokal serta pemberdayaan ekonomi perempuan kelompok rentan.',
                    ],
                    [
                        'icon'  => 'fa-people-carry',
                        'title' => 'Community Action Research (PKM)',
                        'desc'  => 'Penerjunan akademisi dan peneliti untuk menyelesaikan persoalan riil masyarakat melalui program pengabdian aplikatif.',
                    ],
                ],
                'highlights'  => [
                    [
                        'icon'  => 'fa-seedling',
                        'title' => 'Mengangkat Kearifan Lokal',
                        'desc'  => 'Program disusun berakar pada budaya setempat sehingga mudah diterima dan diperkuat secara mandiri oleh warga.',
                    ],
                    [
                        'icon'  => 'fa-hands-helping',
                        'title' => 'Kolaborasi Lintas Sektor',
                        'desc'  => 'Menghubungkan pemerintah, dana CSR korporasi, komunitas adat, dan akademisi dalam satu payung kerja sama.',
                    ],
                    [
                        'icon'  => 'fa-infinity',
                        'title' => 'Dampak Berkelanjutan',
                        'desc'  => 'Menghadirkan dampak ekonomi dan sosial yang terus berlanjut secara mandiri bahkan setelah pendampingan formal selesai.',
                    ],
                ],
                'cta_title'   => 'Mari Ciptakan Perubahan Nyata Bersama Masyarakat',
                'cta_sub'     => 'Kembangkan inisiatif sosial, program CSR pemberdayaan desa, maupun pendampingan UMKM berkelanjutan bersama tim kami.',
                'wa_text'     => 'Halo Denpasar Institute, saya tertarik untuk berkolaborasi mengenai Community Empowerment.',
                'wa_btn'      => 'Form Kemitraan',
            ],

            'global-partnership' => [
                'pillar_id'   => 5,
                'section_code'=> 'Global Partnership',
                'subtitle'    => 'International Collaboration & Academic Exchange',
                'badge'       => 'Kemitraan • Global Partnership',
                'hero_title'  => 'Global Partnership & <span>International Engagement</span>',
                'hero_sub'    => 'Menjembatani kerja sama internasional di bidang pendidikan tinggi, kolaborasi riset lintas batas, pertukaran saintifik, dan jejaring mobilitas global bersama institusi terkemuka dunia.',
                'image'       => 'image/partners/kemitraan-global.png',
                'fallback_image' => 'image/partners/kemitraan-global.png',
                'image_tag'   => 'Jejaring Global Antarbangsa',
                'image_sub'   => 'Kolaborasi aktif dengan universitas & lembaga dunia',
                'intro'       => 'Ruang lingkup kolaborasi antarbangsa pada pilar <strong>Global Partnership</strong> Denpasar Institute:',
                'services'    => [
                    [
                        'icon'  => 'fa-file-signature',
                        'title' => 'International Institutional MoUs',
                        'desc'  => 'Inisiasi, penyusunan, dan pelaksanaan nota kesepahaman (MoU/MoA) resmi dengan universitas serta lembaga dunia.',
                    ],
                    [
                        'icon'  => 'fa-exchange-alt',
                        'title' => 'Student & Faculty Exchange',
                        'desc'  => 'Program pertukaran mahasiswa dan dosen tamu untuk memperkaya wawasan saintifik serta pemahaman lintas budaya.',
                    ],
                    [
                        'icon'  => 'fa-globe-americas',
                        'title' => 'Joint International Conferences',
                        'desc'  => 'Penyelenggaraan simposium ilmiah internasional, seminar multidisiplin, dan forum akademik berskala global di Bali.',
                    ],
                    [
                        'icon'  => 'fa-microscope',
                        'title' => 'Cross-Border Collaborative Research',
                        'desc'  => 'Penelitian bersama antara peneliti Indonesia dengan pakar mancanegara yang didanai skema hibah internasional.',
                    ],
                    [
                        'icon'  => 'fa-user-graduate',
                        'title' => 'Visiting Scholar & Guest Lecturers',
                        'desc'  => 'Fasilitasi profesor dan akademisi tamu terkemuka dunia untuk memberikan kuliah umum dan riset bersama di Indonesia.',
                    ],
                    [
                        'icon'  => 'fa-passport',
                        'title' => 'Dual Certification & Global Standards',
                        'desc'  => 'Penyelarasan kurikulum pelatihan dengan tolok ukur kompetensi internasional dan penerbitan sertifikasi ganda.',
                    ],
                    [
                        'icon'  => 'fa-hand-holding-usd',
                        'title' => 'International Consortium Grants',
                        'desc'  => 'Partisipasi strategis dalam konsorsium proyek multilateral dan pengajuan hibah pembangunan berkelanjutan antarbangsa.',
                    ],
                    [
                        'icon'  => 'fa-plane',
                        'title' => 'Cultural Immersion & Global Study',
                        'desc'  => 'Program studi ekskursi akademik, program magang internasional, serta pembelajaran budaya nusantara bagi mitra asing.',
                    ],
                ],
                'highlights'  => [
                    [
                        'icon'  => 'fa-globe-asia',
                        'title' => 'Jangkauan Diplomatik Luas',
                        'desc'  => 'Menjalin relasi riset dengan institusi mitra di kawasan Asia Pasifik, Eropa, Australia, dan Amerika.',
                    ],
                    [
                        'icon'  => 'fa-user-shield',
                        'title' => 'Fasilitasi Protokol Profesional',
                        'desc'  => 'Didukung tim penghubung internasional yang andal dalam tata kelola protokoler dan kemitraan akademik global.',
                    ],
                    [
                        'icon'  => 'fa-star',
                        'title' => 'Peningkatan Rekognisi Global',
                        'desc'  => 'Membuka peluang bagi institusi dan akademisi lokal untuk tampil dan diakui di panggung ilmiah internasional.',
                    ],
                ],
                'cta_title'   => 'Buka Peluang Kolaborasi Akademik & Global',
                'cta_sub'     => 'Hubungi divisi kerja sama internasional kami untuk inisiasi MoU, penyelenggaraan konferensi global, atau program pertukaran akademik.',
                'wa_text'     => 'Halo Denpasar Institute, saya tertarik untuk berkolaborasi mengenai Global Partnership.',
                'wa_btn'      => 'Form Kemitraan',
            ],

            'publication-and-ipr' => [
                'pillar_id'   => 6,
                'section_code'=> 'Publication & Intellectual Property Rights',
                'subtitle'    => 'Academic Publishing, Book Production & IPR / HKI Management',
                'badge'       => 'Kemitraan • Publication & IPR',
                'hero_title'  => 'Publication & <span>Intellectual Property Rights</span>',
                'hero_sub'    => 'Menyediakan ekosistem terpadu penerbitan buku ber-ISBN, pendampingan publikasi jurnal ilmiah terakreditasi, pengelolaan berkala ilmiah, serta perlindungan hukum kekayaan intelektual (HKI).',
                'image'       => 'image/partners/publikasi-hki.jpg',
                'fallback_image' => 'image/partners/publikasi-hki.jpg',
                'image_tag'   => 'Penerbit Ilmiah & Konsultan HKI',
                'image_sub'   => 'Layanan penerbitan resmi ISBN & pendaftaran hak cipta',
                'intro'       => 'Ruang lingkup layanan penerbitan karya tulis dan perlindungan HKI pada pilar <strong>Publication & IPR</strong> Denpasar Institute:',
                'services'    => [
                    [
                        'icon'  => 'fa-book-reader',
                        'title' => 'Scientific Journal Management',
                        'desc'  => 'Pengelolaan dan penerbitan berkala ilmiah terakreditasi nasional (SINTA) dan internasional berbasis Open Journal Systems (OJS).',
                    ],
                    [
                        'icon'  => 'fa-book',
                        'title' => 'Book Publishing with ISBN',
                        'desc'  => 'Penerbitan buku ajar, referensi, monograf, dan bunga rampai ber-ISBN resmi pemerintah dengan tata letak profesional.',
                    ],
                    [
                        'icon'  => 'fa-copyright',
                        'title' => 'Copyright Registration (Hak Cipta)',
                        'desc'  => 'Fasilitasi pendaftaran hak cipta karya tulis, program komputer, modul ajar, dan seni ke DJKI Kemenkumham RI secara cepat.',
                    ],
                    [
                        'icon'  => 'fa-trademark',
                        'title' => 'Patent & Trademark Filing',
                        'desc'  => 'Pendampingan drafting deskripsi paten, penelusuran invensi kebaruan (novelty check), serta pendaftaran merek dagang institusi.',
                    ],
                    [
                        'icon'  => 'fa-spell-check',
                        'title' => 'Academic Proofreading & Translation',
                        'desc'  => 'Penyuntingan bahasa Inggris akademik oleh native speaker dan penerjemahan tersertifikasi standar jurnal Scopus/WoS.',
                    ],
                    [
                        'icon'  => 'fa-search',
                        'title' => 'Plagiarism & Similarity Screening',
                        'desc'  => 'Pemeriksaan indeks kemiripan naskah menggunakan Turnitin resmi serta konsultasi teknik parafrase yang etis dan tepat.',
                    ],
                    [
                        'icon'  => 'fa-layer-group',
                        'title' => 'Journal Indexing Assistance',
                        'desc'  => 'Pendampingan strategis peningkatan indeksasi jurnal menuju akreditasi SINTA, Scopus, DOAJ, Copernicus, dan Web of Science.',
                    ],
                    [
                        'icon'  => 'fa-file-invoice-dollar',
                        'title' => 'IPR Commercialization & Licensing',
                        'desc'  => 'Konsultasi valuasi kekayaan intelektual, penyusunan kontrak lisensi karya cipta, dan strategi hilirisasi produk hasil riset.',
                    ],
                ],
                'highlights'  => [
                    [
                        'icon'  => 'fa-feather-alt',
                        'title' => 'Penerbit Resmi Anggota IKAPI',
                        'desc'  => 'Memiliki legalitas penerbitan lengkap dengan standar proses editorial, review, dan percetakan berkualitas tinggi.',
                    ],
                    [
                        'icon'  => 'fa-balance-scale',
                        'title' => 'Konsultan HKI Terdaftar',
                        'desc'  => 'Didukung oleh praktisi hukum kekayaan intelektual yang memastikan perlindungan karya Anda aman dari pelanggaran.',
                    ],
                    [
                        'icon'  => 'fa-check-double',
                        'title' => 'Ribuan Karya Telah Terbit',
                        'desc'  => 'Telah sukses mengantarkan ribuan artikel ilmiah dosen dan peneliti tembus di berbagai jurnal bereputasi.',
                    ],
                ],
                'cta_title'   => 'Publikasikan Naskah & Lindungi Karya Intelektual Anda',
                'cta_sub'     => 'Konsultasikan penerbitan buku ber-ISBN, pendampingan publikasi Scopus/SINTA, maupun pendaftaran hak cipta karya Anda sekarang.',
                'wa_text'     => 'Halo Denpasar Institute, saya tertarik untuk berkolaborasi mengenai Publikasi dan HKI.',
                'wa_btn'      => 'Form Kemitraan',
            ],
        ];
    }

    /**
     * Map alias bahasa Indonesia ke slug bahasa Inggris
     */
    protected array $aliases = [
        'riset-dan-inovasi'          => 'research-and-innovation',
        'kemitraan-industri'         => 'industry-partnership',
        'pengembangan-profesional'   => 'professional-development',
        'pemberdayaan-masyarakat'    => 'community-empowerment',
        'kemitraan-global'           => 'global-partnership',
        'publikasi-dan-hki'          => 'publication-and-ipr',
    ];

    /**
     * Tampilkan halaman detail untuk pilar kemitraan yang dipilih
     */
    public function show(string $slug)
    {
        // Cek apakah slug merupakan alias bahasa Indonesia
        if (isset($this->aliases[$slug])) {
            return redirect()->route('partner.detail', $this->aliases[$slug]);
        }

        $allData = self::getPillarsList();

        // Cari pilar dari database berdasarkan slug atau fallback
        $dbPillar = PartnershipPillar::where('slug', $slug)->first();
        if (!$dbPillar && isset($allData[$slug]['pillar_id'])) {
            $dbPillar = PartnershipPillar::find($allData[$slug]['pillar_id']);
        }

        if (!$dbPillar && !isset($allData[$slug])) {
            abort(404, 'Pilar kemitraan tidak ditemukan.');
        }

        $fallback = $allData[$slug] ?? [];

        // Satukan data dengan memprioritaskan nilai database (sehingga bisa diedit dari backoffice)
        $data = [
            'pillar_id'      => $dbPillar->id ?? ($fallback['pillar_id'] ?? 1),
            'section_code'   => $dbPillar->tag ?? ($fallback['section_code'] ?? 'Kemitraan'),
            'subtitle'       => $dbPillar->subtitle ?? ($fallback['subtitle'] ?? ($dbPillar->title ?? '')),
            'badge'          => $dbPillar->badge ?? ($fallback['badge'] ?? ('Kemitraan • ' . ($dbPillar->tag ?? ''))),
            'hero_title'     => $dbPillar->hero_title ?? ($fallback['hero_title'] ?? ($dbPillar->title ?? '')),
            'hero_sub'       => $dbPillar->hero_sub ?? ($fallback['hero_sub'] ?? ($dbPillar->description ?? '')),
            'image'          => $dbPillar->detail_image ?: ($dbPillar->image ?: ($fallback['image'] ?? 'image/partners/pillar-research.jpg')),
            'fallback_image' => $dbPillar->image ?: ($fallback['fallback_image'] ?? 'image/partners/riset-inovasi.png'),
            'image_tag'      => $dbPillar->image_tag ?? ($fallback['image_tag'] ?? 'Pilar Kemitraan'),
            'image_sub'      => $dbPillar->image_sub ?? ($fallback['image_sub'] ?? 'Denpasar Institute'),
            'intro'          => $dbPillar->intro ?? ($fallback['intro'] ?? ''),
            'services'       => !empty($dbPillar->services) ? $dbPillar->services : ($fallback['services'] ?? []),
            'highlights'     => !empty($dbPillar->highlights) ? $dbPillar->highlights : ($fallback['highlights'] ?? []),
            'cta_title'      => $dbPillar->cta_title ?? ($fallback['cta_title'] ?? 'Tertarik Berkolaborasi?'),
            'cta_sub'        => $dbPillar->cta_sub ?? ($fallback['cta_sub'] ?? ''),
            'wa_text'        => $dbPillar->wa_text ?? ($fallback['wa_text'] ?? 'Halo Denpasar Institute, saya tertarik untuk berkolaborasi.'),
            'wa_btn'         => $dbPillar->wa_btn ?? ($fallback['wa_btn'] ?? 'Form Kemitraan'),
        ];

        // Ambil daftar seluruh 6 pilar untuk navigasi switcher dinamis
        $dbPillars = PartnershipPillar::active()->get();
        $allPillarsNav = [];
        if ($dbPillars->isNotEmpty()) {
            foreach ($dbPillars as $p) {
                $pSlug = $p->slug ?: \Illuminate\Support\Str::slug($p->title);
                $allPillarsNav[] = [
                    'slug'     => $pSlug,
                    'title'    => $p->tag ?: $p->title,
                    'subtitle' => $p->subtitle ?: $p->title,
                    'active'   => ($pSlug === $slug || $p->slug === $slug),
                ];
            }
        } else {
            foreach ($allData as $sKey => $sVal) {
                $allPillarsNav[] = [
                    'slug'     => $sKey,
                    'title'    => $sVal['section_code'],
                    'subtitle' => $sVal['subtitle'],
                    'active'   => ($sKey === $slug),
                ];
            }
        }

        return view('partner-detail', compact('data', 'dbPillar', 'slug', 'allPillarsNav', 'allData'));
    }

    /**
     * Proses kirim formulir kemitraan (Pop-up Modal)
     */
    public function submitForm(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'nama_pic'     => 'required|string|max:255',
            'institusi'    => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'no_wa'        => 'required|string|max:30',
            'link_gmap'    => 'nullable|string|max:500',
            'website'      => 'nullable|string|max:255',
            'logo'         => 'nullable|file|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'pillar_slug'  => 'nullable|string|max:100',
            'pillar_title' => 'nullable|string|max:255',
            'pesan'        => 'nullable|string|max:2000',
        ], [
            'nama_pic.required'  => 'Nama PIC wajib diisi.',
            'institusi.required' => 'Nama institusi / perusahaan wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'no_wa.required'     => 'Nomor WhatsApp wajib diisi.',
            'logo.image'         => 'Berkas logo harus berupa gambar (PNG, JPG, WebP, SVG).',
            'logo.max'           => 'Ukuran berkas logo maksimal 3MB.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors(),
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $destinationDir = public_path('image/partnership_logos');
            if (!is_dir($destinationDir)) {
                @mkdir($destinationDir, 0777, true);
            }
            if (!is_writable($destinationDir) && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                @exec('attrib -r "' . $destinationDir . '"');
            }
            try {
                $file->move($destinationDir, $fileName);
            } catch (\Throwable $e) {
                @copy($file->getRealPath(), $destinationDir . DIRECTORY_SEPARATOR . $fileName);
            }
            $validated['logo'] = 'image/partnership_logos/' . $fileName;
        }

        $submission = PartnershipSubmission::create($validated);

        // Siapkan link WhatsApp jika mitra ingin langsung menghubungi
        $waNumber = SiteSetting::get('partner_cta_wa_phone', '6282144814593');
        $waClean  = preg_replace('/[^0-9]/', '', $waNumber);
        $waText   = "Halo Denpasar Institute, saya telah mengirimkan Formulir Kemitraan melalui website:\n\n"
            . "• Nama PIC: " . $submission->nama_pic . "\n"
            . "• Institusi/Perusahaan: " . $submission->institusi . "\n"
            . "• Email: " . $submission->email . "\n"
            . "• WhatsApp: " . $submission->no_wa . "\n"
            . ($submission->website ? "• Website: " . $submission->website . "\n" : "")
            . ($submission->link_gmap ? "• Link Google Map: " . $submission->link_gmap . "\n" : "")
            . ($submission->pillar_title ? "• Bidang Kemitraan: " . $submission->pillar_title . "\n" : "")
            . ($submission->pesan ? "• Catatan: " . $submission->pesan . "\n" : "");
        $waUrl    = "https://wa.me/{$waClean}?text=" . urlencode($waText);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Formulir kemitraan berhasil dikirim! Tim Denpasar Institute akan segera meninjau dan menghubungi Anda.',
                'wa_url'  => $waUrl,
                'data'    => $submission,
            ]);
        }

        return back()->with('success', 'Formulir kemitraan berhasil dikirim! Tim Denpasar Institute akan segera menghubungi Anda.');
    }
}
