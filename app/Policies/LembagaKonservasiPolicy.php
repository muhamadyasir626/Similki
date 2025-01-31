<?php

namespace App\Policies;

use App\Models\LembagaKonservasi;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LembagaKonservasiPolicy
{
    
    public function view(User $user): bool
    {
        return in_array($user->role->tag, ['UPT', 'KKHSG']);
        
    }

    public function create(User $user): bool
    {
    return $user->role->tag === 'upt';
    }

    public function update(User $user, LembagaKonservasi $lk): bool
    {
        if($user->role->tag === 'UPT'){
            return true;
        }else{

            return $user->id_lk === $lk->id; 
        }
    }

    public function detail(User $user, LembagaKonservasi $lk):bool
    {
        if($user->role->tag === 'UPT' || $user->role->tag === 'KKHSG'){
            return true;
        }else{

            return $user->id_lk === $lk->id; 
        }
    }
}
