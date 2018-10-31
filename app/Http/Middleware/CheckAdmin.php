<?php

namespace WidowsXP\Http\Middleware;

use Closure;
use Auth;

class CheckAdmin
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
	    #return $next($request);
	    if(Auth::user() && Auth::user()->is_admin == 1) {
		return $next($request);
	    }
	    return redirect('/')->with(['message' => 'You are not athorized to access that link. Please contact the site administrator.']);
    }
}
