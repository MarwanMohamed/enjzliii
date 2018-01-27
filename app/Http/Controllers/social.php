<?php

namespace App\Http\Controllers;

use App\user;
use Illuminate\Http\Request;
use Socialite;
 
class social extends Controller {

    //

    public function redirectToProvider() {

        return Socialite::driver('facebook')->redirect();
    }

    public function loginTwitter() {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback() {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return redirect('/');
        }
        $social = \App\social::where('provider_id', $user->getId())->where('provider', 'facebook')->first();
        
        
        if ($social && $social->user) {
            
            session()->put('user', $social->user->toArray());
             user::where('id',session('user')['id'])->update(['avatar'=> $user->getAvatar()]);
            $url = '/singleUser';
//            dd($social->user);
        } else {
            $state = 0;
            $user1 = user::where('email', $user->getEmail())->first();
            if (!$user1) {
                $user1 = new user();
                $user1->finishProfileStep = json_encode(['emailConfirm' => 1]);
                $user1->isSocial = 1;
                $user1->isFinishProfile = 0;
            }
            $user1->avatar = $user->getAvatar();
            $user1->email = $user->getEmail();
            $user1->fname = $user->user['name'];
            $user1->lname = '';
            $user1->save();
            $user1->addDefaultNoti();

            $user1 = user::where('id', $user1->id)->first();
            session()->put('user', $user1->toArray());
            $user1->socialProvider()->create(['provider_id' => $user->getId(), 'provider' => 'facebook']);
            $url = '/editProfile';
        }
        return redirect($url);
    }

    public
            function callbackTwitter() {
        // $user->token;

        try {
            $user = Socialite::driver('twitter')->user();

        } catch (\Exception $e) {
            return redirect('/');
        }

        $social = \App\social::where('provider_id', $user->getId())->where('provider', 'twitter')->first();

        if ($social && $social->user) {
            session()->put('user', $social->user->toArray());
            user::where('id',session('user')['id'])->update(['avatar'=> $user->getAvatar()]);
            $url = '/singleUser';
        } else {
            $user1 = user::where('email', $user->getEmail())->first();
            if (!$user1) {
                $user1 = new user();
                $user1->isFinishProfile = 0;
                $user1->finishProfileStep = json_encode(['emailConfirm' => 1]);
                $user1->isSocial = 1;
            } else if ($user->getEmail()) 
                $user1->email = $user->getEmail();
            else 
                $user1->email = '';
            $user1->fname = $user->getName();

            $user1->lname = '';
            $user1->avatar = $user->getAvatar();
            $user1->save();
            $user1->addDefaultNoti();

            $user1 = user::where('id', $user1->id)->first();
 
            session()->put('user', $user1->toArray());

            $user1->socialProvider()->create(['provider_id' => $user->getId(), 'provider' => 'twitter']);
            $url = '/editProfile';
        }
        return redirect($url);
    }

}
