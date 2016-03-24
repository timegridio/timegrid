<?php

namespace Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\ConfigureLogging as BaseConfigureLogging;
use Illuminate\Log\Writer;
use Monolog\Logger as Monolog;

class ConfigureLogging extends BaseConfigureLogging
{
    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Log\Writer  $log
     * @return void
     */
    protected function configureSyslogHandler(Application $app, Writer $log)
    {
        $log->useSyslog(env('SYSLOG_APPNAME', 'timegrid'));
    }
}
