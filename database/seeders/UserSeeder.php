<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN BSI
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'bsi@banksampah.id'
            ],
            [
                'name' => 'Admin BSI',
                'password' => Hash::make('password'),
                'role' => 'admin_bsi',
                'bsu_id' => null,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | ADMIN BSU
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'bsu@banksampah.id'
            ],
            [
                'name' => 'Admin BSU',
                'password' => Hash::make('password'),
                'role' => 'admin_bsu',
                'bsu_id' => 1,
            ]
        );
    }
}