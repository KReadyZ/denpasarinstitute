<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_anggota')->nullable()->unique()->after('role');
            $table->date('berlaku_sd')->nullable()->after('no_anggota'); // tanggal kadaluarsa kartu

            $table->string('tempat_lahir')->nullable()->after('phone');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('kode_provinsi', 2)->default('51')->after('tanggal_lahir'); // 51 = Bali
            $table->string('provinsi')->nullable()->after('kode_provinsi');
            $table->string('motto_hidup')->nullable()->after('bio');

            $table->string('pendidikan_terakhir')->nullable()->after('motto_hidup');
            $table->string('bidang_ilmu')->nullable()->after('pendidikan_terakhir');
            $table->string('praktisi_bidang')->nullable()->after('institution');
            $table->string('keahlian_utama')->nullable()->after('praktisi_bidang');
            $table->string('keahlian_penunjang')->nullable()->after('keahlian_utama');
            $table->text('minat_riset_bidang')->nullable()->after('keahlian_penunjang');
            $table->text('minat_pengabdian_bidang')->nullable()->after('minat_riset_bidang');
            $table->text('profil')->nullable()->after('minat_pengabdian_bidang'); // paragraf panjang ttg orangnya

            $table->string('publon_id')->nullable()->after('google_scholar_id');
            $table->string('garuda_id')->nullable()->after('publon_id');
            $table->string('researcher_id')->nullable()->after('garuda_id');

            $table->string('foto')->nullable()->after('avatar');       // foto 350x350 utk kartu
            $table->string('background')->nullable()->after('foto');   // banner 1150x350
            $table->string('kartu_path')->nullable()->after('background'); // hasil generate gambar kartu

            // ===== Khusus role "mitra" (pengirim berita/event dari instansi luar) =====
            $table->string('nama_instansi')->nullable()->after('institution');
            $table->string('jenis_instansi')->nullable()->after('nama_instansi'); // perusahaan / sekolah / kampus / dll
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])
                  ->nullable()->after('is_active');
            $table->timestamp('verified_at')->nullable()->after('verification_status');
            $table->foreignId('verified_by')->nullable()->after('verified_at')
                  ->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable()->after('verified_by');
        });

        // Update enum role: tambah 'mitra'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','konsultan','grcs','mitra') NOT NULL DEFAULT 'grcs'");
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('verified_by');
            $table->dropColumn([
                'no_anggota', 'berlaku_sd',
                'tempat_lahir', 'tanggal_lahir', 'kode_provinsi', 'provinsi', 'motto_hidup',
                'pendidikan_terakhir', 'bidang_ilmu', 'praktisi_bidang',
                'keahlian_utama', 'keahlian_penunjang',
                'minat_riset_bidang', 'minat_pengabdian_bidang', 'profil',
                'publon_id', 'garuda_id', 'researcher_id',
                'foto', 'background',
                'nama_instansi', 'jenis_instansi',
                'verification_status', 'verified_at', 'rejection_reason',
            ]);
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','konsultan','grcs') NOT NULL DEFAULT 'grcs'");
    }
};