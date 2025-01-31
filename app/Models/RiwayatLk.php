<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatLk extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function user(){
        return $this->belongsToMany(User::class,'id_user');
    }
    public function lk(){
        return $this->belongToManny(LembagaKonservasi::class,'id_lk');
    }
}
