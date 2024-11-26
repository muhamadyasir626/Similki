<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satwa extends Model
{
    use HasFactory;

    protected $guard = ['id'];
    protected $table = 'satwas';

    public function tagging(){
        return $this->belongsTo(Tagging::class, 'id_satwa');
    }
    public function species(){
        return $this->belongsTo(ListSpecies::class,'id_spesies');
    }
    public function lk(){
        return $this->belongsTo(LembagaKonservasi::class, 'id_lk');
    }
}
