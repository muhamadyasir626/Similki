<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatwaKoleksi extends Model
{
    use HasFactory;

    protected $guard =['id'];

    public function ListSpecies(){
        return $this->belongsTo(ListSpecies::class);
    }

    public function ListLK(){
        return $this->belongsTo(ListLk::class);
    }
}
