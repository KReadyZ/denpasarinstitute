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
        Schema::table('cashflows', function (Blueprint $table) {
            $table->decimal('total_tagihan', 15, 2)->nullable()->after('nominal');
            $table->decimal('sisa_piutang', 15, 2)->default(0)->after('total_tagihan');
            $table->date('jatuh_tempo')->nullable()->after('tanggal');
            $table->text('catatan_pelunasan')->nullable()->after('deskripsi');
        });

        Schema::table('admissions', function (Blueprint $table) {
            $table->decimal('total_biaya', 15, 2)->nullable()->after('nominal_pembayaran');
            $table->decimal('sisa_piutang', 15, 2)->default(0)->after('total_biaya');
            $table->string('status_pembayaran', 30)->default('lunas')->after('sisa_piutang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cashflows', function (Blueprint $table) {
            $table->dropColumn(['total_tagihan', 'sisa_piutang', 'jatuh_tempo', 'catatan_pelunasan']);
        });

        Schema::table('admissions', function (Blueprint $table) {
            $table->dropColumn(['total_biaya', 'sisa_piutang', 'status_pembayaran']);
        });
    }
};
