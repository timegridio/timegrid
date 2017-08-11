<?php

return  [
  //==================================== Translations ====================================//
  'agenda' => [
    'title'    => 'Agenda',
    'subtitle' => 'Liste des réservations permanentes',
  ],
  'business' => [
    'btn' => [
      'tooltip' => [
        'agenda'         => 'Calendrier des réservations',
        'contacts'       => 'Liste des Contacts',
        'humanresources' => 'Equipe',
        'services'       => 'Gérer les services',
        'vacancies'      => 'Publier la disponibilité',
      ],
    ],
    'hint' => [
      'out_of_vacancies' => 'Publiez votre disponibilité<br><br>pour que les clients commencent à prendre des réservations, vous devez publier votre disponibilité.',
      'set_services'     => 'Ajoutez les services que vous offrez',
    ],
    'service' => [
      'msg' => [
        'update' => [
          'success' => 'Service mis à jour!',
        ],
      ],
    ],
  ],
  'businesses' => [
    'btn' => [
      'store'  => 'S\'inscrire',
      'update' => 'Mettre à jour',
    ],
    'check' => [
      'remember_vacancies'  => 'Enregistrer ces disponibiltés par défaut',
      'unpublish_vacancies' => 'Réinitialiser ma disponibilité actuelle avant de publier',
    ],
    'contacts' => [
      'btn' => [
        'create' => 'Ajouter un Contact',
      ],
    ],
    'create' => [
      'title' => 'Enregistrez votre entreprise',
    ],
    'notifications' => [
      'title' => 'Notifications',
      'help' => 'Tout ce qui s\'est passé récemment',
    ],
    'dashboard' => [
      'alert' => [
        'no_services_set'  => 'Il n\'y a toujours pas de services ajoutés. Ajoutez-les à partir d\'ici!',
        'no_vacancies_set' => 'Vous n\'avez pas encore publié votre disponibilité. Faites-le d\'ici!',
      ],
      'panel' => [
        'title_appointments_active'    => 'Rendez-vous Actifs',
        'title_appointments_canceled'  => 'Rendez-vous Annulés',
        'title_appointments_served'    => 'Rendez-vous Accopmlis',
        'title_appointments_today'     => 'Aujourd\'hui',
        'title_appointments_tomorrow'  => 'Demain',
        'title_appointments_total'     => 'Nombre total de rendez-vous',
        'title_contacts_subscribed'    => 'Contacts inscrits',
        'title_contacts_registered'    => 'Contacts Inscris',
        'title_total'                  => 'Total',
      ],
      'title' => 'Dashboard',
    ],
    'edit' => [
      'title' => 'Edition du Profile d\'entreprise',
    ],
    'form' => [
      'category' => [
        'label' => 'Industrie',
      ],
      'description' => [
        'label'       => 'Présentez-vous',
        'placeholder' => 'Décrivez votre entreprise et les services que vous offrez',
      ],
      'name' => [
        'label'       => 'Nom',
        'placeholder' => 'Nom Commercial',
        'validation'  => 'Un nom est requis',
      ],
      'link' => [
        'label'       => 'Lien',
        'placeholder' => 'Le lien de votre page d\'accueil sur timegrid',
        'validation'  => 'Votre lien de page d\'accueil n\'est pas valide',
      ],
      'phone' => [
        'label'       => 'Mobile',
        'placeholder' => 'Votre Numéro de mobile',
      ],
      'postal_address' => [
        'label'       => 'Adresse Postale',
        'placeholder' => 'nom de la rue et numéro, département, ville, pays',
      ],
      'social_facebook' => [
        'label'       => 'Page Facebook',
        'placeholder' => 'https://www.facebook.com/timegrid.io',
      ],
      'timezone' => [
        'label' => 'Timezone',
      ],
      'slug' => [
        'label'       => 'Alias',
        'placeholder' => 'Ce sera votre lien timegrid ',
        'validation'  => 'Un alias est requis',
      ],
    ],
    'index' => [
      'help' => 'D\'içi vous pouvez gérer toutes vos entreprises',
      'msg'  => [
        'no_appointments' => 'Il n\'y a aucun rendez-vous actif jusqu\'à présent',
      ],
      'register_business_help' => 'Si vous êtes un fournisseur de services et que vous souhaitez donner des réservations en ligne, c\'est une excellent opportunité!',
      'title'                  => 'Mes Entreprises',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Entreprise supprimée',
      ],
      'index' => [
        'only_one_found' => 'Vous n\'avez qu\'une seule entreprise enregistrée. Voici votre Tableau de bord.',
      ],
      'preferences' => [
        'success' => 'Préférences mises à jour avec succès!',
      ],
      'register' => 'Génial! Nous allons enregistrer votre entreprise avec :plan plan',
      'store'    => [
        'business_already_exists' => 'Cette Entreprise est déjà enregistrée',
        'success'                 => 'Entreprise enregistrée avec succès',
      ],
      'update' => [
        'success' => 'Données commerciales mises à jour',
      ],
    ],
    'notifications' => [
      'help'  => 'Tout ce qui s\'est passé récemment',
      'title' => 'Notifications',
    ],
    'preferences' => [
      'instructions' => 'Ici, vous pouvez personnaliser les paramètres de votre entreprise selon vos besoins.',
      'title'        => 'Préférences de votre Business',
    ],
    'vacancies' => [
      'btn' => [
        'update' => 'Mise à jour de votre disponibilité',
      ],
    ],
  ],
  'contacts' => [
    'btn' => [
      'confirm_delete' => 'Êtes-vous sûr de supprimer le contact?',
      'delete'         => 'Supprimer',
      'edit'           => 'Modifier',
      'store'          => 'Sauvegarder',
      'update'         => 'Mettre à jour',
    ],
    'create' => [
      'title' => 'Contacts',
    ],
    'form' => [
      'birthdate' => [
        'label' => 'Date de naissance',
      ],
      'description' => [
        'label' => 'Description',
      ],
      'email' => [
        'label' => 'Email',
      ],
      'firstname' => [
        'label'      => 'Nom',
        'validation' => 'Le nom est requis',
      ],
      'gender' => [
        'female' => [
          'label' => 'Femelle',
        ],
        'label' => 'Sexe',
        'male'  => [
          'label' => 'Mâle',
        ],
      ],
      'lastname' => [
        'label'      => 'Nom',
        'validation' => 'Le Nom est requis',
      ],
      'mobile' => [
        'label' => 'Mobile',
      ],
      'nin' => [
        'label' => 'ID',
      ],
      'notes' => [
        'label' => 'Notes',
      ],
      'postal_address' => [
        'label'      => 'Addresse Postale',
        'validation' => 'L\'adresse postale est requise',
      ],
      'prerequisites' => [
        'label' => 'Conditions préalables',
      ],
    ],
    'label' => [
      'birthdate'      => 'Date de naissance',
      'email'          => 'Email',
      'member_since'   => 'Inscrit depuis',
      'mobile'         => 'Mobile',
      'nin'            => 'ID',
      'notes'          => 'Notes',
      'postal_address' => 'Addresse Postale',
    ],
    'list' => [
      'btn' => [
        'filter' => 'Filter',
      ],
      'header' => [
        'email'     => 'Email',
        'firstname' => 'Nom',
        'lastname'  => 'Prénom',
        'mobile'    => 'Mobile',
        'username'  => 'Nom d\'utilisateur',
      ],
      'msg' => [
        'filter_no_results' => 'Aucun résultat',
      ],
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Contact supprimé!',
      ],
      'store' => [
        'success'                          => 'Contact enregistré avec succès!',
        'warning_showing_existing_contact' => 'Conseil: Nous avons trouvé ce contact',
      ],
      'update' => [
        'success' => 'Mis à jour avec succés',
      ],
    ],
    'title' => 'Mes clients',
  ],
  'humanresource' => [
    'btn' => [
      'create' => 'Ajouter',
      'delete' => 'Retirer',
      'store'  => 'Sauvegarder',
      'update' => 'Mettre à Jour',
    ],
    'create' => [
      'title'        => 'Ajouter ses membres à votre équipe',
      'subtitle'     => 'Qui fournira les services',
      'instructions' => 'Ajouter un membre de votre équipe qui fournira les services',
    ],
    'edit' => [
      'title'        => 'Modifier le membre de votre équipe',
      'subtitle'     => 'Info',
      'instructions' => 'Modifier les informations du membre de votre équipe',
    ],
    'index' => [
      'title'        => 'Les Membres de votre équipe',
      'subtitle'     => 'Liste',
      'instructions' => 'Liste des membres de votre équipe',
    ],
    'show' => [
      'title'        => 'Membre de votre équipe',
      'subtitle'     => 'Info',
      'instructions' => 'Membre de votre équipe info',
    ],
    'form' => [
      'calendar_link' => [
        'label' => 'Lien du Calendrier',
      ],
      'capacity' => [
        'label' => 'Capacité',
      ],
      'name' => [
        'label' => 'Nom',
      ],
    ],
  ],
  'humanresources' => [
    'msg' => [
      'destroy' => [
        'success' => 'Membre d\'équipe supprimé',
      ],
      'store' => [
        'success' => 'Membre d\'équipe ajouté',
      ],
      'update' => [
        'success' => 'Membre d\'équipe mis à jour',
      ],
    ],
  ],
  'service' => [
    'btn' => [
      'delete' => 'Supprimer',
      'update' => 'Mettre à jour',
    ],
    'form' => [
      'color' => [
        'label' => 'Couleur',
      ],
      'duration' => [
        'label' => 'Durée en minutes',
      ],
      'name' => [
        'label' => 'Nom du Service',
      ],
      'servicetype' => [
        'label' => 'Type de Service',
      ],
    ],
    'msg' => [
      'store' => [
        'success' => 'Service sauvegardé avec succès!',
      ],
    ],
  ],
  'services' => [
    'btn' => [
      'create' => 'Ajouter un Service',
      'store'  => 'Sauvegarder',
    ],
    'create' => [
      'alert' => [
        'go_to_vacancies' => 'Bien joué! Maintenant, vous pouvez publier votre disponibilité.',
      ],
      'btn' => [
        'go_to_vacancies' => 'Définir et publier ma disponibilité',
      ],
      'instructions' => 'Donnez un nom à votre service avec une description precise pour aider vos clients à se familiariser avec. Ajoutez des instructions à vos clients avant leur arrivée au rendez-vous.',
      'title'        => 'Ajouter un Service',
    ],
    'edit' => [
      'title' => 'Modifier un service',
    ],
    'index' => [
      'instructions' => 'Ajoutez autant de services que vous fournissez pour que vous puissiez configurer votre disponibilité pour chacun d\'entre eux.',
      'title'        => 'Services',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Service supprimé!',
      ],
    ],
  ],
  'vacancies' => [
    'edit' => [
      'instructions' => 'Entrez la capacité de rendez-vous pour chaque service pour chaque jour. C\'est ainsi que vous pouvez gérer les rendez-vous par service et par jour?',
      'title'        => 'Disponibilité',
    ],
    'msg' => [
      'edit' => [
        'no_services' => 'Aucun service enregistré. Veuillez créer les services pour votre entreprise.',
      ],
      'store' => [
        'nothing_changed' => 'Vous devez indiquer votre disponibilité pour au moins une date',
        'success'         => 'La disponibilité a été enregistrée avec succès!',
      ],
    ],
    'table' => [
      'th' => [
        'date' => 'Date',
      ],
    ],
  ],
];
