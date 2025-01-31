<?php

namespace App\Models;

use App\Models\Satwa;
use App\Models\ListUpt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LembagaKonservasi extends Model
{
    use HasFactory;

    protected $guard =['id'];

    public function upt(){
        return $this->belongsTo(ListUpt::class, 'id_upt');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function satwa(){
        return $this->belongsTo(Satwa::class);
    }
    public function verifikasi(){
        return $this->hasMany(Verifikasi::class);
    }
    public function riwayat_lk(){
        return $this->hasMany(RiwayatLK::class);
    }
    public function satwa_koleksi_individu(){
        return $this->hasOne(SatwaKoleksiIndividu::class);
    }
    public function titipan(){
        return $this->hasOne(SatwaTitipan::class);
    }
    public function satwaperolehan(){
        return $this->hasOne(SatwaPerolehan::class);
    }
}
