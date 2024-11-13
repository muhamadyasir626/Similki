<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        // Check if the user's permission status is 0 and they are not accessing the 'permission' view
        if ($user && $user->status_permission == 0 && !$this->isRoutePermission($request)) {
            return redirect()->route('permission');
        }

        return $next($request);
    }

    /**
     * Determine if the current route is the 'permission' route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isRoutePermission(Request $request)
    {
        // Check if the current route name is 'permission'
        return $request->route()->named('permission');
    }
}
