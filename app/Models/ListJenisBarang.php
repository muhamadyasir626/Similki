<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListJenisBarang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function barangKonservasi(){
        return $this->hasOne(BarangKonservasi::class);
    }
}
