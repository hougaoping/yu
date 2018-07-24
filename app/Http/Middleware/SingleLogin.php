<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class SingleLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $last_login_time = session()->get('last_login_time');
        if ($last_login_time != Auth::user()->last_login_time) {
            Auth::logout(); 
            return redirect('/login');
        }

        return $next($request);
    }
}
