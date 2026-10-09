<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('hero_sliders', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('subtitle')->nullable();
        $table->string('background_image')->nullable();
        $table->string('logo_image')->nullable();
        $table->string('button_text')->default('Selengkapnya');
        $table->string('button_url')->default('#');
        $table->json('stats')->nullable(); 
        $table->integer('order')->default(0);
        $table->boolean('is_active')->default(true);
        $table->enum('type', ['banner', 'divisi'])->default('divisi');
        $table->string('divisi_name')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('hero_sliders');
}
};
