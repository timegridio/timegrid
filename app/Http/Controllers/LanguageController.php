<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Log;

class LanguageController extends Controller
{
    /**
     * Switch Language
     *
     * @param  string $lang Locale full name
     * @return Redirect     Redirect back to requesting URL
     */
    public function switchLang($lang)
    {
        Log::info("Language switch Request to $lang");
        if (array_key_exists($lang, Config::get('languages'))) {
            Log::info('Language Switched');
            Session::set('applocale', $lang);
        }
        return Redirect::back();
    }
}
