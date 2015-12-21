<?php

namespace App\Http\Controllers;

class LanguageController extends Controller
{
    /**
     * Switch Language.
     *
     * @param string $lang Language iso code
     *
     * @return Redirect HTTP Redirect
     */
    public function switchLang($lang)
    {
        $this->log->info(sprintf('%s: %s', __METHOD__, $lang));

        if ($this->isValidLanguage($lang)) {
            $this->setSessionLanguage($lang);
        }

        return redirect()->back();
    }

    /////////////
    // HELPERS //
    /////////////

    /**
     * Determine if is a POSIX language string is accepted by app config.
     *
     * @param string $posixLocale Requested language
     *
     * @return bool Is an accepted language for this app
     */
    protected function isValidLanguage($posixLocale)
    {
        return array_key_exists($posixLocale, config()->get('languages'));
    }

    /**
     * Set language to session based on the selected POSIX language string.
     *
     * @param string $posixLocale Requested language
     */
    protected function setSessionLanguage($posixLocale)
    {
        $localeSubtags = locale_parse($posixLocale);
        $language = array_get($localeSubtags, 'language');

        session()->set('language', $language);
        session()->set('applocale', $posixLocale);

        $this->log->info("Language Switched: LANG='{$language}' POSIX='{$posixLocale}'");
    }
}
