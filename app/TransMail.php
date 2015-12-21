<?php

namespace App;

use Illuminate\Support\Facades\Mail;

class TransMail
{
    /**
     * @var string
     */
    protected $locale = 'en_US.utf8';

    /**
     * @var string
     */
    protected $revertLocale = 'en_US.utf8';

    /**
     * @var string
     */
    protected $subjectKey = '';

    /**
     * @var array
     */
    protected $subjectParams = [];

    /**
     * @var string
     */
    protected $viewBase = 'emails';

    /**
     * @var string
     */
    protected $viewPath = '';

    /**
     * @var string
     */
    protected $subject = '';

    /**
     * Set the locale.
     *
     * @param  string $posixLocale
     *
     * @return $this
     */
    public function locale($posixLocale)
    {
        $this->revertLocale = app()->getLocale();

        $this->locale = $posixLocale;

        return $this;
    }

    /**
     * Set the template view path key.
     *
     * @param  string $template
     *
     * @return $this
     */
    public function template($template)
    {
        $this->viewPath = $template;

        return $this;
    }

    /**
     * Set the subject trans key and parameters.
     *
     * @param  string $key
     * @param  array  $params
     *
     * @return $this
     */
    public function subject($key, $params = [])
    {
        $this->subjectKey = $key;

        $this->subjectParams = $params;

        return $this;
    }

    /**
     * Switch application wide locale, send message, and restore locale.
     *
     * @param  array  $header
     * @param  array  $params
     *
     * @return void
     */
    public function send(array $header, array $params)
    {
        $this->switchLocale($this->locale);

        Mail::send($this->getViewKey(), $params, function ($mail) use ($header) {
            $mail->to($header['email'], $header['name'])
                 ->subject($this->getSubject());
        });

        $this->switchLocale($this->revertLocale);
    }

    /////////////
    // Helpers //
    /////////////

    /**
     * Switch Locale.
     *
     * @param  string $posixLocale
     *
     * @return void
     */
    protected function switchLocale($posixLocale)
    {
        if (function_exists('setGlobalLocale')) {
            setGlobalLocale($posixLocale);
            return;
        }

        app()->setLocale($posixLocale);
    }

    /**
     * Build and get the view path key.
     *
     * @return string
     */
    protected function getViewKey()
    {
        return $this->viewBase . '.' . $this->locale . '.' . $this->viewPath;
    }

    /**
     * Build and get the localized subject string.
     *
     * @return string
     */
    protected function getSubject()
    {
        return $this->subject = trans('emails.'.$this->subjectKey, $this->subjectParams);
    }
}
