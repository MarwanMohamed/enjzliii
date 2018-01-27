<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class link extends Model
{
    //
    protected $table = 'link';

    static function add($email,$type){
        $checkLink=link::where('email',$email)->where('type',$type)->first();
        if(!$checkLink) {
            $token = md5(uniqid(rand(), true));
            $link = new link();
            $link->email = $email;
            $link->type = $type;
            $link->token = $token;
            $link->save();
        }else{
            link::where('email',$email)->where('type',$type)->update(['status'=>0]);
            $token=$checkLink->token;
        }
        \Illuminate\Support\Facades\Mail
            ::to([$email])->send
            (new \App\Mail\ConfirmEmail($token,$type));
        return $token;

    }
    
    
    
    static function sendRandomPassword($email,$password){
        
        \Illuminate\Support\Facades\Mail
            ::to([$email])->send
            (new \App\Mail\SendRandomPasswordMail($email,$password));

    }
    
    
    
    
}
