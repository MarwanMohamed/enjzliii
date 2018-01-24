<?php

namespace App\Http\Middleware;

use Closure;

class skipLogin
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

        if(str_contains($request->path(),'confirmEmail')){
            return $next($request);
        }
        if(session()->has('user')){
            return redirect('/projects');
        }
        return $next($request);
    }
}
