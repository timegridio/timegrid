<?php

return  [
  //==================================== Translations ====================================//
  'business' => [
    'btn' => [
      'tooltip' => [
        'agenda'         => 'Agenda de Turnos',
        'contacts'       => 'Lista de Contactos',
        'humanresources' => 'Staff',
        'services'       => 'Gestionar Servicios',
        'vacancies'      => 'Publicar Disponibilidad',
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
    'btn' => [
      'store'  => 'Registrar',
      'update' => 'Actualizar',
    ],
    'check' => [
      'remember_vacancies'  => 'Recordar esta disponibilidad como predeterminada',
      'unpublish_vacancies' => 'Limpiar mi disponibilidad actual antes de publicar',
    ],
    'contacts' => [
      'btn' => [
        'create' => 'Agregar un contacto',
      ],
    ],
    'create' => [
      'title' => 'Registrar un prestador',
    ],
    'notifications' => [
      'title' => 'Notificaciones',
      'help' => 'Todo lo sucedido recientemente',
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
        'title_contacts_subscribed'    => 'Contactos Suscriptos',
        'title_contacts_registered'    => 'Contactos Registrados',
        'title_total'                  => 'Total',
      ],
      'title' => 'Panel de Control',
    ],
    'edit' => [
      'title' => 'Edición de datos del prestador',
    ],
    'form' => [
      'category' => [
        'label' => 'Industria',
      ],
      'description' => [
        'label'       => 'Descripción',
        'placeholder' => 'Describí tus prestaciones',
      ],
      'name' => [
        'label'       => 'Nombre',
        'placeholder' => 'Nombre completo del prestador',
        'validation'  => 'Se requiere nombre',
      ],
      'link' => [
        'label'       => 'Enlace',
        'placeholder' => 'Enlace a tu página timegrid',
        'validation'  => 'El enlace a tu página timegrid es inválido',
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
        'label'       => 'Página de Facebook',
        'placeholder' => 'https://facebook.com/tu-pagina-de-facebook',
      ],
      'timezone' => [
        'label' => 'Zona horaria',
      ],
      'slug' => [
        'label'       => 'Alias',
        'placeholder' => 'así será el link en la web',
        'validation'  => 'Se requiere un alias',
      ],
    ],
    'index' => [
      'help' => 'Desde aquí podés administrar todos los prestadores',
      'msg'  => [
        'no_appointments' => 'No hay turnos reservados en este momento.',
      ],
      'register_business_help' => 'Si sos prestador y querés dar turnos online, es tu oportunidad!',
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
    'notifications' => [
      'help'  => 'Todo lo sucedido recientemente',
      'title' => 'Notificaciones',
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
        'label' => 'Sexo',
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
  'humanresource' => [
    'btn' => [
      'create' => 'Agregar',
      'delete' => 'Remover',
      'store'  => 'Guardar',
      'update' => 'Actualizar',
    ],
    'create' => [
      'title'        => 'Agregar Especialistas',
      'subtitle'     => 'Que provee servicios',
      'instructions' => 'Agregar un especialista que provee servicios',
    ],
    'edit' => [
      'title'        => 'Editar Especialista',
      'subtitle'     => 'Información',
      'instructions' => 'Editar información de especialista',
    ],
    'index' => [
      'title'        => 'Especialistas',
      'subtitle'     => 'Lista',
      'instructions' => 'Lista de especialistas',
    ],
    'show' => [
      'title'        => 'Especialista',
      'subtitle'     => 'Información',
      'instructions' => 'Datos del especialista',
    ],
    'form' => [
      'calendar_link' => [
        'label' => 'Link de Calendario',
      ],
      'capacity' => [
        'label' => 'Capacidad',
      ],
      'name' => [
        'label' => 'Nombre',
      ],
    ],
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
      'color' => [
        'label' => 'Color',
      ],
      'duration' => [
        'label' => 'Duración en minutos',
      ],
      'name' => [
        'label' => 'Nombre del servicio',
      ],
      'servicetype' => [
        'label' => 'Tipo',
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
      'instructions' => 'Aquí podés dar de alta los servicios que prestas. Cada uno podrá ser reservado para una y por la cantidad de turnos que admitas',
      'title'        => 'Agregar un servicio',
    ],
    'edit' => [
      'title' => 'Editar servicio',
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
      'instructions' => 'Aquí podés editar y publicar tu disponibilidad para cada servicio por cada fecha.',
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
];
