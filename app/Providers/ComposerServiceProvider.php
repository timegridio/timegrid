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
            ['manager._sidebar-menu-i18n', 'welcome','_navi18n'],
            \App\Http\ViewComposers\NavLanguageComposer::class
        );

        view()->composer(
            ['layouts.app'],
            \App\Http\ViewComposers\NavComposer::class
        );

        view()->composer(
            ['*'],
            \App\Http\ViewComposers\AuthComposer::class
        );

        view()->composer(
            ['layouts.app'],
            \App\Http\ViewComposers\UserHelpComposer::class
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
