<?php

namespace Database\Seeders;

use App\Models\ListCaraSatwaPerolehan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListCaraSatwaPerolehanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ListCaraSatwaPerolehan::create([
            'nama' => 'penyerahan'
        ]);
        ListCaraSatwaPerolehan::create([
            'nama' => 'hibah pemberian/sumbangan'
        ]);
        ListCaraSatwaPerolehan::create([
            'nama' => 'tukar menukar'
        ]);
        ListCaraSatwaPerolehan::create([
            'nama' => 'peminjaman'
        ]);
        ListCaraSatwaPerolehan::create([
            'nama' => 'pengambilan dari instalasi pemerintah'
        ]);
        ListCaraSatwaPerolehan::create([
            'nama' => 'pembelian'
        ]);
        ListCaraSatwaPerolehan::create([
            'nama' => 'pengambilan/penangkapan dari alam'
        ]);
    }
}
