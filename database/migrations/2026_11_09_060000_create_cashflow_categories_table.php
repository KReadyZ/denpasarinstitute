<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cashflow_categories', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['masuk', 'keluar'])->default('masuk')->index();
            $table->string('kode', 30)->unique(); // Contoh: KM-ADM, KK-GJI, KM-KRS
            $table->string('nama', 150); // Contoh: Pendaftaran Siswa / Mahasiswa Baru
            $table->text('deskripsi')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashflow_categories');
    }
};

