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
        $this->app->bind(
            \Illuminate\Contracts\Auth\Registrar::class,
            \App\Services\Registrar::class
        );

        if ($this->app->environment() == 'local') {
            $this->app->register(\Laracasts\Generators\GeneratorsServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
            $this->app->register(\Potsky\LaravelLocalizationHelpers\LaravelLocalizationHelpersServiceProvider::class);
        }

        if (env('ROLLBAR_TOKEN', false)) {
            $this->app->register(\Jenssegers\Rollbar\RollbarServiceProvider::class);
        }
    }
}
