<?php

namespace Database\Seeders;

use App\Models\CategoryAccident;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryAccidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'category' => 'First Aid',
            ],
            [
                'category' => 'Non LWD',
            ],
            [
                'category' => 'LWD',
            ],
            [
                'category' => 'Fatal',
            ],
        ];

        foreach ($categories as $category) {
            CategoryAccident::create($category);
        }
    }
}
