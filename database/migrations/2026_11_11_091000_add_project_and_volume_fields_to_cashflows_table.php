<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cashflows', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->after('program_id')->constrained('projects')->nullOnDelete();
            $table->string('satuan', 50)->nullable()->after('kategori');
            $table->decimal('volume', 10, 2)->default(1)->after('satuan');
            $table->decimal('harga_satuan', 15, 2)->nullable()->after('volume');
        });
    }

    public function down(): void
    {
        Schema::table('cashflows', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn(['project_id', 'satuan', 'volume', 'harga_satuan']);
        });
    }
};

