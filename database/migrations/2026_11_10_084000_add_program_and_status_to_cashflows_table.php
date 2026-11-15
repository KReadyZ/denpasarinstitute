<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cashflows', function (Blueprint $table) {
            $table->string('judul', 255)->nullable()->after('kode');
            $table->foreignId('program_id')->nullable()->after('kategori')->constrained('programs')->nullOnDelete();
            $table->string('status', 30)->default('lunas')->after('metode_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('cashflows', function (Blueprint $table) {
            $table->dropForeign(['program_id']);
            $table->dropColumn(['judul', 'program_id', 'status']);
        });
    }
};

