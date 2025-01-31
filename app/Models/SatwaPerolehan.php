<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatwaPerolehan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }
    public function caraperolehan(){
        return $this->belongsTo(ListCaraSatwaPerolehan::class,'id_cara_perolehan');
    }
    public function lk(){
        return $this->belongsTo(LembagaKonservasi::class,'id_lk');
    }
    public function asallk(){
        return $this->belongsTo(LembagaKonservasi::class,'asal_lk');
    }
    public function verifikasi(){
        return $this->hasOne(Verifikasi::class);
    }
    public function spesies(){
        return $this->belongsTo(ListSpecies::class,'id_spesies');
    }
}
