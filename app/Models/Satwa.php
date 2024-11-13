<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satwa extends Model
{
    use HasFactory;

    protected $guard = ['id'];

    public function Tagging(){
        return $this->belongsTo(Tagging::class);
    }
    public function ListSpecies(){
        return $this->belongsTo(ListSpecies::class);
    }

    public function ListLK(){
        return $this->belongsTo(ListLk::class);
    }
}
