<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use Request;

class hasLogin
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
        if(!session()->has('user')){
          
            if(Request::ajax()){
                $json['status']=0;
                $json['msg']='الرجاء تسجيل الدخول '.'<a href="/login">سجل</a>';
                return response()->json($json);
            }else
            return redirect('/login');
        }
        return $next($request);
    }
}
