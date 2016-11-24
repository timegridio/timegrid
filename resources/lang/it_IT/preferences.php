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
    'cancellation_policy_advice' => [
      'format' => 'per esempio: Puoi cancellare gratuitamente il tuo appuntamento fino al %s',
      'help'   => 'Inserisci un avviso da mostrare ai tui clienti per le condizioni di cancellazione appuntamenti',
      'label'  => 'Condizioni di Cancellazione',
    ],
    'appointment_flexible_arrival' => [
      'format' => 'S&iacute;/No',
      'help'   => 'Permetti ai clienti di arrivare tra l\'orario di apertura e quello di chiusura',
      'label'  => 'Appuntamenti flessibili',
    ],
    'finish_at' => [
      'format' => 'hh:mm:ss',
      'help'   => 'L\'orario in cui termini di ricevere appuntamenti',
      'label'  => 'Orario di Chiusura',
    ],
    'service_default_duration' => [
      'format' => 'per esempio: 30',
      'help'   => 'La durata media del servizio fornito',
      'label'  => 'Durata della prestazione (in minuti)',
    ],
    'vacancy_edit_advanced_mode' => [
      'format' => 'S&iacute;/No',
      'help'   => 'Utilizz&agrave; la modalit&agrave; avanzata per pubblicare le giornate non lavorative',
      'label'  => 'Modalit&agrave; avanzata giorni non lavorativi',
    ],
    'time_format' => [
      'format' => 'H:i a',
      'help'   => 'Time format per mostrare l\'orario',
      'label'  => 'Time Format',
    ],
    'date_format' => [
      'format' => 'd-m-Y',
      'help'   => 'Date format per mostrare le date',
      'label'  => 'Date Format',
    ],
    'timeslot_step' => [
      'format' => 'Minuti',
      'help'   => 'Minuti necessari tra una prenotazione e l\'altra',
      'label'  => 'Tempo di passaggio',
    ],
    'availability_future_days' => [
      'format' => 'Giorni',
      'help'   => 'Numero di giorni da mostrare per la disponibilit&agrave; di prenotazione',
      'label'  => 'Disponibilit&agrave; prossimi giorni',
    ],
    'report_daily_schedule' => [
      'format' => 'S&iacute;/No',
      'help'   => 'Desidero ricevere una report giornaliero con gli appuntamenti attivi',
      'label'  => 'Abilita ricezione programma giornaliero',
    ],
    'vacancy_autopublish' => [
      'format' => 'S&iacute;/No',
      'help'   => 'Permetti a timegrid di pubblicare automaticamente e settimanalmente (ogni domenica) i giorni non lavorativi nel calendario',
      'label'  => 'Abilita pubblicazione automatica giorni non lavorativi',
    ],
    'allow_guest_registration' => [
      'format' => 'S&iacute;/No',
      'help'   => 'Permetti agli utenti la registrazione di nuovi contatti per appuntamenti non importanti',
      'label'  => 'Abilita la registrazione degli Ospiti',
    ],
  ],
  'controls' => [
    'select' => [
      'no'  => 'No',
      'yes' => 'S&iacute;',
    ],
  ],
];
