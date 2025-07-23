<?php

namespace Database\Seeders;

use App\Models\AgcLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgcLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'category' => 'Gold',
                'color' => '#F3C623',
                'fr_max' => 0.5,
                'sr_max' => 20
            ],
            [
                'category' => 'Green',
                'color' => '#347433',
                'fr_min' => 0.5,
                'fr_max' => 1.9,
                'sr_min' => 20,
                'sr_max' => 170,
            ],
            [
                'category' => 'Blue',
                'color' => '#0D5EA6',
                'fr_min' => 1.9,
                'fr_max' => 2,
                'sr_min' => 170,
                'sr_max' => 375,
            ],
            [
                'category' => 'Red',
                'color' => '#DC2525',
                'fr_min' => 2,
                'fr_max' => 3,
                'sr_min' => 375,
                'sr_max' => 750,
            ],
            [
                'category' => 'Black',
                'color' => '#000000',
                'fr_min' => 3,
                'sr_min' => 750,
            ],

        ];

        foreach ($levels as $level) {
            AgcLevel::create($level);
        }
    }
}
