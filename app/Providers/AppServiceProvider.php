<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        //compose all the views....
        view()->composer('*', function ($view) {
            //$notification_count = auth()->user() ? auth()->user()->unreadNotifications()->count() : 0 ;
            $notifications = auth()->user()->unreadNotifications ?? '';
            $view->with('notifications', $notifications );    
        });  
    }
}
