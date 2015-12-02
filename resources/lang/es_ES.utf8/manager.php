<?php
/*************************************************************************
 Generated via "php artisan localization:missing" at 2015/12/02 23:47:14 
*************************************************************************/

return array (
  //============================== New strings to translate ==============================//
  'businesses' => 
  array (
    'form' => 
    array (
      'social_facebook' => 
      array (
        'label' => 'URL Página de Facebook',
        'placeholder' => 'https://facebook.com/tu-pagina-de-facebook',
      ),
      'category' => 
      array (
        'label' => 'Rubro Comercial',
      ),
      'description' => 
      array (
        'label' => 'Descripción',
        'placeholder' => 'Describe al prestador',
      ),
      'name' => 
      array (
        'label' => 'Nombre',
        'placeholder' => 'Nombre completo del prestador',
        'validation' => 'Se requiere nombre',
      ),
      'phone' => 
      array (
        'label' => 'Móvil',
        'placeholder' => 'tu móvil de contacto',
        'hint' => 'sin espacios ni guiones',
      ),
      'postal_address' => 
      array (
        'label' => 'Dirección Postal',
        'placeholder' => 'altura calle, barrio, ciudad, país',
      ),
      'slug' => 
      array (
        'label' => 'Alias',
        'placeholder' => 'así será el link en la web',
        'validation' => 'Se requiere un alias',
      ),
      'timezone' => 
      array (
        'label' => 'Zona Horaria',
      ),
    ),
    'msg' => 
    array (
      'index' => 
      array (
        'only_one_found' => 'Sólo tienes este negocio registrado.',
      ),
      'create' => 
      array (
        'success' => '¡Olé! Vamos a registrarte con el plan :plan',
      ),
      'destroy' => 
      array (
        'success' => 'Prestador removido',
      ),
      'preferences' => 
      array (
        'success' => 'Actualizaste las preferencias Ok',
      ),
      'store' => 
      array (
        'business_already_exists' => 'El prestador ya está registrado',
        'restored_trashed' => 'Prestador restaurado',
        'success' => 'Prestador registrado',
      ),
      'update' => 
      array (
        'success' => 'Datos del prestador actualizados',
      ),
    ),
    'preferences' => 
    array (
      'instructions' => 'Aquí puedes configurar las preferencias a las necesidades de tu negocio',
      'title' => 'Preferencias del prestador',
    ),
    'btn' => 
    array (
      'deactivate' => 'Desactivar este prestador',
      'store' => 'Registrar',
      'update' => 'Actualizar',
      'return' => 'Volver',
    ),
    'contacts' => 
    array (
      'btn' => 
      array (
        'create' => 'Agregar un contacto',
        'import' => 'Importar contactos',
      ),
    ),
    'create' => 
    array (
      'title' => 'Registrar un prestador',
    ),
    'dashboard' => 
    array (
      'alert' => 
      array (
        'no_services_set' => 'Aún no tienes servicios cargados! Hazlo aquí!',
        'no_vacancies_set' => 'Aún no tienes publicada tu disponibilidad! Hazlo aquí!',
      ),
      'panel' => 
      array (
        'title_appointments_active' => 'Activos',
        'title_appointments_annulated' => 'Anulados',
        'title_appointments_served' => 'Atendidos',
        'title_appointments_today' => 'Hoy',
        'title_appointments_tomorrow' => 'Mañana',
        'title_appointments_total' => 'Total',
        'title_contacts_active' => 'Suscriptos',
        'title_contacts_registered' => 'Registrados',
        'title_contacts_total' => 'Totales',
      ),
      'meta' => 
      array (
        'title_owner' => 'Propietario',
        'title_registered_since' => 'Registrado desde',
      ),
    ),
    'edit' => 
    array (
      'title' => 'Edición de datos del prestador',
    ),
    'index' => 
    array (
      'help' => 'Desde aquí puedes administrar todos los prestadores',
      'register_business_help' => 'Si eres prestador y quieres dar turnos online, es tu oportunidad!',
      'title' => 'Mis Prestadores',
      'btn' => 
      array (
        'manage' => 'Administrar prestadores',
        'register' => 'Registrar un prestador',
      ),
    ),
    'vacancies' => 
    array (
      'btn' => 
      array (
        'update' => 'Actualizar Disponibilidad',
      ),
    ),
    'show' => 
    array (
      'title' => 'Prestador',
    ),
  ),
  'services' => 
  array (
    'create' => 
    array (
      'instructions' => 'Aquí puedes dar de alta los servicios que prestas. Cada uno podrá ser reservado para una '.
                        'y por la cantidad de citas que admitas',
      'alert' => 
      array (
        'go_to_vacancies' => '¡Muy bien! Ya podés indicar tu disponibilidad y hacerla visible a tus clientes',
      ),
      'btn' => 
      array (
        'go_to_vacancies' => 'Publicar disponibilidad',
      ),
      'title' => 'Agregar un servicio',
    ),
    'index' => 
    array (
      'instructions' => 'Estos son tus servicios',
      'title' => 'Servicios',
      'th' => 
      array (
        'duration' => 'Duración',
        'name' => 'Nombre',
        'slug' => 'Alias',
      ),
    ),
    'btn' => 
    array (
      'create' => 'Agregar un servicio',
      'store' => 'Guardar',
    ),
    'msg' => 
    array (
      'destroy' => 
      array (
        'success' => '¡Servicio eliminado!',
      ),
    ),
  ),
  'vacancies' => 
  array (
    'edit' => 
    array (
      'instructions' => 'Aquí puedes editar y publicar tu disponibilidad para cada servicio por cada fecha.',
      'title' => 'Disponibilidades',
    ),
    'msg' => 
    array (
      'edit' => 
      array (
        'no_services' => 'No hay servicios registrados. Favor de registrar servicios para tu negocio.',
      ),
      'store' => 
      array (
        'nothing_changed' => 'Debés completar tu disponibilidad para alguna fecha',
        'success' => 'Disponibilidades registradas!',
      ),
    ),
    'table' => 
    array (
      'th' => 
      array (
        'date' => 'Fecha',
      ),
    ),
  ),
  //==================================== Translations ====================================//
  'business' => 
  array (
    'alert' => 
    array (
      'deactivate_confirm' => '¡Atención! Desactivar el prestador es una operación IRREVERSIBLE. ¿Seguro desactivar?',
    ),
    'btn' => 
    array (
      'tooltip' => 
      array (
        'agenda' => 'Agenda de Turnos',
        'contacts' => 'Lista de Contactos',
        'edit' => 'Editar datos del Prestador',
        'preferences' => 'Cambiar Preferencias',
        'services' => 'Gestionar Servicios',
        'vacancies' => 'Publicar Disponibilidad',
      ),
    ),
    'hint' => 
    array (
      'out_of_vacancies' => 'Publicá tu disponibilidad<br><br>Para que puedan empezar a pedirte turnos es necesario que indiques tu disponibilidad',
      'set_services' => 'Agregá los servicios que brindás',
    ),
    'service' => 
    array (
      'msg' => 
      array (
        'update' => 
        array (
          'success' => 'Servicio Actualizado!',
        ),
      ),
    ),
    'form' => 
    array (
      'strategy' => 
      array (
        'dateslot' => 'Por fecha',
        'timeslot' => 'Por fecha y horario',
      ),
    ),
  ),
  'contacts' => 
  array (
    'btn' => 
    array (
      'confirm_delete' => '¿Seguro querés eliminar el contacto?',
      'delete' => 'Eliminar',
      'edit' => 'Editar',
      'import' => 'Importar Contactos',
      'store' => 'Guardar',
      'update' => 'Actualizar',
    ),
    'create' => 
    array (
      'title' => 'Contactos',
    ),
    'form' => 
    array (
      'birthdate' => 
      array (
        'label' => 'Nacimiento',
        'placeholder' => 'fecha de nacimiento',
      ),
      'data' => 
      array (
        'label' => 'datos en formato CSV',
      ),
      'description' => 
      array (
        'label' => 'Descripción',
      ),
      'email' => 
      array (
        'label' => 'Email',
        'placeholder' => 'email@ejemplo.com',
      ),
      'firstname' => 
      array (
        'label' => 'Nombre',
        'validation' => 'Se requiere su primer nombre',
        'placeholder' => 'primer nombre',
      ),
      'gender' => 
      array (
        'female' => 
        array (
          'label' => 'Femenino',
        ),
        'male' => 
        array (
          'label' => 'Masculino',
        ),
        'label' => 'Sexo',
      ),
      'lastname' => 
      array (
        'label' => 'Apellido',
        'validation' => 'Se requiere su apellido',
        'placeholder' => 'apellido',
      ),
      'mobile' => 
      array (
        'label' => 'Móvil',
        'placeholder' => 'número de móvil completo',
      ),
      'nin' => 
      array (
        'label' => 'DNI',
        'placeholder' => 'número de identificación nacional',
      ),
      'notes' => 
      array (
        'label' => 'Notas',
        'placeholder' => 'notas',
      ),
      'prerequisites' => 
      array (
        'label' => 'Prerequisitos',
      ),
    ),
    'import' => 
    array (
      'title' => 'Importar contactos',
    ),
    'label' => 
    array (
      'birthdate' => 'Nacimiento',
      'email' => 'Email',
      'member_since' => 'Suscripto desde',
      'mobile' => 'Móvil',
      'nin' => 'DNI',
      'notes' => 'Notas',
      'gender' => 'Sexo',
      'next_appointment' => 'Próximo Turno',
      'username' => 'Usuario',
    ),
    'list' => 
    array (
      'btn' => 
      array (
        'filter' => 'Filtro',
      ),
      'header' => 
      array (
        'email' => 'Email',
        'firstname' => 'Nombre',
        'lastname' => 'Apellidos',
        'mobile' => 'Móvil',
        'quality' => 'Puntaje',
        'username' => 'Usuario',
        'gender' => 'Sexo',
      ),
      'msg' => 
      array (
        'filter_no_results' => 'Nada por aquí',
      ),
    ),
    'msg' => 
    array (
      'destroy' => 
      array (
        'success' => '¡Contacto eliminado!',
      ),
      'import' => 
      array (
        'success' => ':count Contactos importados',
      ),
      'store' => 
      array (
        'success' => '¡Contacto registrado Ok!',
        'warning_showing_existing_contact' => 'Encontramos el contacto ya registrado',
      ),
      'update' => 
      array (
        'success' => 'Actualizado Ok',
      ),
    ),
    'title' => 'Mis Clientes',
  ),
  'service' => 
  array (
    'btn' => 
    array (
      'delete' => 'Eliminar',
      'update' => 'Actualizar',
    ),
    'form' => 
    array (
      'name' => 
      array (
        'label' => 'Nombre del servicio',
      ),
    ),
    'msg' => 
    array (
      'store' => 
      array (
        'success' => '¡Servicio Guardado!',
      ),
    ),
  ),
  //================================== Obsolete strings ==================================//
);