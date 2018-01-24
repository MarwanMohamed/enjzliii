<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use Request;

class editProfile
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
        $url=url()->full();
        if((!session('user')['isFinishProfile'])&&(!str_contains($url,['editProfile','deleteImage','handleEditProfile','uploadImage']))) {
            if ($request->ajax()) {

                $json['status']=0;
                $json['msg']='يجب تعديل الملف الشخصي اولا '.'<a href="/editProfile">تعديل الملف الشخصي</a>';
                return response()->json($json);
            } else {
                session()->flash('msg', 'يجب تعديل الملف الشخصي اولا');
                return redirect('/editProfile');
            }
        }
        return $next($request);
    }
}
