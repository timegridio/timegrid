<?php

return  [
  'App\\Models\\User' => [
    'timezone' => [
      'label' => 'Fuso Orario',
    ],
  ],
  'App\\Models\\Business' => [
    'appointment_cancellation_pre_hs' => [
      'format' => 'Ore',
      'help'   => 'Ore di anticipo richieste per la cancellazione di un appuntamento',
      'label'  => 'Cancellazione Appuntamento',
    ],
    'appointment_code_length' => [
      'format' => 'Numero di caratteri',
      'help'   => 'Numero di caratteri da utilizzare per creare un codice appuntamento',
      'label'  => 'Codice Appuntamento',
    ],
    'appointment_take_today' => [
      'format' => 'Ore',
      'help'   => 'Permetti di prendere un\'appuntamento il giorno stesso della prestazione',
      'label'  => 'Permetti appuntamenti lo stesso giorno',
    ],
    'show_map' => [
      'format' => 'S&iacute;/No',
      'help'   => 'Pubblica la mappa della tua posizione (mostra la citt&agrave;)',
      'label'  => 'Pubblica Mappa',
    ],
    'show_phone' => [
      'format' => 'S&iacute;/No',
      'help'   => 'Pubblica il tuo numero di telefono',
      'label'  => 'Pubblica Telefono',
    ],
    'show_postal_address' => [
      'format' => 'S&iacute;/no',
      'help'   => 'Pubblica il tuo indirizzo postale',
      'label'  => 'Pubblica Indirizzo',
    ],
    'start_at' => [
      'format' => 'hh:mm:ss',
      'help'   => 'L\'orario in cui inizi a ricevere appuntamenti',
      'label'  => 'Orario di Apertura',
    ],
  ],
  'controls' => [
    'select' => [
      'no'  => 'No',
      'yes' => 'S&iacute;',
    ],
  ],
];
