<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagging extends Model
{
    use HasFactory;

    public function SatwaKoleksi(){
        return $this->belongsTo(SatwaKoleksi::class);
    }

    public function PendataanSatwa(){
        return $this->belongsTo(PendataanSatwa::class);
    }
}
