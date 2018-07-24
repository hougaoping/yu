<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Route;

class Admin
{
    use AuthorizesRequests;
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if ( !session()->has('is_admin') && !(session()->get('is_admin') == 1) ) {
            return redirect('/');
        }

        $this->authorize('admin', Auth::user());
        $this->authorize('permission', Auth::user());
        return $next($request);
    }
}
