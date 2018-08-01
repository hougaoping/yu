<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Route;

class Buyer
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
     
        $this->authorize('buyer', Auth::user());
        return $next($request);
    }
}
