<?php

namespace Database\Seeders;

use App\Models\PartnershipSubmission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MitraKlienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = storage_path('app/all_partners_scraped.json');
        if (!File::exists($jsonPath)) {
            $this->command->error("File {$jsonPath} not found!");
            return;
        }

        $partners = json_decode(File::get($jsonPath), true);
        $order = 1;

        foreach ($partners as $p) {
            $host = parse_url($p['website'], PHP_URL_HOST);
            $cleanHost = preg_replace('/^www\./', '', $host ?? 'denpasarinstitute.com');

            PartnershipSubmission::updateOrCreate(
                ['institusi' => $p['institusi']],
                [
                    'nama_pic'     => 'Humas & Kemitraan ' . $p['institusi'],
                    'kategori'     => $p['kategori'] ?? 'Kemitraan Strategis',
                    'email'        => 'info@' . $cleanHost,
                    'no_wa'        => '081234567' . sprintf('%03d', $order),
                    'website'      => $p['website'],
                    'logo'         => $p['logo'],
                    'pillar_slug'  => 'industry-partnership',
                    'pillar_title' => 'Kemitraan Strategis',
                    'status'       => 'approved',
                    'urutan'       => $order,
                    'verified_at'  => now(),
                    'verified_by'  => 'Super Admin',
                    'admin_notes'  => 'Mitra resmi terverifikasi dari www.denpasarinstitute.com/partner',
                ]
            );

            $this->command->info("Seeded partner #{$order}: {$p['institusi']}");
            $order++;
        }

        $this->command->info("Total {$order} partners seeded successfully.");
    }
}
