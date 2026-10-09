<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('divisi_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('divisi_id')->constrained('divisis')->onDelete('cascade');
            $table->string('section_name');
            $table->longText('content');
            $table->string('image')->nullable();
            $table->integer('urutan')->default(0);
            $table->enum('design_style', ['light', 'dark', 'accent'])->default('light');
            $table->string('position_after')->default('before_program');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('divisi_id');
            $table->index('urutan');
        });
    }

    public function down()
    {
        Schema::dropIfExists('divisi_sections');
    }
};