<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListSpecies extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(){
        return $this->hasOne(User::class);
    }
    public function satwa(){
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
    }
}
