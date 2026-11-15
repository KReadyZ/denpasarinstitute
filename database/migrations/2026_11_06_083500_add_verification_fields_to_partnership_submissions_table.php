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
        Schema::table('partnership_submissions', function (Blueprint $table) {
            $table->timestamp('verified_at')->nullable()->after('status');
            $table->string('verified_by')->nullable()->after('verified_at');
            $table->text('admin_notes')->nullable()->after('verified_by');
            $table->string('kategori')->nullable()->after('institusi');
            $table->integer('urutan')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partnership_submissions', function (Blueprint $table) {
            $table->dropColumn(['verified_at', 'verified_by', 'admin_notes', 'kategori', 'urutan']);
        });
    }
};

