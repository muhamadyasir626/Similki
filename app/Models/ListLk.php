<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListLk extends Model
{
    use HasFactory;
    protected $guard =['id'];

    public function User(){
        return $this->belongsTo(User::class);
    }
    public function LembagaKonservasi(){
        return $this->belongsTo(LembagaKonservasi::class);
    }
    public function MonitoringInvestasi(){
        return $this->belongsTo(MonitoringInvestasi::class);
    }
}
