<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ImportNewsSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = storage_path('app/imported_news.json');
        if (!File::exists($jsonPath)) {
            $this->command->error("File {$jsonPath} not found!");
            return;
        }

        $newsList = json_decode(File::get($jsonPath), true);

        foreach ($newsList as $item) {
            // Ensure category exists
            KategoriBerita::firstOrCreate(['nama' => $item['kategori']]);

            // Update or create article by title
            Berita::updateOrCreate(
                ['title' => $item['title']],
                [
                    'kategori'       => $item['kategori'],
                    'kontributor'    => $item['kontributor'],
                    'no_anggota'     => $item['no_anggota'] ?? null,
                    'published_at'   => $item['published_at'],
                    'content'        => $item['content'],
                    'image'          => $item['image'],
                    'views'          => $item['views'] ?? 0,
                    'is_active'      => true,
                    'status'         => 'approved',
                    'created_by'     => 1,
                    'approved_by'    => 1,
                    'approved_at'    => $item['published_at'],
                    'rejection_note' => null,
                ]
            );

            $this->command->info("Seeded: {$item['title']}");
        }
    }
}

