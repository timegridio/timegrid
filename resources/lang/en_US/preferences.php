<?php

return  [
  //==================================== Translations ====================================//
  'App\\Models\\Business' => [
    'appointment_cancellation_pre_hs' => [
      'format' => 'Number of hours',
      'help'   => 'Number of hours in advance for which an appointment can be canceled',
      'label'  => 'Appointment Cancellation Anticipation',
    ],
    'appointment_code_length' => [
      'format' => 'Number of characters',
      'help'   => 'Number of characters an appointment code is identified with',
      'label'  => 'Appointment Code Length',
    ],
    'appointment_take_today' => [
      'format' => 'Number of hours',
      'help'   => 'Permit booking on the same day the reservation takes place',
      'label'  => 'Permit booking on same day',
    ],
    'show_map' => [
      'format' => 'Yes/No',
      'help'   => 'Publish the map of your location (city level)',
      'label'  => 'Publish Map',
    ],
    'show_phone' => [
      'format' => 'Yes/No',
      'help'   => 'Publish your phone in business profile',
      'label'  => 'Publish Phone',
    ],
    'show_postal_address' => [
      'format' => 'Yes/no',
      'help'   => 'Publish full postal address',
      'label'  => 'Publish Postal Address',
    ],
    'start_at' => [
      'format' => 'hh:mm:ss',
      'help'   => 'The time your business opens for receiving appointments',
      'label'  => 'Opening Hour',
    ],
  ],
  'controls' => [
    'select' => [
      'no'  => 'No',
      'yes' => 'Yes',
    ],
  ],
];
