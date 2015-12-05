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
 
        if ($this->isValidLanguage($lang)) {
            $this->setSessionLanguage($lang);
        }
 
        return redirect()->back();
    }

    /////////////
    // HELPERS //
    /////////////

    /**
     * Determine if is a language is accepted by app config
     *
     * @param  string  $lang Requested language
     * @return boolean       Is an accepted language for this app
     */
    protected function isValidLanguage($lang)
    {
        return array_key_exists($lang, config()->get('languages'));
    }

    /**
     * set Language to Session
     *
     * @param string $lang Requested language
     */
    protected function setSessionLanguage($lang)
    {
        session()->set('applocale', $lang);
        $locale = \Locale::parseLocale($lang);
        session()->set('language', $locale['language']);
        $this->log->info("Language Switched:{$locale['language']}");
    }
}
