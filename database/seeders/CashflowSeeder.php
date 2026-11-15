<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cashflow;
use App\Models\Program;
use App\Models\Admission;
use Illuminate\Support\Facades\DB;

class CashflowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Cashflow::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $registrations = [
            // November 2026
            [
                'kode'              => 'KM-ADM-2611-001',
                'program_id'        => 4, // Academic Writing
                'nama_pihak'        => 'KadekReady',
                'nominal'           => 250000,
                'tanggal'           => '2026-11-10',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
            ],
            [
                'kode'              => 'KM-ADM-2611-002',
                'program_id'        => 45, // Ausbildung
                'nama_pihak'        => 'Ni Putu Ayu Saraswati',
                'nominal'           => 3500000,
                'total_tagihan'     => 7000000,
                'sisa_piutang'      => 3500000,
                'status'            => 'dp',
                'jatuh_tempo'       => '2026-11-28',
                'tanggal'           => '2026-11-08',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
            ],
            [
                'kode'              => 'KM-ADM-2611-003',
                'program_id'        => 4, // Academic Writing
                'nama_pihak'        => 'I Made Agus Wijaya',
                'nominal'           => 250000,
                'tanggal'           => '2026-11-05',
                'metode'            => 'QRIS / E-Wallet',
            ],
            [
                'kode'              => 'KM-ADM-2611-004',
                'program_id'        => 40, // Data Science
                'nama_pihak'        => 'Ni Luh Putu Sintya Dewi',
                'nominal'           => 1500000,
                'total_tagihan'     => 3000000,
                'sisa_piutang'      => 1500000,
                'status'            => 'dp',
                'jatuh_tempo'       => '2026-11-25',
                'tanggal'           => '2026-11-02',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
            ],
            // Oktober 2026
            [
                'kode'              => 'KM-ADM-2610-001',
                'program_id'        => 40, // Data Science
                'nama_pihak'        => 'I Wayan Gede Pratama',
                'nominal'           => 1500000,
                'tanggal'           => '2026-10-28',
                'metode'            => 'QRIS / E-Wallet',
            ],
            [
                'kode'              => 'KM-ADM-2610-002',
                'program_id'        => 20, // Publikasi Ilmiah
                'nama_pihak'        => 'Made Dwi Anggara',
                'nominal'           => 750000,
                'tanggal'           => '2026-10-15',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
            ],
            [
                'kode'              => 'KM-ADM-2610-003',
                'program_id'        => 49, // TOEFL dan IELTS
                'nama_pihak'        => 'Ketut Raka Pramana',
                'nominal'           => 600000,
                'tanggal'           => '2026-10-09',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
            ],
            // September 2026
            [
                'kode'              => 'KM-ADM-2609-001',
                'program_id'        => 31, // Online School
                'nama_pihak'        => 'Ketut Surya Dharma',
                'nominal'           => 500000,
                'tanggal'           => '2026-09-20',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
            ],
            [
                'kode'              => 'KM-ADM-2609-002',
                'program_id'        => 49, // TOEFL dan IELTS
                'nama_pihak'        => 'Luh Putu Widya Lestari',
                'nominal'           => 600000,
                'tanggal'           => '2026-09-08',
                'metode'            => 'QRIS / E-Wallet',
            ],
            [
                'kode'              => 'KM-ADM-2609-003',
                'program_id'        => 45, // Ausbildung
                'nama_pihak'        => 'I Gede Yudi Antara',
                'nominal'           => 3500000,
                'tanggal'           => '2026-09-02',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
            ],
            // Agustus 2026
            [
                'kode'              => 'KM-ADM-2608-001',
                'program_id'        => 62, // Bimbingan Karir
                'nama_pihak'        => 'I Nyoman Artha Kusuma',
                'nominal'           => 350000,
                'tanggal'           => '2026-08-14',
                'metode'            => 'Tunai (Cash)',
            ],
            [
                'kode'              => 'KM-ADM-2608-002',
                'program_id'        => 4, // Academic Writing
                'nama_pihak'        => 'Ni Kadek Sri Utari',
                'nominal'           => 250000,
                'tanggal'           => '2026-08-06',
                'metode'            => 'QRIS / E-Wallet',
            ],
            // Juli 2026
            [
                'kode'              => 'KM-ADM-2607-001',
                'program_id'        => 22, // Interview Coaching
                'nama_pihak'        => 'Ni Made Dewi Savitri',
                'nominal'           => 450000,
                'tanggal'           => '2026-07-22',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
            ],
            [
                'kode'              => 'KM-ADM-2607-002',
                'program_id'        => 20, // Publikasi Ilmiah
                'nama_pihak'        => 'Dr. I Wayan Sudarta, M.Si',
                'nominal'           => 750000,
                'tanggal'           => '2026-07-10',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
            ],
            // Juni 2026
            [
                'kode'              => 'KM-ADM-2606-001',
                'program_id'        => 16, // Diklat Riset
                'nama_pihak'        => 'Putu Bayu Mahendra',
                'nominal'           => 500000,
                'tanggal'           => '2026-06-18',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
            ],
            [
                'kode'              => 'KM-ADM-2606-002',
                'program_id'        => 31, // Online School
                'nama_pihak'        => 'I Made Ariawan',
                'nominal'           => 500000,
                'tanggal'           => '2026-06-05',
                'metode'            => 'QRIS / E-Wallet',
            ],
            // Mei 2026
            [
                'kode'              => 'KM-ADM-2605-001',
                'program_id'        => 44, // BIPA Program
                'nama_pihak'        => 'Komang Sri Wahyuni',
                'nominal'           => 1200000,
                'tanggal'           => '2026-05-10',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
            ],
            // April 2026
            [
                'kode'              => 'KM-ADM-2604-001',
                'program_id'        => 60, // Inkubator Bisnis
                'nama_pihak'        => 'I Kadek Dwi Putra',
                'nominal'           => 800000,
                'tanggal'           => '2026-04-12',
                'metode'            => 'QRIS / E-Wallet',
            ],
            // Maret 2026
            [
                'kode'              => 'KM-ADM-2603-001',
                'program_id'        => 32, // Private Tutoring
                'nama_pihak'        => 'Desak Made Sintia',
                'nominal'           => 650000,
                'tanggal'           => '2026-03-20',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
            ],
            // Februari 2026
            [
                'kode'              => 'KM-ADM-2602-001',
                'program_id'        => 29, // Diklat SDM
                'nama_pihak'        => 'I Gusti Ngurah Agung',
                'nominal'           => 750000,
                'tanggal'           => '2026-02-15',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
            ],
            // Januari 2026
            [
                'kode'              => 'KM-ADM-2601-001',
                'program_id'        => 58, // Manajemen SDM
                'nama_pihak'        => 'Ni Luh Putu Aryani',
                'nominal'           => 1000000,
                'tanggal'           => '2026-01-25',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
            ],
            [
                'kode'              => 'KM-ADM-2601-002',
                'program_id'        => 18, // Pengajuan HKI
                'nama_pihak'        => 'Ida Bagus Rama Putra',
                'nominal'           => 1500000,
                'tanggal'           => '2026-01-12',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
            ],
        ];

        foreach ($registrations as $r) {
            $prog = Program::find($r['program_id']);
            $progNama = $prog ? $prog->nama : 'Program Khusus';

            $totalTagihan = $r['total_tagihan'] ?? $r['nominal'];
            $sisaPiutang = $r['sisa_piutang'] ?? 0;
            $status = $r['status'] ?? 'lunas';
            $jatuhTempo = $r['jatuh_tempo'] ?? null;

            $cf = Cashflow::create([
                'kode'              => $r['kode'],
                'tipe'              => 'masuk',
                'kode_kategori'     => 'KM-ADM',
                'kategori'          => 'Pendaftaran Siswa / Mahasiswa Baru (Admission)',
                'judul'             => 'Pendaftaran Peserta: ' . $r['nama_pihak'] . ' - ' . $progNama,
                'program_id'        => $r['program_id'],
                'status'            => $status,
                'nominal'           => $r['nominal'],
                'total_tagihan'     => $totalTagihan,
                'sisa_piutang'      => $sisaPiutang,
                'tanggal'           => $r['tanggal'],
                'jatuh_tempo'       => $jatuhTempo,
                'deskripsi'         => $status === 'dp'
                    ? 'Pembayaran DP (Uang Muka) sebesar Rp ' . number_format($r['nominal'], 0, ',', '.') . ' dari total biaya Rp ' . number_format($totalTagihan, 0, ',', '.') . '. Sisa piutang Rp ' . number_format($sisaPiutang, 0, ',', '.') . ' akan dilunasi kemudian.'
                    : 'Pembayaran biaya pendaftaran dan administrasi lunas program ' . $progNama . ' Denpasar Institute atas nama ' . $r['nama_pihak'] . '.',
                'nama_pihak'        => $r['nama_pihak'] . ' (Peserta Program)',
                'metode_pembayaran' => $r['metode'],
                'lampiran'          => null,
                'created_by'        => 1,
            ]);

            if ($r['nama_pihak'] === 'KadekReady') {
                Admission::where('id', 3)->update(['cashflow_id' => $cf->id]);
            }
        }

        $expenses = [
            // November 2026
            [
                'kode'              => 'KK-OPS-2611-001',
                'kode_kategori'     => 'KK-OPS',
                'kategori'          => 'Operasional Kantor, Listrik (PLN), Air & Kebersihan',
                'judul'             => 'Tagihan Listrik PLN & Air Kantor Utama Denpasar Institute - November 2026',
                'nominal'           => 850000,
                'tanggal'           => '2026-11-09',
                'nama_pihak'        => 'PT PLN (Persero) Rayon Denpasar',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
                'deskripsi'         => 'Pembayaran tagihan rekening listrik operasional kantor, laboratorium komputer, dan pendingin ruangan Denpasar Institute periode November 2026.',
            ],
            [
                'kode'              => 'KK-IT-2611-002',
                'kode_kategori'     => 'KK-IT',
                'kategori'          => 'Langganan Internet, Server, Cloud & Software',
                'judul'             => 'Langganan Dedicated Internet Fiber & Hosting Server LMS DI - November 2026',
                'nominal'           => 650000,
                'tanggal'           => '2026-11-06',
                'nama_pihak'        => 'Biznet Networks Bali',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
                'deskripsi'         => 'Biaya bulanan koneksi internet broadband kantor dan perpanjangan cloud VPS untuk platform e-learning & website Denpasar Institute.',
            ],
            [
                'kode'              => 'KK-GJI-2611-003',
                'kode_kategori'     => 'KK-GJI',
                'kategori'          => 'Gaji & Honorarium Pegawai / Dosen / Narasumber',
                'judul'             => 'Honorarium Narasumber Pelatihan Academic Writing & Pengolahan Data Riset',
                'nominal'           => 1500000,
                'tanggal'           => '2026-11-04',
                'nama_pihak'        => 'Dr. I Made Sudarsana, M.Hum (Narasumber)',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
                'deskripsi'         => 'Pemberian honorarium pemateri dan fasilitator pelatihan penulisan artikel ilmiah dan bimbingan riset publikasi.',
            ],
            [
                'kode'              => 'KK-LOG-2611-004',
                'kode_kategori'     => 'KK-LOG',
                'kategori'          => 'Konsumsi & Logistik Acara / Pelatihan / Rapat',
                'judul'             => 'Konsumsi Rapat Evaluasi Kurikulum Semester & Snack Peserta Workshop',
                'nominal'           => 450000,
                'tanggal'           => '2026-11-03',
                'nama_pihak'        => 'Catering Satria Denpasar',
                'metode'            => 'QRIS / E-Wallet',
                'deskripsi'         => 'Penyediaan snack box dan makan siang rapat koordinasi pengurus serta pendampingan peserta baru.',
            ],

            // Oktober 2026
            [
                'kode'              => 'KK-OPS-2610-001',
                'kode_kategori'     => 'KK-OPS',
                'kategori'          => 'Operasional Kantor, Listrik (PLN), Air & Kebersihan',
                'judul'             => 'Tagihan Rekening Listrik PLN & Kebersihan Kantor - Oktober 2026',
                'nominal'           => 820000,
                'tanggal'           => '2026-10-25',
                'nama_pihak'        => 'PT PLN (Persero) Rayon Denpasar',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
                'deskripsi'         => 'Biaya listrik operasional bulanan gedung kantor Denpasar Institute.',
            ],
            [
                'kode'              => 'KK-IT-2610-002',
                'kode_kategori'     => 'KK-IT',
                'kategori'          => 'Langganan Internet, Server, Cloud & Software',
                'judul'             => 'Langganan Internet Kantor & Perpanjangan Domain Web Lembaga',
                'nominal'           => 700000,
                'tanggal'           => '2026-10-07',
                'nama_pihak'        => 'Biznet Networks & Registrar Domain',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
                'deskripsi'         => 'Perpanjangan domain resmi dan koneksi internet fiber.',
            ],

            // September 2026
            [
                'kode'              => 'KK-OPS-2609-001',
                'kode_kategori'     => 'KK-OPS',
                'kategori'          => 'Operasional Kantor, Listrik (PLN), Air & Kebersihan',
                'judul'             => 'Pembayaran Listrik PLN & Air Kantor Denpasar Institute',
                'nominal'           => 810000,
                'tanggal'           => '2026-09-24',
                'nama_pihak'        => 'PT PLN (Persero)',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
                'deskripsi'         => 'Operasional listrik dan air kantor bulan September 2026.',
            ],
            [
                'kode'              => 'KK-GJI-2609-002',
                'kode_kategori'     => 'KK-GJI',
                'kategori'          => 'Gaji & Honorarium Pegawai / Dosen / Narasumber',
                'judul'             => 'Honorarium Instruktur Kursus Bahasa Asing & Persiapan Ausbildung',
                'nominal'           => 1200000,
                'tanggal'           => '2026-09-12',
                'nama_pihak'        => 'Ni Putu Desi Ratnawati, S.Pd',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
                'deskripsi'         => 'Honor pengajaran intensif bahasa dan pembekalan materi wawancara.',
            ],

            // Agustus 2026
            [
                'kode'              => 'KK-OPS-2608-001',
                'kode_kategori'     => 'KK-OPS',
                'kategori'          => 'Operasional Kantor, Listrik (PLN), Air & Kebersihan',
                'judul'             => 'Tagihan Listrik PLN & Air Kantor DI - Agustus 2026',
                'nominal'           => 790000,
                'tanggal'           => '2026-08-22',
                'nama_pihak'        => 'PT PLN (Persero)',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
                'deskripsi'         => 'Operasional listrik dan pendingin ruangan.',
            ],
            [
                'kode'              => 'KK-MOD-2608-002',
                'kode_kategori'     => 'KK-MOD',
                'kategori'          => 'Pengadaan Buku, Modul Ajar & Perlengkapan Riset',
                'judul'             => 'Cetak Buku Modul Ajar & Panduan Riset Mahasiswa',
                'nominal'           => 550000,
                'tanggal'           => '2026-08-08',
                'nama_pihak'        => 'Percetakan Guna Media Bali',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
                'deskripsi'         => 'Pengadaan bahan ajar modul cetak dan buku pegangan peserta.',
            ],

            // Juli 2026
            [
                'kode'              => 'KK-OPS-2607-001',
                'kode_kategori'     => 'KK-OPS',
                'kategori'          => 'Operasional Kantor, Listrik (PLN), Air & Kebersihan',
                'judul'             => 'Tagihan Listrik PLN & Pemeliharaan Sanitasi Kantor',
                'nominal'           => 780000,
                'tanggal'           => '2026-07-20',
                'nama_pihak'        => 'PT PLN (Persero)',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
                'deskripsi'         => 'Biaya utilitas kantor dan ruang diklat.',
            ],
            [
                'kode'              => 'KK-MKT-2607-002',
                'kode_kategori'     => 'KK-MKT',
                'kategori'          => 'Biaya Pemasaran, Iklan Sosial Media & Brosur',
                'judul'             => 'Biaya Iklan Digital Pendaftaran Gelombang Baru & Brosur Program',
                'nominal'           => 500000,
                'tanggal'           => '2026-07-05',
                'nama_pihak'        => 'Meta Advertising Platform',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
                'deskripsi'         => 'Kampanye promosi penerimaan siswa dan pendaftar kursus.',
            ],

            // Juni 2026
            [
                'kode'              => 'KK-OPS-2606-001',
                'kode_kategori'     => 'KK-OPS',
                'kategori'          => 'Operasional Kantor, Listrik (PLN), Air & Kebersihan',
                'judul'             => 'Tagihan Listrik PLN Kantor Denpasar Institute',
                'nominal'           => 770000,
                'tanggal'           => '2026-06-21',
                'nama_pihak'        => 'PT PLN (Persero)',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
                'deskripsi'         => 'Beban listrik kantor periode Juni 2026.',
            ],

            // Mei 2026
            [
                'kode'              => 'KK-OPS-2605-001',
                'kode_kategori'     => 'KK-OPS',
                'kategori'          => 'Operasional Kantor, Listrik (PLN), Air & Kebersihan',
                'judul'             => 'Tagihan Listrik PLN & Air Kantor DI',
                'nominal'           => 760000,
                'tanggal'           => '2026-05-18',
                'nama_pihak'        => 'PT PLN (Persero)',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
                'deskripsi'         => 'Beban listrik kantor periode Mei 2026.',
            ],

            // April 2026
            [
                'kode'              => 'KK-OPS-2604-001',
                'kode_kategori'     => 'KK-OPS',
                'kategori'          => 'Operasional Kantor, Listrik (PLN), Air & Kebersihan',
                'judul'             => 'Biaya Listrik PLN & Perawatan Berkala AC Kantor',
                'nominal'           => 850000,
                'tanggal'           => '2026-04-15',
                'nama_pihak'        => 'PT PLN & Teknisi AC Bali Sejuk',
                'metode'            => 'Tunai (Cash)',
                'deskripsi'         => 'Service AC ruang pelatihan dan tagihan listrik PLN.',
            ],

            // Maret 2026
            [
                'kode'              => 'KK-OPS-2603-001',
                'kode_kategori'     => 'KK-OPS',
                'kategori'          => 'Operasional Kantor, Listrik (PLN), Air & Kebersihan',
                'judul'             => 'Tagihan Listrik PLN & Air Kantor DI',
                'nominal'           => 740000,
                'tanggal'           => '2026-03-21',
                'nama_pihak'        => 'PT PLN (Persero)',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
                'deskripsi'         => 'Beban listrik kantor periode Maret 2026.',
            ],

            // Februari 2026
            [
                'kode'              => 'KK-OPS-2602-001',
                'kode_kategori'     => 'KK-OPS',
                'kategori'          => 'Operasional Kantor, Listrik (PLN), Air & Kebersihan',
                'judul'             => 'Tagihan Listrik PLN Kantor DI',
                'nominal'           => 730000,
                'tanggal'           => '2026-02-18',
                'nama_pihak'        => 'PT PLN (Persero)',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
                'deskripsi'         => 'Beban listrik kantor periode Februari 2026.',
            ],

            // Januari 2026
            [
                'kode'              => 'KK-OPS-2601-001',
                'kode_kategori'     => 'KK-OPS',
                'kategori'          => 'Operasional Kantor, Listrik (PLN), Air & Kebersihan',
                'judul'             => 'Tagihan Listrik PLN & Biaya Notaris Perpanjangan Legalitas',
                'nominal'           => 1200000,
                'tanggal'           => '2026-01-16',
                'nama_pihak'        => 'PT PLN & Kantor Notaris Denpasar',
                'metode'            => 'Transfer Bank (BCA / Mandiri / BNI / BRI)',
                'deskripsi'         => 'Biaya operasional awal tahun dan pengurusan dokumen legal kelembagaan.',
            ],
        ];

        foreach ($expenses as $ex) {
            Cashflow::create([
                'kode'              => $ex['kode'],
                'tipe'              => 'keluar',
                'kode_kategori'     => $ex['kode_kategori'],
                'kategori'          => $ex['kategori'],
                'judul'             => $ex['judul'],
                'program_id'        => null,
                'status'            => 'lunas',
                'nominal'           => $ex['nominal'],
                'total_tagihan'     => $ex['nominal'],
                'sisa_piutang'      => 0,
                'tanggal'           => $ex['tanggal'],
                'jatuh_tempo'       => null,
                'deskripsi'         => $ex['deskripsi'],
                'nama_pihak'        => $ex['nama_pihak'],
                'metode_pembayaran' => $ex['metode'],
                'lampiran'          => null,
                'created_by'        => 1,
            ]);
        }
    }
}
