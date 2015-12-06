<?php
/*************************************************************************
 Generated via "php artisan localization:missing" at 2015/12/04 11:29:01
*************************************************************************/

return [
  //==================================== Translations ====================================//
  'appointments' => [
    'alert' => [
      'empty_list'   => 'No tienes reserves en curso ahora.',
      'no_vacancies' => 'Lo sentimos, el prestador no puede tomar reservas al momento.',
    ],
    'btn' => [
      'book'        => 'Reservar Cita',
      'book_in_biz' => 'Reservar cita en :biz',
    ],
    'form' => [
      'btn' => [
        'submit' => 'Confirmar',
      ],
      'comments' => [
        'label' => 'Comentarios',
      ],
      'date' => [
        'label' => 'Fecha',
      ],
      'duration' => [
        'label' => 'Duración',
      ],
      'msg' => [
        'please_select_a_service' => 'Selecciona un servicio',
      ],
      'service' => [
        'label' => 'Servicio',
      ],
      'time' => [
        'label' => 'Hora',
      ],
      'timetable' => [
        'instructions' => 'Selecciona un servicio para reservar cita',
        'msg'          => [
          'no_vacancies' => 'No hay disponibilidades para esta fecha',
        ],
        'title' => 'Reserva una cita',
      ],
      'business' => [
        'label' => 'Comercio',
      ],
      'contact_id' => [
        'label' => 'Contacto',
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
  'booking' => [
    'msg' => [
      'store' => [
        'error'            => 'Please translate this !',
        'sorry_duplicated' => 'Lo sentimos, tu cita se duplica con el :code reservado anteriormente',
        'success'          => '¡Tomá nota! Reservamos tu cita bajo el código :code',
      ],
      'you_are_not_subscribed_to_business' => 'Para pedir una cita debés suscribirte al prestador antes',
    ],
  ],
  'business' => [
    'btn' => [
      'subscribe' => 'Suscribir',
    ],
    'msg' => [
      'please_select_a_business' => 'Seleccioná un prestador',
    ],
    'subscriptions_count' => '{0} ¡Sé el primer suscriptor! |Este prestador ya tiene :count usuario suscripto|Este prestador tiene :count usuarios suscriptos',
  ],
  'businesses' => [
    'index' => [
      'btn' => [
        'create'       => 'Registrar prestador',
        'manage'       => 'Mis prestadores',
        'power_create' => 'Registrá tu comercio ahora',
      ],
      'title' => 'Prestadores disponibles',
    ],
    'list' => [
      'no_businesses' => 'No se econtraron prestadores.',
      'alert'         => [
        'not_found' => 'No podemos encontrar ese prestador, favor de escoger uno de la lista',
      ],
    ],
    'subscriptions' => [
      'none_found' => 'No hay suscripciones disponibles.',
      'title'      => 'Suscripciones',
    ],
    'show' => [
      'btn' => [
        'book'   => 'Reservar Cita',
        'change' => 'Cambiar',
      ],
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
      'store' => [
        'associated_existing_contact' => 'Se asoció tu perfil a los datos ya registrados',
        'success'                     => 'Guardado',
        'warning'                     => [
          'already_registered'       => 'Se asoció tu perfil a los datos ya registrados',
          'showing_existing_contact' => 'Se asoció tu perfil a los datos ya registrados',
        ],
      ],
      'update' => [
        'success' => 'Actualizado',
      ],
    ],
  ],
  //================================== Obsolete strings ==================================//
];
