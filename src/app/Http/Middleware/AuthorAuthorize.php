<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthorAuthorize
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
        if (!(Auth::user()->id == $request->id)) { //$request->id from URL
            return redirect()->route('homes.home')->withErrors('この行動は禁止です！');
        }
        return $next($request);
    }
}
