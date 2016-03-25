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
        'associated_existing_contact' => 'Se asoció tu perfil a los datos ya registrados',
        'success' => 'Guardado',
        'warning' => 
        array (
          'already_registered' => 'Se asoció tu perfil a los datos ya registrados',
        ),
      ),
      'update' => 
      array (
        'success' => 'Actualizado',
      ),
    ),
    'btn' => 
    array (
      'store' => 'Guardar',
      'update' => 'Editar',
    ),
    'create' => 
    array (
      'help' => '¡Bien hecho! Ya casi estas listo. Llena tu perfil por primera vez para que tu reserva se maneje sin consecuencia. Podrás cambiar esta información por empresa si deseas.',
      'title' => 'Mis datos',
    ),
  ),
  //==================================== Translations ====================================//
  'appointments' => 
  array (
    'alert' => 
    array (
      'empty_list' => 'No tienes reservas en curso ahora.',
      'no_vacancies' => 'Lo sentimos, el prestador no puede tomar reservas al momento.',
      'book_in_biz_on_behalf_of' => 'Reservar cita para :contact en :biz',
    ),
    'btn' => 
    array (
      'book' => 'Reservar Cita',
      'book_in_biz' => 'Reservar cita en :biz',
      'book_in_biz_on_behalf_of' => 'Reservar cita para :contact en :biz',
      'more_dates' => 'Ver más fechas',
    ),
    'form' => 
    array (
      'btn' => 
      array (
        'submit' => 'Confirmar',
      ),
      'comments' => 
      array (
        'label' => '¿ Querés dejarle algún comentario al prestador ?',
      ),
      'date' => 
      array (
        'label' => 'Fecha',
      ),
      'duration' => 
      array (
        'label' => 'Duración',
      ),
      'service' => 
      array (
        'label' => 'Servicio',
      ),
      'time' => 
      array (
        'label' => '¿ Qué horario querés reservar ?',
      ),
      'timetable' => 
      array (
        'instructions' => 'Selecciona un servicio para reservar cita',
        'msg' => 
        array (
          'no_vacancies' => 'No hay disponibilidades para esta fecha',
        ),
        'title' => 'Reserva una cita en :business',
      ),
    ),
    'index' => 
    array (
      'th' => 
      array (
        'business' => 'Prestador',
        'calendar' => 'Fecha',
        'code' => 'Código',
        'contact' => 'Cliente',
        'duration' => 'Duración',
        'finish_time' => 'Finaliza',
        'remaining' => 'Dentro de',
        'service' => 'Servicio',
        'start_time' => 'Comienza',
        'status' => 'Estado',
      ),
      'title' => 'Citas',
    ),
  ),
  'booking' => 
  array (
    'msg' => 
    array (
      'store' => 
      array (
        'error' => 'Lo sentimos, no hay la disponibilidad está agotada para esta reserva.',
        'sorry_duplicated' => 'Lo sentimos, tu cita se duplica con el :code reservado anteriormente',
        'success' => '¡Tomá nota! Reservamos tu cita bajo el código :code',
      ),
      'you_are_not_subscribed_to_business' => 'Para pedir una cita debés suscribirte al prestador antes',
    ),
  ),
  'business' => 
  array (
    'btn' => 
    array (
      'subscribe' => 'Suscribir',
      'subscribe_to' => 'Suscribirme a :business',
    ),
  ),
  'businesses' => 
  array (
    'index' => 
    array (
      'btn' => 
      array (
        'create' => 'Registrar Prestación',
        'manage' => 'Mis Prestaciones',
        'power_create' => 'Registrá tu comercio ahora',
      ),
      'title' => 'Prestadores disponibles',
    ),
    'list' => 
    array (
      'no_businesses' => 'No se econtraron prestadores.',
    ),
    'subscriptions' => 
    array (
      'none_found' => 'No hay suscripciones disponibles.',
      'title' => 'Suscripciones',
    ),
  ),
  'dashboard' => 
  array (
    'card' => 
    array (
      'agenda' => 
      array (
        'button' => 'Ver Agenda',
        'description' => 'Revisa tu cita actual en agenda.|[2, Inf] Revisa tus citas actuales en agenda.',
        'title' => 'Tu Cita|[2, Inf] Tus Citas',
      ),
      'directory' => 
      array (
        'button' => 'Ver Directorio',
        'description' => 'Conoce los comercions en los que puedes reservar servicios.',
        'title' => 'Directorio',
      ),
      'subscriptions' => 
      array (
        'button' => 'Mis Suscripciones',
        'description' => 'Revisa los comercios a los que ya estás suscripto.',
        'title' => 'Suscripciones',
      ),
    ),
  ),
);