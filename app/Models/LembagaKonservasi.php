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

    protected $guarded =['id'];

    public function upt(){
        return $this->belongsTo(ListUpt::class, 'id_upt');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function satwa(){
        return $this->belongsTo(Satwa::class);
    }
    public function monitoring(){
        return $this->belongsTo(MonitoringInvestasi::class);
    }
}
