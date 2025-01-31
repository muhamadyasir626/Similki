<?php

namespace Database\Seeders;

use App\Models\ListJenisBarang;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ListJenisBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ListJenisBarang::create([
            'nama' => 'satwa',
        ]);
        ListJenisBarang::create([
            'nama' => 'tumbuhan',
        ]);
        ListJenisBarang::create([
            'nama' => 'pakan',
        ]);
        ListJenisBarang::create([
            'nama' => 'peralatan lk',
        ]);
        ListJenisBarang::create([
            'nama' => 'obat-obatan',
        ]);
    }
}
