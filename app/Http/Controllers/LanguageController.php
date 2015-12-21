<?php

namespace App\Http\Controllers;

class LanguageController extends Controller
{
    /**
     * Switch Language.
     *
     * @param string $posixLocale Language iso code
     *
     * @return Redirect HTTP Redirect
     */
    public function switchLang($posixLocale)
    {
        logger()->info(sprintf('%s: %s', __METHOD__, $posixLocale));

        if (isAcceptedLocale($posixLocale)) {
            $this->setSessionLanguage($posixLocale);
        }

        return redirect()->back();
    }

    /////////////
    // HELPERS //
    /////////////

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

        logger()->info("Language Switched: LANG='{$language}' POSIX='{$posixLocale}'");
    }
}
