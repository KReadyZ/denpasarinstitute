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
        Schema::create('partnership_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('pillar_slug')->nullable();
            $table->string('pillar_title')->nullable();
            $table->string('nama_pic');
            $table->string('institusi');
            $table->string('email');
            $table->string('no_wa');
            $table->text('link_gmap')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->text('pesan')->nullable();
            $table->string('status')->default('pending'); // pending, reviewed, contacted, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partnership_submissions');
    }
};

