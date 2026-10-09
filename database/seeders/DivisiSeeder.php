<?php

namespace Database\Seeders;

use App\Models\Divisi;
use Illuminate\Database\Seeder;

class DivisiSeeder extends Seeder
{
    public function run(): void
    {
        $divisis = [
            [
                'nama' => 'Divisi Riset dan Inovasi',
                'slug' => 'divisi-riset-dan-inovasi',
                'header' => ' Divisi Riset dan Inovasi',
                'deskripsi' => '<p>Divisi Riset dan Inovasi berkomitmen mengembangkan pengetahuan melalui penelitian berkualitas tinggi dan inovasi berkelanjutan untuk kemajuan bangsa.</p>',
                'stats' => [
                    ['number' => '150+', 'label' => 'Penelitian'],
                    ['number' => '50+', 'label' => 'Publikasi'],
                    ['number' => '30+', 'label' => 'Mitra'],
                    ['number' => '1000+', 'label' => 'Alumni'],
                ],
                'is_active' => true,
                'urutan' => 1,
            ],
            [
                'nama' => 'Divisi Publikasi dan HKI',
                'slug' => 'divisi-publikasi-dan-hki',
                'header' => 'Publikasi dan HKI',
                'deskripsi' => '<p>Divisi Publikasi dan HKI mendukung diseminasi hasil riset dan perlindungan hak kekayaan intelektual dari para peneliti dan akademisi.</p>',
                'stats' => [
                    ['number' => '200+', 'label' => 'Jurnal'],
                    ['number' => '45', 'label' => 'Paten'],
                    ['number' => '60', 'label' => 'Buku'],
                    ['number' => '85', 'label' => 'HKI'],
                ],
                'is_active' => true,
                'urutan' => 2,
            ],
            [
                'nama' => 'Divisi Pengembangan SDM',
                'slug' => 'divisi-pengembangan-sdm',
                'header' => 'Pengembangan SDM',
                'deskripsi' => '<p>Divisi Pengembangan SDM fokus pada peningkatan kapasitas dan kompetensi sumber daya manusia melalui program pelatihan berkelanjutan.</p>',
                'stats' => [
                    ['number' => '500+', 'label' => 'Peserta'],
                    ['number' => '25', 'label' => 'Program'],
                    ['number' => '40', 'label' => 'Trainer'],
                    ['number' => '95%', 'label' => 'Kepuasan'],
                ],
                'is_active' => true,
                'urutan' => 3,
            ],
            [
                'nama' => 'Divisi Vokasi dan Sertifikasi',
                'slug' => 'divisi-vokasi-dan-sertifikasi',
                'header' => 'Vokasi dan Sertifikasi',
                'deskripsi' => '<p>Divisi Vokasi dan Sertifikasi menyediakan program pelatihan dan sertifikasi profesional yang relevan dengan kebutuhan industri.</p>',
                'stats' => [
                    ['number' => '300+', 'label' => 'Lulusan'],
                    ['number' => '15', 'label' => 'Sertifikasi'],
                    ['number' => '80%', 'label' => 'Terserap'],
                    ['number' => '20', 'label' => 'Industri'],
                ],
                'is_active' => true,
                'urutan' => 4,
            ],
            [
                'nama' => 'Divisi Sains Data dan TI',
                'slug' => 'divisi-sains-data-dan-ti',
                'header' => 'Sains Data dan TI',
                'deskripsi' => '<p>Divisi Sains Data dan TI mengembangkan solusi teknologi informasi dan analitik data untuk transformasi digital organisasi modern.</p>',
                'stats' => [
                    ['number' => '100+', 'label' => 'Project'],
                    ['number' => '50', 'label' => 'Klien'],
                    ['number' => '25', 'label' => 'Developer'],
                    ['number' => '99%', 'label' => 'Uptime'],
                ],
                'is_active' => true,
                'urutan' => 5,
            ],
            [
                'nama' => 'Divisi Bahasa, Seni dan Budaya',
                'slug' => 'divisi-bahasa-seni-budaya',
                'header' => 'Bahasa, Seni dan Budaya',
                'deskripsi' => '<p>Divisi Bahasa, Seni dan Budaya melestarikan dan mengembangkan warisan budaya lokal melalui riset dan dokumentasi sistematis.</p>',
                'stats' => [
                    ['number' => '35', 'label' => 'Bahasa'],
                    ['number' => '200+', 'label' => 'Dokumen'],
                    ['number' => '15', 'label' => 'Event'],
                    ['number' => '1000+', 'label' => 'Peserta'],
                ],
                'is_active' => true,
                'urutan' => 6,
            ],
            [
                'nama' => 'Divisi Kerja Sama dan HI',
                'slug' => 'divisi-kerja-sama-dan-hi',
                'header' => 'Kerja Sama dan HI',
                'deskripsi' => '<p>Divisi Kerja Sama dan HI membangun kolaborasi nasional dan internasional untuk memperkuat jaringan akademis dan riset global.</p>',
                'stats' => [
                    ['number' => '50+', 'label' => 'Negara'],
                    ['number' => '100+', 'label' => 'Mitra'],
                    ['number' => '80', 'label' => 'MoU'],
                    ['number' => '200+', 'label' => 'Kolaborasi'],
                ],
                'is_active' => true,
                'urutan' => 7,
            ],
            [
                'nama' => 'Divisi Konsultan',
                'slug' => 'divisi-konsultan',
                'header' => 'Konsultan',
                'deskripsi' => '<p>Divisi Konsultan memberikan layanan konsultasi ahli untuk berbagai kebutuhan organisasi publik dan privat dengan solusi yang terukur.</p>',
                'stats' => [
                    ['number' => '500+', 'label' => 'Klien'],
                    ['number' => '30', 'label' => 'Ahli'],
                    ['number' => '1000+', 'label' => 'Project'],
                    ['number' => '90%', 'label' => 'Sukses'],
                ],
                'is_active' => true,
                'urutan' => 8,
            ],
            [
                'nama' => 'Divisi Karir dan Kewirausahaan',
                'slug' => 'divisi-karir-dan-kewirausahaan',
                'header' => 'Karir dan Kewirausahaan',
                'deskripsi' => '<p>Divisi Karir dan Kewirausahaan mendukung pengembangan karir dan ekosistem kewirausahaan untuk menciptakan entrepreneur muda berbakat.</p>',
                'stats' => [
                    ['number' => '2000+', 'label' => 'Alumni'],
                    ['number' => '300+', 'label' => 'Startup'],
                    ['number' => '50', 'label' => 'Mentee'],
                    ['number' => '95%', 'label' => 'Terserap'],
                ],
                'is_active' => true,
                'urutan' => 9,
            ],
        ];

        foreach ($divisis as $divisi) {
            Divisi::create($divisi);
        }
    }
}