<?php

namespace Database\Seeders;

use App\Models\Satwa;
use App\Models\Tagging;
use App\Models\ListSpecies;
use Illuminate\Database\Seeder;
use App\Models\LembagaKonservasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class satwaeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path('resources/data/db satwa.csv');
        $data = array_map(function ($line) {
            return str_getcsv($line, ',');
        }, file($csvFile));

        array_shift($data); // Menghapus header CSV
        // foreach($data as $index =>$row){
        //     if($index === 571){
        //         echo 'menemukan 571-';
        //         // dd($row);
        //         $id_lk = LembagaKonservasi::where('slug', $row[2])->value('id');
        //         dd($id_lk);

        //         $id_species = ListSpecies::where('nama_lokal', $row[10])->value('id');
        //         if (!$id_species) {
        //             $id_species = ListSpecies::create([
        //                 'class' => $row[5] ?? NULL,
        //                 'genus' => $row[7] ?? NULL,
        //                 'spesies' => $row[8] ?? NULL,
        //                 'subspesies' => $row[9] ?? NULL,
        //                 'nama_lokal' => $row[10] ?? NULL,
        //                 'nama_ilmiah' => $row[11] ?? NULL,
        //             ])->id;
        //         }

        //         $status_perlindungan = ($row[6] == 'dilindungi') ? 1 : 0;
        //         $pengambilan_Satwa = ($row[17] == 'endemik') ? 1 : 0;
        //         $perilaku_satwa = ($row[21] == 'individu') ? 1 : 0;
        //         $jenis_kelamin_individu = ($row[22] == 'jantan') ? 1 : 0;
        //         $tahun_titipan = isset($row[34]) ? substr(trim($row[34]), 0, 4) : NULL;

        //         $validasi_tanggal = (!empty(trim($row[33])) && preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($row[33]))) 
        //             ? $row[33] 
        //             : NULL;
        //         if ($row[32] === 'tidak ada') {
        //             $row[32] = '';
        //         }
        //         if (isset($id_species) && isset($id_lk)) {
        //             $satwa = Satwa::create([
        //                 'id_lk' => $id_lk,
        //                 'jenis_koleksi' => $row[3],
        //                 'asal_satwa' => $row[4],
        //                 'no_sats_ln' => $row[16],
        //                 'id_spesies' => $id_species,
        //                 'status_perlindungan' => $status_perlindungan,
        //                 'pengambilan_satwa' => $pengambilan_Satwa,
        //                 'sk_kepala' => $row[18] ?? NULL,
        //                 'sk_menteri' => $row[20] ?? NULL,
        //                 'sk_ksdae' => $row[19] ?? NULL,
        //                 'perilaku_satwa' => $perilaku_satwa,
        //                 'jenis_kelamin_individu' => $jenis_kelamin_individu,
        //                 'status_satwa' => $row[14],
        //                 'jumlah_jantan' => $row[23],
        //                 'jumlah_betina' => $row[24],
        //                 'jumlah_unsex' => $row[25],
        //                 'jumlah_keseluruhan_gender' => $row[26],
        //                 'no_izin_peroleh' => $row[16] ?? NULL,
        //                 'no_ba_titipan' => $row[29] ?? NULL,
        //                 'no_ba_kelahiran' => $row[20] ?? NULL,
        //                 'no_ba_kematian' => $row[31] ?? NULL,
        //                 'nama_panggilan' => $row[32] ?? NULL,
        //                 'validasi_tanggal' => $validasi_tanggal,
        //                 'tahun_titipan' => $tahun_titipan,
        //                 'keterangan' => $row[35] ?? NULL,
        //             ]);
        //             $tanggal_tagging = (!empty(trim($row[27])) && preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($row[27]))) 
        //                 ? $row[27] 
        //                 : NULL;
        //             Tagging::create([
        //                 'id_satwa' => $satwa->id,
        //                 'jenis_tagging' => $row[11] ?? NULL,
        //                 'kode_tagging' => $row[12] ?? NULL,
        //                 'alasan_belum_tagging' => $row[26] ?? NULL,
        //                 'tanggal_tagging' => $tanggal_tagging ?? NULL,
        //             ]);
        //             // if($index === 9){
        //             //     dd("Row-index " . ($index + 1) . " successfully saved to database.\n") ;

        //             // }
        //             // dd("Row " . ($index + 1) . " successfully saved to database.\n") ;
        //             dd($satwa);
        //             break;
        //         }
        //     }
            
        // }
        foreach ($data as $index => $row) { // Tambahkan $index untuk melacak baris
            try {
                dd($row[27]);
                $id_lk = LembagaKonservasi::where('slug', $row[2])->value('id');

                $id_species = ListSpecies::where('nama_lokal', $row[10])->value('id');
                if (!$id_species) {
                    $id_species = ListSpecies::create([
                        'class' => $row[5] ?? NULL,
                        'genus' => $row[7] ?? NULL,
                        'spesies' => $row[8] ?? NULL,
                        'subspesies' => $row[9] ?? NULL,
                        'nama_lokal' => $row[10] ?? NULL,
                        'nama_ilmiah' => $row[11] ?? NULL,
                    ])->id;
                }

                $status_perlindungan = ($row[6] == 'dilindungi') ? 1 : 0;
                $pengambilan_Satwa = ($row[17] == 'endemik') ? 1 : 0;
                $perilaku_satwa = ($row[21] == 'individu') ? 1 : 0;
                $jenis_kelamin_individu = ($row[22] == 'jantan') ? 1 : 0;
                $tahun_titipan = isset($row[34]) ? substr(trim($row[34]), 0, 4) : NULL;

                $validasi_tanggal = (!empty(trim($row[33])) && preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($row[33]))) 
                    ? $row[33] 
                    : NULL;
                if ($row[32] === 'tidak ada') {
                    $row[32] = '';
                }

                if (isset($id_species) && isset($id_lk)) {
                    $satwa = Satwa::create([
                        'id_lk' => $id_lk,
                        'jenis_koleksi' => $row[3],
                        'asal_satwa' => $row[4],
                        'no_sats_ln' => $row[16],
                        'id_spesies' => $id_species,
                        'status_perlindungan' => $status_perlindungan,
                        'pengambilan_satwa' => $pengambilan_Satwa,
                        'sk_kepala' => $row[18] ?? NULL,
                        'sk_menteri' => $row[20] ?? NULL,
                        'sk_ksdae' => $row[19] ?? NULL,
                        'perilaku_satwa' => $perilaku_satwa,
                        'jenis_kelamin_individu' => $jenis_kelamin_individu,
                        'status_satwa' => $row[14],
                        'jumlah_jantan' => $row[23],
                        'jumlah_betina' => $row[24],
                        'jumlah_unsex' => $row[25],
                        'jumlah_keseluruhan_gender' => $row[26],
                        'no_izin_peroleh' => $row[16] ?? NULL,
                        'no_ba_titipan' => $row[29] ?? NULL,
                        'no_ba_kelahiran' => $row[20] ?? NULL,
                        'no_ba_kematian' => $row[31] ?? NULL,
                        'nama_panggilan' => $row[32] ?? NULL,
                        'validasi_tanggal' => $validasi_tanggal,
                        'tahun_titipan' => $tahun_titipan,
                        'keterangan' => $row[35] ?? NULL,
                    ]);
                    $tanggal_tagging = (!empty(trim($row[27])) && preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($row[27]))) 
                        ? $row[27] 
                        : NULL;
                    Tagging::create([
                        'id_satwa' => $satwa->id,
                        'jenis_tagging' => $row[12] ?? NULL,
                        'kode_tagging' => $row[13] ?? NULL,
                        'alasan_belum_tagging' => $row[27] ?? NULL,
                        'tanggal_tagging' => $tanggal_tagging ?? NULL,
                    ]);
                    // if($index === 9){
                    //     dd("Row-index " . ($index + 1) . " successfully saved to database.\n") ;

                    // }
                    // dd("Row " . ($index + 1) . " successfully saved to database.\n") ;

                }
            } catch (\Exception $e) {
                // Tampilkan error di terminal
                echo "Error at row " . ($index + 1) . ": " . $e->getMessage() . "\n";
            }
        }
    }

    
}
