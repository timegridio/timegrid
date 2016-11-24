<?php

return  [
  'user' => [
    'welcome' => [
      'subject'              => 'Benvenuto a timegrid.io',
      'button'               => 'TODO: button',
      'hello-paragraph'      => 'TimeGrid aiuta imprenditori e clienti a trovare l\'orario ideale per un appuntamento.',
      'hello-title'          => 'Ciao :userName',
      'quickstart-paragraph' => 'Vai su timegrid ogni volta che vuoi fare una prenotazione',
      'quickstart-title'     => 'Sei pronto a partire',
    ],
    'appointment-cancellation' => [
      'appointment-title' => 'Ecco i dettagli del tuo appuntamento cancellato',
      'button'            => 'Consulta la mia agenda',
      'hello-paragraph'   => 'Spiacenti, il tuo appuntamento &egrave; stato cancellato.',
      'hello-title'       => 'Ciao :userName,',
    ],
    'appointment-confirmation' => [
      'appointment-title' => 'Ecco i dettagli del tuo appuntamento',
      'button'            => 'Consulta la mia agenda',
      'hello-paragraph'   => 'Il tuo appuntamento &egrave; stato confermato.',
      'hello-title'       => 'Ciao :userName,',
    ],
    'appointment-notification' => [
      'appointment-title' => 'Ecco i dettagli del tuo appuntamento',
      'button'            => 'Consulta la mia agenda',
      'hello-paragraph'   => 'La tua richiesta di appuntamento è stata ricevuta.',
      'hello-title'       => ':userName, hai richiesto un nuovo appuntamento',
    ],
  ],
  //==================================== Translations ====================================//
  'guest' => [
    'password' => [
      'hello'        => 'Ciao :userName,',
      'instructions' => 'Clicca sul pulsante di reset password per resettarla.',
    ],
  ],
  'manager' => [
    'appointment-notification' => [
      'instructions' => 'Nuovo appuntamento prenotato',
      'title'        => 'Dettagli Appuntamento',
      'welcome'      => ':ownerName, hai un nuovo appuntamento',
    ],
    'business-report' => [
      'button'  => 'Calendario',
      'welcome' => 'Ciao :ownerName',
      'subject' => 'Calendario al :date',
    ],
  ],
];
