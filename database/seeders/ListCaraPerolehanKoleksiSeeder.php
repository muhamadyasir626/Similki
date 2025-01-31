<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ListCaraPerolehanKoleksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ListCaraPerolehanKoleksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Penyerahan',
            'Hibah, Pemberian atau Sumbangan',
            'Tukar Menukar',
            'Peminjaman',
            'Pengambilan',
            'Pembelian',
            'Pengambilan / Penangkapan dari Alam'
        ];

        foreach ($data as $item) {
            ListCaraPerolehanKoleksi::create(['nama' => $item]);
        }
    }
}
