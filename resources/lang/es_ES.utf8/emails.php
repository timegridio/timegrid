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
            'subject'      => 'Tienes una nueva reserva',
            'welcome'      => ':ownerName, tienes una nueva reserva',
            'instructions' => 'Se realizó una reserva',
            'title'        => 'Detalles de la reserva',
        ],
    ],
    'user'    => [
        'welcome' => [
            'subject'              => 'Te damos la bienvenida a timegrid.io',
            'hello-title'          => 'Hola :userName',
            'hello-paragraph'      => 'Timegrid ayuda a los profesionales y clientes a encontrar el momento perfecto en sus agendas para una cita.',
            'quickstart-title'     => 'Todo listo para empezar',
            'quickstart-paragraph' => 'Simplemente ve a timegrid en cualquier momento y comienza a reservar horarios con profesionales directamente por Internet',
        ],
        'appointment-notification' => [
            'subject'      => 'Detalles de tu reserva',
            'welcome'      => ':ownerName, generaste una reserva',
            'instructions' => 'Tu reserva fue exitosa.',
            'title'        => 'Aquí los detalles de tu reserva',
        ],
        'appointment-confirmation' => [
            'subject'              => 'Tu cita en :businessName fue confirmada',
            'hello-title'          => 'Hola :userName,',
            'hello-paragraph'      => 'Tu cita fue confirmada.',
            'appointment-title'    => 'Aquí los detalles de la cita',
            'button'               => 'Ver mi agenda',
        ],
        'appointment-cancellation' => [
            'subject'              => 'La cita en :businessName fue cancelada',
            'hello-title'          => 'Hola :userName,',
            'hello-paragraph'      => 'Disculpas, tu cita fue cancelada.',
            'appointment-title'    => 'Aquí los detalles',
            'button'               => 'Ver mi agenda',
        ],
    ],
    'guest'   => [
        'password' => [
            'subject'      => 'Pasos para reestablecer tu contraseña',
            'hello'        => 'Hola :userName,',
            'instructions' => 'Haz click en el botón de reset para recuperar tu acceso.',
            'button'       => 'Reestablecer mi contraseña',
        ],
        'appointment-validation' => [
            'subject'            => 'Por favor valida tu reserva',
            'hello-title'        => 'Valida tu reserva',
            'hello-paragraph'    => 'Haz hecho una reserva online que necesita tu confirmación. De no hacerlo la misma caducará.',
            'appointment-title'  => 'Detalles de la reserva',
            'button'             => 'Validar Reserva',
        ],
    ],
];
