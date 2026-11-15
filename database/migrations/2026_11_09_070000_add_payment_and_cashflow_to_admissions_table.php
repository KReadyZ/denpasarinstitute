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
        Schema::table('admissions', function (Blueprint $table) {
            $table->decimal('nominal_pembayaran', 15, 2)->nullable()->default(250000)->after('bukti_bayar_program');
            $table->string('metode_pembayaran', 60)->nullable()->default('Transfer Bank')->after('nominal_pembayaran');
            $table->unsignedBigInteger('cashflow_id')->nullable()->after('metode_pembayaran');
            
            $table->foreign('cashflow_id')->references('id')->on('cashflows')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            $table->dropForeign(['cashflow_id']);
            $table->dropColumn(['nominal_pembayaran', 'metode_pembayaran', 'cashflow_id']);
        });
    }
};

