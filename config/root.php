<?php

/**
 * System administrator related.
 */
return [
    
    'appname' => env('SYSLOG_APPNAME', 'timegrid'),

    'report' => [
        'from_address'       => env('MAIL_FROM_ADDRESS', 'root@localhost'),
        'to_mail'            => env('ROOT_REPORT_MAIL', 'root@localhost'),
        'time'               => env('ROOT_REPORT_TIME', '20:00'),
        'exceptions_subject' => '[ROOT] Exception Report',
    ],

    'vacancy_edit_days' => env('DEFAULT_VACANCY_EDIT_DAYS_QUANTITY', 15),

    'time' => [
        'format' => env('DISPLAY_TIME_FORMAT', 'h:i A'),
    ]
];
