<?php

return [
    'root'    => [
        'report' => [
            'subject' => 'Root Report',
        ],
    ],
    'manager' => [
        'business-report' => [
            'subject'      => 'Schedule report of :date at :businessName',
            'welcome'      => 'Hi :ownerName',
            'button'       => 'View Calendar',
        ],
        'appointment-notification' => [
            'subject'      => 'You have a new appointment',
            'welcome'      => ':ownerName, you have a new appointment',
            'instructions' => 'A new appointment was reserved',
            'title'        => 'Appointment Details',
        ],
    ],
    'user'    => [
        'welcome' => [
            'subject'              => 'Welcome to timegrid.io',
            'hello-title'          => 'Hello :userName',
            'hello-paragraph'      => 'Timegrid helps contractors and customers to find the perfect meeting time through online appointments.',
            'quickstart-title'     => 'You are ready to go',
            'quickstart-paragraph' => 'Just go to timegrid anytime you want to make a reservation with your contractor',
        ],
        'appointment-notification' => [
            'subject'              => 'Your new appointment details',
            'welcome'              => ':userName, you made a new appointment',
            'instructions'         => 'Your appointment reservation was taken.',
            'title'                => 'Here your appointment details',
            'button'               => 'View my agenda',
        ],
        'appointment-confirmation' => [
            'subject'              => 'Your appointment at :businessName was confirmed',
            'hello-title'          => 'Hi :userName,',
            'hello-paragraph'      => 'Your appointment was confirmed.',
            'appointment-title'    => 'Here your appointment details',
            'button'               => 'View my agenda',
        ],
        'appointment-cancellation' => [
            'subject'              => 'Your appointment at :businessName was cancelled',
            'hello-title'          => 'Hi :userName,',
            'hello-paragraph'      => 'Sorry, your appointment was cancelled.',
            'appointment-title'    => 'Here the cancelled appointment details',
            'button'               => 'View my agenda',
        ],
    ],
    'guest'   => [
        'password' => [
            'subject'      => 'Password reset',
            'hello'        => 'Hello :userName,',
            'instructions' => 'Just click the password reset button and reset your password.',
            'button'       => 'Reset my password.',
        ],
        'appointment-validation' => [
            'subject'            => 'Please validate your reservation',
            'hello-title'        => 'Validate your appointment',
            'hello-paragraph'    => 'You made a guest reservation which needs your validation. In case you don\'t confirm, it will automatically expire.',
            'appointment-title'  => 'Reservation details',
            'button'             => 'Validate Appointment',
        ],
    ],
];
