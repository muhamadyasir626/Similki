<?php

namespace App\Models;

use App\Models\Satwa;
use App\Models\ListUpt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LembagaKonservasi extends Model
{
    use HasFactory;

    protected $guard =['id'];

    public function ListUpt(){
        return $this->belongsTo(ListUpt::class, 'id_upt');
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
