<?php

namespace App\Http\Middleware;

use Closure;

class IsStaff
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

        if(auth()->user() && auth()->user()->isStaff()) {
            return $next($request);
        }
        else {
            redirect(route('login'));
        }
        //return $next($request);
        return redirect(route('login'));
    }
}
