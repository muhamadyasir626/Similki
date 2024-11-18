<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListUpt extends Model
{
    use HasFactory;

    protected $guard =['id'];
    protected $fillable =[
        'nama',
        'wilayah',
        'slug',
    ];

    public function lk(){
        return $this->belongsTo(LembagaKonservasi::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

  


}
