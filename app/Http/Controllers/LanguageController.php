<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    /**
     * Switch Language
     *
     * @param  string  $lang    Language iso code
     * @param  Session $session Session Facade
     * @return Redirect         HTTP Redirect
     */
    public function switchLang($lang)
    {
        $this->log->info("Language switch Request to $lang");
 
        if (array_key_exists($lang, Config::get('languages'))) {
            $this->log->info('Language Switched');
            session()->set('applocale', $lang);
            $locale = \Locale::parseLocale($lang);
            session()->set('language', $locale['language']);
        }
 
        return Redirect::back();
    }
}
