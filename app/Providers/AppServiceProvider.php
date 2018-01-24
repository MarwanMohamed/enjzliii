<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('greater_than', function($attribute, $value, $parameters)
        {
            $minAge = ( ! empty($parameters)) ? (int) $parameters[0] : 18;
            return \Carbon\Carbon::now()->diff(new \Carbon\Carbon($value))->y >= $minAge;

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once(app_path().'/Helpers/paytabs.php');

        //
//       foreach (glob(app_path().‘/Helpers/*.php’) as $filename){
//         }
    }
}
