<?php

return  [
  //==================================== Translations ====================================//
  'App\\Models\\Business' => [
    'appointment_cancellation_pre_hs' => [
      'format' => 'Cantida de horas',
      'help'   => 'Cantidad de horas con las que es factible cancelar una cita',
      'label'  => 'Antelación de Cancelaciones',
    ],
    'appointment_code_length' => [
      'format' => 'Cantidad de caracteres',
      'help'   => 'Cantidad de caracteres para identificar una cita',
      'label'  => 'Largo de Código de Cita',
    ],
    'appointment_take_today' => [
      'format' => 'Cantidad de horas',
      'help'   => 'Permitir que se tomen citas en el mismo día',
      'label'  => 'Recibir citas en el día',
    ],
    'show_map' => [
      'format' => 'Si/No',
      'help'   => 'Quieres mostrar el mapa de tu ubicación (nivel ciudad)',
      'label'  => 'Publicar mapa',
    ],
    'show_phone' => [
      'format' => 'Sí/No',
      'help'   => 'Publicar el teléfono de mi negocio en el perfil',
      'label'  => 'Publicar teléfono',
    ],
    'show_postal_address' => [
      'format' => 'Sí/No',
      'help'   => 'Publicar la dirección postal completa',
      'label'  => 'Publicar Dirección Postal',
    ],
    'start_at' => [
      'format' => 'hh:mm:ss',
      'help'   => 'Horario en que comienzas a recibir citas',
      'label'  => 'Hora de Apertura',
    ],
  ],
  'controls' => [
    'select' => [
      'no'  => 'No',
      'yes' => 'Sí',
    ],
  ],
];
