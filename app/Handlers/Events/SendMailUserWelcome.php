<?php

namespace App\Handlers\Events;

use App\Events\NewUserWasRegistered;
use App\TransMail;

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
        logger()->info('Handle NewUserWasRegistered.SendMailUserWelcome()');

        $params = [
            'user' => $event->user,
        ];
        $header = [
            'name'  => $event->user->name,
            'email' => $event->user->email,
        ];
        $this->transmail->template('welcome')
                        ->subject('user.welcome.subject')
                        ->send($header, $params);
    }
}
