<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

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
        view()->composer('*', function($view)
        {
            if(Auth::guard('web')->check()) {
                $unread_noti_count = Auth::guard('web')->user()->unreadNotifications->count();
                $view->with([
                    'unread_noti_count' => $unread_noti_count
                ]);
            }
        });
    }
}
