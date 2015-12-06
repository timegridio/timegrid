<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Support\Facades\Config;

class Language implements Middleware
{
    public function handle($request, Closure $next)
    {
        $sessionAppLocale = session()->get('applocale');

        if (session()->has('applocale') and array_key_exists($sessionAppLocale, Config::get('languages'))) {
            app()->setLocale($sessionAppLocale);
            setlocale(LC_TIME, $sessionAppLocale);
            Carbon::setLocale(\Locale::getPrimaryLanguage($sessionAppLocale));

            return $next($request);
        }

        $fallbackLocale = Config::get('app.fallback_locale');

        app()->setLocale($fallbackLocale);
        setlocale(LC_TIME, $fallbackLocale);
        Carbon::setLocale(\Locale::getPrimaryLanguage($fallbackLocale));

        return $next($request);
    }
}
