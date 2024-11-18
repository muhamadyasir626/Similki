<?php

namespace Database\Seeders;

use App\Models\ListUpt;
use Illuminate\Database\Seeder;
use App\Models\LembagaKonservasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LembagaKonservasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path('resources/data/db lk.csv');
        // $csvFile = base_path('resources/data/data lk lengkap-new.csv');
        $data = array_map(function($line){
            return str_getcsv($line, ',');
        }, file($csvFile));
        
        array_shift($data);
        
        foreach($data as $row){
            $wilayah = strtolower(trim($row[3])); 
            switch ($wilayah){
                case 'tangerang':
                case 'bekasi':
                case 'dki jakarta':
                case 'jakarta':
                case 'banten':
                    $wilayah_upt = 'jakarta';
                    break;
        
                case 'kepulauan riau':
                case 'riau':
                    $wilayah_upt = 'riau';
                    break;
        
                case 'bengkulu':
                case 'lampung':
                    $wilayah_upt = 'bengkulu lampung';
                    break;
        
                case 'kepulauan bangka belitung':
                case 'bangka belitung':
                    $wilayah_upt = 'sumatera selatan';
                    break;
                case 'daerah istimewa yogyakarta':
                case 'diy yogyakarta':
                    $wilayah_upt = 'yogyakarta';
                    break;
                default:
                    $wilayah_upt = $wilayah;
                    break;
            }
            $id_upt = ListUpt::whereRaw('LOWER(TRIM(wilayah)) = ?', [$wilayah_upt])->value('id');

            $lk = LembagaKonservasi::create([
                'nama' => $row[1] ?? null,
                'slug' => $row[2] ?? null,
                'id_upt' => $id_upt??null,
                'alamat' => $row[4] ?? null,
                'provinsi' => $row[5] ?? null,
                'kota_kab' => $row[6] ?? null,
                'kelurahan_desa' => $row[7],
                'kecamatan' => $row[8] ?? null,
                'kode_pos' => $row[9] ?? null,
                'bentuk_lk' => $row[10] ?? null,
                'legalitas_perizinan' => $row[11] ?? null,
                'tahun_izin' => $row[12] ?? null,
                'link_sk' => $row[13] ?? null,
                'nilai_akred' => $row[14] ?? null,
                'tahun_akred' => $row[15] ?? null,
                'nomor_tanggal_surat' => $row[16] ?? null,
                'pengelola' => $row[17] ?? null,
                'nama_pimpinan' => $row[18] ?? null,
                'izin_perolehan_tsl' => $row[19] ?? null,
                'pks_dengan_lk_lainnya' => $row[20] ?? null,
            ]);
        }

    }
}
