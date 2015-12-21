<?php

use Carbon\Carbon;

if (! function_exists('setGlobalLocale')) {
    /**
     * Set locale among all localizable contexts.
     *
     * @param  string  $posixLocale
     *
     * @return void
     */
    function setGlobalLocale($posixLocale)
    {
        app()->setLocale($posixLocale);
        setlocale(LC_TIME, $posixLocale);
        Carbon::setLocale(\Locale::getPrimaryLanguage($posixLocale));
    }
}

if (! function_exists('isAcceptedLocale')) {    
    /**
     * Determine if is a POSIX language string is accepted by app config.
     *
     * @param string $posixLocale Requested language
     *
     * @return bool Is an accepted language for this app
     */
    function isAcceptedLocale($posixLocale)
    {
        return array_key_exists($posixLocale, config()->get('languages'));
    }
}
