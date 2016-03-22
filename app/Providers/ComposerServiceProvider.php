<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            '_navi18n', 'App\Http\ViewComposers\NavLanguageComposer'
        );

        view()->composer(
            ['user._navmenu', 'manager._navmenu'], 'App\Http\ViewComposers\NavComposer'
        );

        view()->composer(
            ['layouts.app'], 'App\Http\ViewComposers\AuthComposer'
        );

        view()->composer(
            ['layouts.app'], 'App\Http\ViewComposers\UserHelpComposer'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
