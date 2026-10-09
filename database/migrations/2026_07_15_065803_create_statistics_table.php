<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->default('fa-layer-group'); // font-awesome class, tanpa "fas"
            $table->unsignedInteger('number');
            $table->string('label');
            $table->unsignedInteger('trend_percentage')->nullable();
            $table->enum('trend_direction', ['up', 'down'])->default('up');
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};