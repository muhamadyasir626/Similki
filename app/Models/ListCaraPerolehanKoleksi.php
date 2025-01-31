<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListCaraPerolehanKoleksi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function satwa_koleksi_individu(){
        return $this->hasOne(SatwaKoleksiIndividu::class);
    }
}
