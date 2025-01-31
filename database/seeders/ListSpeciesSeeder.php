<?php

namespace Database\Seeders;

use App\Models\ListSpecies;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ListSpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
                // 'subspesies' => $row[7],
                'nama_lokal' => $row[3],
                'nama_ilmiah' => $row[4],
                'nama_internasional' => '',
            ]);
        }
    }
}
