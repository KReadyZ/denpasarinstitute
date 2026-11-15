<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PartnershipPillar;
use App\Http\Controllers\PartnerDetailController;

class PartnershipPillarDetailSeeder extends Seeder
{
    public function run(): void
    {
        $pillarsData = PartnerDetailController::getPillarsList();

        $defaultDetailImages = [
            'research-and-innovation'  => 'image/partners/pillar-research.jpg',
            'industry-partnership'     => 'image/partners/pillar-industry.jpg',
            'professional-development' => 'image/partners/pillar-training.jpg',
            'community-empowerment'    => 'image/partners/pillar-community.jpg',
            'global-partnership'       => 'image/partners/pillar-global.jpg',
            'publication-and-ipr'      => 'image/partners/pillar-publication.jpg',
        ];

        foreach ($pillarsData as $slug => $data) {
            $pillarId = $data['pillar_id'] ?? null;
            if (!$pillarId) continue;

            $pillar = PartnershipPillar::find($pillarId);
            if (!$pillar) {
                $pillar = PartnershipPillar::where('link_url', 'like', "%{$slug}%")->first();
            }

            if ($pillar) {
                $detailImage = $defaultDetailImages[$slug] ?? ($data['image'] ?? null);

                $pillar->update([
                    'slug'         => $slug,
                    'subtitle'     => $data['subtitle'] ?? null,
                    'badge'        => $data['badge'] ?? null,
                    'hero_title'   => $data['hero_title'] ?? null,
                    'hero_sub'     => $data['hero_sub'] ?? null,
                    'detail_image' => $detailImage,
                    'image_tag'    => $data['image_tag'] ?? null,
                    'image_sub'    => $data['image_sub'] ?? null,
                    'intro'        => $data['intro'] ?? null,
                    'services'     => $data['services'] ?? [],
                    'highlights'   => $data['highlights'] ?? [],
                    'cta_title'    => $data['cta_title'] ?? null,
                    'cta_sub'      => $data['cta_sub'] ?? null,
                    'wa_text'      => $data['wa_text'] ?? null,
                    'wa_btn'       => $data['wa_btn'] ?? 'Form Kemitraan',
                    'link_url'     => '/partner-with-di/' . $slug,
                ]);
            }
        }
    }
}

