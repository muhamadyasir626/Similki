<?php

namespace Database\Seeders;

use App\Models\Tagging;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaggingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('taggings')->insert([
            ['id' => 1, 'jenis_tagging' => 'chip'],
            ['id' => 2, 'jenis_tagging' => 'label'],
            ['id' => 3, 'jenis_tagging' => 'eartag'],
            ['id' => 4, 'jenis_tagging' => 'ring'],
        ]);
    }
}
