<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListUpt extends Model
{
    use HasFactory;

    protected $guard =['id'];
    protected $fillable =[
        'nama',
        'wilayah',
        'slug',
    ];


}
