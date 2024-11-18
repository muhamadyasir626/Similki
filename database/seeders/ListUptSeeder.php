<?php

namespace Database\Seeders;

use App\Models\ListUpt;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ListUptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
