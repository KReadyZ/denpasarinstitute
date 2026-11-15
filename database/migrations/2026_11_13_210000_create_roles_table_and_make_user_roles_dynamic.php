<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Buat tabel roles jika belum ada
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('slug', 50)->unique();
                $table->enum('category', ['internal', 'member'])->default('internal');
                $table->text('description')->nullable();
                $table->string('badge_color', 30)->default('primary');
                $table->string('icon', 50)->default('fa-user');
                $table->boolean('is_system')->default(false);
                $table->boolean('is_active')->default(true);
                $table->integer('order')->default(0);
                $table->timestamps();
            });
        }

        // 2. Ubah kolom role pada tabel users dari ENUM menjadi VARCHAR agar dinamis
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(50) NOT NULL DEFAULT 'grcs'");

        // 3. Masukkan data role default ke dalam tabel roles
        $roles = [
            [
                'name'        => 'Super Admin',
                'slug'        => 'superadmin',
                'category'    => 'internal',
                'description' => 'Akses penuh ke seluruh menu, konfigurasi sistem, dan manajemen akun staf.',
                'badge_color' => 'danger',
                'icon'        => 'fa-crown',
                'is_system'   => true,
                'is_active'   => true,
                'order'       => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Admin Operasional',
                'slug'        => 'admin',
                'category'    => 'internal',
                'description' => 'Pengelolaan data operasional harian, admission, verifikasi anggota, dan konten website.',
                'badge_color' => 'primary',
                'icon'        => 'fa-user-tie',
                'is_system'   => true,
                'is_active'   => true,
                'order'       => 2,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Finance',
                'slug'        => 'finance',
                'category'    => 'internal',
                'description' => 'Pengelolaan kas keuangan umum, rincian biaya program, dan pencatatan transaksi.',
                'badge_color' => 'success',
                'icon'        => 'fa-calculator',
                'is_system'   => true,
                'is_active'   => true,
                'order'       => 3,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Konsultan',
                'slug'        => 'konsultan',
                'category'    => 'member',
                'description' => 'Anggota terdaftar sebagai tenaga ahli dan konsultan Denpasar Institute.',
                'badge_color' => 'danger',
                'icon'        => 'fa-user-tie',
                'is_system'   => true,
                'is_active'   => true,
                'order'       => 4,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'GRCS Club',
                'slug'        => 'grcs',
                'category'    => 'member',
                'description' => 'Anggota Global Research & Community Service Club.',
                'badge_color' => 'success',
                'icon'        => 'fa-user-shield',
                'is_system'   => true,
                'is_active'   => true,
                'order'       => 5,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Mitra & Klien',
                'slug'        => 'mitra',
                'category'    => 'member',
                'description' => 'Akun perwakilan instansi mitra atau klien kerjasama.',
                'badge_color' => 'info',
                'icon'        => 'fa-handshake',
                'is_system'   => true,
                'is_active'   => true,
                'order'       => 6,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        foreach ($roles as $roleData) {
            DB::table('roles')->updateOrInsert(
                ['slug' => $roleData['slug']],
                $roleData
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','admin','finance','konsultan','grcs','mitra') NOT NULL DEFAULT 'grcs'");
        Schema::dropIfExists('roles');
    }
};

