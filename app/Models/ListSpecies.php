<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListSpecies extends Model
{
    use HasFactory;

    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Satwa(){
        return $this->belongsTo (Satwa::class);
    }
}
