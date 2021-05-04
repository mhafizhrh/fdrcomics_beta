<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ... $role)
    {
        if (Auth::check() && in_array(Auth::user()->role, $role)) {

            return $next($request);
        }

        // return redirect()->route('login');
        abort(403);
    }
}
