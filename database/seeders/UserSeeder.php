<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'npk' => '121212',
                'name' => 'Aufar Pakcoy',
                'dept' => 'EHS',
                'sect' => 'Non BaaN',
                'golongan' => '4',
                'acting' => '4',
                'password' => '123',
            ],

        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
