<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\HttpException'
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        if (env('APP_ENV', 'local')!='local') {
            Mail::raw($e, function ($message) {
                $message->subject('[ROOT] Exception Report');
                $message->from(env('MAIL_FROM_ADDRESS', 'root@localhost'), env('SYSLOG_APPNAME', ''));
                $message->to(env('ROOT_REPORT_MAIL', 'root@localhost'));
            });
        }
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        return parent::render($request, $e);
    }
}
