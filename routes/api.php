<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE,OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Authorization, Content-Type, Api-Token,Device-Token,token');

Route::group(['prefix' => 'v1'], function () {
    Route::group(['namespace' => 'api'], function () {

        Route::post('user/push/token', 'users@pushToken');
        Route::get('avatar/{user}', 'users@showImage')->name('avatar');
        Route::post('registration', 'users@registration'); // not
        Route::post('socialLoginHandle', 'users@socialLoginHandle');
        
        Route::post('login', 'users@login');


        Route::group(['middleware' => 'checkToken'], function () {
            Route::post('resetPassword', 'users@resetPassword'); // not


            Route::group(['prefix'=>'notification'],function (){
                Route::get('messages/UnseenCount','view@unseenCount');
                Route::get('/','view@noti');
                Route::get('message','view@message');
                Route::get('notiSeen/{id}','view@notiSeen');
                Route::get('messageSeen/{id}','view@messageSeen');
            });
        });
    });
});