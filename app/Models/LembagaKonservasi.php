<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LembagaKonservasi extends Model
{
    use HasFactory;

    protected $guard =['id'];

    public function list_lk(){
        return $this->belongsTo(ListLk::class);
    }
}
