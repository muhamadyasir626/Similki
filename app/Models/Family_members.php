<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family_members extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function satwaAsAyah(){
        return $this->hasMany(satwa::class,'id_ayah');
    }
    public function satwaAsIbu(){
        return $this->hasMany(satwa::class,'id_ibu');
    }

}
