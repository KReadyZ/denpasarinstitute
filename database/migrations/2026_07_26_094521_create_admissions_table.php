<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('hp_wa');
            $table->string('email');
            $table->text('special_request')->nullable();
            $table->string('bukti_bayar_pendaftaran')->nullable();
            $table->string('bukti_bayar_program')->nullable();
            $table->json('sumber_informasi')->nullable();
            $table->string('status')->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('admission_program', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_id')->constrained('admissions')->cascadeOnDelete();
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admission_program');
        Schema::dropIfExists('admissions');
    }
};