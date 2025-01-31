<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatSatwa extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function User(){
        return $this->belongsTo(User::class, 'id_user');
    }

    public function satwaPerolehan(){
        return $this->belongsTo(SatwaPerolehan::class, 'id_satwa_perolehan');
    }
    public function satwaKoleksiIndividu(){
        return $this->belongsTo(SatwaKoleksiIndividu::class, 'id_satwa_koleksi_individu');
    }
    public function satwaTitipan(){
        return $this->belongsTo(SatwaTitipan::class, 'id_satwa_titipan');
    }
    // public function satwaKoleksiKelompok(){
    //     return $this->belongsTo(SatwaKoleksiKelompok::class, 'id_satwa_koleksi_kelompok');
    // }
}
