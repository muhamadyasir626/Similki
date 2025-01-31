<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListCaraSatwaPerolehan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function satwaperolehan(){
        return $this->hasOne(SatwaPerolehan::class);
    }
}
