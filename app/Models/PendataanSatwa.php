<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendataanSatwa extends Model
{
    use HasFactory;

    protected $guard = ['id'];

    public function Tagging(){
        return $this->belongsTo(Tagging::class);
    }
}
