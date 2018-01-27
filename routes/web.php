<?php
use Illuminate\Support\Facades\Storage;
/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */


//    admin

 Route::get('test12',function(){
    requestVisa(100);
  });
Route::get('testM',function(){
   $aa = \App\portfolio::where('user_id', 42)->first(['files'])->files;
//    array_push($aa,22);
    $f = explode('"',$aa);

    $arr = [];
    foreach ($f as $e){
        if(is_numeric($e)){
            array_push($arr,$e);
        }
    }

    dd(json_encode($arr));


  });
Route::group(['prefix' => 'admin'], function () {

    Route::group(['namespace' => 'admin', 'middleware' => 'adminSkipLogin'], function () {
        Route::get('login', ["uses" => "adminAuth@login", 'as' => 'login']);
        Route::get('/', ["uses" => "adminAuth@login", 'as' => 'login']);
        Route::get('forget', ["uses" => "adminAuth@forget", 'as' => 'forget']);
        Route::get('resetPass/{code}', ["uses" => "adminAuth@resetPass", 'as' => 'resetPass']);


        Route::post('handel_login', ['as' => 'handel_login', 'uses' => 'adminAuth@handel_login']
        );

        Route::post('handle_resetPass', ['as' => 'handle_resetPass', 'uses' => 'adminAuth@handle_resetPass']
        );
        Route::post('handle_Forget', ['as' => 'handle_Forget', 'uses' => 'adminAuth@handle_Forget']
        );
    });


    Route::group(['middleware' => 'adminHasLogin'], function () {
            Route::post('addmoney/payout', array('as' => 'addmoney.payout', 'uses' => 'AddMoneyController@payout'));
        Route::group(['namespace' => 'admin'], function() {

            Route::get('/statistic','control@statistic');

            Route::get('logout', ["uses" => "adminAuth@logout"]);
            Route::get('/', ["uses" => "users@index"]);
            Route::get('/notAuth', ["uses" => "adminAuth@notAuth"]);

            Route::get('accountSetting', 'adminAuth@accountSetting');
            Route::post('accountSetting', 'adminAuth@accountSettingPost');

            Route::group([], function () {
//        users accounts['middleware' => 'checkPermission']

                Route::group(['prefix' => 'users'], function () {
                    Route::get('/index', ["uses" => "users@index"]);
                    Route::get('/', ["uses" => "users@index"]);
                    Route::get('/singleUser/{id}', ["uses" => "users@singleUser"]);
                    Route::get('/single/{id}', ["uses" => "users@single"]);
                    Route::get('/VIP/{id}', ["uses" => "users@updateVip"]);
                    Route::get('/delete/{id}', ["uses" => "users@delete"]);
                    Route::post('/block', ["uses" => "users@block"]);
                    Route::post('/notifcation', ["uses" => "users@notifcation"]);
                    Route::get('/activate/{id}', ["uses" => "users@activate"]);
                    Route::get('/activateAccount/{id}', ["uses" => "users@activateAccount"]);
                    Route::get('/add', ["uses" => "users@add"]);
                    Route::post('/add', ["uses" => "users@addPost"]);
                    Route::get('/setting', ["uses" => "users@setting"]);
                    Route::get('/statistic', ["uses" => "users@statistic"]);
                });

                Route::group(['prefix' => 'projects'], function () {
                    Route::get('/index', ["uses" => "projects@index"]);
                    Route::get('/needRevision', ["uses" => "projects@needRevision"]);
                    Route::get('/', ["uses" => "projects@index"]);
                    Route::get('/single/{id}', ["uses" => "projects@single"]);
                    Route::get('/cancel/{id}', ["uses" => "projects@delete"]);
                    Route::post('/cancel', ["uses" => "projects@cancel"]);
                    Route::post('/block', ["uses" => "projects@block"]);
                    Route::get('/unblock/{id}', ["uses" => "projects@unblock"]);
                    Route::get('/approve/{id}', ["uses" => "projects@approve"]);
                    Route::get('/errors', ["uses" => "projects@errors"]);
                    Route::get('/statistic', ["uses" => "projects@statistic"]);

                });


                Route::group(['prefix' => 'bids'], function () {
                    Route::get('/index', ["uses" => "bids@index"]);
                    Route::get('/index/{id}', ["uses" => "bids@index"]);
                    Route::get('/', ["uses" => "bids@index"]);
                    Route::get('/single/{id}', ["uses" => "bids@single"]);
                    Route::post('/block', ["uses" => "bids@block"]);
                    Route::get('/unblock/{id}', ["uses" => "bids@unblock"]);
                    Route::get('/statistic', ["uses" => "bids@statistic"]);

                });



                Route::group(['prefix' => 'conversations'], function () {
                    Route::get('/index', ["uses" => "conversations@index"]);
                    Route::get('/', ["uses" => "conversations@index"]);
                    Route::get('/single/{id}', ["uses" => "conversations@single"]);
                    Route::post('/send', ["uses" => "conversations@send"]);
                    Route::get('/block/{id}', ["uses" => "conversations@block"]);
                    Route::get('/unblock/{id}', ["uses" => "conversations@unblock"]);
                    Route::get('/statistic', ["uses" => "conversations@statistic"]);
                });

                Route::group(['prefix' => 'reports'], function () {
                    Route::get('/projects', ["uses" => "reports@project"]);
                    Route::get('/bids', ["uses" => "reports@bids"]);
                    Route::get('/portifolio', ["uses" => "reports@portifolio"]);
                    Route::get('/users', ["uses" => "reports@users"]);
                    Route::get('/blockProject/{id}', ["uses" => "reports@blockProject"]);
                    Route::get('/blockPortfolio/{id}', ["uses" => "reports@blockPortfolio"]);
                    Route::get('/unblockPortfolio/{id}', ["uses" => "reports@unblockPortfolio"]);
                    Route::get('/blockUser/{id}', ["uses" => "reports@blockUser"]);
                    Route::get('/show/{type}/{id}', ["uses" => "reports@show"]);
                    Route::get('statistic', 'reports@statistic');

                });
                        Route::group(['prefix' => 'transactions'], function () {
                            Route::get('/index', ["uses" => "transactions@index"]);
                            Route::get('/user/{id}', ["uses" => "transactions@user"]);
                            Route::get('/statistic', ["uses" => "transactions@statistic"]);
                            Route::get('/withdrawrequest', ["uses" => "transactions@withdrawrequest"]);
                            Route::post('/withdraw', ["uses" => "transactions@withdraw"]);
                        });



                Route::group(['prefix' => 'files'], function () {
                    Route::get('/index', 'files@index');
                    Route::get('/edit/{id}', 'files@edit');
                    Route::post('/edit', 'files@edit');
                    Route::post('/add', 'files@add');
                    Route::get('/deleteType/{id}', 'files@deleteType');
                    Route::get('/editType/{id}', 'files@editType');
                    Route::post('/editType', 'files@editTypePost');
                });




                Route::group(['prefix' => 'control'], function() {
                    Route::get('/usersImages', ["uses" => "users@images"]);
                    Route::post('/usersImages', ["uses" => "users@updateImages"]);
                    Route::get('/filesTypes', 'files@types');

                    Route::get('viewAdmin', ["uses" => "control@viewAdmin"]);
                    Route::get('newAdmin', ["uses" => "control@newAdmin"]);
                    Route::post('newAdmin', ["uses" => "control@newAdminPost"]);
                    Route::get('editAdmin/{id}', ["uses" => "control@editAdmin"])->where(['id' => '[0-9]+']);
                    Route::post('editAdmin', ["uses" => "control@editAdminPost"]);
                    Route::get('deleteAdmin/{id}', ["uses" => "control@deleteAdmin"])->where(['id' => '[0-9]+']);
                    Route::get('activateAdmin/{id}', ["uses" => "control@activateAdmin"])->where(['id' => '[0-9]+']);
                    Route::get('deActivateAdmin/{id}', ["uses" => "control@deActivateAdmin"])->where(['id' => '[0-9]+']);


                    Route::get('permission', ["uses" => "control@permission"]);
                    Route::get('newGroup', ["uses" => "control@newGroup"]);
                    Route::post('newGroup', ["uses" => "control@newGroupPost"]);
                    Route::get('editGroup/{id}', ["uses" => "control@editGroup"])->where(['id' => '[0-9]+']);
                    Route::get('deleteGroup/{id}', ["uses" => "control@deleteGroup"])->where(['id' => '[0-9]+']);
                    Route::post('editGroup', ["uses" => "control@editGroupPost"]);
                    Route::post('handleSetting', ["uses" => "control@handleSetting"]);
                    Route::get('settings', ["uses" => "control@settings"]);
                    Route::post('settings', ["uses" => "control@settingsPosts"]);
                });

                Route::group(['prefix' => 'constants'], function () {
                    Route::get('/budget', ["uses" => "constants@budget"]);
                    Route::get('/deleteBudget/{id}', ["uses" => "constants@deleteBudget"]);
                    Route::post('/addBudget', ["uses" => "constants@addBudget"]);
                    Route::post('/editBudget', ["uses" => "constants@editBudgetPost"]);
                    Route::get('/editBudget/{id}', ["uses" => "constants@editBudget"]);

                    Route::get('/specialization', ["uses" => "constants@specialization"]);
                    Route::get('/deleteSpec/{id}', ["uses" => "constants@deleteSpec"]);
                    Route::post('/addSpec', ["uses" => "constants@addSpec"]);
                    Route::post('/editSpec', ["uses" => "constants@editSpecPost"]);
                    Route::get('/editSpec/{id}', ["uses" => "constants@editSpec"]);
                    Route::get('/editSkill/{id}', ["uses" => "constants@editSkill"]);

                    Route::get('/skills', ["uses" => "constants@skills"]);
                    Route::get('/deleteSkill/{id}', ["uses" => "constants@deleteSkill"]);
                    Route::post('/addSkill', ["uses" => "constants@addSkill"]);
                    Route::post('/editSkill', ["uses" => "constants@editSkillPost"]);
                    Route::get('/editSkill/{id}', ["uses" => "constants@editSkill"]);

                    Route::get('/countries', ["uses" => "constants@countries"]);
                    Route::get('/deleteCountry/{id}', ["uses" => "constants@deleteCountry"]);
                    Route::post('/addCountry', ["uses" => "constants@addCountry"]);
                    Route::post('/editCountry', ["uses" => "constants@editCountryPost"]);
                    Route::get('/editCountry/{id}', ["uses" => "constants@editCountry"]);

                    Route::get('/tibs', ["uses" => "constants@tibs"]);
                    Route::get('/deleteTib/{id}', ["uses" => "constants@deleteTib"]);
                    Route::post('/addTib', ["uses" => "constants@addTib"]);
                    Route::post('/editTib', ["uses" => "constants@editTibPost"]);
                    Route::get('/editTib/{id}', ["uses" => "constants@editTib"]);

                    Route::get('/faq', ["uses" => "constants@faq"]);
                    Route::get('/deletefaq/{id}', ["uses" => "constants@deletefaq"]);
                    Route::post('/addfaq', ["uses" => "constants@addfaq"]);
                    Route::post('/editfaq', ["uses" => "constants@editfaqPost"]);
                    Route::get('/editfaq/{id}', ["uses" => "constants@editfaq"]);
                });


                Route::group(['prefix' => 'super'], function () {
                    Route::get('/index', 'vip@index');
                    Route::get('/single/{id}', 'vip@single');
                    Route::get('/cancel/{id}', 'vip@cancel');
                    Route::get('/recieved/{id}', 'vip@recieved');
                    Route::get('/addUser', 'vip@addUser');
                    Route::get('/show', 'vip@showUser');
                    Route::post('/addUser', 'vip@addUserPost');
                    Route::get('/statistic', 'vip@statistic');
                });


                Route::group(['prefix' => 'messages'], function() {
                    Route::get('index', 'messages@index');
                    Route::get('single/{id}', 'messages@single');
                    Route::get('statistic', 'messages@statistic');
                });

                Route::group(['prefix' => 'pages'], function() {
                    Route::get('index', 'pages@index');
                    Route::get('edit/{id}', 'pages@edit');
                    Route::post('edit', 'pages@editPost');
                    Route::get('add', 'pages@add');
                    Route::post('add', 'pages@addPost');
                });
            });
        });
    });
});



