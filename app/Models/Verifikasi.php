<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Verifikasi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

    public function lk(){
        return $this->belongsToMany(LembagaKonservasi::class, 'id_user');
    }
    
    public function barangKonservasi(){
        return $this->belongsToMany(barangKonservasi::class,'id_barang_konservasi');
    }
    public function satwaperolehan(){
        return $this->belongsTo(SatwaPerolehan::class);
    }
}
