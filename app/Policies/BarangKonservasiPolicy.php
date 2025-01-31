<?php

namespace App\Policies;

use App\Models\BarangKonservasi;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BarangKonservasiPolicy
{
    public function admin(User $user):bool
    {
        return $user->role->tag === 'KLKHSG'; 
    }
    
    public function create(User $user){
        return $user->role->tag === 'LK';
    }

    public function view(User $user):bool
    {
        return $user->role->tag === 'LK' || $user->role->tag === 'KKHSG' ;
    }

    public function detail(User $user, BarangKonservasi $id):bool
    {
        if($user->role->tag === 'KKHSG'){
            return true;
        }

        return $user->id_lk === $id;
    }

}
