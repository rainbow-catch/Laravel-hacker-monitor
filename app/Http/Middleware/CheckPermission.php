<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Closure $next
     * @param $action
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $action)
    {
        if (Auth::user() && Auth::user()->approve > 1) {
            return $next($request);
        }
        else if(Auth::user()->CanSee($action)) {
            return $next($request);
        }
        abort(403);
    }
}
