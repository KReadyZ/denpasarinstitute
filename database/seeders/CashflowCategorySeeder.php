<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CashflowCategory;

class CashflowCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Pemasukan (KM)
            [
                'tipe'      => 'masuk',
                'kode'      => 'KM-ADM',
                'nama'      => 'Pendaftaran Siswa / Mahasiswa Baru (Admission)',
                'deskripsi' => 'Penerimaan biaya pendaftaran, formulir, dan registrasi mahasiswa/siswa baru.',
                'urutan'    => 1,
                'is_active' => true,
            ],
            [
                'tipe'      => 'masuk',
                'kode'      => 'KM-PLT',
                'nama'      => 'Biaya Pelatihan, Workshop & Masterclass',
                'deskripsi' => 'Pemasukan dari peserta pelatihan, workshop SDM, sertifikasi soft skill, dan seminar.',
                'urutan'    => 2,
                'is_active' => true,
            ],
            [
                'tipe'      => 'masuk',
                'kode'      => 'KM-SRT',
                'nama'      => 'Uji Kompetensi & Sertifikasi BNSP / Profesi',
                'deskripsi' => 'Biaya asesmen, uji kompetensi vokasi, dan sertifikasi profesi resmi BNSP.',
                'urutan'    => 3,
                'is_active' => true,
            ],
            [
                'tipe'      => 'masuk',
                'kode'      => 'KM-KNS',
                'nama'      => 'Layanan Konsultasi & Riset Lembaga',
                'deskripsi' => 'Pendapatan jasa konsultasi manajemen, studi kelayakan, survei, dan riset kelembagaan.',
                'urutan'    => 4,
                'is_active' => true,
            ],
            [
                'tipe'      => 'masuk',
                'kode'      => 'KM-PUB',
                'nama'      => 'Penerbitan Buku Ber-ISBN, ISSN & Jurnal',
                'deskripsi' => 'Biaya penerbitan buku ilmiah, monograf, prosiding, pengurusan ISBN, dan publikasi jurnal (Ijolida & Yaguwipa).',
                'urutan'    => 5,
                'is_active' => true,
            ],
            [
                'tipe'      => 'masuk',
                'kode'      => 'KM-MTR',
                'nama'      => 'Kemitraan, Kerja Sama & Sponsorship Industri',
                'deskripsi' => 'Dana kerja sama industri, sponsorship program, hibah, dan MoU kemitraan strategis.',
                'urutan'    => 6,
                'is_active' => true,
            ],
            [
                'tipe'      => 'masuk',
                'kode'      => 'KM-BRS',
                'nama'      => 'Biaya Pasang Lowongan Bursa SDM Perusahaan',
                'deskripsi' => 'Biaya publikasi lowongan kerja, rekrutmen eksklusif, dan penempatan tenaga kerja mitra industri.',
                'urutan'    => 7,
                'is_active' => true,
            ],
            [
                'tipe'      => 'masuk',
                'kode'      => 'KM-SWF',
                'nama'      => 'Sewa Laboratorium, Ruang Kelas & Aula Diklat',
                'deskripsi' => 'Penyewaan fasilitas fisik gedung, ruang komputer, laboratorium riset, dan aula kegiatan.',
                'urutan'    => 8,
                'is_active' => true,
            ],
            [
                'tipe'      => 'masuk',
                'kode'      => 'KM-LLN',
                'nama'      => 'Pemasukan Lain-lain',
                'deskripsi' => 'Pemasukan kas lainnya yang belum terkategori dalam divisi utama.',
                'urutan'    => 9,
                'is_active' => true,
            ],

            // Pengeluaran (KK)
            [
                'tipe'      => 'keluar',
                'kode'      => 'KK-GJI',
                'nama'      => 'Gaji & Honorarium Pegawai / Dosen / Narasumber',
                'deskripsi' => 'Pembayaran gaji pokok, honor narasumber, instruktur, dosen tamu, lembur, dan tunjangan pegawai.',
                'urutan'    => 1,
                'is_active' => true,
            ],
            [
                'tipe'      => 'keluar',
                'kode'      => 'KK-OPS',
                'nama'      => 'Operasional Kantor, Listrik (PLN), Air & Kebersihan',
                'deskripsi' => 'Pembayaran tagihan listrik PLN, PDAM, iuran lingkungan, kebersihan, dan ATK kantor rutin.',
                'urutan'    => 2,
                'is_active' => true,
            ],
            [
                'tipe'      => 'keluar',
                'kode'      => 'KK-IT',
                'nama'      => 'Langganan Internet, Server, Cloud & Software',
                'deskripsi' => 'Biaya koneksi internet fiber, cloud hosting website, domain, lisensi software, dan infrastruktur TI.',
                'urutan'    => 3,
                'is_active' => true,
            ],
            [
                'tipe'      => 'keluar',
                'kode'      => 'KK-LOG',
                'nama'      => 'Konsumsi & Logistik Acara / Pelatihan / Rapat',
                'deskripsi' => 'Konsumsi snack, makan siang peserta, coffee break, banner fisik, dan kelengkapan rapat koordinasi.',
                'urutan'    => 4,
                'is_active' => true,
            ],
            [
                'tipe'      => 'keluar',
                'kode'      => 'KK-MOD',
                'nama'      => 'Pengadaan Buku, Modul Ajar & Perlengkapan Riset',
                'deskripsi' => 'Biaya cetak modul pelatihan, pengadaan buku pustaka riset, dan instrumen pengujian riset.',
                'urutan'    => 5,
                'is_active' => true,
            ],
            [
                'tipe'      => 'keluar',
                'kode'      => 'KK-MNT',
                'nama'      => 'Pemeliharaan Gedung, AC & Sarana Prasarana',
                'deskripsi' => 'Servis AC berkala, perbaikan sarana gedung, pengecatan, dan perbaikan perangkat pendukung.',
                'urutan'    => 6,
                'is_active' => true,
            ],
            [
                'tipe'      => 'keluar',
                'kode'      => 'KK-MKT',
                'nama'      => 'Biaya Pemasaran, Iklan Sosial Media & Brosur',
                'deskripsi' => 'Iklan digital (Meta Ads, Google Ads), cetak brosur promosi pendaftaran, dan merchandise branding.',
                'urutan'    => 7,
                'is_active' => true,
            ],
            [
                'tipe'      => 'keluar',
                'kode'      => 'KK-LEG',
                'nama'      => 'Biaya Notaris, Pajak & Legalitas Kelembagaan',
                'deskripsi' => 'Pengurusan akta notaris, pembayaran pajak institusi, dan perpanjangan izin operasional lembaga.',
                'urutan'    => 8,
                'is_active' => true,
            ],
            [
                'tipe'      => 'keluar',
                'kode'      => 'KK-LLN',
                'nama'      => 'Pengeluaran Lain-lain',
                'deskripsi' => 'Pengeluaran kas operasional tak terduga lainnya.',
                'urutan'    => 9,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $cat) {
            CashflowCategory::updateOrCreate(
                ['kode' => $cat['kode']],
                $cat
            );
        }
    }
}

