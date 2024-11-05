<?php

namespace Database\Seeders;

use App\Models\ListLk;
use App\Models\ListSpecies;
use App\Models\ListUpt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CSVSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // =========================== LIST LK =====================
        // $csvFile = base_path('resources\data\list_lk.csv');
        // $data = array_map(function ($line) {
        //     return str_getcsv($line, ','); 
        // }, file($csvFile));
    
        // array_shift($data); 
    
        // // $filteredData = array_filter($data, function ($row) {
        // //     return count($row) > 1;
        // // });

        // // dd($filteredData);
        // // dd($data);
    
        // foreach ($data as $row) {
        //     ListLk::Create([
        //         'name' => $row[0], 
        //         'slug' => $row[1], 
        //     ]);
        // }

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
    //     $csvFile = base_path('resources\data\list_species.csv');
    //     $data = array_map(function($line){
    //         return str_getcsv($line,',');
    //     }, file($csvFile));

    //     array_shift($data);

    //     // dd($data);

    //     foreach($data as $row){
    //         ListSpecies::create([
    //             'class' => $row[0],
    //             'genus' => $row[5],
    //             'spesies' => $row[6],
    //             'subspesies' => $row[7],
    //             'nama_lokal' => $row[3],
    //             'nama_ilmiah' => $row[4],
    //         ]);
    //     }
    
    }
    
}
