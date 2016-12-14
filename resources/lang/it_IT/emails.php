<?php

return [
    'root'    => [
        'report' => [
            'subject' => 'Root Report',
        ],
    ],
    'manager' => [
        'business-report' => [
            'subject'      => 'Report per :businessName del giorno :date',
            'welcome'      => 'Ciao :ownerName',
            'button'       => 'Calendario',
        ],
        'appointment-notification' => [
            'subject'      => 'Hai un nuovo appuntamento',
            'welcome'      => ':ownerName, hai un nuovo appuntamento',
            'instructions' => 'Nuovo appuntamento prenotato',
            'title'        => 'Dettagli Appuntamento',
        ],
    ],
    'user'    => [
        'welcome' => [
            'subject'              => 'Benvenuto in timegrid.io',
            'hello-title'          => 'Ciao :userName',
            'hello-paragraph'      => 'TimeGrid aiuta imprenditori e clienti a trovare l\'orario ideale per un appuntamento.',
            'quickstart-title'     => 'Sei pronto a partire',
            'quickstart-paragraph' => 'Vai su timegrid ogni volta che vuoi fare una prenotazione',
        ],
        'appointment-notification' => [
            'subject'              => 'I dettagli del tuo appuntamento',
            'hello-title'          => ':userName, hai richiesto un nuovo appuntamento',
            'hello-paragraph'      => 'La tua richiesta di appuntamento è stata ricevuta.',
            'appointment-title'    => 'Ecco i dettagli del tuo appuntamento',
            'button'               => 'Consulta la mia agenda',
        ],
        'appointment-confirmation' => [
            'subject'              => 'Il tuo appuntamento presso :businessName &egrave; stato confermato',
            'hello-title'          => 'Ciao :userName,',
            'hello-paragraph'      => 'Il tuo appuntamento &egrave; stato confermato.',
            'appointment-title'    => 'Ecco i dettagli del tuo appuntamento',
            'button'               => 'Consulta la mia agenda',
        ],
        'appointment-cancellation' => [
            'subject'              => 'Il tuo appuntamento presso :businessName &egrave; stato cancellato',
            'hello-title'          => 'Ciao :userName,',
            'hello-paragraph'      => 'Spiacenti, il tuo appuntamento &egrave; stato cancellato.',
            'appointment-title'    => 'Ecco i dettagli del tuo appuntamento cancellato',
            'button'               => 'Consulta la mia agenda',
        ],
    ],
    'guest'   => [
        'password' => [
            'subject'      => 'Password reset',
            'hello'        => 'Ciao :userName,',
            'instructions' => 'Clicca sul pulsante di reset password per resettarla.',
            'button'       => 'Resetta la mia password.',
        ],
        'appointment-validation' => [
            'subject'            => 'Per favore conferma il tuo appuntamento',
            'hello-title'        => 'Conferma il tuo appuntamento',
            'hello-paragraph'    => 'You made a guest reservation which needs your validation. In case you don\'t confirm, it will automatically expire.',
            'hello-paragraph'    => 'Hai fatto una prenotazione come utente ospite e abbiamo bisogno della tua convalida. La prenotazione scadr&agrave; automaticamente se non sar&agrave; confermata.',
            'appointment-title'  => 'Dettagli appuntamento',
            'button'             => 'Conferma Appuntamento',
        ],
    ],
    'text'  => [
        'business'          => 'Commercio',
        'user'              => 'Utente',
        'date'              => 'Data',
        'time'              => 'Orario',
        'code'              => 'Codice',
        'where'             => 'Posto',
        'phone'             => 'Tel',
        'service'           => 'Sevizio',
        'important'         => 'Importante',
        'customer_notes'    => 'Note',
        'there_are'         => 'Ci sono',
        'registered'        => 'utenti registrati finora',
    ],
];
