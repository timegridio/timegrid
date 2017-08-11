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
      'help'   => 'Publier l\'adresse postale complète',
      'label'  => 'Publier Adresse Postale',
    ],
    'start_at' => [
      'format' => 'hh:mm:ss',
      'help'   => 'L\'heure d\'ouverture de votre entreprise pour la réception des rendez-vous',
      'label'  => 'Horaire d\'ouverture',
    ],
    'cancellation_policy_advice' => [
      'format' => 'Exemple: Vous pouvez annuler ce rendez-vous sans frais jusqu\'à %s',
      'help'   => 'Rédiger un conseil que vos clients verront au sujet de votre politique d\'annulation de rendez-vous',
      'label'  => 'Conseil sur la politique d\'annulation',
    ],
    'appointment_flexible_arrival' => [
      'format' => 'Oui/Non',
      'help'   => 'Laissez les clients arriver en tout temps pendant le service',
      'label'  => 'Rendez-vous flexibles par ordre d\'arrivée',
    ],
    'finish_at' => [
      'format' => 'hh:mm:ss',
      'help'   => 'L\'heure de fermeture de votre entreprise pour la réception des rendez-vous',
      'label'  => 'Horaire de Fermeture',
    ],
    'service_default_duration' => [
      'format' => 'exemple: 30',
      'help'   => 'La durée par défaut de tout service que vous offrez',
      'label'  => 'Durée de service par défaut (minutes)',
    ],
    'vacancy_edit_advanced_mode' => [
      'format' => 'Oui/Non',
      'help'   => 'Utilisez le mode avancé pour publier des postes vacants',
      'label'  => 'Utilisez le mode avancé pour publier des postes vacants',
    ],
    'time_format' => [
      'format' => 'H:i a',
      'help'   => 'Format de l\'heure pour afficher l\'heure',
      'label'  => 'Format de l\'heure',
    ],
    'date_format' => [
      'format' => 'Y-m-d',
      'help'   => 'Format des dates pour afficher les dates',
      'label'  => 'Format des Dates',
    ],
    'timeslot_step' => [
      'format' => 'Nombre',
      'help'   => 'Nombre de minutes pour accépter la disponibilité de la réservation',
      'label'  => 'Horraire',
    ],
    'availability_future_days' => [
      'format' => 'Nombre',
      'help'   => 'Nombre de jours à afficher pour la disponibilité de la réservation',
      'label'  => 'Disponibilité des jours prochains',
    ],
    'report_daily_schedule' => [
      'format' => 'Oui/Non',
      'help'   => 'Je souhaite recevoir un courriel quotidien avec les rendez-vous actifs',
      'label'  => 'Activer les Notifications Quotidiennes',
    ],
    'vacancy_autopublish' => [
      'format' => 'Oui/Non',
      'help'   => 'Autoriser timegrid a publier ma disponibilté (chaque Dimanche)',
      'label'  => 'Activer la publication automatique de Disponibilité',
    ],
    'allow_guest_registration' => [
      'format' => 'Oui/Non',
      'help'   => 'Autoriser les utilisateurs invités a s\'inscrire sur votre carnet d\'adresses lors de la réservation d\'un rendez-vous',
      'label'  => 'Autoriser les invités a réserver des rendez-vous',
    ],
    'disable_outbound_mailing' => [
      'format' => 'Oui/Non',
      'help'   => 'Empêcher l\'envoi d\'emails',
      'label'  => 'Désactiver l\'envoi d\'emails sortant',
    ],
  ],
  'controls' => [
    'select' => [
      'no'  => 'Non',
      'yes' => 'Oui',
    ],
  ],
];
