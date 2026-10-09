<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Illuminate\Database\Seeder;

class StatisticSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['icon' => 'fa-layer-group', 'number' => 9,   'label' => 'Divisi Aktif',     'trend_percentage' => 100, 'trend_direction' => 'up', 'order' => 1],
            ['icon' => 'fa-users',       'number' => 250, 'label' => 'Anggota Aktif',    'trend_percentage' => 25,  'trend_direction' => 'up', 'order' => 2],
            ['icon' => 'fa-file-alt',    'number' => 480, 'label' => 'Publikasi Ilmiah', 'trend_percentage' => 40,  'trend_direction' => 'up', 'order' => 3],
            ['icon' => 'fa-handshake',   'number' => 35,  'label' => 'Mitra Institusi',  'trend_percentage' => 15,  'trend_direction' => 'up', 'order' => 4],
            ['icon' => 'fa-certificate', 'number' => 120, 'label' => 'Sertifikasi',      'trend_percentage' => 50,  'trend_direction' => 'up', 'order' => 5],
        ];

        foreach ($data as $item) {
            Statistic::create($item);
        }
    }
}