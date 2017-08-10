<?php

return  [
  'App\\Models\\User' => [
    'timezone' => [
      'label' => 'Timezone',
    ],
  ],
  'App\\Models\\Business' => [
    'appointment_cancellation_pre_hs' => [
      'format' => 'Nombre d\'heure',
      'help'   => 'Nombre d\'heures par avance pour les quelles un rendez-vous peut être annulé',
      'label'  => 'Anticiper une annulation de rendez-vous',
    ],
    'appointment_code_length' => [
      'format' => 'Nombre de caractères',
      'help'   => 'Nombre de caractères pour identifier le code d\'un rendez-vous',
      'label'  => 'Taille d\'un code de rendez-vous',
    ],
    'appointment_take_today' => [
      'format' => 'Nombre d\'heure',
      'help'   => 'Autoriser la réservation le jour même où la réservation aura lieu',
      'label'  => 'Autoriser la réservation le même jour',
    ],
    'show_map' => [
      'format' => 'Oui/Non',
      'help'   => 'Publiez la carte de votre emplacement (au niveau de la ville)',
      'label'  => 'Publier la Carte',
    ],
    'show_phone' => [
      'format' => 'Oui/Non',
      'help'   => 'Publiez votre téléphone dans le profil d\'entreprise',
      'label'  => 'Publier téléphone',
    ],
    'show_postal_address' => [
      'format' => 'Oui/Non',
      'help'   => 'Publish full postal address',
      'label'  => 'Publish Postal Address',
    ],
    'start_at' => [
      'format' => 'hh:mm:ss',
      'help'   => 'The time your business opens for receiving appointments',
      'label'  => 'Opening Hour',
    ],
    'cancellation_policy_advice' => [
      'format' => 'example: You may annulate this appointment charge-free until %s',
      'help'   => 'Write an advice text your clients will see about your appointment cancellation policy',
      'label'  => 'Cancellation Policy Advice Text',
    ],
    'appointment_flexible_arrival' => [
      'format' => 'Oui/Non',
      'help'   => 'Let clients arrive anytime during service time',
      'label'  => 'Flexible appointments by arrival time order',
    ],
    'finish_at' => [
      'format' => 'hh:mm:ss',
      'help'   => 'The time your business closes for receiving appointments',
      'label'  => 'Closing Hour',
    ],
    'service_default_duration' => [
      'format' => 'example: 30',
      'help'   => 'The default duration of any service you provide',
      'label'  => 'Default service duration (minutes)',
    ],
    'vacancy_edit_advanced_mode' => [
      'format' => 'Oui/Non',
      'help'   => 'Use advanced mode to publish vacancies',
      'label'  => 'Use advanced mode to publish vacancies',
    ],
    'time_format' => [
      'format' => 'H:i a',
      'help'   => 'Time format to display time',
      'label'  => 'Time Format',
    ],
    'date_format' => [
      'format' => 'Y-m-d',
      'help'   => 'Date format to display dates',
      'label'  => 'Date Format',
    ],
    'timeslot_step' => [
      'format' => 'Number',
      'help'   => 'Number of minutes to step for booking availability',
      'label'  => 'Timeslot step',
    ],
    'availability_future_days' => [
      'format' => 'Number',
      'help'   => 'Number of days to show for booking availability',
      'label'  => 'Availability future days',
    ],
    'report_daily_schedule' => [
      'format' => 'Oui/Non',
      'help'   => 'I want to receive a daily email with active appointments',
      'label'  => 'Enable Daily Schedule Email',
    ],
    'vacancy_autopublish' => [
      'format' => 'Oui/Non',
      'help'   => 'Let timegrid autopublish my vacancies weekly (every sunday)',
      'label'  => 'Enable Vacancy Autopublish',
    ],
    'allow_guest_registration' => [
      'format' => 'Oui/Non',
      'help'   => 'Let guest users to register on your addressbook through reserving an appointment',
      'label'  => 'Allow guest users to reserve appointments',
    ],
    'disable_outbound_mailing' => [
      'format' => 'Oui/Non',
      'help'   => 'Prevent sending emails',
      'label'  => 'Disable outbound mailing',
    ],
  ],
  'controls' => [
    'select' => [
      'no'  => 'No',
      'yes' => 'Yes',
    ],
  ],
];
