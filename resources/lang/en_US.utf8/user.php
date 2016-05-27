<?php
/*************************************************************************
 Generated via "php artisan localization:missing" at 2016/01/27 01:07:13 
*************************************************************************/

return array (
  //============================== New strings to translate ==============================//
  // Defined in file /home/alariva/timegrid.io/app/app/Http/Controllers/User/ContactController.php
  'contacts' => 
  array (
    'msg' => 
    array (
      'destroy' => 
      array (
        'success' => 'TODO: success',
      ),
      'store' => 
      array (
        'associated_existing_contact' => 'Your profile was attached to an existing one',
        'success' => 'Successfully saved',
        'warning' => 
        array (
          'already_registered' => 'This profile was already registered',
        ),
      ),
      'update' => 
      array (
        'success' => 'Updated successfully',
      ),
    ),
    'btn' => 
    array (
      'store' => 'Save',
      'update' => 'Update',
    ),
    'create' => 
    array (
      'help' => 'Well done! You are about to go. Fill your contact profile for the first time so your reservation is handled accordingly. You will be able to change this info per business if you want to.',
      'title' => 'My profile',
    ),
  ),
  //==================================== Translations ====================================//
  'appointments' => 
  array (
    'alert' => 
    array (
      'empty_list' => 'You have no ongoing reservations.',
      'no_vacancies' => 'Sorry, the business cannot take any reservations now.',
      'book_in_biz_on_behalf_of' => 'Book appointment for :contact at :biz',
    ),
    'btn' => 
    array (
      'confirm_booking' => 'Confirm appointment reservation',
      'book' => 'Book appointment',
      'book_in_biz' => 'Book appointment for :biz',
      'book_in_biz_on_behalf_of' => 'Book appointment for :contact at :biz',
      'more_dates' => 'Check more dates',
      'calendar' => 'View Calendar',
    ),
    'form' => 
    array (
      'btn' => 
      array (
        'submit' => 'Confirm',
      ),
      'comments' => 
      array (
        'label' => 'Would you like to leave any comments for the provider?',
      ),
      'date' => 
      array (
        'label' => 'Date',
      ),
      'duration' => 
      array (
        'label' => 'Duration',
      ),
      'service' => 
      array (
        'label' => 'Service',
      ),
      'time' => 
      array (
        'label' => 'At what time would you like to boot?',
      ),
      'timetable' => 
      array (
        'instructions' => 'Select a service to reserve',
        'msg' => 
        array (
          'no_vacancies' => 'There is no availability for this date',
        ),
        'title' => 'Reserve appointment at :business',
      ),
    ),
    'index' => 
    array (
      'th' => 
      array (
        'business' => 'Business',
        'calendar' => 'Date',
        'code' => 'Code',
        'contact' => 'Client',
        'duration' => 'Duration',
        'finish_time' => 'Finishes',
        'remaining' => 'Within',
        'service' => 'Service',
        'start_time' => 'Begins',
        'status' => 'Status',
      ),
      'title' => 'Appointments',
    ),
  ),
  'booking' => 
  array (
    'msg' => 
    array (
      'store' => 
      array (
        'error' => 'Sorry, there is no longer availability for the attempted reservation.',
        'sorry_duplicated' => 'Sorry, your appointment is duplicated with :code reserved before',
        'success' => 'Success! Your appointment was registered with code :code',
      ),
      'you_are_not_subscribed_to_business' => 'To be able to do a reservation you must subscribe the business first',
    ),
  ),
  'business' => 
  array (
    'btn' => 
    array (
      'subscribe' => 'Subscribe',
      'subscribe_to' => 'Subscribe to :business',
    ),
  ),
  'businesses' => 
  array (
    'index' => 
    array (
      'btn' => 
      array (
        'create' => 'Register business',
        'manage' => 'My businesses',
        'power_create' => 'Register now',
      ),
      'title' => 'Available businesses',
    ),
    'list' => 
    array (
      'no_businesses' => 'No businesses available.',
    ),
    'subscriptions' => 
    array (
      'none_found' => 'No subscriptions available.',
      'title' => 'Subscriptions',
    ),
  ),
  'dashboard' => 
  array (
    'card' => 
    array (
      'agenda' => 
      array (
        'button' => 'See Agenda',
        'description' => 'Check out your current reservation.|[2,Inf] Check out your current reservations.',
        'title' => 'One appointment|[2,Inf] Your appointments',
      ),
      'directory' => 
      array (
        'button' => 'Browse Directory',
        'description' => 'Browse the directory and book your service.',
        'title' => 'Directory',
      ),
      'subscriptions' => 
      array (
        'button' => 'See Subscriptions',
        'description' => 'Manage your subscriptions to businesses.',
        'title' => 'Subscriptions',
      ),
    ),
  ),
);