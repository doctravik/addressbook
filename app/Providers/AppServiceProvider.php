<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param UrlGenerator $url
     * @return void
     */
     public function boot(UrlGenerator $url)
     {
         if (env('APP_ENV') === 'production') {
             $url->forceScheme('https');
         }

        \App\Person::observe(\App\Observers\PersonObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
