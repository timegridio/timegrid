<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\HttpException',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $exception
     *
     * @return void
     */
    public function report(Exception $exception)
    {
        if (env('APP_ENV', 'local') != 'local') {
            Mail::raw($exception, function ($message) {
                $message->subject('[ROOT] Exception Report');
                $message->from(env('MAIL_FROM_ADDRESS', 'root@localhost'), env('SYSLOG_APPNAME', ''));
                $message->to(env('ROOT_REPORT_MAIL', 'root@localhost'));
            });
        }

        return parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // Catch TokenMismatchException to show a friendly error message
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect($request->fullUrl());
        }

        // Catch General exceptios to show a friendly error message
        if ($exception instanceof \Exception) {
            return redirect('/');
        }

        // Handle any other case
        return parent::render($request, $exception);
    }
}
