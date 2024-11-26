<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListSpecies extends Model
{
    use HasFactory;
    protected $table = 'list_species';
    protected $primaryKey = 'id';

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function satwa(){
        // return $this->belongsTo (Satwa::class);
        return $this->hasMany(Satwa::class, 'id_spesies', 'id');
    }
}
