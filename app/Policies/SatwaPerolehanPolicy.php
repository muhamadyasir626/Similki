<?php

namespace App\Policies;

use App\Models\SatwaPerolehan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SatwaPerolehanPolicy
{
    public function create (User $user){
        return $user->role->tag === 'LK' ;
    }
}
