<?php

namespace App\Providers;

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
        $this->app->bind('App\Interfaces\Repositories\ITenantRepository', 'App\Repositories\DbTenantRepository');
        $this->app->bind('App\Interfaces\Services\IAuthService', 'App\Services\AuthService');
    }
}
