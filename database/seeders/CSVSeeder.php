<?php

namespace Database\Seeders;

use App\Models\LembagaKonservasi;
use App\Models\ListLk;
use App\Models\ListSpecies;
use App\Models\ListUpt;
use App\Models\Satwa;
use App\Models\Tagging;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CSVSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // ========================================= LIST UPT =====================
        $csvFile = base_path('resources\data\list_upt.csv');
        $data = array_map(function ($line) {
            return str_getcsv($line, ','); 
        }, file($csvFile));
    
        array_shift($data); 
    
        // $filteredData = array_filter($data, function ($row) {
        //     return count($row) > 1;
        // });

        // dd($filteredData);
        // dd($data);
    
        foreach ($data as $row) {
            ListUpt::Create([
                'bentuk' => $row[0], 
                'wilayah' => $row[1], 
                'slug' => $row[2], 
            ]);
        }


        // ============================================ List Species ==================
        $csvFile = base_path('resources\data\list_species.csv');
        $data = array_map(function($line){
            return str_getcsv($line,',');
        }, file($csvFile));

        array_shift($data);

        // dd($data);

        foreach($data as $row){
            ListSpecies::create([
                'class' => $row[0],
                'genus' => $row[5],
                'spesies' => $row[6],
                'subspesies' => $row[7],
                'nama_lokal' => $row[3],
                'nama_ilmiah' => $row[4],
            ]);
        }

        // ============================================== Data satwa ===========================

        // $csvFile = base_path('resources/data/data_satwa.csv');
        // $data = array_map(function($line) {
        //     return str_getcsv($line, ',');
        // }, file($csvFile));

        // array_shift($data); // Menghapus header CSV

        // foreach ($data as $row) {
        //     // Mendapatkan ID Lembaga Konservasi berdasarkan slug
        //     $id_lk = LembagaKonservasi::where('slug', $row[2])->first();

        //     // Mendapatkan atau membuat ID spesies berdasarkan nama lokal
        //     $id_species = ListSpecies::where('nama_lokal', $row[9])->first();
        //     if (!$id_species) {
        //         $id_species = ListSpecies::create([
        //             'class' => $row[6],
        //             'genus' => $row[8],
        //             'spesies' => $row[9],
        //             'subspesies' => $row[10],
        //             'nama_lokal' => $row[11],
        //             'nama_ilmiah' => $row[12]
        //         ]);
        //     }
            

        //     // Konversi status perlindungan ke formatnya
        //     $status_perlindungan = ($row[8] == 'dilindungi') ? '1' : '0';

        //     // Konversi perilaku satwa ke formatnya
        //     $perilaku_satwa = ($row[22] == 'individu') ? '1' : '0';

        //     // Konversi jenis kelamin individu ke formatnya
        //     $jenis_kelamin_individu = ($row[23] == 'jantan') ? '1' : '0';

        //     // Cek apakah $id_lk dan $id_species ada sebelum memasukkan data
        //     if (isset($id_species) && isset($id_lk)) {
        //         $satwa = Satwa::create([
        //             'id_lk' => $id_lk->id, 
        //             'jenis_koleksi' => $row[4],
        //             'asal_satwa' => $row[5],
        //             'no_sats_ln' => $row[17],
        //             'id_spesies' => $id_species->id,
        //             'status_perlindungan' => $status_perlindungan,
        //             'pengambilan_satwa' => $row[18],
        //             'sk_kepala' => $row[19],
        //             'sk_menteri' => $row[21],
        //             'sk_ksdae' => $row[20],
        //             'perilaku_satwa' => $perilaku_satwa,
        //             'jenis_kelamin_individu' => $jenis_kelamin_individu,
        //             'status_satwa' => $row[15],
        //             'jumlah_jantan' => $row[24],
        //             'jumlah_betina' => $row[25],
        //             'jumlah_unsex' => $row[26],
        //             'jumlah_keseluruhan_gender' => $row[27],
        //             'no_izin_peroleh' => $row[16],
        //             'no_ba_titipan' => $row[30],
        //             'no_ba_kelahiran' => $row[31],
        //             'no_ba_kematian' => $row[32],
        //             'nama_panggilan' => $row[33],
        //             'validasi_tanggal' => $row[34],
        //             'tahun_titipan' => $row[35],
        //             'keterangan' => $row[36],
        //         ]);
        //         Tagging::create([
        //             'id_satwa' => $satwa->id,
        //             'jenis_tagging' => $row[12],
        //             'kode_tagging'=> $row[13],
        //             'alasa_belum_tagging' => $row[27],
        //             'tanggal_tagging' => $row[28],
        //         ]);
        //     }
        // }


        // ========================================== data list lk =================================
        
       

        // // ============================================== Data satwa ===========================

       
        


        
        

    }
    
}