<?php

/**
 * System administrator related.
 */
return [
    'from_address'       => env('MAIL_FROM_ADDRESS', 'root@localhost'),
    'report_mail'        => env('ROOT_REPORT_MAIL', 'root@localhost'),
    'appname'            => env('SYSLOG_APPNAME', 'timegrid'),
    'exceptions_subject' => '[ROOT] Exception Report',
];
