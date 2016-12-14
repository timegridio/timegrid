<?php

return [
    'root'    => [
        'report' => [
            'subject' => 'Reporte de Root',
        ],
    ],
    'manager' => [
        'business-report' => [
            'subject' => 'Reporte de agenda del :date en :businessName',
            'welcome' => 'Hola :ownerName',
            'button'  => 'Ver Agenda',
        ],
        'appointment-notification' => [
            'subject'      => 'Tenés una nueva reserva',
            'welcome'      => ':ownerName, tenés una nueva reserva',
            'instructions' => 'Se realizó una reserva',
            'title'        => 'Detalles de la reserva',
        ],
    ],
    'user'    => [
        'welcome' => [
            'subject'              => 'Te damos la bienvenida a timegrid.io',
            'hello-title'          => 'Hola :userName',
            'hello-paragraph'      => 'Timegrid ayuda a los profesionales y clientes a encontrar el momento perfecto en sus agendas para un turno.',
            'quickstart-title'     => 'Todo listo para empezar',
            'quickstart-paragraph' => 'Simplemente dirigite a timegrid en cualquier momento y comenzá a reservar horarios con profesionales directamente por Internet',
        ],
        'appointment-notification' => [
            'subject'              => 'Detalles de tu reserva',
            'hello-title'          => ':userName, generaste una reserva',
            'hello-paragraph'      => 'Tu reserva fue exitosa.',
            'appointment-title'    => 'Aquí los detalles de tu reserva',
            'button'               => 'Ver mi agenda',
        ],
        'appointment-confirmation' => [
            'subject'              => 'Tu turno en :businessName fue confirmado',
            'hello-title'          => 'Hola :userName,',
            'hello-paragraph'      => 'Tu turno fue confirmado.',
            'appointment-title'    => 'Aquí los detalles del turno',
            'button'               => 'Ver mi agenda',
        ],
        'appointment-cancellation' => [
            'subject'              => 'El turno en :businessName fue cancelado',
            'hello-title'          => 'Hola :userName,',
            'hello-paragraph'      => 'Disculpas, tu turno fue cancelado.',
            'appointment-title'    => 'Aquí los detalles',
            'button'               => 'Ver mi agenda',
        ],
    ],
    'guest'   => [
        'password' => [
            'subject'      => 'Pasos para reestablecer tu contraseña',
            'hello'        => 'Hola :userName,',
            'instructions' => 'Dale click al botón de reset para recuperar tu acceso.',
            'button'       => 'Reestablecer mi contraseña',
        ],
        'appointment-validation' => [
            'subject'            => 'Por favor valida tu reserva',
            'hello-title'        => 'Valida tu reserva',
            'hello-paragraph'    => 'Hiciste una reserva online que necesita tu confirmación. De no hacerlo la misma caducará.',
            'appointment-title'  => 'Detalles de la reserva',
            'button'             => 'Validar Reserva',
        ],
    ],
    'text'  => [
        'business'          => 'Business',
        'user'              => 'User',
        'date'              => 'Date',
        'time'              => 'Time',
        'code'              => 'Code',
        'where'             => 'Where',
        'phone'             => 'Phone',
        'service'           => 'Service',
        'important'         => 'important',
        'customer_notes'    => 'Customer notes for you',
        'there_are'         => 'There are',
        'registered'        => 'registered users so far',
    ],
];
