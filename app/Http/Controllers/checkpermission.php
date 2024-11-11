<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkpermission extends Controller
{
    public function check(){
        $user = Auth::user();
        // dd($user);
        if($user){

            return response()->json(['status_permission' => $user->status_permission]);
        }
        return response()->json(['error' => 'user not Authenticated'],401);
        }
}
