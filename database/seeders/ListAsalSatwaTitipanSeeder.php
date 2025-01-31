<?php

namespace Database\Seeders;

use App\Models\ListAsalSatwaTitipan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListAsalSatwaTitipanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ListAsalSatwaTitipan::create([
            'nama'=> 'penyerahan masyarakat',
        ]);

        ListAsalSatwaTitipan::create([
            'nama'=> 'sitaan',
        ]);

        ListAsalSatwaTitipan::create([
            'nama'=> 'konflik satwa-manusia',
        ]);

        ListAsalSatwaTitipan::create([
            'nama'=> 'repatriasi',
        ]);

        ListAsalSatwaTitipan::create([
            'nama'=> 'rampasan',
        ]);
        
        ListAsalSatwaTitipan::create([
            'nama'=> 'temuan',
        ]);

        ListAsalSatwaTitipan::create([
            'nama'=> 'tegahan',
        ]);

        ListAsalSatwaTitipan::create([
            'nama'=> 'dampak bencana alam, bencana non alam atau kegiatan manusia',
        ]);

        ListAsalSatwaTitipan::create([
            'nama'=> 'wilayah yang terisolir',
        ]);

        ListAsalSatwaTitipan::create([
            'nama'=> 'lk',
        ]);

        ListAsalSatwaTitipan::create([
            'nama'=> 'penangkaran',
        ]);
    }
}
