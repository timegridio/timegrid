<?php

return  [
  //============================== New strings to translate ==============================//
  'booking' => [
    'msg' => [
      'validate' => [
        'error' => [
          'bad-code'                              => 'Désolé, code de rendez-vous invalide',
          'no-appointment-was-found'              => 'Désolé, aucun rendez-vous n\'a été trouvé avec ce code',
        ],
        'success' => [
          'your-appointment-is-already-confirmed' => 'Cool, votre rendez-vous est déjà confirmé',
          'your-appointment-was-confirmed'        => 'Vous avez confirmé votre rendez-vous avec succès',
        ],
      ],
      'store' => [
        'error'            => 'Désolé, il n\'y a plus de disponibilité pour la tentative de réservation.',
        'not-registered'   => 'Vous devez être listé sur le carnet d\'adresses du contractant afin de faire une réservation en tant qu\'invité.',
        'sorry_duplicated' => 'Désolé, votre rendez-vous est en double avec :code réservé avant',
        'success'          => 'Super! Votre rendez-vous a été enregistré avec le code :code',
      ],
      'you_are_not_subscribed_to_business' => 'Pour pouvoir faire une réservation, vous devez être inscrire.',
    ],
  ],
  //==================================== Translations ====================================//
  'appointments' => [
    'alert' => [
      'book_in_biz_on_behalf_of' => 'Carnet de Rendez-vous pour :contact à :biz',
      'empty_list'               => 'Vous n\'avez aucune réservation en cours.',
      'no_vacancies'             => 'Désolé, l\'entreprise ne peut prendre aucune réservation maintenant.',
    ],
    'btn' => [
      'book'                     => 'Prennez un Rendez-vous',
      'book_in_biz'              => 'Prennez un Rendez-vous avec :biz',
      'book_in_biz_on_behalf_of' => 'Prennez un Rendez-vous avec :contact at :biz',
      'calendar'                 => 'Afficher le calendrier',
      'confirm_booking'          => 'Confirmer la réservation',
      'more_dates'               => 'Voir plus de dates',
    ],
    'form' => [
      'btn' => [
        'submit' => 'Confirmer',
      ],
      'comments' => [
        'label' => 'Voulez-vous laisser des commentaires pour le fournisseur?',
      ],
      'date' => [
        'label' => 'Date',
      ],
      'email' => [
        'label' => 'Votre email',
      ],
      'service' => [
        'label' => 'Service',
      ],
      'time' => [
        'label' => 'A quelle heure souhaitez-vous réserver?',
      ],
      'timetable' => [
        'instructions' => 'Sélectionnez un service à réserver',
        'msg'          => [
          'no_vacancies' => 'Il n\'y a pas de disponibilité pour cette date',
        ],
        'title' => 'Réserver un Rendez-vous avec :business',
      ],
    ],
    'index' => [
      'th' => [
        'business'    => 'Entreprise',
        'calendar'    => 'Date',
        'code'        => 'Code',
        'contact'     => 'Client',
        'duration'    => 'Durée',
        'finish_time' => 'Termine',
        'remaining'   => 'Dans',
        'service'     => 'Service',
        'start_time'  => 'Commence',
        'status'      => 'Status',
      ],
      'title' => 'Rendez-vous',
    ],
  ],
  'business' => [
    'btn' => [
      'subscribe_to' => 'S\'abonner à :business',
    ],
  ],
  'businesses' => [
    'index' => [
      'btn' => [
        'create'       => 'Inscrivez votre Entreprise',
        'manage'       => 'Mes Entreprises',
        'power_create' => 'S\'inscrire maintenant',
      ],
      'title' => 'Entreprises disponibles',
    ],
    'list' => [
      'no_businesses' => 'Aucune Entreprise disponible.',
    ],
    'subscriptions' => [
      'none_found' => 'Aucun abonnements disponibles.',
      'title'      => 'Abonnements',
    ],
  ],
  'contacts' => [
    'btn' => [
      'store'  => 'Sauvegarder',
      'update' => 'Mettre à Jour',
    ],
    'create' => [
      'help'  => 'Bien joué! Vous êtes sur le point de commencer. Remplissez votre profil de contact pour la première fois afin que votre réservation soit traitée en conséquence. Vous pourrez modifier cette information par entreprise si vous le souhaitez.',
      'title' => 'Mon profile',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Supprimé avec succès',
      ],
      'store' => [
        'associated_existing_contact' => 'Votre profil a été rattaché à un',
        'success'                     => 'Enregistré avec succès',
        'warning'                     => [
          'already_registered' => 'Ce profil était déjà enregistré',
        ],
      ],
      'update' => [
        'success' => 'Mis à jour avec succés',
      ],
    ],
  ],
  'dashboard' => [
    'card' => [
      'agenda' => [
        'button'      => 'Voir l\'Agenda',
        'description' => 'Consultez votre réservation actuelle.|[2,Inf] Découvrez vos réservations en cours.',
        'title'       => 'Un rendez-vous|[2,Inf] Vos rendez-vous',
      ],
      'directory' => [
        'button'      => 'Parcourir l\'annuaire',
        'description' => 'Parcourez le répertoire et réservez votre service.',
        'title'       => 'Annuaire',
      ],
      'subscriptions' => [
        'button'      => 'Voir les abonnements',
        'description' => 'Gérez vos abonnements aux entreprises.',
        'title'       => 'Abonnements',
      ],
    ],
  ],
  'msg' => [
    'preferences' => [
      'success' => 'Vos préférences ont été enregistrées.',
    ],
  ],
  'preferences' => [
    'title' => 'Mes préférences',
  ],
  'go_to_business_dashboard' => 'Aller à :business\'s dashboard',
];
