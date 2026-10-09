<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSlider;

class HeroSliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            [
                'title'            => '9 Divisi Aktif Denpasar Institute',
                'subtitle'         => 'Satu ekosistem lengkap mulai dari riset ilmiah, publikasi, pengembangan SDM, teknologi, budaya, hingga kewirausahaan. Transforming Ideas into Action.',
                'type'             => 'banner',
                'background_image' => null,
                'logo_image'       => null,
                'button_text'      => 'Selengkapnya',
                'button_url'       => '#',
                'stats'            => [],
                'order'            => 1,
                'is_active'        => true,
            ],
            [
                'title'            => 'Divisi Riset dan Inovasi',
                'subtitle'         => 'Mendorong penelitian berkualitas tinggi dan inovasi berbasis bukti untuk kemajuan institusi dan masyarakat luas.',
                'type'             => 'divisi',
                'divisi_name'      => 'Riset dan Inovasi',
                'background_image' => null,
                'logo_image'       => null,
                'button_text'      => 'Selengkapnya',
                'button_url'       => '/divisi/riset-dan-inovasi',
                'stats'            => [
                    ['number' => '50+',  'label' => 'Proyek Riset'],
                    ['number' => '25+',  'label' => 'Inovasi'],
                    ['number' => '100+', 'label' => 'Peneliti'],
                ],
                'order'            => 2,
                'is_active'        => true,
            ],
            [
                'title'            => 'Divisi Publikasi dan HKI',
                'subtitle'         => 'Mengelola penerbitan jurnal, buku, serta layanan Hak Kekayaan Intelektual dan paten profesional.',
                'type'             => 'divisi',
                'divisi_name'      => 'Publikasi dan HKI',
                'background_image' => null,
                'logo_image'       => null,
                'button_text'      => 'Selengkapnya',
                'button_url'       => '/divisi/publikasi-hki',
                'stats'            => [
                    ['number' => '30+',  'label' => 'Jurnal'],
                    ['number' => '200+', 'label' => 'HKI Terdaftar'],
                    ['number' => '15+',  'label' => 'Paten'],
                ],
                'order'            => 3,
                'is_active'        => true,
            ],
            [
                'title'            => 'Divisi Pengembangan SDM',
                'subtitle'         => 'Pelatihan, workshop, dan seminar untuk meningkatkan kompetensi sumber daya manusia yang berdaya saing global.',
                'type'             => 'divisi',
                'divisi_name'      => 'Pengembangan SDM',
                'background_image' => null,
                'logo_image'       => null,
                'button_text'      => 'Selengkapnya',
                'button_url'       => '/divisi/pengembangan-sdm',
                'stats'            => [
                    ['number' => '500+', 'label' => 'Peserta/Tahun'],
                    ['number' => '40+',  'label' => 'Program'],
                    ['number' => '95%',  'label' => 'Kepuasan'],
                ],
                'order'            => 4,
                'is_active'        => true,
            ],
            [
                'title'            => 'Divisi Vokasi & Sertifikasi',
                'subtitle'         => 'Pendidikan vokasi dan program sertifikasi berstandar nasional dan internasional untuk kesiapan karir profesional.',
                'type'             => 'divisi',
                'divisi_name'      => 'Vokasi dan Sertifikasi',
                'background_image' => null,
                'logo_image'       => null,
                'button_text'      => 'Selengkapnya',
                'button_url'       => '/divisi/vokasi-sertifikasi',
                'stats'            => [
                    ['number' => '20+',   'label' => 'Skema Sertifikasi'],
                    ['number' => '1000+', 'label' => 'Lulusan'],
                    ['number' => '90%',   'label' => 'Terserap Kerja'],
                ],
                'order'            => 5,
                'is_active'        => true,
            ],
            [
                'title'            => 'Divisi Sains Data & Teknologi',
                'subtitle'         => 'Solusi big data, artificial intelligence, dan transformasi digital untuk institusi modern dan berkelanjutan.',
                'type'             => 'divisi',
                'divisi_name'      => 'Sains Data dan Teknologi',
                'background_image' => null,
                'logo_image'       => null,
                'button_text'      => 'Selengkapnya',
                'button_url'       => '/divisi/sains-IT',
                'stats'            => [
                    ['number' => '100+', 'label' => 'Proyek AI'],
                    ['number' => '50+',  'label' => 'Klien'],
                    ['number' => '24/7', 'label' => 'Support'],
                ],
                'order'            => 6,
                'is_active'        => true,
            ],
            [
                'title'            => 'Divisi Bahasa, Seni & Budaya',
                'subtitle'         => 'Pelestarian bahasa, riset budaya, dan digitalisasi warisan budaya Indonesia untuk generasi mendatang.',
                'type'             => 'divisi',
                'divisi_name'      => 'Bahasa, Seni dan Budaya',
                'background_image' => null,
                'logo_image'       => null,
                'button_text'      => 'Selengkapnya',
                'button_url'       => '/divisi/bahasa-seni-budaya',
                'stats'            => [
                    ['number' => '10+',  'label' => 'Bahasa'],
                    ['number' => '50+',  'label' => 'Riset Budaya'],
                    ['number' => '500+', 'label' => 'Artefak Digital'],
                ],
                'order'            => 7,
                'is_active'        => true,
            ],
            [
                'title'            => 'Divisi Kerja Sama & Hub. Internasional',
                'subtitle'         => 'Kemitraan global, pertukaran ilmu pengetahuan, beasiswa, dan kolaborasi riset internasional.',
                'type'             => 'divisi',
                'divisi_name'      => 'Kerja Sama dan Hubungan Internasional',
                'background_image' => null,
                'logo_image'       => null,
                'button_text'      => 'Selengkapnya',
                'button_url'       => '/divisi/kerjasama-hi',
                'stats'            => [
                    ['number' => '30+',  'label' => 'Mitra Global'],
                    ['number' => '15+',  'label' => 'Negara'],
                    ['number' => '200+', 'label' => 'Kolaborasi'],
                ],
                'order'            => 8,
                'is_active'        => true,
            ],
            [
                'title'            => 'Divisi Konsultan',
                'subtitle'         => 'Layanan konsultasi manajemen, kebijakan publik, dan riset terapan untuk berbagai sektor dan industri.',
                'type'             => 'divisi',
                'divisi_name'      => 'Konsultan',
                'background_image' => null,
                'logo_image'       => null,
                'button_text'      => 'Selengkapnya',
                'button_url'       => '/divisi/konsultan',
                'stats'            => [
                    ['number' => '75+',  'label' => 'Klien'],
                    ['number' => '150+', 'label' => 'Proyek'],
                    ['number' => '98%',  'label' => 'Rekomendasi'],
                ],
                'order'            => 9,
                'is_active'        => true,
            ],
            [
                'title'            => 'Divisi Karir & Kewirausahaan',
                'subtitle'         => 'Inkubasi bisnis, program wirausaha, dan pendampingan startup untuk generasi muda yang inovatif.',
                'type'             => 'divisi',
                'divisi_name'      => 'Karir dan Kewirausahaan',
                'background_image' => null,
                'logo_image'       => null,
                'button_text'      => 'Selengkapnya',
                'button_url'       => '/divisi/karir-kewirausahaan',
                'stats'            => [
                    ['number' => '50+',  'label' => 'Startup'],
                    ['number' => '300+', 'label' => 'Wirausaha'],
                    ['number' => '85%',  'label' => 'Berhasil'],
                ],
                'order'            => 10,
                'is_active'        => true,
            ],
        ];

        foreach ($sliders as $slider) {
            HeroSlider::create($slider);
        }
    }
}