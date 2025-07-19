<?php

namespace Database\Seeders;

use App\Models\Accident;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accidents = [
            [
                'accident' => 'Kecelakaan Kerja',
            ],
            [
                'accident' => 'Kebakaran',
            ],
            [
                'accident' => 'Lalu Lintas',
            ],
        ];

        foreach ($accidents as $accident) {
            Accident::create($accident);
        }
    }
}
