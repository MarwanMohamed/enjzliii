<?php

namespace App\Providers;

use App\MailingList;
use App\Request;
use App\Settings;
use App\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LayoutProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       View::composer('admin._layout', function ($view) {
           $notifications = [];
           // projects
           $notifications['projects'] = \App\project::where('isView', 0)->count();
           $notifications['/admin/projects/needRevision'] = \App\project::where('isView', 0)->where('status', 1)->count();
           $notifications['/admin/projects/errors'] = \App\project::where('isView', 0)->where('status', 4)->count();

           //reports
           $notifications['reports'] = \App\report::where('isView', 0)->count();
           $notifications['/admin/reports/projects'] =\App\report::where('isView', 0)->where('type', 5)->count();
           $notifications['/admin/reports/bids'] =\App\report::where('isView', 0)->where('type', 2)->count();
           $notifications['/admin/reports/portifolio'] =\App\report::where('isView', 0)->where('type', 1)->count();
           $notifications['/admin/reports/users'] =\App\report::where('isView', 0)->where('type', 3)->count();
           
           //conversations
           $notifications['conversations'] = \App\conversation::where('isView', 0)->count();
           $notifications['/admin/conversations/index'] = \App\conversation::where('isView', 0)->count();

           //messages
           $notifications['messages'] = \App\contact::where('isView', 0)->count();
           $notifications['/admin/messages/index'] = \App\contact::where('isView', 0)->count();

           //super
           $notifications['super'] = \App\VIPRequest::where('isView', 0)->count();
           $notifications['/admin/super/index'] = \App\VIPRequest::where('isView', 0)->count();

           //transactions
           $notifications['transactions'] =  \App\withdrawrequest::where('isView', 0)->count();
           $notifications['/admin/transactions/withdrawrequest'] = \App\withdrawrequest::where('isView', 0)->count();

           $view->with(['notifications' => $notifications]);
       });


       View::composer('admin._layout2', function ($view) {
          $notifications = [];
          // projects
           $notifications['projects'] = \App\project::where('isView', 0)->count();
           $notifications['/admin/projects/needRevision'] = \App\project::where('isView', 0)->where('status', 1)->count();
           $notifications['/admin/projects/errors'] = \App\project::where('isView', 0)->where('status', 4)->count();

           //reports
           $notifications['reports'] = \App\report::where('isView', 0)->count();
           $notifications['/admin/reports/projects'] =\App\report::where('isView', 0)->where('type', 5)->count();
           $notifications['/admin/reports/bids'] =\App\report::where('isView', 0)->where('type', 2)->count();
           $notifications['/admin/reports/portifolio'] =\App\report::where('isView', 0)->where('type', 1)->count();
           $notifications['/admin/reports/users'] =\App\report::where('isView', 0)->where('type', 3)->count();
           
           //conversations
           $notifications['conversations'] = \App\conversation::where('isView', 0)->count();
           $notifications['/admin/conversations/index'] = \App\conversation::where('isView', 0)->count();
           
           //messages
           $notifications['messages'] = \App\contact::where('isView', 0)->count();
           $notifications['/admin/messages/index'] = \App\contact::where('isView', 0)->count();

           //super
           $notifications['super'] = \App\VIPRequest::where('isView', 0)->count();
           $notifications['/admin/super/index'] = \App\VIPRequest::where('isView', 0)->count();

           //transactions
           $notifications['transactions'] =  \App\withdrawrequest::where('isView', 0)->count();
           $notifications['/admin/transactions/withdrawrequest'] = \App\withdrawrequest::where('isView', 0)->count();
           
           $view->with(['notifications' => $notifications]);
       });


    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
