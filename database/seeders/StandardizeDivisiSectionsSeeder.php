<?php

namespace Database\Seeders;

use App\Models\Divisi;
use App\Models\DivisiSection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StandardizeDivisiSectionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::beginTransaction();

        try {
            // 1. DIVISI 11: Divisi Riset dan Inovasi (Benchmark)
            $d11 = Divisi::find(11);
            if ($d11) {
                $sTentang = DivisiSection::where('divisi_id', 11)->where('section_name', 'like', '%tentang%')->first();
                if ($sTentang) {
                    $sTentang->update(['urutan' => 1, 'position_after' => 'before_program', 'design_style' => 'light']);
                }
                $sKeunggulan = DivisiSection::where('divisi_id', 11)->where('section_name', 'like', '%keunggulan%')->first();
                if ($sKeunggulan) {
                    $sKeunggulan->update(['urutan' => 2, 'position_after' => 'before_program', 'design_style' => 'accent']);
                }
                $sKolaborasi = DivisiSection::where('divisi_id', 11)->where('section_name', 'like', '%kolaborasi%')->first();
                if ($sKolaborasi) {
                    $sKolaborasi->update(['urutan' => 3, 'position_after' => 'after_program', 'design_style' => 'accent']);
                }
            }

            // 2. DIVISI 12: Divisi Publikasi dan HKI
            $d12 = Divisi::find(12);
            if ($d12) {
                $sTentang = DivisiSection::where('divisi_id', 12)->where('section_name', 'like', '%tentang%')->first();
                if ($sTentang) {
                    $sTentang->update(['urutan' => 1, 'position_after' => 'before_program', 'design_style' => 'light']);
                }
                
                $sKeunggulan = DivisiSection::firstOrNew(['divisi_id' => 12, 'section_name' => 'Keunggulan Divisi']);
                $sKeunggulan->urutan = 2;
                $sKeunggulan->position_after = 'before_program';
                $sKeunggulan->design_style = 'accent';
                $sKeunggulan->is_active = 1;
                $sKeunggulan->content = '<p><span style="font-size: 16px;">Keunggulan Divisi Publikasi dan HKI terletak pada pendampingan menyeluruh serta ekosistem penerbitan ilmiah yang terpercaya, didukung oleh:</span></p><ul><li><span style="font-size: 16px;">Pengelolaan jurnal ilmiah bereputasi dengan standar akreditasi nasional (SINTA) dan indeksasi internasional.</span></li><li><span style="font-size: 16px;">Pendampingan pendaftaran Hak Cipta, Paten, Merek, dan Desain Industri secara cepat dan terintegrasi dengan DJKI Kemenkumham RI.</span></li><li><span style="font-size: 16px;">Dukungan Digital Object Identifier (DOI Crossref), sistem peer-review profesional, serta sertifikasi orisinalitas karya bebas plagiarisme.</span></li><li><span style="font-size: 16px;">Jaringan reviewer dan editor ahli lintas universitas dan lembaga riset di tingkat nasional maupun internasional.</span></li></ul>';
                $sKeunggulan->save();

                $sKolaborasi = DivisiSection::firstOrNew(['divisi_id' => 12, 'section_name' => 'Kolaborasi dan Keanggotaan']);
                $sKolaborasi->urutan = 3;
                $sKolaborasi->position_after = 'after_program';
                $sKolaborasi->design_style = 'accent';
                $sKolaborasi->is_active = 1;
                $sKolaborasi->content = '<p><span style="font-size: 16px;">Divisi Publikasi dan HKI Denpasar Institute mengundang akademisi, dosen, peneliti, dan praktisi untuk bergabung dalam <strong style="font-weight: bold;">Dewan Editorial Jurnal, Peer Reviewer Ahli, atau Penulis Kontributor</strong>. Partisipasi aktif Anda mempercepat hilirisasi ilmu pengetahuan dan inovasi bagi kemaslahatan masyarakat luas.</span></p><p><span style="font-size: 16px;">Kami juga membuka kemitraan institusional bagi universitas, pusat studi, dan lembaga riset dalam pengelolaan prosiding seminar internasional, indeksasi jurnal, serta pendampingan HKI sivitas akademika.</span></p><p><span style="font-size: 16px;">Bersama Denpasar Institute, amankan dan diseminasikan karya intelektual Anda ke panggung akademik nasional dan global.</span></p>';
                $sKolaborasi->save();
            }

            // 3. DIVISI 13: Divisi Pengembangan SDM
            $d13 = Divisi::find(13);
            if ($d13) {
                $sTentang = DivisiSection::where('divisi_id', 13)->where('section_name', 'like', '%tentang%')->first();
                if ($sTentang) {
                    $sTentang->update(['urutan' => 1, 'position_after' => 'before_program', 'design_style' => 'light']);
                }
                
                $sKeunggulan = DivisiSection::firstOrNew(['divisi_id' => 13, 'section_name' => 'Keunggulan Divisi']);
                $sKeunggulan->urutan = 2;
                $sKeunggulan->position_after = 'before_program';
                $sKeunggulan->design_style = 'accent';
                $sKeunggulan->is_active = 1;
                $sKeunggulan->content = '<p><span style="font-size: 16px;">Keunggulan Divisi Pengembangan SDM terletak pada kurikulum berbasis kompetensi masa depan dan pendekatan pelatihan yang aplikatif, didukung oleh:</span></p><ul><li><span style="font-size: 16px;">Program training dan workshop yang dirancang khusus (customized corporate training) sesuai kebutuhan riil industri dan organisasi.</span></li><li><span style="font-size: 16px;">Metode pembelajaran interaktif memadukan studi kasus nyata, simulasi kepemimpinan, dan adaptasi AI di tempat kerja.</span></li><li><span style="font-size: 16px;">Fasilitator dan master trainer bersertifikasi dengan pengalaman praktis puluhan tahun di korporasi dan institusi publik.</span></li><li><span style="font-size: 16px;">Evaluasi berkala terhadap dampak pelatihan (training impact evaluation) guna memastikan peningkatan kinerja nyata.</span></li></ul>';
                $sKeunggulan->save();

                $sKolaborasi = DivisiSection::firstOrNew(['divisi_id' => 13, 'section_name' => 'Kolaborasi dan Keanggotaan']);
                $sKolaborasi->urutan = 3;
                $sKolaborasi->position_after = 'after_program';
                $sKolaborasi->design_style = 'accent';
                $sKolaborasi->is_active = 1;
                $sKolaborasi->content = '<p><span style="font-size: 16px;">Divisi Pengembangan SDM Denpasar Institute membuka kesempatan bagi para profesional, trainer independen, dan konsultan HR untuk bergabung sebagai <strong style="font-weight: bold;">Master Trainer, Fasilitator Workshop, atau Asesor Kompetensi</strong>.</span></p><p><span style="font-size: 16px;">Kami juga menjalin kemitraan strategis dengan BUMN, instansi pemerintah, rumah sakit, dan korporasi swasta dalam perancangan program talent development, leadership pipeline, serta continuous improvement tim kerja.</span></p><p><span style="font-size: 16px;">Mari wujudkan SDM unggul dan berdaya saing tinggi demi kemajuan berkelanjutan institusi Anda.</span></p>';
                $sKolaborasi->save();
            }

            // 4. DIVISI 14: Divisi Vokasi dan Sertifikasi
            $d14 = Divisi::find(14);
            if ($d14) {
                $sTentang = DivisiSection::where('divisi_id', 14)->where('section_name', 'like', '%tentang%')->first();
                if ($sTentang) {
                    $sTentang->update(['urutan' => 1, 'position_after' => 'before_program', 'design_style' => 'light']);
                }

                $sKeunggulan = DivisiSection::firstOrNew(['divisi_id' => 14, 'section_name' => 'Keunggulan Divisi']);
                $sKeunggulan->urutan = 2;
                $sKeunggulan->position_after = 'before_program';
                $sKeunggulan->design_style = 'accent';
                $sKeunggulan->is_active = 1;
                $sKeunggulan->content = '<p><span style="font-size: 16px;">Keunggulan Divisi Vokasi dan Sertifikasi terletak pada pengakuan kompetensi resmi berstandar nasional dan kesiapan kerja lulusan, didukung oleh:</span></p><ul><li><span style="font-size: 16px;">Kerja sama erat dengan Lembaga Sertifikasi Profesi (LSP) terlisensi BNSP Republik Indonesia.</span></li><li><span style="font-size: 16px;">Kurikulum vokasi berbasis Standar Kompetensi Kerja Nasional Indonesia (SKKNI) dan standar industri global.</span></li><li><span style="font-size: 16px;">Instruktur praktisi berpengalaman dan Tempat Uji Kompetensi (TUK) yang terstandarisasi serta representatif.</span></li><li><span style="font-size: 16px;">Penyaluran dan rekomendasi kerja bagi lulusan yang telah teruji kompetensinya di berbagai sektor unggulan industri kreatif dan pariwisata.</span></li></ul>';
                $sKeunggulan->save();

                $sKolaborasi = DivisiSection::firstOrNew(['divisi_id' => 14, 'section_name' => 'Kolaborasi dan Keanggotaan']);
                $sKolaborasi->urutan = 3;
                $sKolaborasi->position_after = 'after_program';
                $sKolaborasi->design_style = 'accent';
                $sKolaborasi->is_active = 1;
                $sKolaborasi->content = '<p><span style="font-size: 16px;">Divisi Vokasi dan Sertifikasi Denpasar Institute membuka ruang kolaborasi bagi asosiasi profesi, SMK/politeknik, serta dunia usaha dan dunia industri (DUDI) untuk bergabung sebagai <strong style="font-weight: bold;">Mitra Tempat Uji Kompetensi (TUK), Asesor Lisensi, atau Industri Pengguna Lulusan</strong>.</span></p><p><span style="font-size: 16px;">Kami juga memfasilitasi program link and match pendidikan vokasi dengan sertifikasi profesi berskala nasional guna menjamin keterserapan lulusan di dunia kerja.</span></p><p><span style="font-size: 16px;">Kami berkomitmen mencetak tenaga kerja profesional yang siap kerja, beretika, dan bersertifikasi resmi.</span></p>';
                $sKolaborasi->save();
            }

            // 5. DIVISI 15: Divisi Sains Data dan TI
            $d15 = Divisi::find(15);
            if ($d15) {
                $sTentang = DivisiSection::where('divisi_id', 15)->where('section_name', 'like', '%tentang%')->first();
                if ($sTentang) {
                    $sTentang->update(['urutan' => 1, 'position_after' => 'before_program', 'design_style' => 'light']);
                }

                $sKeunggulan = DivisiSection::firstOrNew(['divisi_id' => 15, 'section_name' => 'Keunggulan Divisi']);
                $sKeunggulan->urutan = 2;
                $sKeunggulan->position_after = 'before_program';
                $sKeunggulan->design_style = 'accent';
                $sKeunggulan->is_active = 1;
                $sKeunggulan->content = '<p><span style="font-size: 16px;">Keunggulan Divisi Sains Data dan TI terletak pada keandalan infrastruktur analitik dan transformasi digital terintegrasi, didukung oleh:</span></p><ul><li><span style="font-size: 16px;">Kapabilitas data science modern meliputi data mining, machine learning, predictive analytics, dan business intelligence.</span></li><li><span style="font-size: 16px;">Pengembangan sistem informasi pendidikan dan manajemen terpadu (SIDIK, SIMAS, E-Office, dan Repository Digital).</span></li><li><span style="font-size: 16px;">Layanan statistik komprehensif, uji validitas data penelitian, dan audit sistem teknologi informasi independen.</span></li><li><span style="font-size: 16px;">Laboratorium komputasi data dan tim data engineer bersertifikasi yang siap mendampingi riset serta digitalisasi organisasi.</span></li></ul>';
                $sKeunggulan->save();

                $sKolaborasi = DivisiSection::firstOrNew(['divisi_id' => 15, 'section_name' => 'Kolaborasi dan Keanggotaan']);
                $sKolaborasi->urutan = 3;
                $sKolaborasi->position_after = 'after_program';
                $sKolaborasi->design_style = 'accent';
                $sKolaborasi->is_active = 1;
                $sKolaborasi->content = '<p><span style="font-size: 16px;">Divisi Sains Data dan TI Denpasar Institute mengundang para saintis data, software engineer, data analyst, dan praktisi IT untuk berkolaborasi sebagai <strong style="font-weight: bold;">Tenaga Ahli IT, Konsultan Sistem Informasi, atau Instruktur Data Science</strong>.</span></p><p><span style="font-size: 16px;">Kami juga melayani kemitraan instansi pemerintah, BUMD, dan perguruan tinggi dalam perancangan roadmap transformasi digital, audit sistem, serta pengolahan big data strategis.</span></p><p><span style="font-size: 16px;">Bersama kami, hubungkan data dengan keputusan strategis yang presisi dan berdampak luas.</span></p>';
                $sKolaborasi->save();
            }

            // 6. DIVISI 16: Divisi Bahasa, Seni dan Budaya
            $d16 = Divisi::find(16);
            if ($d16) {
                $sTentang = DivisiSection::where('divisi_id', 16)->where('section_name', 'like', '%tentang%')->first();
                if ($sTentang) {
                    $sTentang->update(['urutan' => 1, 'position_after' => 'before_program', 'design_style' => 'light']);
                }

                $sKeunggulan = DivisiSection::firstOrNew(['divisi_id' => 16, 'section_name' => 'Keunggulan Divisi']);
                $sKeunggulan->urutan = 2;
                $sKeunggulan->position_after = 'before_program';
                $sKeunggulan->design_style = 'accent';
                $sKeunggulan->is_active = 1;
                $sKeunggulan->content = '<p><span style="font-size: 16px;">Keunggulan Divisi Bahasa, Seni dan Budaya terletak pada harmonisasi penguasaan bahasa global dan pelestarian kearifan lokal, didukung oleh:</span></p><ul><li><span style="font-size: 16px;">Program layanan bahasa berdasarkan Classroom Action Research dan Kajian Empiris yang teruji.</span></li><li><span style="font-size: 16px;">Ruang kelas ber-AC yang nyaman, representatif, serta dilengkapi fasilitas multimedia modern.</span></li><li><span style="font-size: 16px;">Pengajar bergelar Master, lulusan dalam dan luar negeri, serta mengantongi skor resmi TOEFL / IELTS tinggi.</span></li><li><span style="font-size: 16px;">Silabus berstandar internasional dengan modul intensif dan simulasi tes berkala (Diagnostic Test).</span></li><li><span style="font-size: 16px;">Workshop kebudayaan dan seni tradisi Bali yang edukatif bagi pembelajar domestik maupun mancanegara.</span></li></ul>';
                $sKeunggulan->save();

                $sKolaborasi = DivisiSection::firstOrNew(['divisi_id' => 16, 'section_name' => 'Kolaborasi dan Keanggotaan']);
                $sKolaborasi->urutan = 3;
                $sKolaborasi->position_after = 'after_program';
                $sKolaborasi->design_style = 'accent';
                $sKolaborasi->is_active = 1;
                $sKolaborasi->content = '<p><span style="font-size: 16px;">Divisi Bahasa, Seni dan Budaya Denpasar Institute menyambut para pengajar bahasa, pegiat seni tradisi, budayawan, dan penerjemah tersumpah untuk berpartisipasi sebagai <strong style="font-weight: bold;">Instruktur Bahasa, Pengajar BIPA, Budayawan Mitra, atau Penerjemah Resmi</strong>.</span></p><p><span style="font-size: 16px;">Kami juga menyelenggarakan program kemitraan kursus bahasa in-house bagi instansi perhotelan, pemerintahan, serta program pertukaran budaya internasional.</span></p><p><span style="font-size: 16px;">Perluas wawasan dan komunikasi global Anda bersama Denpasar Institute tanpa kehilangan akar kearifan nusantara.</span></p>';
                $sKolaborasi->save();
            }

            // 7. DIVISI 17: Divisi Kerja Sama dan HI
            $d17 = Divisi::find(17);
            if ($d17) {
                $sTentang = DivisiSection::where('divisi_id', 17)->where('section_name', 'like', '%tentang%')->first();
                if ($sTentang) {
                    $sTentang->update(['urutan' => 1, 'position_after' => 'before_program', 'design_style' => 'light']);
                }

                $sKeunggulan = DivisiSection::firstOrNew(['divisi_id' => 17, 'section_name' => 'Keunggulan Divisi']);
                $sKeunggulan->urutan = 2;
                $sKeunggulan->position_after = 'before_program';
                $sKeunggulan->design_style = 'accent';
                $sKeunggulan->is_active = 1;
                $sKeunggulan->content = '<p><span style="font-size: 16px;">Keunggulan Divisi Kerja Sama dan Hubungan Internasional terletak pada jejaring kemitraan lintas batas yang kuat dan berdampak strategis, didukung oleh:</span></p><ul><li><span style="font-size: 16px;">Jaringan kemitraan aktif dengan universitas, konsulat, lembaga donor, dan organisasi internasional terkemuka.</span></li><li><span style="font-size: 16px;">Pendampingan legal dan formalisasi kerja sama (MoU, MoA, Implementation Agreement) yang terstruktur dan terarah.</span></li><li><span style="font-size: 16px;">Fasilitasi program pertukaran sivitas (student exchange & staff mobility), riset kolaboratif global, dan joint conference.</span></li><li><span style="font-size: 16px;">Dukungan diplomasi akademik dan akselerasi pencapaian reputasi internasional institusi mitra.</span></li></ul>';
                $sKeunggulan->save();

                $sKolaborasi = DivisiSection::firstOrNew(['divisi_id' => 17, 'section_name' => 'Kolaborasi dan Keanggotaan']);
                $sKolaborasi->urutan = 3;
                $sKolaborasi->position_after = 'after_program';
                $sKolaborasi->design_style = 'accent';
                $sKolaborasi->is_active = 1;
                $sKolaborasi->content = '<p><span style="font-size: 16px;">Divisi Kerja Sama dan HI membuka pintu selebar-lebarnya bagi institusi pendidikan tinggi, lembaga riset luar negeri, konsulat jenderal, dan NGO internasional untuk bergabung dalam <strong style="font-weight: bold;">Konsorsium Riset Global, Kemitraan Strategis, atau Program Mobilitas Akademik</strong>.</span></p><p><span style="font-size: 16px;">Hubungi tim Hubungan Internasional kami untuk merancang inisiasi kerja sama bilateral maupun multilateral yang saling menguntungkan.</span></p><p><span style="font-size: 16px;">Bersama kita bangun jembatan kolaborasi global yang berakar pada kearifan lokal Bali dan Nusantara.</span></p>';
                $sKolaborasi->save();
            }

            // 8. DIVISI 18: Divisi Konsultan
            $d18 = Divisi::find(18);
            if ($d18) {
                $sTentang = DivisiSection::where('divisi_id', 18)->where('section_name', 'like', '%tentang%')->first();
                if ($sTentang) {
                    $sTentang->update(['urutan' => 1, 'position_after' => 'before_program', 'design_style' => 'light']);
                }

                $sKeunggulan = DivisiSection::firstOrNew(['divisi_id' => 18, 'section_name' => 'Keunggulan Divisi']);
                $sKeunggulan->urutan = 2;
                $sKeunggulan->position_after = 'before_program';
                $sKeunggulan->design_style = 'accent';
                $sKeunggulan->is_active = 1;
                $sKeunggulan->content = '<p><span style="font-size: 16px;">Keunggulan Divisi Konsultan terletak pada ketajaman analisis multidisiplin dan solusi strategis yang dapat diimplementasikan secara konkret, didukung oleh:</span></p><ul><li><span style="font-size: 16px;">Tim konsultan senior bergelar doktor dan master dari berbagai bidang kepakaran (kebijakan publik, manajemen, hukum, dan ekonomi bisnis).</span></li><li><span style="font-size: 16px;">Metodologi konsultasi berbasis bukti (evidence-based advisory) yang obyektif, independen, dan terukur.</span></li><li><span style="font-size: 16px;">Penyusunan naskah akademik, studi kelayakan (feasibility study), rencana strategis (Renstra), dan evaluasi kebijakan yang komprehensif.</span></li><li><span style="font-size: 16px;">Komitmen kerahasiaan data tingkat tinggi dengan penerapan integritas etika profesi yang ketat.</span></li></ul>';
                $sKeunggulan->save();

                $sKolaborasi = DivisiSection::firstOrNew(['divisi_id' => 18, 'section_name' => 'Kolaborasi dan Keanggotaan']);
                $sKolaborasi->urutan = 3;
                $sKolaborasi->position_after = 'after_program';
                $sKolaborasi->design_style = 'accent';
                $sKolaborasi->is_active = 1;
                $sKolaborasi->content = '<p><span style="font-size: 16px;">Divisi Konsultan Denpasar Institute membuka kesempatan bagi para akademisi pakar, praktisi berpengalaman, dan analis kebijakan untuk bergabung sebagai <strong style="font-weight: bold;">Lead Consultant, Tenaga Ahli Bidang, atau Penasihat Strategis</strong>.</span></p><p><span style="font-size: 16px;">Kami juga siap mendampingi kementerian, pemerintah daerah, badan usaha, dan organisasi nirlaba dalam menyelesaikan tantangan manajerial dan kebijakan publik yang kompleks.</span></p><p><span style="font-size: 16px;">Memberikan solusi berbasis bukti untuk pengambilan keputusan yang tepat, berdaya guna, dan berkelanjutan.</span></p>';
                $sKolaborasi->save();
            }

            // 9. DIVISI 19: Divisi Karir dan Kewirausahaan
            $d19 = Divisi::find(19);
            if ($d19) {
                $sTentang = DivisiSection::where('divisi_id', 19)->where('section_name', 'like', '%tentang%')->first();
                if ($sTentang) {
                    $sTentang->update(['urutan' => 1, 'position_after' => 'before_program', 'design_style' => 'light']);
                }

                $sKeunggulan = DivisiSection::firstOrNew(['divisi_id' => 19, 'section_name' => 'Keunggulan Divisi']);
                $sKeunggulan->urutan = 2;
                $sKeunggulan->position_after = 'before_program';
                $sKeunggulan->design_style = 'accent';
                $sKeunggulan->is_active = 1;
                $sKeunggulan->content = '<p><span style="font-size: 16px;">Keunggulan Divisi Karir dan Kewirausahaan terletak pada inkubasi bisnis aplikatif dan kesiapan kerja lulusan yang teruji, didukung oleh:</span></p><ul><li><span style="font-size: 16px;">Bimbingan karir personal meliputi review CV profesional, simulasi interview kerja, dan career coaching mendalam.</span></li><li><span style="font-size: 16px;">Inkubator bisnis rintisan (startup incubation) mulai dari validasi ide, business model canvas, hingga akses jejaring investor.</span></li><li><span style="font-size: 16px;">Jaringan luas dengan perusahaan mitra penyedia lowongan kerja dan magang industri bersertifikat.</span></li><li><span style="font-size: 16px;">Mentoring kewirausahaan berkelanjutan bersama para praktisi bisnis sukses dan wirausahawan berpengalaman.</span></li></ul>';
                $sKeunggulan->save();

                $sKolaborasi = DivisiSection::firstOrNew(['divisi_id' => 19, 'section_name' => 'Kolaborasi dan Keanggotaan']);
                $sKolaborasi->urutan = 3;
                $sKolaborasi->position_after = 'after_program';
                $sKolaborasi->design_style = 'accent';
                $sKolaborasi->is_active = 1;
                $sKolaborasi->content = '<p><span style="font-size: 16px;">Divisi Karir dan Kewirausahaan mengundang para pengusaha, angel investor, HR recruiter, dan startup founder untuk berkolaborasi sebagai <strong style="font-weight: bold;">Mentor Bisnis, Career Coach, atau Mitra Penyerap Tenaga Kerja</strong>.</span></p><p><span style="font-size: 16px;">Kami juga menyelenggarakan bursa kerja kampus (Job Fair), inkubasi bisnis mahasiswa, dan kemitraan magang industri terstruktur bersama sekolah dan perguruan tinggi mitra.</span></p><p><span style="font-size: 16px;">Mencetak generasi muda mandiri yang berdaya saing, berkarir cemerlang, dan berjiwa wirausaha unggul.</span></p>';
                $sKolaborasi->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
