<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','admin','finance','konsultan','grcs','mitra') NOT NULL DEFAULT 'grcs'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','konsultan','grcs','mitra') NOT NULL DEFAULT 'grcs'");
    }
};