// Route::get('/v1', 'viewController@index');

Route::get('/', 'viewController@index');
// Route::get('/', 'viewController@index1');
Route::get('/vip', function(){
  return redirect('super');
});
Route::get('/super', 'viewController@vip');
Route::get('/deleteTest', 'handleController@deleteTest');
Route::post('/sendVIP', 'handleController@sendVIP');
Route::post('/sendSuper', 'handleController@sendVIP');


Route::get('testnoti', 'viewController@testnoti');
Route::get('msg', 'viewController@msg');
Route::get('page/{name}', 'viewController@page');
Route::get('FAQ', 'viewController@FAQ');
Route::get('Contact', 'viewController@Contact');
Route::post('Contact', 'handleController@contact');
Route::get('testNoti', 'viewController@testNoti');
Route::get('errors', 'viewController@errors');

// public Route without any Authentication
Route::get('image/{size}/{id}', ['as' => 'image', 'uses' => 'ImageHandler@getPublicImage']);
Route::get('image_r/{size}/{id}', ['as' => 'image', 'uses' => 'ImageHandler@getImageResize']);
Route::get('image/{id}', ['as' => 'image', 'uses' => 'ImageHandler@getDefaultImage']);
Route::get('download/{id}', ['as' => 'image', 'uses' => 'ImageHandler@download']);


