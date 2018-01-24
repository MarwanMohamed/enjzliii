<?php

namespace App\Http\Middleware;

use Closure;

class adminHasLogin
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
        if(!session()->has('admin')){

            return redirect('admin/login');
        }else{
            global $menu;
            global $setting;
            $menu=session('menu');
            $setting['/admin/projects/needRevision']=$needRevision=\App\project::where('status',1)->get()->count();
            $setting['/admin/projects/errors']=$errors=\App\project::finishTime()->count();
            $setting['/admin/super/index']=\App\VIPRequest::where('status',0)->count();
            $setting['messages']= \App\contact::where('seen',0)->limit(10)->get()->count();
            
            $setting['projects']=$needRevision+$errors;
            $setting['super']=$setting['/admin/super/index'];
            $reports= \App\report::where('status',0)->get();
            $withdrawRequest = \App\withdrawRequest::where('status',1)->get();

            $setting['/admin/reports/portifolio']=$portifolio=arrayCount($reports,1);
            $setting['/admin/reports/projects']=$projects=arrayCount($reports,2);
            $setting['/admin/reports/users']=$users=arrayCount($reports,3);
            $setting['/admin/reports/bids']=$bids = arrayCount($reports,5);
            $setting['/admin/transactions/withdrawrequest']=$withdraws = $withdrawRequest->count();

            $setting['transactions']=$withdraws;
            $setting['reports']=$portifolio+$projects+$users+$bids;
            date_default_timezone_set ('Asia/Riyadh');
         
            
        }
        return $next($request);
    }
}
