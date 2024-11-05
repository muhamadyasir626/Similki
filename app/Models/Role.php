<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tag'
    ];

    protected $guard =['id'];

    public function User(){
        return $this->belongsTo(User::class);
    }

}
