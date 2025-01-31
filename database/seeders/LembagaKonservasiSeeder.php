<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\ListUpt;
use Illuminate\Support\Str;
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
                'kode_pos' => 12345,
                'provinsi' => $row[5] ?? null,
                'kota_kab' => $row[6] ?? null,
                'kelurahan' => $row[7],
                'kecamatan' => $row[8] ?? null,
                'kode_pos' => $row[9] ?? null,
                'bentuk_lk' => $row[10] ?? null,
                'nib'=> 1,
                'npwp' => 2,
                'email' => Str::random(10) . '@gmail.com',
                // 'sk_izin'=> "",
                // 'tanggal_sk' => Carbon::now()->format('Y-m-d H:i:s'),
                'nama_direktur' => $row[18] ?? null,
                'no_telp'=>"628". mt_rand(100000000, 999999999),
                'jumlah_investasi' => 0,
                'jumlah_tenaga_kerja' => 0,
                'luas_wilayah' => 0.0,
                'doc_site_plan' => 'site_plan_2.pdf',
                'path_site_plan' => 'documents/site_plan_2.pdf',
                'doc_persetujuan_lingkungan' => 'persetujuan_lingkungan_2.pdf',
                'path_persetujuan_lingkungan' => 'documents/persetujuan_lingkungan_2.pdf',
                'doc_draft_rkp' => 'draft_rkp_2.pdf',
                'path_draft_rkp' => 'documents/draft_rkp_2.pdf',
                'doc_surat_permohonan' => 'surat_pemohonan_2.pdf',
                'path_surat_permohonan' => 'documents/surat_pemohonan_2.pdf',
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

                // 'legalitas_perizinan' => $row[11] ?? null,
                // 'tahun_izin' => $row[12] ?? null,
                // 'link_sk' => $row[13] ?? null,
                // 'nilai_akred' => $row[14] ?? null,
                // 'tahun_akred' => $row[15] ?? null,
                // 'nomor_tanggal_surat' => $row[16] ?? null,
                // 'pengelola' => $row[17] ?? null,
                // 'izin_perolehan_tsl' => $row[19] ?? null,
                // 'pks_dengan_lk_lainnya' => $row[20] ?? null,
            ]);
        }

    }
}
