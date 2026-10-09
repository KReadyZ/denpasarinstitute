<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bursa_sdms', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['perusahaan', 'individu']);
            $table->string('nama'); // nama perusahaan / nama individu
            $table->string('slug')->unique();
            $table->string('kategori')->nullable(); // mis. "IT, Marketing, dll"
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable(); // logo perusahaan / foto profil individu
            $table->string('email')->nullable();
            $table->string('no_wa')->nullable();
            $table->string('alamat')->nullable();
            $table->string('website')->nullable();
            // khusus perusahaan
            $table->string('bidang_usaha')->nullable();
            // khusus individu
            $table->string('keahlian')->nullable();
            $table->string('posisi_dicari')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('is_active')->default(false); // tampil di publik atau tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bursa_sdms');
    }
};