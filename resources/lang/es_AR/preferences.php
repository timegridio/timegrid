<?php

return  [
  'App\\Models\\User' => [
    'timezone' => [
      'label' => 'Zona Horaria',
    ],
  ],
  'App\\Models\\Business' => [
    'appointment_cancellation_pre_hs' => [
      'format' => 'Cantida de horas',
      'help'   => 'Cantidad de horas con las que es factible cancelar un turno',
      'label'  => 'Antelación de Cancelaciones',
    ],
    'appointment_code_length' => [
      'format' => 'Cantidad de caracteres',
      'help'   => 'Cantidad de caracteres para identificar un turno',
      'label'  => 'Largo de Código de Turno',
    ],
    'appointment_take_today' => [
      'format' => 'Cantidad de horas',
      'help'   => 'Permitir que se tomen turnos en el mismo día',
      'label'  => 'Recibir turnos en el día',
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
      'help'   => 'Horario en que comienzas a recibir turnos',
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
