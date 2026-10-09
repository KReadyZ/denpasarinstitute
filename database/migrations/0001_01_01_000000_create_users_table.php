<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nip_nim')->nullable(); 
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('avatar')->nullable();
            $table->string('position')->nullable(); 
            $table->string('institution')->nullable(); 
            $table->text('bio')->nullable();
            
            $table->string('orcid_id')->nullable();
            $table->string('scopus_id')->nullable();
            $table->string('sinta_id')->nullable();
            $table->string('google_scholar_id')->nullable();
            
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->string('youtube')->nullable();
            
            $table->json('expertise')->nullable(); 
            $table->json('education')->nullable(); 
            $table->json('certifications')->nullable(); 
            $table->json('publications')->nullable(); 
            $table->enum('membership_type', ['regular', 'premium', 'vip'])->default('regular');
            $table->timestamp('member_since')->nullable();
            $table->timestamp('profile_completed_at')->nullable();
            
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['superadmin', 'konsultan', 'grcs'])->default('grcs');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};