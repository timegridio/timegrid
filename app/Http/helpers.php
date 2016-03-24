<?php

use Carbon\Carbon;

if (!function_exists('setGlobalLocale')) {
    /**
     * Set locale among all localizable contexts.
     *
     * @param string $posixLocale
     *
     * @return void
     */
    function setGlobalLocale($posixLocale)
    {
        app()->setLocale($posixLocale);
        setlocale(LC_TIME, $posixLocale);
        Carbon::setLocale(locale_get_primary_language($posixLocale));
    }
}

if (!function_exists('isAcceptedLocale')) {
    /**
     * Determine if is a POSIX language string is accepted by app config.
     *
     * @param string $posixLocale Requested language
     *
     * @return bool Is an accepted language for this app
     */
    function isAcceptedLocale($posixLocale)
    {
        return array_key_exists($posixLocale, config('languages'));
    }
}

if (!function_exists('trans_duration')) {
    /**
     * Localize a human-friendly duration string.
     *
     * @param string
     *
     * @return string
     */
    function trans_duration($string)
    {
        $translations = [
            'hour'    => trans_choice('datetime.duration.hours',1),
            'hours'   => trans_choice('datetime.duration.hours',2),
            'minute'  => trans_choice('datetime.duration.minutes',1),
            'minutes' => trans_choice('datetime.duration.minutes',2),
            'second'  => trans_choice('datetime.duration.seconds',1),
            'seconds' => trans_choice('datetime.duration.seconds',2),
        ];

        return str_replace(array_keys($translations), array_values($translations), $string);
    }
}
