<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name'=> 'Konservasi Keanekaragaman Hayati Spesies & Genetik',
            'tag' => 'KKHSG',
        ]);

        Role::create([
            'name'=> 'Lembaga Konservasi',
            'tag' => 'LK',
        ]);

        Role::create([
            'name'=> 'Unit Pelaksana Teknis',
            'tag' => 'UPT',

        ]);

        Role::create([
            'name'=> 'Dokter Hewan',
            'tag' => 'DRH',

        ]);

        Role::create([
            'name'=> 'Studbook',
            'tag' => 'SB',

        ]);

        Role::create([
            'name'=> 'Staff Keeper',
            'tag' => 'SK',

        ]);

    }
}
