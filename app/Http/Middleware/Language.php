<?php // app/Http/Middleware/Language.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class Language implements Middleware
{
    public function handle($request, Closure $next)
    {
        if (Session::has('applocale') and array_key_exists(Session::get('applocale'), Config::get('languages'))) {
            App::setLocale(Session::get('applocale'));
            setlocale(LC_TIME, Session::get('applocale'));
            Carbon::setLocale(\Locale::getPrimaryLanguage(Session::get('applocale')));
        } else {
            App::setLocale(Config::get('app.fallback_locale'));
            setlocale(LC_TIME, Config::get('app.fallback_locale'));
            Carbon::setLocale(\Locale::getPrimaryLanguage(Config::get('app.fallback_locale')));
        }
        return $next($request);
    }
}
