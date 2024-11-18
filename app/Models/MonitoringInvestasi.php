<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringInvestasi extends Model
{
    use HasFactory;


    public function lk(){
        return $this->belongsTo(LembagaKonservasi::class,'id_lk');
    }

}
