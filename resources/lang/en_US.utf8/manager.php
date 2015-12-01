<?php
/*************************************************************************
 Generated via "php artisan localization:missing" at 2015/11/30 17:35:29
*************************************************************************/

return [
  //============================== New strings to translate ==============================//
  'businesses' =>
  [
    'preferences' =>
    [
      'instructions' => 'Here you can customize the business settings to your needs.',
      'title' => 'Business preferences',
    ],
    'btn' =>
    [
      'deactivate' => 'Deactivate this business',
      'store' => 'Register',
      'update' => 'Update',
      'return' => 'Back',
    ],
    'contacts' =>
    [
      'btn' =>
      [
        'create' => 'Add a contact',
        'import' => 'Import contacts',
      ],
    ],
    'create' =>
    [
      'title' => 'Register a business',
    ],
    'dashboard' =>
    [
      'alert' =>
      [
        'no_services_set' => 'There are still no services added. Add them from here!',
        'no_vacancies_set' => 'You haven\'t yet published your availability. Do it from here!',
      ],
      'panel' =>
      [
        'title_appointments_active' => 'Active',
        'title_appointments_annulated' => 'Annulated',
        'title_appointments_served' => 'Served',
        'title_appointments_today' => 'Today',
        'title_appointments_tomorrow' => 'Tomorrow',
        'title_appointments_total' => 'Total',
        'title_contacts_active' => 'Subscribed',
        'title_contacts_registered' => 'Registered',
        'title_contacts_total' => 'Total',
      ],
      'meta' =>
      [
        'title_owner' => 'Owner',
        'title_registered_since' => 'Registered since',
      ],
    ],
    'edit' =>
    [
      'title' => 'Business profile edit',
    ],
    'form' =>
    [
      'category' =>
      [
        'label' => 'Industry',
      ],
      'description' =>
      [
        'label' => 'Describe yourself',
        'placeholder' => 'Describe your business and the services you provide',
      ],
      'name' =>
      [
        'label' => 'Name',
        'placeholder' => 'Commercial name',
        'validation' => 'A name is required',
      ],
      'phone' =>
      [
        'label' => 'Mobile',
        'placeholder' => 'your mobile number',
        'hint' => 'no spaces or dashes',
      ],
      'postal_address' =>
      [
        'label' => 'Postal Address',
        'placeholder' => 'street name and number, area, city, country',
      ],
      'slug' =>
      [
        'label' => 'Alias',
        'placeholder' => 'this will be your timegrid URL',
        'validation' => 'An alias is required',
      ],
      'social_facebook' =>
      [
        'label' => 'Facebook URL',
        'placeholder' => 'https://www.facebook.com/timegrid.io',
      ],
      'timezone' =>
      [
        'label' => 'TimeZone',
      ],
    ],
    'index' =>
    [
      'help' => 'From here you can manage all your businesses',
      'register_business_help' => 'If you are a service provider and you wish to give online reservations, this is '.
                                  'your chance!',
      'title' => 'My businesses',
      'btn' =>
      [
        'manage' => 'Manage businesses',
        'register' => 'Register a business',
      ],
    ],
    'msg' =>
    [
      'create' =>
      [
        'success' => 'Well done! You chose :plan',
      ],
      'destroy' =>
      [
        'success' => 'Business removed',
      ],
      'index' =>
      [
        'only_one_found' => 'You only have one business registered. Here your dashboard.',
      ],
      'preferences' =>
      [
        'success' => 'Successfully updated preferences!',
      ],
      'store' =>
      [
        'business_already_exists' => 'The business is already registered',
        'restored_trashed' => 'Business restored',
        'success' => 'Business successfully registered',
      ],
      'update' =>
      [
        'success' => 'Updated business data',
      ],
    ],
    'vacancies' =>
    [
      'btn' =>
      [
        'update' => 'Update availability',
      ],
    ],
    'show' =>
    [
      'title' => 'Business',
    ],
  ],
  'services' =>
  [
    'create' =>
    [
      'instructions' => 'Give a name to your service, a wide description to help your customers be familiar with it.'.
                        'Add any instructions for your customers before they get to the appointment.',
      'alert' =>
      [
        'go_to_vacancies' => 'Well done! Now you can publish your availability.',
      ],
      'btn' =>
      [
        'go_to_vacancies' => 'Set and publish my availability',
      ],
      'title' => 'Add a service',
    ],
    'index' =>
    [
      'instructions' => 'Add as many services as you provide to configure availability for each of them.',
      'title' => 'Services',
      'th' =>
      [
        'duration' => 'Duration',
        'name' => 'Name',
        'slug' => 'Alias',
      ],
    ],
    'btn' =>
    [
      'create' => 'Add a service',
      'store' => 'Save',
    ],
    'msg' =>
    [
      'destroy' =>
      [
        'success' => 'Service deleted!',
      ],
    ],
  ],
  'vacancies' =>
  [
    'edit' =>
    [
      'instructions' => 'Enter the appointments capacity for each service on each day day. This is, how may '.
                        'appointments can you handle per service per day?',
      'title' => 'Availability',
    ],
    'msg' =>
    [
      'edit' =>
      [
        'no_services' => 'No services registered. Please register services for your business.',
      ],
      'store' =>
      [
        'nothing_changed' => 'You must indicate your availability at least for one date',
        'success' => 'Availability registered successfully!',
      ],
    ],
    'table' =>
    [
      'th' =>
      [
        'date' => 'Date',
      ],
    ],
  ],
  //==================================== Translations ====================================//
  'business' =>
  [
    'alert' =>
    [
      'deactivate_confirm' => 'Advice! Deactivating the business is IRREVERSIBLE. Are you sure?',
    ],
    'btn' =>
    [
      'tooltip' =>
      [
        'agenda' => 'Reservations schedule',
        'contacts' => 'Contact list',
        'edit' => 'Edit business profile',
        'preferences' => 'Change preferences',
        'services' => 'Manage services',
        'vacancies' => 'Publish availability',
      ],
    ],
    'hint' =>
    [
      'out_of_vacancies' => 'Publish your availability<br><br>For clients to begin taking reservations you need to '.
                            'publish your availability.',
      'set_services' => 'Add the services you provide',
    ],
    'service' =>
    [
      'msg' =>
      [
        'update' =>
        [
          'success' => 'Service updated!',
        ],
      ],
    ],
    'form' =>
    [
      'strategy' =>
      [
        'dateslot' => 'By date',
        'timeslot' => 'By date and time',
      ],
    ],
  ],
  'contacts' =>
  [
    'btn' =>
    [
      'confirm_delete' => 'Sure to delete contact?',
      'delete' => 'Delete',
      'edit' => 'Edit',
      'import' => 'Import contacts',
      'store' => 'Save',
      'update' => 'Update',
    ],
    'create' =>
    [
      'title' => 'Contacts',
    ],
    'form' =>
    [
      'birthdate' =>
      [
        'label' => 'Birthdate',
        'placeholder' => 'birthdate',
      ],
      'data' =>
      [
        'label' => 'CSV data',
      ],
      'description' =>
      [
        'label' => 'Description',
      ],
      'email' =>
      [
        'label' => 'Email',
        'placeholder' => 'email@example.com',
      ],
      'firstname' =>
      [
        'label' => 'Name',
        'validation' => 'Name is required',
        'placeholder' => 'first name',
      ],
      'gender' =>
      [
        'female' =>
        [
          'label' => 'Female',
        ],
        'male' =>
        [
          'label' => 'Male',
        ],
        'label' => 'Gender',
      ],
      'lastname' =>
      [
        'label' => 'Last name',
        'validation' => 'Last name is required',
        'placeholder' => 'last name',
      ],
      'mobile' =>
      [
        'label' => 'Mobile',
        'placeholder' => 'complete mobile number',
      ],
      'nin' =>
      [
        'label' => 'ID',
        'placeholder' => 'national identification number',
      ],
      'notes' =>
      [
        'label' => 'Notes',
        'placeholder' => 'notes',
      ],
      'prerequisites' =>
      [
        'label' => 'Prerequisites',
      ],
    ],
    'import' =>
    [
      'title' => 'Import contacts',
    ],
    'label' =>
    [
      'birthdate' => 'Birthdate',
      'email' => 'Email',
      'member_since' => 'Subscribed since',
      'mobile' => 'Mobile',
      'nin' => 'ID',
      'notes' => 'Notes',
      'gender' => 'Gender',
      'next_appointment' => 'Next Appointment',
      'username' => 'Username',
    ],
    'list' =>
    [
      'btn' =>
      [
        'filter' => 'Filter',
      ],
      'header' =>
      [
        'email' => 'Email',
        'firstname' => 'Name',
        'lastname' => 'Lastname',
        'mobile' => 'Mobile',
        'quality' => 'Score',
        'username' => 'Username',
        'gender' => 'Gender',
      ],
      'msg' =>
      [
        'filter_no_results' => 'Nothing here',
      ],
    ],
    'msg' =>
    [
      'destroy' =>
      [
        'success' => 'Contact deleted!',
      ],
      'import' =>
      [
        'success' => ':count imported contacts',
      ],
      'store' =>
      [
        'success' => 'Contact registered successfully!',
        'warning_showing_existing_contact' => 'Advice: We found this existing contact',
      ],
      'update' =>
      [
        'success' => 'Updated successfully',
      ],
    ],
    'title' => 'My customers',
  ],
  'service' =>
  [
    'btn' =>
    [
      'delete' => 'Delete',
      'update' => 'Update',
    ],
    'form' =>
    [
      'name' =>
      [
        'label' => 'Service name',
      ],
    ],
    'msg' =>
    [
      'store' =>
      [
        'success' => 'Service stored successfully!',
      ],
    ],
  ],
];