//skip if has login
Route::group(['middleware' => 'skipLogin'], function () {
    Route::get('login', 'viewController@login');
    Route::post('handleLogin', 'handleController@handleLogin');
    Route::get('handleLogin', 'handleController@handleLogin');
    Route::get('register', 'viewController@register');
    Route::post('handleRegister', 'handleController@handleRegister');
    Route::get('confirmEmail/{token}', 'handleController@confirmEmail');
    Route::get('resetPass/{token}', 'handleController@confirmEmail');
    Route::get('forgetPassword', 'viewController@forgetPassword');
    Route::post('handleForgetPassword', 'handleController@handleForgetPassword');
    Route::post('resetPassword', 'handleController@resetPassword');

    // Route::get('/loginFacebook', 'social@redirectToProvider');
    // Route::get('/callbackFacebook', 'social@handleProviderCallback');
    // Route::get('/loginTwitter', 'social@loginTwitter');
    // Route::get('/callbackTwitter', 'social@callbackTwitter');
    
     Route::get('/loginFacebook', function(){
         abort(404);
     });
    Route::get('/callbackFacebook',function(){
         abort(404);
     });
    Route::get('/loginTwitter', function(){
         abort(404);
     });
    Route::get('/callbackTwitter', function(){
         abort(404);
     });
});

