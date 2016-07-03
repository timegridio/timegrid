<?php

return [
    'root'    => [
    ],
    'manager' => [
        'business-report' => [
            'subject' => 'Reporte de agenda del :date en :businessName',
            'welcome' => 'Hola :ownerName',
            'button'  => 'Ver Agenda',
        ],
        'appointment-notification' => [
            'subject'      => 'Tienes una nueva reserva',
            'welcome'      => ':ownerName, tienes una nueva reserva',
            'instructions' => 'Se realizó una reserva',
            'title'        => 'Detalles de la reserva',
        ],
    ],
    'user'    => [
        'appointment-notification' => [
            'subject'      => 'Detalles de tu reserva',
            'welcome'      => ':ownerName, generaste una reserva',
            'instructions' => 'Tu reserva fue exitosa.',
            'title'        => 'Aquí los detalles de tu reserva',
        ],
    ],
    'guest'   => [
    ],
];
