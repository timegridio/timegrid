<?php

namespace App\Listeners;

use App\Events\NewUserWasRegistered;
use App\TG\TransMail;

class SendMailUserWelcome
{
    private $transmail;

    public function __construct(TransMail $transmail)
    {
        $this->transmail = $transmail;
    }

    /**
     * Handle the event.
     *
     * @param NewUserWasRegistered $event
     *
     * @return void
     */
    public function handle(NewUserWasRegistered $event)
    {
        logger()->info(__METHOD__);

        $params = [
            'user' => $event->user,
            'userName' => $event->user->name,
        ];
        $header = [
            'name'  => $event->user->name,
            'email' => $event->user->email,
        ];
        $this->transmail->template('user.welcome.welcome')
                        ->subject('user.welcome.subject')
                        ->send($header, $params);
    }
}
