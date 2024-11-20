<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListSpecies extends Model
{
    use HasFactory;


    public function user(){
        return $this->belongsTo(User::class);
    }
    public function satwa(){
        return $this->belongsTo (Satwa::class);
    }
}
