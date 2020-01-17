<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class IsAdminOrManager
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
        if (Auth::check() && Auth::user()->isAdminOrManager())
        {
            return $next($request);
        }

        return redirect('/');
    }
}
