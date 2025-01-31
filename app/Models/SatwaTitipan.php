<?php

namespace App\Models;

use Database\Seeders\ListSpeciesSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatwaTitipan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function lk(){
        return $this->belongsTo(LembagaKonservasi::class, 'id_lk');
    }

    public function spesies(){
        return $this->belongsTo(ListSpecies::class, 'id_spesies');
    }

    public function asal_satwa(){
        return $this->belongsTo(ListAsalSatwaTitipan::class,'asal_satwa_titipan');
    }
}
