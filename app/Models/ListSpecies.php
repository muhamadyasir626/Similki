<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListSpecies extends Model
{
    use HasFactory;

<<<<<<< Updated upstream
=======
    protected $guarded = ['id'];

>>>>>>> Stashed changes
    public function user(){
        return $this->hasOne(User::class);
    }
    public function satwa(){
<<<<<<< Updated upstream
        return $this->belongsTo (Satwa::class);
=======
        return $this->hasMany(Satwa::class);
    }
    public function koleksi_individu(){
        return $this->hasOne(SatwaKoleksiIndividu::class);
    }
    public function titipan(){
        return $this->hasOne(SatwaTitipan::class);
    }
    public function satwaperolehan(){
        return $this->hasOne(satwaperolehan::class);
>>>>>>> Stashed changes
    }
}
