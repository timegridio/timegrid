<?php

return  [
  //============================== New strings to translate ==============================//
  'booking' => [
    'msg' => [
      'validate' => [
        'error' => [
          'bad-code'                              => 'Código de cita inválido',
          'no-appointment-was-found'              => 'No encontramos citas con ese código',
        ],
        'success' => [
          'your-appointment-is-already-confirmed' => 'Bien, tu cita ya está confirmada',
          'your-appointment-was-confirmed'        => 'Confirmaste tu cita exitosamente',
        ],
      ],
      'store' => [
        'error'            => 'Lo sentimos, no hay la disponibilidad está agotada para esta reserva.',
        'not-registered'   => 'Debés estar en la agenda de contactos del proveedor para hacer reservas como invitado.',
        'sorry_duplicated' => 'Lo sentimos, tu cita se duplica con el :code reservado anteriormente',
        'success'          => '¡Tomá nota! Reservamos tu cita bajo el código :code',
      ],
      'you_are_not_subscribed_to_business' => 'Para pedir una cita debés suscribirte al prestador antes',
    ],
  ],
  //==================================== Translations ====================================//
  'appointments' => [
    'alert' => [
      'book_in_biz_on_behalf_of' => 'Reservar cita para :contact en :biz',
      'empty_list'               => 'No tienes reservas en curso ahora.',
      'no_vacancies'             => 'Lo sentimos, el prestador no puede tomar reservas al momento.',
    ],
    'btn' => [
      'book'                     => 'Reservar Cita',
      'book_in_biz'              => 'Reservar cita en :biz',
      'book_in_biz_on_behalf_of' => 'Reservar cita para :contact en :biz',
      'calendar'                 => 'Ver Calendario',
      'confirm_booking'          => 'Confirmar reserva de cita',
      'more_dates'               => 'Ver más fechas',
    ],
    'form' => [
      'btn' => [
        'submit' => 'Confirmar',
      ],
      'comments' => [
        'label' => '¿ Querés dejarle algún comentario al prestador ?',
      ],
      'date' => [
        'label' => 'Fecha',
      ],
      'email' => [
        'label' => 'Tu Email',
      ],
      'service' => [
        'label' => 'Servicio',
      ],
      'time' => [
        'label' => '¿ Qué horario querés reservar ?',
      ],
      'timetable' => [
        'instructions' => 'Selecciona un servicio para reservar cita',
        'msg'          => [
          'no_vacancies' => 'No hay disponibilidades para esta fecha',
        ],
        'title' => 'Reserva una cita en :business',
      ],
    ],
    'index' => [
      'th' => [
        'business'    => 'Prestador',
        'calendar'    => 'Fecha',
        'code'        => 'Código',
        'contact'     => 'Cliente',
        'duration'    => 'Duración',
        'finish_time' => 'Finaliza',
        'remaining'   => 'Dentro de',
        'service'     => 'Servicio',
        'start_time'  => 'Comienza',
        'status'      => 'Estado',
      ],
      'title' => 'Citas',
    ],
  ],
  'business' => [
    'btn' => [
      'subscribe_to' => 'Suscribirme a :business',
    ],
  ],
  'businesses' => [
    'index' => [
      'btn' => [
        'create'       => 'Registrar Prestación',
        'manage'       => 'Mis Prestaciones',
        'power_create' => 'Registrá tu comercio ahora',
      ],
      'title' => 'Prestadores disponibles',
    ],
    'list' => [
      'no_businesses' => 'No se econtraron prestadores.',
    ],
    'subscriptions' => [
      'none_found' => 'No hay suscripciones disponibles.',
      'title'      => 'Suscripciones',
    ],
  ],
  'contacts' => [
    'btn' => [
      'store'  => 'Guardar',
      'update' => 'Editar',
    ],
    'create' => [
      'help'  => '¡Bien hecho! Ya casi estas listo. Llena tu perfil por primera vez para que tu reserva se maneje sin consecuencia. Podrás cambiar esta información por empresa si deseas.',
      'title' => 'Mis datos',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'TODO: success',
      ],
      'store' => [
        'associated_existing_contact' => 'Se asoció tu perfil a los datos ya registrados',
        'success'                     => 'Guardado',
        'warning'                     => [
          'already_registered' => 'Se asoció tu perfil a los datos ya registrados',
        ],
      ],
      'update' => [
        'success' => 'Actualizado',
      ],
    ],
  ],
  'dashboard' => [
    'card' => [
      'agenda' => [
        'button'      => 'Ver Agenda',
        'description' => 'Revisa tu cita actual en agenda.|[2, Inf] Revisa tus citas actuales en agenda.',
        'title'       => 'Tu Cita|[2, Inf] Tus Citas',
      ],
      'directory' => [
        'button'      => 'Ver Directorio',
        'description' => 'Conoce los comercions en los que puedes reservar servicios.',
        'title'       => 'Directorio',
      ],
      'subscriptions' => [
        'button'      => 'Mis Suscripciones',
        'description' => 'Revisa los comercios a los que ya estás suscripto.',
        'title'       => 'Suscripciones',
      ],
    ],
  ],
  'msg' => [
    'preferences' => [
      'success' => 'Hemos guardado tus preferencias de usuario.',
    ],
  ],
  'preferences' => [
    'title' => 'Preferencias',
  ],
];
