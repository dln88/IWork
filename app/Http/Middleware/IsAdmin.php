<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
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
        if(session('user')->admin_div) {
            if(session('user')->admin_div === config('define.admin_div.admin')) {
                return $next($request);
            }
        }
        return redirect(route('login'));
    }
}
