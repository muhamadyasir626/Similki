<?php

namespace App\Policies;

use App\Models\SatwaKoleksiIndividu;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SatwaKoleksiIndividuPolicy
{
    public function create(User $user):bool{
        return $user->role->tag === 'LK';
    }
}
