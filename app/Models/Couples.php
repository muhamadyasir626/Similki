<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Couples extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function satwa(){
        return $this->belongTo(Satwa::class,'id_jantan','id_betina');
    }
}
