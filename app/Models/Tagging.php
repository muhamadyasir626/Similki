<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagging extends Model
{
    use HasFactory;

<<<<<<< Updated upstream
    public function Satwa(){
=======
    protected $guarded = ['id'];

    public function satwa(){
>>>>>>> Stashed changes
        return $this->belongsTo(Satwa::class,'id_satwa');
    }

    public function koleksi_individu(){
        return $this->hasOne(SatwaKoleksiIndividu::class);
    }

    
}
