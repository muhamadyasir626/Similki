<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatwaKoleksiIndividu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function riwayatSatwa(){
        return $this->hasMany(RiwayatSatwa::class);
    }
    public function tagging(){
        return  $this->belongsTo(Tagging::class,'bentuk_tagging');
    }
    public function list_cara_perolehan_koleksi(){
        return $this->belongsTo(ListCaraPerolehanKoleksi::class, 'cara_perolehan_koleksi');
    }
    public function lk(){
        return $this->belongsTo(LembagaKonservasi::class, 'id_lk');
    }
    public function spesies(){
        return $this->belongsTo(ListSpecies::class, 'id_spesies');
    }
}
