<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Verifikasi;
use Illuminate\Auth\Access\Response;

class VerifikasiPolicy
{
    public function update(User $user):bool{
        return $user->role->tag === 'KKHSG';
    }
}
