<?php

namespace App\Http\Middleware;

use Closure;
use App\Admin;
use App\controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class checkPermission
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
        $segment1=$request->segment(1);
		
		if($segment1=='ar'){
			$segment1=$request->segment(2);
			$segment2=$request->segment(3);
		}else{
			$segment2=$request->segment(2);

		}
		$segment3=$request->segment(3); 
		if($segment3)
            $path='/'.$segment1.'/'.$segment2.'/'.$segment3;
        else
            $path='/'.$segment1.'/'.$segment2.'/index';


// //        temp
//         $scope=Admin::havePermission(session('admin')['id']);
//         $menu=controller::orderBy('order','asc')->whereHas('permission',function($q) {
//             $q->where('PermissionGroup_id',1);
//         })->with('fun')->get()->toArray();
//         session(['scope'=>$scope,'menu'=>$menu]);

        if(isset(session('scope')[$path])){
            session(['function_id'=>session('scope')[$path]]);
            return $next($request);
        }else{
            return redirect('admin/notAuth');
        }
    }
    
  
}
 