//    must have login
Route::group(['middleware' => 'hasLogin'], function () {

    Route::get('checkUserName/{username}', 'handleController@checkUserName');
    Route::get('sendActivaeMobile', 'handleController@sendActivaeMobile');
    Route::get('checkMobileCode', 'handleController@checkMobileCode');
        
    Route::group(['middleware' => 'editProfile'], function () {
        Route::get('editProfile', 'viewController@editProfile');

        Route::post('handleEditProfile', 'handleController@handleEditProfile');
        Route::post('uploadImage', 'handleController@uploadImage');


        Route::post('upload', 'handleController@upload');
        Route::post('uploadAddProject', 'handleController@uploadAddProject');



        Route::post('uploadFile', 'handleController@uploadFile');
        Route::get('deleteFile/{fileName}', 'handleController@deleteFile');
        Route::post('uploadFileMultiple', 'handleController@uploadFileMultiple');

        Route::get('deleteImage', 'handleController@deleteImage');
        Route::post('handleAddPortfolio', 'handleController@handleAddPortfolio');
        Route::get('portfolios', 'viewController@myPortfolios');
//        my
        Route::get('myFavorite', 'viewController@myFavorite');
        Route::get('balance', 'viewController@balance');
        Route::get('myProjects', 'viewController@myProjects');
        Route::get('freelancer/{id}', 'viewController@freelancers')->where(['id' => '[0-9]+']);
        Route::get('inviteFreelancer/{project_id}/{id}', 'handleController@inviteFreelancer')->where(['id' => '[0-9]+'])->where(['project_id' => '[0-9]+']);
        Route::get('myProjects/{id}', 'viewController@fillterMyProjects')->where(['id' => '[0-9]+']);
        Route::get('myBids', 'viewController@myBids');
        Route::get('myBids/{id}', 'viewController@myBids');
        Route::get('statistic', 'viewController@statistic');
        Route::get('messages', 'viewController@messages');

        Route::get('/addProject', 'viewController@addProject');
        Route::get('/addProject', 'viewController@addProject');
        Route::post('/handleAddProject', 'handleController@handleAddProject');
        Route::post('/addDescussion', 'handleController@addDescussion');
        Route::get('/orderFinishProject/{id}', 'handleController@orderFinishProject')->where(['id' => '[0-9]+']);
        Route::get('/finishProject/{id}', 'handleController@finishProject')->where(['id' => '[0-9]+']);
        Route::get('/evaluate/{id}', 'viewController@evaluate')->where(['id' => '[0-9]+']);
        Route::post('/evaluate', 'handleController@evaluate')->where(['id' => '[0-9]+']);

//        freelancer
        Route::get('/addPrivateProject/{id}', 'viewController@addPrivateProject');
        Route::get('/freelancerSearch', 'viewController@freelancerSearch');
        Route::get('/freelancerSearch/{id}', 'viewController@freelancerSearch')->where(['id' => '[0-9]+']);
        Route::get('/freelancers', 'viewController@freelancers');
    
        Route::get('/freelancers/{id}', 'viewController@freelancers')->where(['id' => '[0-9]+']);

//        ajax
        Route::get('getBids', 'viewController@getBids');
        Route::get('getPortfolio', 'viewController@getPortfolio');
        Route::get('getEvaluate', 'viewController@getEvaluate');

        Route::get('like', 'handleController@like');
        Route::get('fovarite', 'handleController@fovarite');
        Route::get('/favorite', 'handleController@favorite');
        Route::get('/favoriteNew', 'handleController@favoriteNew');
        Route::get('addFreelancer', 'handleController@addFreelancer');
        Route::post('addBids', 'handleController@addBids');
        Route::get('report', 'handleController@report');
        Route::post('/cancelFreelancer', 'handleController@cancelFreelancer');

        //end ajax
//        message
        Route::get('conversation', 'viewController@conversation');
        Route::get('conversations', 'viewController@conversations');

        Route::get('conversation/{id}', 'viewController@conversationById');
        Route::post('sendMessage', 'handleController@sendMessage');
        Route::post('withdrawRequest', 'handleController@withdrawRequest');

//   notifcation

        Route::get('notifcations', 'viewController@notifcations');
        Route::get('notifcation/seen/{id}', 'viewController@notifcationSeen');
        Route::get('notifcationSetting', 'viewController@notifcationSetting');
        Route::post('notifcationSetting', 'handleController@notifcationSettingPost');
        Route::get('notifcation/{id}', 'viewController@notifcation')->where(['id' => '[0-9]+']);


        Route::get('editPort/{id}', 'viewController@editPort')->where(['id' => '[0-9]+']);
        Route::get('editBid/{id}', 'viewController@editBid')->where(['id' => '[0-9]+']);
        Route::get('singleUser/{id}', 'viewController@singleUser');
        Route::get('editPortfolio/{id}', 'viewController@editPortfolio')->where(['id' => '[0-9]+']);
        Route::get('deletePortfolio/{id}', 'viewController@deletePortfolio')->where(['id' => '[0-9]+']);

        Route::get('singleUser', 'viewController@singleUser');
        Route::get('u/{username}', 'viewController@singleUser');

        Route::get('addPortfolio', 'viewController@addPortfolio');


//    payment
//        Route::post('addmoney/payout', array('as' => 'addmoney.payout', 'uses' => 'AddMoneyController@payout'));

        Route::get('addmoney/paywithpaypal', array('as' => 'addmoney.paywithpaypal', 'uses' => 'AddMoneyController@payWithPaypal',));
        Route::post('addmoney/paypal', array('as' => 'addmoney.paypal', 'uses' => 'AddMoneyController@postPaymentWithpaypal',));
        Route::post('addmoney/pay', array('as' => 'addmoney.pay', 'uses' => 'AddMoneyController@postPayment',));
        Route::get('addmoney/paypal', array('as' => 'payment.status', 'uses' => 'AddMoneyController@getPaymentStatus'));
        Route::get('addmoney/visa', 'AddMoneyController@requestVisa');
              Route::get('balance/visa', 'AddMoneyController@VisaReturn');
              Route::post('balance/visa', 'AddMoneyController@VisaReturn');

        Route::get('addmoney/successPayment', array('as' => 'payment.successPayment', 'uses' => 'AddMoneyController@successPayment'));
    });
    Route::get('getNew', 'viewController@getNew');
});


Route::get('/project/{id}', 'viewController@project');
Route::post('/project/{id}','viewController@editablePrice')->name('editable.price');
Route::get('/project/{id}/{title}', 'viewController@project')->where(['id' => '[0-9]+']);

Route::get('logout', 'handleController@logout');

Route::get('portfolios/{id}', 'viewController@portfolios')->where(['id' => '[0-9]+']);
Route::get('portfolio/{id}', 'viewController@portfolio')->where(['id' => '[0-9]+']);

Route::get('test', 'test@test');

//        projects
Route::get('/projects', 'viewController@projects');
Route::get('/projectsSearch', 'viewController@projectsSearch');
Route::get('getBidsProject', 'viewController@getBidsProject');
Route::get('/test', function(){
//$path = Storage::url('uploads/images/image_admin.png');
//return $path;
    return getNumberOfDays('20-09-2017') ;
//    return getFileType('project');
//    return(getFileType1('portfolio'));
    $m1 = ['en' =>  'تم اضافة عرض جديد على مشروع ' ];
//    $url = url('/').'/project/'.$project->id.'-'.$project->title;
    sendNotification($m1, 'd7efd50b-94ca-4cba-a592-41e56ff88418', 'project','aaaaaa');

});




