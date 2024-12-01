<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagging extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_satwa',
        'jenis_tagging',
        'alasan_belum_tagging',
        'ba_tagging',
        'kode_tagging',
    ];

    public function satwa(){
        return $this->belongsTo(Satwa::class,'id_satwa');
    }

    
}
