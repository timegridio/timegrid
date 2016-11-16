<?php

return  [
  //============================== New strings to translate ==============================//
  'booking' => [
    'msg' => [
      'validate' => [
        'error' => [
          'bad-code'                              => 'Spiacenti, codice appuntamento non valido',
          'no-appointment-was-found'              => 'Spiacenti, nessun appuntamento trovato per il codice fornito',
        ],
        'success' => [
          'your-appointment-is-already-confirmed' => 'Il tuo appuntamento risulta gi&agrave; confermato',
          'your-appointment-was-confirmed'        => 'Appuntamento confermato correttamente',
        ],
      ],
      'store' => [
        'error'            => 'Spiacenti, disponibilit&agrave; terminata per la richiesta effettuata.',
        'not-registered'   => 'Devi risultare negli indirizzi dell\'azienda per poter effettuare una prenotazione.',
        'sorry_duplicated' => 'Spiacenti, il tuo appuntamento risulta duplicato con il codice :code utilizzato precedentemente',
        'success'          => 'Buone notizie! Il tuo appuntamento &egrave; stato registrato con il codice :code',
      ],
      'you_are_not_subscribed_to_business' => 'Per effettuare una prenotazione devi essere registrato presso l\'azienda',
    ],
  ],
  //==================================== Translations ====================================//
  'appointments' => [
    'alert' => [
      'book_in_biz_on_behalf_of' => 'Effettua una prenotazione per :contact presso :biz',
      'empty_list'               => 'Non hai nessuna prenotazione al momento.',
      'no_vacancies'             => 'Spiacenti, l\'azienda non pu&ograve; ricevere altre prenotazioni al momento.',
    ],
    'btn' => [
      'book'                     => 'Prenota un appuntamento',
      'book_in_biz'              => 'Prenota un appuntamento per :biz',
      'book_in_biz_on_behalf_of' => 'Prenota un appuntamento :contact presso :biz',
      'calendar'                 => 'Consulta il Calendario',
      'confirm_booking'          => 'Conferma la prenotazione dell\'appuntamento',
      'more_dates'               => 'Controlla altre date',
    ],
    'form' => [
      'btn' => [
        'submit' => 'Conferma',
      ],
      'comments' => [
        'label' => 'Desideri lasciare un commento per il fornitore del servizio?',
      ],
      'date' => [
        'label' => 'Data',
      ],
      'email' => [
        'label' => 'La tua email',
      ],
      'service' => [
        'label' => 'Servizio',
      ],
      'time' => [
        'label' => 'Che orario desideri prenotare?',
      ],
      'timetable' => [
        'instructions' => 'Seleziona un servizio da prenotare',
        'msg'          => [
          'no_vacancies' => 'Non ci sono posti disponibili per questa data',
        ],
        'title' => 'Prenota un appuntamento presso :business',
      ],
    ],
    'index' => [
      'th' => [
        'business'    => 'Azienda',
        'calendar'    => 'Data',
        'code'        => 'Codice',
        'contact'     => 'Cliente',
        'duration'    => 'Durata',
        'finish_time' => 'Fine',
        'remaining'   => 'Entro',
        'service'     => 'Servizio',
        'start_time'  => 'Inizio',
        'status'      => 'Stato',
      ],
      'title' => 'Appuntamenti',
    ],
  ],
  'business' => [
    'btn' => [
      'subscribe_to' => 'Iscriviti presso :business',
    ],
  ],
  'businesses' => [
    'index' => [
      'btn' => [
        'create'       => 'Registra un\'azienda',
        'manage'       => 'Le mie aziende',
        'power_create' => 'Registrati',
      ],
      'title' => 'Aziende disponibili',
    ],
    'list' => [
      'no_businesses' => 'Nessuna azienda disponibile.',
    ],
    'subscriptions' => [
      'none_found' => 'Nessuna iscrizione disponibile.',
      'title'      => 'Iscrizioni',
    ],
  ],
  'contacts' => [
    'btn' => [
      'store'  => 'Salva',
      'update' => 'Aggiorna',
    ],
    'create' => [
      'help'  => 'Bene! Ci siamo quasi. Compila il tuo profilo per gestire la prenotazione. Potrai modificare queste informazioni quando vuoi.',
      'title' => 'Il mio profilo',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Cancellato correttamente',
      ],
      'store' => [
        'associated_existing_contact' => 'Il tuo profilo &egrave; stato collegato ad un profilo esistente',
        'success'                     => 'Salvato correttamente',
        'warning'                     => [
          'already_registered' => 'Questo profilo risulta gi&agrave; registrato',
        ],
      ],
      'update' => [
        'success' => 'Aggiornato correttamente',
      ],
    ],
  ],
  'dashboard' => [
    'card' => [
      'agenda' => [
        'button'      => 'Consulta l\'Agenda',
        'description' => 'Controlla la tua prenotazione.|[2,Inf] Controlla le tue prenotazioni.',
        'title'       => 'Il tuo appuntamento|[2,Inf] I tuoi appuntamenti',
      ],
      'directory' => [
        'button'      => 'Consulta l\'elenco',
        'description' => 'Consulta l\'elenco e prenota il tuo servizio.',
        'title'       => 'Elenco',
      ],
      'subscriptions' => [
        'button'      => 'Controlla le iscrizioni',
        'description' => 'Gestisci le tue iscrizioni presso le aziende.',
        'title'       => 'Iscrizioni',
      ],
    ],
  ],
  'msg' => [
    'preferences' => [
      'success' => 'Le tue impostazioni sono state salvate.',
    ],
  ],
  'preferences' => [
    'title' => 'Impostazioni',
  ],
];
