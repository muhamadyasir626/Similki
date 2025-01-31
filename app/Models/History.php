<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function user(){
        return $this->hasMany(User::class,'user_id');
    }

    public function satwa(){
        return $this->hasMany(Satwa::class,'id_satwa');
    }

    public function lk(){
        return $this->hasMany(Satwa::class,'id_lk');
    }
}
