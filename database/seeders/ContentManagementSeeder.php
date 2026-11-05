<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NavigationItem;
use App\Models\SiteSetting;
use App\Models\PartnershipPillar;

class ContentManagementSeeder extends Seeder
{
    public function run(): void
    {
        // 1. NAVIGATION ITEMS
        $navItems = [
            // Navbar Left
            ['title' => 'Home', 'url' => '/', 'location' => 'navbar_left', 'order' => 1, 'target' => '_self', 'is_active' => true],
            ['title' => 'Divisi', 'url' => '#divisi-detail', 'location' => 'navbar_left', 'order' => 2, 'target' => '_self', 'is_active' => true],
            ['title' => 'Konsultan', 'url' => '/konsultan', 'location' => 'navbar_left', 'order' => 3, 'target' => '_self', 'is_active' => true],
            ['title' => 'GRCS Club', 'url' => '/grcs-club', 'location' => 'navbar_left', 'order' => 4, 'target' => '_self', 'is_active' => true],

            // Navbar Right
            ['title' => 'Bursa SDM', 'url' => '/bursa-sdm', 'location' => 'navbar_right', 'order' => 1, 'target' => '_self', 'is_active' => true],
            ['title' => 'Event', 'url' => '/event', 'location' => 'navbar_right', 'order' => 2, 'target' => '_self', 'is_active' => true],
            ['title' => 'News', 'url' => '/berita', 'location' => 'navbar_right', 'order' => 3, 'target' => '_self', 'is_active' => true],
            ['title' => 'Partnership', 'url' => '/partner-with-di', 'location' => 'navbar_right', 'order' => 4, 'target' => '_self', 'is_active' => true],

            // Footer Komunitas
            ['title' => 'GRCS Club', 'url' => '/grcs-club', 'location' => 'footer_komunitas', 'order' => 1, 'target' => '_self', 'is_active' => true],
            ['title' => 'Konsultan', 'url' => '/konsultan', 'location' => 'footer_komunitas', 'order' => 2, 'target' => '_self', 'is_active' => true],
            ['title' => 'Bursa SDM', 'url' => '/bursa-sdm', 'location' => 'footer_komunitas', 'order' => 3, 'target' => '_self', 'is_active' => true],
            ['title' => 'Partnership', 'url' => '/partner-with-di', 'location' => 'footer_komunitas', 'order' => 4, 'target' => '_self', 'is_active' => true],
            ['title' => 'Event', 'url' => '/event', 'location' => 'footer_komunitas', 'order' => 5, 'target' => '_self', 'is_active' => true],
            ['title' => 'News', 'url' => '/berita', 'location' => 'footer_komunitas', 'order' => 6, 'target' => '_self', 'is_active' => true],
            ['title' => 'Research Sharing', 'url' => '/#news', 'location' => 'footer_komunitas', 'order' => 7, 'target' => '_self', 'is_active' => true],
        ];

        foreach ($navItems as $item) {
            NavigationItem::updateOrCreate(
                ['title' => $item['title'], 'location' => $item['location']],
                $item
            );
        }

        // 2. SITE SETTINGS
        $settings = [
            // Contact & Footer
            ['key' => 'contact_address', 'value' => 'Denpasar, Bali - Indonesia', 'group' => 'contact', 'label' => 'Alamat Kantor'],
            ['key' => 'contact_email', 'value' => 'info@denpasarinstitute.id', 'group' => 'contact', 'label' => 'Email Utama'],
            ['key' => 'contact_phone_1', 'value' => '+62 821-4481-4593', 'group' => 'contact', 'label' => 'WhatsApp Sekretariat 1'],
            ['key' => 'contact_phone_2', 'value' => '+62 823-1866-6547', 'group' => 'contact', 'label' => 'WhatsApp Sekretariat 2'],
            ['key' => 'contact_wa_lead_consultant', 'value' => '+62 813-3764-4463', 'group' => 'contact', 'label' => 'WhatsApp Lead Consultant'],
            ['key' => 'contact_email_secretary', 'value' => 'info@denpasarinstitute.com', 'group' => 'contact', 'label' => 'Email Sekretariat'],
            ['key' => 'footer_copyright', 'value' => 'Denpasar Institute. Hak cipta dilindungi undang-undang.', 'group' => 'footer', 'label' => 'Teks Hak Cipta Footer'],

            // Social Media
            ['key' => 'social_facebook', 'value' => '#', 'group' => 'social', 'label' => 'URL Facebook'],
            ['key' => 'social_instagram', 'value' => '#', 'group' => 'social', 'label' => 'URL Instagram'],
            ['key' => 'social_youtube', 'value' => '#', 'group' => 'social', 'label' => 'URL YouTube'],
            ['key' => 'social_linkedin', 'value' => '#', 'group' => 'social', 'label' => 'URL LinkedIn'],

            // Sambutan & Motto Beranda
            ['key' => 'sambutan_leader_name', 'value' => 'Prof. Dr. I Nengah Laba', 'group' => 'home', 'label' => 'Nama Lead Consultant'],
            ['key' => 'sambutan_leader_title', 'value' => 'Sambutan Lead Consultant', 'group' => 'home', 'label' => 'Label Judul Sambutan'],
            ['key' => 'sambutan_motto', 'value' => 'Transforming Ideas into Action', 'group' => 'home', 'label' => 'Moto (Teks Berjalan)'],
            ['key' => 'sambutan_welcome_title', 'value' => 'Selamat Datang di Official Website Denpasar Institute', 'group' => 'home', 'label' => 'Judul Sambutan'],
            ['key' => 'sambutan_p1', 'value' => '<strong>Denpasar Institute</strong> merupakan Lembaga Riset & Pengembangan SDM yang berkomitmen mendorong kemajuan ilmu pengetahuan, inovasi, publikasi ilmiah, peningkatan kompetensi, dan pemberdayaan masyarakat.', 'group' => 'home', 'label' => 'Paragraf Sambutan 1'],
            ['key' => 'sambutan_p2', 'value' => 'Melalui kolaborasi nasional dan internasional, kami membangun ekosistem riset, pembelajaran, dan inovasi yang inklusif, profesional, serta berkelanjutan untuk menghasilkan kontribusi nyata bagi masyarakat.', 'group' => 'home', 'label' => 'Paragraf Sambutan 2'],
            ['key' => 'sambutan_p3', 'value' => 'Kami membuka peluang kerja sama dengan akademisi, peneliti, pendidik, praktisi, pemerintah, dunia usaha, dan berbagai pemangku kepentingan dalam mengembangkan potensi dan meningkatkan daya saing sumber daya manusia.', 'group' => 'home', 'label' => 'Paragraf Sambutan 3 (Selengkapnya)'],
            ['key' => 'sambutan_p4', 'value' => 'Kami berharap website ini menjadi sumber informasi dan ruang kolaborasi untuk bersama-sama mewujudkan masa depan yang lebih baik.', 'group' => 'home', 'label' => 'Paragraf Sambutan 4 (Selengkapnya)'],

            // Halaman Partner with DI
            ['key' => 'partner_hero_title', 'value' => 'Partnership, Community & Global Engagement', 'group' => 'partner', 'label' => 'Judul Hero Kemitraan'],
            ['key' => 'partner_hero_tagline', 'value' => 'Connecting Knowledge, Research, Industry, and Communities.', 'group' => 'partner', 'label' => 'Tagline Hero Kemitraan'],
            ['key' => 'partner_hero_desc', 'value' => 'Partnership, Community & Global Engagement merupakan wadah pengembangan kerja sama dan kolaborasi Denpasar Institute dengan berbagai institusi pendidikan, pemerintah, dunia usaha, industri, dan komunitas di tingkat nasional maupun internasional. Melalui kemitraan strategis, kami mendorong pertukaran pengetahuan, pengembangan riset, inovasi, dan peningkatan kualitas sumber daya manusia.', 'group' => 'partner', 'label' => 'Deskripsi Hero Kemitraan'],
            ['key' => 'partner_cta_title', 'value' => 'Siap Berkolaborasi Bersama Denpasar Institute?', 'group' => 'partner', 'label' => 'Judul CTA Kemitraan'],
            ['key' => 'partner_cta_desc', 'value' => 'Diskusikan peluang kemitraan strategis, riset bersama, pelatihan institusi, maupun kolaborasi global bersama tim kami.', 'group' => 'partner', 'label' => 'Deskripsi CTA Kemitraan'],
            ['key' => 'partner_cta_wa_phone', 'value' => '6282144814593', 'group' => 'partner', 'label' => 'Nomor WhatsApp Hotline Kemitraan (Format: 62...)'],
        ];

        foreach ($settings as $s) {
            SiteSetting::updateOrCreate(
                ['key' => $s['key']],
                $s
            );
        }

        // 3. PARTNERSHIP PILLARS (6 PILARS)
        $pillars = [
            [
                'number' => '01',
                'title' => 'Riset dan Inovasi',
                'tag' => 'Riset & Inovasi',
                'icon' => 'fa-microscope',
                'description' => 'Menyediakan layanan penelitian, konsultasi, dan pengembangan inovasi untuk menghasilkan solusi yang bermanfaat bagi masyarakat, lembaga, dan dunia usaha.',
                'image' => 'image/partners/riset-inovasi.png',
                'link_url' => '/divisi/divisi-riset-dan-inovasi',
                'link_text' => 'Learn more',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'number' => '02',
                'title' => 'Kemitraan Industri',
                'tag' => 'Kemitraan Industri',
                'icon' => 'fa-industry',
                'description' => 'Membangun kerja sama strategis dengan dunia usaha, industri, pemerintah, dan institusi pendidikan untuk mendukung pengembangan program, peningkatan kompetensi, dan peluang kolaborasi.',
                'image' => 'image/partners/kemitraan-industri.png',
                'link_url' => 'https://wa.me/6282144814593?text=Halo%20Denpasar%20Institute,%20saya%20tertarik%20mengenai%20Kemitraan%20Industri.',
                'link_text' => 'Learn more',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'number' => '03',
                'title' => 'Pengembangan Profesional',
                'tag' => 'Pengembangan Profesional',
                'icon' => 'fa-chalkboard-teacher',
                'description' => 'Menyelenggarakan berbagai program pelatihan, pendampingan, dan pengembangan kompetensi untuk meningkatkan keterampilan, profesionalisme, serta kualitas sumber daya manusia.',
                'image' => 'image/partners/pengembangan-profesional.png',
                'link_url' => '/divisi/divisi-pengembangan-sdm',
                'link_text' => 'Learn more',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'number' => '04',
                'title' => 'Pemberdayaan Masyarakat',
                'tag' => 'Pemberdayaan Masyarakat',
                'icon' => 'fa-hands-helping',
                'description' => 'Mengembangkan program pemberdayaan dan pengabdian masyarakat melalui pendidikan, pelatihan, pendampingan, serta pengembangan potensi lokal secara berkelanjutan.',
                'image' => 'image/partners/pemberdayaan-masyarakat.png',
                'link_url' => '/divisi/divisi-bahasa-seni-dan-budaya',
                'link_text' => 'Learn more',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'number' => '05',
                'title' => 'Kemitraan Global',
                'tag' => 'Kemitraan Global',
                'icon' => 'fa-globe-asia',
                'description' => 'Memfasilitasi kerja sama internasional dalam bidang pendidikan, penelitian, pertukaran akademik, pengembangan SDM, dan kegiatan kolaboratif lintas negara.',
                'image' => 'image/partners/kemitraan-global.png',
                'link_url' => '/divisi/divisi-kerja-sama-dan-hi',
                'link_text' => 'Learn more',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'number' => '06',
                'title' => 'Publikasi & HKI',
                'tag' => 'Publikasi & HKI',
                'icon' => 'fa-book-open',
                'description' => 'Menyediakan layanan penerbitan buku, pendampingan publikasi ilmiah, pengelolaan jurnal, serta fasilitasi perlindungan dan pengembangan kekayaan intelektual.',
                'image' => 'image/partners/publikasi-hki.jpg',
                'link_url' => '/divisi/divisi-publikasi-dan-hki',
                'link_text' => 'Learn more',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($pillars as $p) {
            PartnershipPillar::updateOrCreate(
                ['number' => $p['number']],
                $p
            );
        }
    }
}

