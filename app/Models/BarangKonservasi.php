<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKonservasi extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function jenisBarang(){
        return $this->belongsTo(ListJenisBarang::class, 'jenis_barang');
    }

    public function verifikasi(){
        return $this->hasMany(Verifikasi::class);
    }
}
