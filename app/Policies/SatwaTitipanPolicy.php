<?php

namespace App\Policies;

use App\Models\SatwaTitipan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SatwaTitipanPolicy
{
    public function create(User $user):bool{
        return $user->role->tag === 'LK';
    }
    
}
