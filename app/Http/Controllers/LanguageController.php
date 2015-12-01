<?php

namespace App\Http\Controllers;

class LanguageController extends Controller
{
    /**
     * Switch Language
     *
     * @param  string  $lang    Language iso code
     * @return Redirect         HTTP Redirect
     */
    public function switchLang($lang)
    {
        $this->log->info(sprintf("%s: %s", __METHOD__, $lang));
 
        if (array_key_exists($lang, config()->get('languages'))) {
            session()->set('applocale', $lang);
            $locale = \Locale::parseLocale($lang);
            session()->set('language', $locale['language']);

            $this->log->info("  Language Switched:{$locale['language']}");
        }
 
        return redirect()->back();
    }
}
