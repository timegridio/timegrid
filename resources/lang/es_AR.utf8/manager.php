<?php

/*************************************************************************
 Generated via "php artisan localization:missing" at 2016/01/27 11:25:57
*************************************************************************/

return [
  //============================== New strings to translate ==============================//
  'humanresource' => [
    'btn' => [
      'create' => 'Agregar',
      'delete' => 'Remover',
      'store'  => 'Guardar',
      'update' => 'Actualizar',
    ],
    'create' => [
      'instructions' => 'Agregar un Recurso Humano',
      'title'        => 'Recursos Humanos',
    ],
    'form' => [
      'capacity' => [
        'label' => 'Capacidad',
      ],
      'name' => [
        'label' => 'Nombre',
      ],
    ],
    'index' => [
      'instructions' => 'Gestiona tus Recursos Humanos aquí',
      'title'        => 'Recursos Humanos',
    ],
  ],
  //==================================== Translations ====================================//
  'business' => [
    'btn' => [
      'tooltip' => [
        'agenda'        => 'Agenda de Turnos',
        'contacts'      => 'Lista de Contactos',
        'edit'          => 'Editar datos del Prestador',
        'preferences'   => 'Cambiar Preferencias',
        'services'      => 'Gestionar Servicios',
        'vacancies'     => 'Publicar Disponibilidad',
        'notifications' => 'Leer notificaciones',
        'humanresources' => 'Staff',
      ],
    ],
    'hint' => [
      'out_of_vacancies' => 'Publicá tu disponibilidad<br><br>Para que puedan empezar a pedirte turno es necesario que indiques tu disponibilidad',
      'set_services'     => 'Agregá los servicios que brindás',
    ],
    'service' => [
      'msg' => [
        'update' => [
          'success' => 'Servicio Actualizado!',
        ],
      ],
    ],
  ],
  'businesses' => [
    'check' => [
      'remember_vacancies'  => 'Recordar esta disponibilidad como predeterminada',
      'unpublish_vacancies' => 'Limpiar mi disponibilidad actual antes de publicar',
    ],
    'btn' => [
      'store'  => 'Registrar',
      'update' => 'Actualizar',
    ],
    'contacts' => [
      'btn' => [
        'create' => 'Agregar un contacto',
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
        'title_appointments_active'    => 'Turnos Activos',
        'title_appointments_canceled'  => 'Turnos Cancelados',
        'title_appointments_served'    => 'Turnos Atendidos',
        'title_appointments_today'     => 'Hoy',
        'title_appointments_tomorrow'  => 'Mañana',
        'title_appointments_total'     => 'Turnos Totales',
        'title_contacts_active'        => 'Contactos Suscriptos',
        'title_contacts_registered'    => 'Contactos Registrados',
        'title_total'                  => 'Total',
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
      ],
      'postal_address' => [
        'label'       => 'Dirección Postal',
        'placeholder' => 'altura calle, barrio, ciudad, país',
      ],
      'social_facebook' => [
        'label'       => 'URL Página de Facebook',
        'placeholder' => 'https://facebook.com/tu-pagina-de-facebook',
      ],
      'timezone' => [
        'label' => 'Zona Horaria',
      ],
      'slug' => [
        'label'       => 'Alias',
        'placeholder' => 'así será el link en la web',
        'validation'  => 'Se requiere un alias',
      ],
    ],
    'index' => [
      'help' => 'Desde aquí puedes administrar todos los prestadores',
      'msg'  => [
        'no_appointments' => 'No hay turnos reservados en este momento.',
      ],
      'register_business_help' => 'Si sos prestador y querés dar citas online, es tu oportunidad!',
      'title'                  => 'Mis Prestaciones',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Prestador removido',
      ],
      'index' => [
        'only_one_found' => 'Sólo tenés este negocio registrado.',
      ],
      'preferences' => [
        'success' => 'Actualizaste las preferencias Ok',
      ],
      'register' => 'Registrar prestación',
      'store'    => [
        'business_already_exists' => 'El prestador ya está registrado',
        'success'                 => 'Prestador registrado',
      ],
      'update' => [
        'success' => 'Datos del prestador actualizados',
      ],
    ],
    'preferences' => [
      'instructions' => 'Aquí podés configurar las preferencias a las necesidades de tu negocio',
      'title'        => 'Preferencias del prestador',
    ],
    'vacancies' => [
      'btn' => [
        'update' => 'Actualizar Disponibilidad',
      ],
    ],
  ],
  'contacts' => [
    'btn' => [
      'confirm_delete' => '¿Seguro querés eliminar el contacto?',
      'delete'         => 'Eliminar',
      'edit'           => 'Editar',
      'store'          => 'Guardar',
      'update'         => 'Actualizar',
    ],
    'create' => [
      'title' => 'Contactos',
    ],
    'form' => [
      'birthdate' => [
        'label' => 'Nacimiento',
      ],
      'description' => [
        'label' => 'Descripción',
      ],
      'email' => [
        'label' => 'Email',
      ],
      'firstname' => [
        'label'      => 'Nombre',
        'validation' => 'Se requiere su primer nombre',
      ],
      'gender' => [
        'female' => [
          'label' => 'Femenino',
        ],
        'male' => [
          'label' => 'Masculino',
        ],
      ],
      'lastname' => [
        'label'      => 'Apellido',
        'validation' => 'Se requiere su apellido',
      ],
      'mobile' => [
        'label' => 'Móvil',
      ],
      'nin' => [
        'label' => 'DNI',
      ],
      'notes' => [
        'label' => 'Notas',
      ],
      'postal_address' => [
        'label'      => 'Dirección postal',
        'validation' => 'La dirección postal es requerida',
      ],
      'prerequisites' => [
        'label' => 'Prerequisitos',
      ],
      'data' => [
        'label' => 'datos en formato CSV',
      ],
    ],
    'label' => [
      'birthdate'      => 'Nacimiento',
      'email'          => 'Email',
      'member_since'   => 'Suscripto desde',
      'mobile'         => 'Móvil',
      'nin'            => 'DNI',
      'notes'          => 'Notas',
      'postal_address' => 'Dirección Postal',
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
        'username'  => 'Usuario',
        'quality'   => 'Puntaje',
      ],
      'msg' => [
        'filter_no_results' => 'Nada por aquí',
      ],
    ],
    'msg' => [
      'destroy' => [
        'success' => '¡Contacto eliminado!',
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
  'humanresources' => [
    'msg' => [
      'destroy' => [
        'success' => 'Recurso humano removido',
      ],
      'store' => [
        'success' => 'Recurso humano agregado',
      ],
      'update' => [
        'success' => 'Recurso humano actualizado',
      ],
    ],
  ],
  'service' => [
    'btn' => [
      'delete' => 'Eliminar',
      'update' => 'Actualizar',
    ],
    'form' => [
      'duration' => [
        'label' => 'Duración en minutos',
      ],
      'name' => [
        'label' => 'Nombre del servicio',
      ],
      'color' => [
        'label' => 'Color',
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
