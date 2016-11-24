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
    'cancellation_policy_advice' => [
      'format' => 'ejemplo: Podrás cancelar el turno sin cargo hasta el %s',
      'help'   => 'Escribe un breve texto de tu política de cancelación de turnos',
      'label'  => 'Política de Cancelación de Turnos',
    ],
    'appointment_flexible_arrival' => [
      'format' => 'Si/No',
      'help'   => 'Dar turnos con horario flexible por orden de llegada',
      'label'  => 'Turnos por orden de llegada',
    ],
    'finish_at' => [
      'format' => 'hh:mm:ss',
      'help'   => 'Horario en que no recibes más turnos',
      'label'  => 'Horario de Cierre',
    ],
    'service_default_duration' => [
      'format' => 'ejemplo: 30',
      'help'   => 'La duración por defecto de tus servicios',
      'label'  => 'Duración Predeterminada de Servicios (minutos)',
    ],
    'vacancy_edit_advanced_mode' => [
      'format' => 'Si/No',
      'help'   => 'Usar modo avanzado para publicar disponibilidad',
      'label'  => 'Usar modo avanzado para publicar disponibilidad',
    ],
    'time_format' => [
      'format' => 'H:i a',
      'help'   => 'Formato preferido para mostrar la hora',
      'label'  => 'Formato de Hora',
    ],
    'date_format' => [
      'format' => 'Y-m-d',
      'help'   => 'Formato para mostrar fechas',
      'label'  => 'Formato de Fecha',
    ],
    'timeslot_step' => [
      'format' => 'número de minutos',
      'help'   => 'Cantidad de minutos entre espacio y espacio para reservar',
      'label'  => 'Saltos entre reservas',
    ],
    'availability_future_days' => [
      'format' => 'número',
      'help'   => 'Cantidad de días a mostrar en disponibilidad',
      'label'  => 'Días futuros en disponibilidad',
    ],
    'report_daily_schedule' => [
      'format' => 'Si/No',
      'help'   => 'Quiero recibir un correo diario con turnos activos',
      'label'  => 'Reporte Diario de Turnos',
    ],
    'vacancy_autopublish' => [
      'format' => 'Si/No',
      'help'   => 'Dejar que timegrid publique mi disponibilidad cada Domingo',
      'label'  => 'Disponibilidad Automática',
    ],
    'allow_guest_registration' => [
      'format' => 'Si/No',
      'help'   => 'Permitir a usuarios no identificados a agregarse en tu agenda de contactos',
      'label'  => 'Permitir Registro de Invitados',
    ],
  ],
  'controls' => [
    'select' => [
      'no'  => 'No',
      'yes' => 'Sí',
    ],
  ],
];
