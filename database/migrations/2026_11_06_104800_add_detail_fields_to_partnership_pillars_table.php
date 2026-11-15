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
        Schema::table('partnership_pillars', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
            $table->string('subtitle')->nullable()->after('slug');
            $table->string('badge')->nullable()->after('subtitle');
            $table->string('hero_title')->nullable()->after('badge');
            $table->text('hero_sub')->nullable()->after('hero_title');
            $table->string('detail_image')->nullable()->after('image');
            $table->string('image_tag')->nullable()->after('detail_image');
            $table->string('image_sub')->nullable()->after('image_tag');
            $table->text('intro')->nullable()->after('image_sub');
            $table->json('services')->nullable()->after('intro');
            $table->json('highlights')->nullable()->after('services');
            $table->string('cta_title')->nullable()->after('highlights');
            $table->text('cta_sub')->nullable()->after('cta_title');
            $table->string('wa_text')->nullable()->after('cta_sub');
            $table->string('wa_btn')->nullable()->after('wa_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partnership_pillars', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'subtitle',
                'badge',
                'hero_title',
                'hero_sub',
                'detail_image',
                'image_tag',
                'image_sub',
                'intro',
                'services',
                'highlights',
                'cta_title',
                'cta_sub',
                'wa_text',
                'wa_btn',
            ]);
        });
    }
};

