<?php
/*************************************************************************
 Generated via "php artisan localization:missing" at 2015/12/04 11:29:01
*************************************************************************/

return [
  //============================== New strings to translate ==============================//
  'businesses' => [
    'index' => [
      'msg' => [
        'no_appointments' => 'manager.businesses.index.msg.no_appointments',
      ],
      'help'                   => 'Desde aquí puedes administrar todos los prestadores',
      'register_business_help' => 'Si eres prestador y quieres dar citas online, es tu oportunidad!',
      'title'                  => 'Mis Prestadores',
      'btn'                    => [
        'manage'   => 'Administrar prestadores',
        'register' => 'Registrar un prestador',
      ],
    ],
    'btn' => [
      'deactivate' => 'Desactivar este prestador',
      'store'      => 'Registrar',
      'update'     => 'Actualizar',
      'return'     => 'Volver',
    ],
    'contacts' => [
      'btn' => [
        'create' => 'Agregar un contacto',
        'import' => 'Importar contactos',
      ],
    ],
    'create' => [
      'title' => 'Registrar un prestador',
    ],
    'dashboard' => [
      'alert' => [
        'no_services_set'  => 'Aún no tienes servicios cargados! Hazlo aquí!',
        'no_vacancies_set' => 'Aún no tienes publicada tu disponibilidad! Hazlo aquí!',
      ],
      'panel' => [
        'title_appointments_active'    => 'Activos',
        'title_appointments_annulated' => 'Anulados',
        'title_appointments_served'    => 'Atendidos',
        'title_appointments_today'     => 'Hoy',
        'title_appointments_tomorrow'  => 'Mañana',
        'title_appointments_total'     => 'Total',
        'title_contacts_active'        => 'Suscriptos',
        'title_contacts_registered'    => 'Registrados',
        'title_contacts_total'         => 'Totales',
      ],
      'meta' => [
        'title_owner'            => 'Propietario',
        'title_registered_since' => 'Registrado desde',
      ],
    ],
    'edit' => [
      'title' => 'Edición de datos del prestador',
    ],
    'form' => [
      'category' => [
        'label' => 'Rubro Comercial',
      ],
      'description' => [
        'label'       => 'Descripción',
        'placeholder' => 'Describe al prestador',
      ],
      'name' => [
        'label'       => 'Nombre',
        'placeholder' => 'Nombre completo del prestador',
        'validation'  => 'Se requiere nombre',
      ],
      'phone' => [
        'label'       => 'Móvil',
        'placeholder' => 'tu móvil de contacto',
        'hint'        => 'sin espacios ni guiones',
      ],
      'postal_address' => [
        'label'       => 'Dirección Postal',
        'placeholder' => 'altura calle, barrio, ciudad, país',
      ],
      'slug' => [
        'label'       => 'Alias',
        'placeholder' => 'así será el link en la web',
        'validation'  => 'Se requiere un alias',
      ],
      'social_facebook' => [
        'label'       => 'URL Página de Facebook',
        'placeholder' => 'https://facebook.com/tu-pagina-de-facebook',
      ],
      'timezone' => [
        'label' => 'Zona Horaria',
      ],
    ],
    'msg' => [
      'create' => [
        'success' => '¡Olé! Vamos a registrarte con el plan :plan',
      ],
      'destroy' => [
        'success' => 'Prestador removido',
      ],
      'index' => [
        'only_one_found' => 'Sólo tienes este negocio registrado.',
      ],
      'preferences' => [
        'success' => 'Actualizaste las preferencias Ok',
      ],
      'store' => [
        'business_already_exists' => 'El prestador ya está registrado',
        'restored_trashed'        => 'Prestador restaurado',
        'success'                 => 'Prestador registrado',
      ],
      'update' => [
        'success' => 'Datos del prestador actualizados',
      ],
    ],
    'preferences' => [
      'instructions' => 'Aquí puedes configurar las preferencias a las necesidades de tu negocio',
      'title'        => 'Preferencias del prestador',
    ],
    'vacancies' => [
      'btn' => [
        'update' => 'Actualizar Disponibilidad',
      ],
    ],
    'show' => [
      'title' => 'Prestador',
    ],
  ],
  //==================================== Translations ====================================//
  'business' => [
    'alert' => [
      'deactivate_confirm' => '¡Atención! Desactivar el prestador es una operación IRREVERSIBLE. ¿Seguro desactivar?',
    ],
    'btn' => [
      'tooltip' => [
        'agenda'      => 'Agenda de Citass',
        'contacts'    => 'Lista de Contactos',
        'edit'        => 'Editar datos del Prestador',
        'preferences' => 'Cambiar Preferencias',
        'services'    => 'Gestionar Servicios',
        'vacancies'   => 'Publicar Disponibilidad',
      ],
    ],
    'hint' => [
      'out_of_vacancies' => 'Publicá tu disponibilidad<br><br>Para que puedan empezar a pedirte citas es necesario que indiques tu disponibilidad',
      'set_services'     => 'Agregá los servicios que brindás',
    ],
    'service' => [
      'msg' => [
        'update' => [
          'success' => 'Servicio Actualizado!',
        ],
      ],
    ],
    'form' => [
      'strategy' => [
        'dateslot' => 'Por fecha',
        'timeslot' => 'Por fecha y horario',
      ],
    ],
  ],
  'contacts' => [
    'btn' => [
      'confirm_delete' => '¿Seguro querés eliminar el contacto?',
      'delete'         => 'Eliminar',
      'edit'           => 'Editar',
      'import'         => 'Importar Contactos',
      'store'          => 'Guardar',
      'update'         => 'Actualizar',
    ],
    'create' => [
      'title' => 'Contactos',
    ],
    'form' => [
      'birthdate' => [
        'label'       => 'Nacimiento',
        'placeholder' => 'fecha de nacimiento',
      ],
      'data' => [
        'label' => 'datos en formato CSV',
      ],
      'description' => [
        'label' => 'Descripción',
      ],
      'email' => [
        'label'       => 'Email',
        'placeholder' => 'email@ejemplo.com',
      ],
      'firstname' => [
        'label'       => 'Nombre',
        'validation'  => 'Se requiere su primer nombre',
        'placeholder' => 'primer nombre',
      ],
      'gender' => [
        'female' => [
          'label' => 'Femenino',
        ],
        'male' => [
          'label' => 'Masculino',
        ],
        'label' => 'Sexo',
      ],
      'lastname' => [
        'label'       => 'Apellido',
        'validation'  => 'Se requiere su apellido',
        'placeholder' => 'apellido',
      ],
      'mobile' => [
        'label'       => 'Móvil',
        'placeholder' => 'número de móvil completo',
      ],
      'nin' => [
        'label'       => 'DNI',
        'placeholder' => 'número de identificación nacional',
      ],
      'notes' => [
        'label'       => 'Notas',
        'placeholder' => 'notas',
      ],
      'prerequisites' => [
        'label' => 'Prerequisitos',
      ],
    ],
    'import' => [
      'title' => 'Importar contactos',
    ],
    'label' => [
      'birthdate'        => 'Nacimiento',
      'email'            => 'Email',
      'member_since'     => 'Suscripto desde',
      'mobile'           => 'Móvil',
      'nin'              => 'DNI',
      'notes'            => 'Notas',
      'gender'           => 'Sexo',
      'next_appointment' => 'Próxima Cita',
      'username'         => 'Usuario',
    ],
    'list' => [
      'btn' => [
        'filter' => 'Filtro',
      ],
      'header' => [
        'email'     => 'Email',
        'firstname' => 'Nombre',
        'lastname'  => 'Apellidos',
        'mobile'    => 'Móvil',
        'quality'   => 'Puntaje',
        'username'  => 'Usuario',
        'gender'    => 'Sexo',
      ],
      'msg' => [
        'filter_no_results' => 'Nada por aquí',
      ],
    ],
    'msg' => [
      'destroy' => [
        'success' => '¡Contacto eliminado!',
      ],
      'import' => [
        'success' => ':count Contactos importados',
      ],
      'store' => [
        'success'                          => '¡Contacto registrado Ok!',
        'warning_showing_existing_contact' => 'Encontramos el contacto ya registrado',
      ],
      'update' => [
        'success' => 'Actualizado Ok',
      ],
    ],
    'title' => 'Mis Clientes',
  ],
  'service' => [
    'btn' => [
      'delete' => 'Eliminar',
      'update' => 'Actualizar',
    ],
    'form' => [
      'name' => [
        'label' => 'Nombre del servicio',
      ],
    ],
    'msg' => [
      'store' => [
        'success' => '¡Servicio Guardado!',
      ],
    ],
  ],
  'services' => [
    'btn' => [
      'create' => 'Agregar un servicio',
      'store'  => 'Guardar',
    ],
    'create' => [
      'alert' => [
        'go_to_vacancies' => '¡Muy bien! Ya podés indicar tu disponibilidad y hacerla visible a tus clientes',
      ],
      'btn' => [
        'go_to_vacancies' => 'Publicar disponibilidad',
      ],
      'instructions' => 'Aquí puedes dar de alta los servicios que prestas. Cada uno podrá ser reservado para una y por la cantidad de citas que admitas',
      'title'        => 'Agregar un servicio',
    ],
    'index' => [
      'instructions' => 'Estos son tus servicios',
      'title'        => 'Servicios',
      'th'           => [
        'duration' => 'Duración',
        'name'     => 'Nombre',
        'slug'     => 'Alias',
      ],
    ],
    'msg' => [
      'destroy' => [
        'success' => '¡Servicio eliminado!',
      ],
    ],
  ],
  'vacancies' => [
    'edit' => [
      'instructions' => 'Aquí puedes editar y publicar tu disponibilidad para cada servicio por cada fecha.',
      'title'        => 'Disponibilidades',
    ],
    'msg' => [
      'edit' => [
        'no_services' => 'No hay servicios registrados. Favor de registrar servicios para tu negocio.',
      ],
      'store' => [
        'nothing_changed' => 'Debés completar tu disponibilidad para alguna fecha',
        'success'         => 'Disponibilidades registradas!',
      ],
    ],
    'table' => [
      'th' => [
        'date' => 'Fecha',
      ],
    ],
  ],
  //================================== Obsolete strings ==================================//
];
