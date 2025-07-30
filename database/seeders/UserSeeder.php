<?php

namespace Database\Seeders;

use App\Models\CTUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'npk' => '10101',
                'full_name' => 'Aufar',
                'pwd' => Hash::make('admin'),
                'dept' => 'EHS',
                'sect' => '11',
                'subsect' => null,
                'golongan' => '4',
                'acting' => '2',
                'no_telp' => '085714505031',
                'email' => 'aufar@gmail.com',
            ],

        ];

        foreach ($users as $user) {
            CTUser::create($user);
        }
    }
}
