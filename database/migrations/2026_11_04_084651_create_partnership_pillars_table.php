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
        Schema::create('partnership_pillars', function (Blueprint $table) {
            $table->id();
            $table->string('number', 10)->default('01');
            $table->string('title');
            $table->string('tag');
            $table->string('icon')->nullable(); // fa-microscope, etc.
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('link_url')->nullable();
            $table->string('link_text')->default('Learn more');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partnership_pillars');
    }
};
