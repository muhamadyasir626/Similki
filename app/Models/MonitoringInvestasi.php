<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringInvestasi extends Model
{
    use HasFactory;


    public function ListLk(){
        return $this->belongsTo(ListLk::class);
    }
}
