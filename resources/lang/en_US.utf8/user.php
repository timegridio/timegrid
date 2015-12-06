<?php
/*************************************************************************
 Generated via "php artisan localization:missing" at 2015/12/04 11:29:01
*************************************************************************/

return [
  //==================================== Translations ====================================//
  'appointments' => [
    'alert' => [
      'empty_list'   => 'You have no ongoing reservations by now.',
      'no_vacancies' => 'Sorry, the business cannot take any reservations now.',
    ],
    'btn' => [
      'book'        => 'Book appointment',
      'book_in_biz' => 'Book appointment for :biz',
    ],
    'form' => [
      'btn' => [
        'submit' => 'Confirm',
      ],
      'comments' => [
        'label' => 'Comments',
      ],
      'date' => [
        'label' => 'Date',
      ],
      'duration' => [
        'label' => 'Duration',
      ],
      'msg' => [
        'please_select_a_service' => 'Select a service',
      ],
      'service' => [
        'label' => 'Service',
      ],
      'time' => [
        'label' => 'Hour',
      ],
      'timetable' => [
        'instructions' => 'Select a service to reserve',
        'msg'          => [
          'no_vacancies' => 'There is no availability for this date',
        ],
        'title' => 'Reserve appointment',
      ],
      'business' => [
        'label' => 'Business',
      ],
      'contact_id' => [
        'label' => 'Contact',
      ],
    ],
    'index' => [
      'th' => [
        'business'    => 'Business',
        'calendar'    => 'Date',
        'code'        => 'Code',
        'contact'     => 'Client',
        'duration'    => 'Duration',
        'finish_time' => 'Finishes',
        'remaining'   => 'Within',
        'service'     => 'Service',
        'start_time'  => 'Begins',
        'status'      => 'Status',
      ],
      'title' => 'Appointments',
    ],
  ],
  'booking' => [
    'msg' => [
      'store' => [
        'error'            => 'Sorry, we could not allocate your reservation request.',
        'sorry_duplicated' => 'Sorry, your appointment is duplicated with :code reserved before',
        'success'          => 'Success! Your appointment was registered with code :code',
      ],
      'you_are_not_subscribed_to_business' => 'To be able to do a reservation you must subscribe the business first',
    ],
  ],
  'business' => [
    'btn' => [
      'subscribe' => 'Subscribe',
    ],
    'msg' => [
      'please_select_a_business' => 'Choose a business',
    ],
    'subscriptions_count' => '{0} ¡Be the first to subscribe! |This business has :count subscribed user|This business has :count subscribed users',
  ],
  'businesses' => [
    'index' => [
      'btn' => [
        'create'       => 'Register business',
        'manage'       => 'My businesses',
        'power_create' => 'Register now',
      ],
      'title' => 'Available businesses',
    ],
    'list' => [
      'no_businesses' => 'No businesses available.',
      'alert'         => [
        'not_found' => 'We cant find that business, please choose one from the list',
      ],
    ],
    'subscriptions' => [
      'none_found' => 'No subscriptions available.',
      'title'      => 'Subscriptions',
    ],
    'show' => [
      'btn' => [
        'book'   => 'Reserve appointment',
        'change' => 'Change',
      ],
    ],
  ],
  'contacts' => [
    'btn' => [
      'store'  => 'Save',
      'update' => 'Update',
    ],
    'create' => [
      'help'  => 'Well done! You are about to go. Fill your contact profile for the first time so your reservation is handled accordingly. You will be able to change this info per business if you want to.',
      'title' => 'My profile',
    ],
    'msg' => [
      'store' => [
        'associated_existing_contact' => 'Your profile was attached to an existing one',
        'success'                     => 'Successfully saved',
        'warning'                     => [
          'already_registered'       => 'This profile was already registered',
          'showing_existing_contact' => 'Your profile was attached to an existing one',
        ],
      ],
      'update' => [
        'success' => 'Updated successfully',
      ],
    ],
  ],
  //================================== Obsolete strings ==================================//
];
