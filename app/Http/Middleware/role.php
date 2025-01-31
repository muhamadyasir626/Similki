<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        $roles = explode(',', $roles); 
        if (Auth::check() && in_array(Auth::user()->role->tag, $roles)) {
            return $next($request);
        }

        abort(403, 'You do not have permission to access this page');
    }
}
