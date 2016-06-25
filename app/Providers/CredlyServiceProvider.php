<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\Credly;

class CredlyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Credly::class, function ($app) {
            return new Credly(
                config('services.credly.url'),
                config('services.credly.key'),
                config('services.credly.secret')
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['App\Helpers\Credly'];
    }
}
