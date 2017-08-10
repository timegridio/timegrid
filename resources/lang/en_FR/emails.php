<?php

return [
    'root'    => [
        'report' => [
            'subject' => 'Rapport original',
        ],
    ],
    'manager' => [
        'business-report' => [
            'subject'      => 'Programmé un rapport :date pour :businessName',
            'welcome'      => 'Bonjour :ownerName',
            'button'       => 'Afficher le calendrier',
        ],
        'appointment-notification' => [
            'subject'      => 'Vous avez un nouveau rendez-vous',
            'welcome'      => ':ownerName, vous avez un nouveau rendez-vous',
            'instructions' => 'Un nouveau rendez-vous a été réservé',
            'title'        => 'Détails du rendez-vous',
        ],
    ],
    'user'    => [
        'welcome' => [
            'subject'              => 'Bienvenue sur timegrid.io',
            'hello-title'          => 'Bonjour :userName',
            'hello-paragraph'      => 'Timegrid aide les entrepreneurs et les clients à trouver les meilleurs horaires de réunion via les rendez-vous en ligne.',
            'quickstart-title'     => 'Vous êtes prêt à démarrer',
            'quickstart-paragraph' => 'Allez simplement sur timegrid pour toutes réservations auprès de votre entrepreneur',
        ],
        'appointment-notification' => [
            'subject'              => 'Les détails de votre nouveau rendez-vous',
            'hello-title'          => ':userName, Vous avez effectué un nouveau rendez-vous',
            'hello-paragraph'      => 'Votre réservation de rendez-vous est confirmée.',
            'appointment-title'    => 'Voici les détails de votre rendez-vous',
            'button'               => 'Consulter mon agenda',
        ],
        'appointment-confirmation' => [
            'subject'              => 'Votre rendez-vous auprés de :businessName est confirmé',
            'hello-title'          => 'Bonjour :userName,',
            'hello-paragraph'      => 'Votre rendez-vous est confirmé.',
            'appointment-title'    => 'Voici les détails de votre rendez-vous',
            'button'               => 'Consulter mon agenda',
        ],
        'appointment-cancellation' => [
            'subject'              => 'Votre rendez-vous auprés de :businessName est annulé',
            'hello-title'          => 'Bonjour :userName,',
            'hello-paragraph'      => 'Désolé, votre rendez-vous a été annulé.',
            'appointment-title'    => 'Voici les détails du rendez-vous annulé',
            'button'               => 'Consulter mon agenda',
        ],
    ],
    'guest'   => [
        'password' => [
            'subject'      => 'Réinitialiser votre mot de passe.',
            'hello'        => 'Bonjour :userName,',
            'instructions' => 'Cliquez simplement sur le bouton Réinitialiser le mot de passe pour réinitialisez votre mot de passe.',
            'button'       => 'Réinitialiser mon mot de passe.',
        ],
        'appointment-validation' => [
            'subject'            => 'Veuillez valider votre réservation',
            'hello-title'        => 'Validez votre rendez-vous',
            'hello-paragraph'    => 'Vous avez effectué une réservation en tant qu\'invité qui nécessite votre validation. Dans le cas où vous ne confirmez pas, la réservation expirera automatiquement.',
            'appointment-title'  => 'Détails de la réservation',
            'button'             => 'Valider le rendez-vous',
        ],
    ],
    'text'  => [
        'business'          => 'Business',
        'user'              => 'Utilisateur',
        'date'              => 'Date',
        'time'              => 'Horaire',
        'code'              => 'Code',
        'where'             => 'Adresse',
        'phone'             => 'Téléphone',
        'service'           => 'Service',
        'important'         => 'important',
        'customer_notes'    => 'Notes du client pour vous',
        'there_are'         => 'Il y a',
        'registered'        => 'Utilisateurs enregistrés jusqu\'à présent',
    ],
];
