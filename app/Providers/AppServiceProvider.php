<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Jenssegers\Rollbar\RollbarServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Illuminate\Contracts\Auth\Registrar',
            'App\Services\Registrar'
        );

        if ($this->app->environment() == 'local') {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');
            $this->app->register('Potsky\LaravelLocalizationHelpers\LaravelLocalizationHelpersServiceProvider');
        }

        if ($this->app->environment() != 'testing') {
            $this->app->register(RollbarServiceProvider::class);
        }
    }
}
