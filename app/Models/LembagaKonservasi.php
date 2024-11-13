<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Satwa;

class LembagaKonservasi extends Model
{
    use HasFactory;

    protected $guard =['id'];

    public function list_upt(){
        return $this->belongsTo(ListUpt::class);
    }
    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Satwa(){
        return $this->belongsTo(Satwa::class);
    }
    public function MonitoringInvestasi(){
        return $this->belongsTo(MonitoringInvestasi::class);
    }
}
