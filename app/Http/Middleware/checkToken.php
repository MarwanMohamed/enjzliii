<?php

namespace App\Http\Middleware;

use Closure;
use Validator;
class checkToken
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
                    global $user;

        
        $validator = Validator::make(['token'=>$request->header('token')], [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error_type" => "Validation Errors",
                'error' => $validator->errors()

            ], 422);
        }
            $user = \App\user::where('api_token', $request->header('token'))->first();
            if ($user) {
                 
            if ($user->isdelete) {
                $json['msg']= 'تم حذف حسابك من قبل الإدارة ,الرجاء التواصل مع الإدارة';
                return Response()->json($json,401);
            } else {
                $setting['isBlock'] = ($user->status == 2) ? 1 : 0;
            }
                return $next($request);
            }else{
                return Response()->json('Unauthorized ',401);
            }
//        }
        }
    }
