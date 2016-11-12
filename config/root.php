<?php

/**
 * System administrator related.
 */
return [

    'app' => [
        'name' => env('SYSLOG_APPNAME', 'default.timegrid'),
    ],

    'docs_url' => 
    [
        'en' => env('DOCS_URL_EN', 'http://www.timegrid.io/docs/en/user-manual/'),
        'es' => env('DOCS_URL_ES', 'http://www.timegrid.io/docs/es/manual-de-usuario/'),
    ],

    'report' => [
        'from_address'       => env('MAIL_FROM_ADDRESS', 'root@localhost'),
        'to_mail'            => env('ROOT_REPORT_MAIL', 'root@localhost'),
        'time'               => env('ROOT_REPORT_TIME', '20:00'),
        'exceptions_subject' => '[ROOT] Exception Report',
    ],

    'vacancy_edit_days' => env('DEFAULT_VACANCY_EDIT_DAYS_QUANTITY', 15),

    'time' => [
        'format' => env('DISPLAY_TIME_FORMAT', 'h:i A'),
    ],
];
