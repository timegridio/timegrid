<?php
/*************************************************************************
 Generated via "php artisan localization:missing" at 2015/12/16 18:22:37 
*************************************************************************/

return  [
  //============================== New strings to translate ==============================//
  // Defined in file /home/alariva/timegrid.io/app/resources/views/manager/businesses/services/_form.blade.php
  'service' => [
    'form' => [
      'duration' => [
        'label' => 'Duration in minutes',
      ],
      'name' => [
        'label' => 'Service name',
      ],
    ],
    'btn' => [
      'delete' => 'Delete',
      'update' => 'Update',
    ],
    'msg' => [
      'store' => [
        'success' => 'Service stored successfully!',
      ],
    ],
  ],
  //==================================== Translations ====================================//
  'business' => [
    'btn' => [
      'tooltip' => [
        'agenda'      => 'Reservations schedule',
        'contacts'    => 'Contact list',
        'edit'        => 'Edit business profile',
        'preferences' => 'Change preferences',
        'services'    => 'Manage services',
        'vacancies'   => 'Publish availability',
      ],
    ],
    'hint' => [
      'out_of_vacancies' => 'Publish your availability<br><br>For clients to begin taking reservations you need to publish your availability.',
      'set_services'     => 'Add the services you provide',
    ],
    'service' => [
      'msg' => [
        'update' => [
          'success' => 'Service updated!',
        ],
      ],
    ],
  ],
  'businesses' => [
    'btn' => [
      'store'  => 'Register',
      'update' => 'Update',
    ],
    'contacts' => [
      'btn' => [
        'create' => 'Add a contact',
        'import' => 'Import contacts',
      ],
    ],
    'create' => [
      'title' => 'Register a business',
    ],
    'dashboard' => [
      'alert' => [
        'no_services_set'  => 'There are still no services added. Add them from here!',
        'no_vacancies_set' => 'You haven\'t yet published your availability. Do it from here!',
      ],
      'panel' => [
        'title_appointments_active'    => 'Appointments Active',
        'title_appointments_annulated' => 'Appointments Annulated',
        'title_appointments_served'    => 'Appointments Served',
        'title_appointments_today'     => 'Today',
        'title_appointments_tomorrow'  => 'Tomorrow',
        'title_appointments_total'     => 'Total Appointments',
        'title_total'                  => 'Total',
        'title_contacts_active'        => 'Contacts Subscribed',
        'title_contacts_registered'    => 'Contacts Registered',
      ],
    ],
    'edit' => [
      'title' => 'Business profile edit',
    ],
    'form' => [
      'category' => [
        'label' => 'Industry',
      ],
      'description' => [
        'label'       => 'Describe yourself',
        'placeholder' => 'Describe your business and the services you provide',
      ],
      'name' => [
        'label'       => 'Name',
        'placeholder' => 'Commercial name',
        'validation'  => 'A name is required',
      ],
      'phone' => [
        'label'       => 'Mobile',
        'placeholder' => 'your mobile number',
      ],
      'postal_address' => [
        'label'       => 'Postal Address',
        'placeholder' => 'street name and number, area, city, country',
      ],
      'slug' => [
        'label'       => 'Alias',
        'placeholder' => 'this will be your timegrid URL',
        'validation'  => 'An alias is required',
      ],
      'social_facebook' => [
        'label'       => 'Your Facebook Page URL',
        'placeholder' => 'https://www.facebook.com/timegrid.io',
      ],
      'timezone' => [
        'label' => 'TimeZone',
      ],
    ],
    'index' => [
      'help' => 'From here you can manage all your businesses',
      'msg'  => [
        'no_appointments' => 'There are no active appointments right now',
      ],
      'register_business_help' => 'If you are a service provider and you wish to give online reservations, this is your chance!',
      'title'                  => 'My businesses',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Business removed',
      ],
      'index' => [
        'only_one_found' => 'You only have one business registered. Here your dashboard.',
      ],
      'preferences' => [
        'success' => 'Successfully updated preferences!',
      ],
      'register' => 'Great! We are going to register your business with :plan plan',
      'store'    => [
        'business_already_exists' => 'The business is already registered',
        'success'                 => 'Business successfully registered',
      ],
      'update' => [
        'success' => 'Updated business data',
      ],
    ],
    'preferences' => [
      'instructions' => 'Here you can customize the business settings to your needs.',
      'title'        => 'Business preferences',
    ],
    'vacancies' => [
      'btn' => [
        'update' => 'Update availability',
      ],
    ],
  ],
  'contacts' => [
    'btn' => [
      'confirm_delete' => 'Sure to delete contact?',
      'delete'         => 'Delete',
      'edit'           => 'Edit',
      'import'         => 'Import contacts',
      'store'          => 'Save',
      'update'         => 'Update',
    ],
    'create' => [
      'title' => 'Contacts',
    ],
    'form' => [
      'birthdate' => [
        'label' => 'Birthdate',
      ],
      'data' => [
        'label' => 'CSV data',
      ],
      'description' => [
        'label' => 'Description',
      ],
      'email' => [
        'label' => 'Email',
      ],
      'firstname' => [
        'label'      => 'Name',
        'validation' => 'Name is required',
      ],
      'gender' => [
        'female' => [
          'label' => 'Female',
        ],
        'male' => [
          'label' => 'Male',
        ],
      ],
      'lastname' => [
        'label'      => 'Last name',
        'validation' => 'Last name is required',
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
      'prerequisites' => [
        'label' => 'Prerequisites',
      ],
    ],
    'import' => [
      'title' => 'Import contacts',
    ],
    'label' => [
      'birthdate'    => 'Birthdate',
      'email'        => 'Email',
      'member_since' => 'Subscribed since',
      'mobile'       => 'Mobile',
      'nin'          => 'ID',
      'notes'        => 'Notes',
    ],
    'list' => [
      'btn' => [
        'filter' => 'Filter',
      ],
      'header' => [
        'email'     => 'Email',
        'firstname' => 'Name',
        'lastname'  => 'Lastname',
        'mobile'    => 'Mobile',
        'quality'   => 'Score',
        'username'  => 'Username',
      ],
      'msg' => [
        'filter_no_results' => 'Nothing here',
      ],
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Contact deleted!',
      ],
      'import' => [
        'success' => ':count imported contacts',
      ],
      'store' => [
        'success'                          => 'Contact registered successfully!',
        'warning_showing_existing_contact' => 'Advice: We found this existing contact',
      ],
      'update' => [
        'success' => 'Updated successfully',
      ],
    ],
    'title' => 'My customers',
  ],
  'services' => [
    'btn' => [
      'create' => 'Add a service',
      'store'  => 'Save',
    ],
    'create' => [
      'alert' => [
        'go_to_vacancies' => 'Well done! Now you can publish your availability.',
      ],
      'btn' => [
        'go_to_vacancies' => 'Set and publish my availability',
      ],
      'instructions' => 'Give a name to your service, a wide description to help your customers be familiar with it.Add any instructions for your customers before they get to the appointment.',
      'title'        => 'Add a service',
    ],
    'index' => [
      'instructions' => 'Add as many services as you provide to configure availability for each of them.',
      'title'        => 'Services',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Service deleted!',
      ],
    ],
  ],
  'vacancies' => [
    'edit' => [
      'instructions' => 'Enter the appointments capacity for each service on each day day. This is, how may appointments can you handle per service per day?',
      'title'        => 'Availability',
    ],
    'msg' => [
      'edit' => [
        'no_services' => 'No services registered. Please register services for your business.',
      ],
      'store' => [
        'nothing_changed' => 'You must indicate your availability at least for one date',
        'success'         => 'Availability registered successfully!',
      ],
    ],
    'table' => [
      'th' => [
        'date' => 'Date',
      ],
    ],
  ],
  //================================== Obsolete strings ==================================//
];
