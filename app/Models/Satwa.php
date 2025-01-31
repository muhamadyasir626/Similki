<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satwa extends Model
{
    use HasFactory;

<<<<<<< Updated upstream
    protected $guard = ['id'];
=======
    protected $guarded = ['id'];
    protected $table = 'satwa';
>>>>>>> Stashed changes

    // public function tagging(){
    //     return $this->belongsTo(Tagging::class);
    // }
    public function species(){
        return $this->belongsTo(ListSpecies::class,'id_spesies');
    }

    public function lk(){
        return $this->belongsTo(LembagaKonservasi::class, 'id_lk');
    }
<<<<<<< Updated upstream
=======

    public function family_member(){
        return $this->belongsTo(Family_members::class);
    }

    public function copule(){
        return $this->belongsTo(Couples::class);
    }

    public function history(){
        return $this->hasMany(History::class);
    }
>>>>>>> Stashed changes
}
