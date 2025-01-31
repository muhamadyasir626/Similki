<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListAsalSatwaTitipan extends Model
{
    use HasFactory;

    public function titipan(){
        return $this->hasOne(SatwaTitipan::class);
    }
}
