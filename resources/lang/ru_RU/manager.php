<?php

return  [
  //==================================== Translations ====================================//
  'agenda' => [
    'title'    => 'Назначения',
    'subtitle' => 'Список резервирований',
  ],
  'business' => [
    'btn' => [
      'tooltip' => [
        'agenda'         => 'График резервирования',
        'contacts'       => 'Список контактов',
        'humanresources' => 'Персонал',
        'services'       => 'Управление услугами',
        'vacancies'      => 'Публикация доступности',
      ],
    ],
    'hint' => [
      'out_of_vacancies' => 'Опубликуйте свои часы работы.',
      'set_services'     => 'Добавьте сервисы',
    ],
    'service' => [
      'msg' => [
        'update' => [
          'success' => 'Сервис обновлен!',
        ],
      ],
    ],
  ],
  'businesses' => [
    'btn' => [
      'store'  => 'Регистрация',
      'update' => 'Обновить',
    ],
    'check' => [
      'remember_vacancies'  => 'Помните эти рабочие часы по умолчанию',
      'unpublish_vacancies' => 'Сбросить мои текущие рабочие часы перед публикацией',
    ],
    'contacts' => [
      'btn' => [
        'create' => 'Добавить контакт',
      ],
    ],
    'create' => [
      'title' => 'Зарегистрируйте Ваш бизнес',
    ],
    'notifications' => [
      'title' => 'Уведомления',
      'help' => 'Все, что произошло недавно',
    ],
    'dashboard' => [
      'alert' => [
        'no_services_set'  => 'До сих пор не добавлены службы. Добавьте их сюда!',
        'no_vacancies_set' => 'Вы еще не опубликовали ваше рабочее время. Сделайте это!',
      ],
      'panel' => [
        'title_appointments_active'    => 'Активные назначения',
        'title_appointments_canceled'  => 'Отмененные назначения',
        'title_appointments_served'    => 'Завершенные встречи',
        'title_appointments_today'     => 'Сегодня',
        'title_appointments_tomorrow'  => 'Завтра',
        'title_appointments_total'     => 'Всего Назначений',
        'title_contacts_subscribed'    => 'Подписчики',
        'title_contacts_registered'    => 'Зарегистрированные контакты',
        'title_total'                  => 'Всего',
      ],
      'title' => 'Панель инструментов',
    ],
    'edit' => [
      'title' => 'Редактирование профиля бизнеса',
    ],
    'form' => [
      'category' => [
        'label' => 'Индустрия',
      ],
      'description' => [
        'label'       => 'О себе',
        'placeholder' => 'Опишите свой бизнес и услуги',
      ],
      'name' => [
        'label'       => 'Имя',
        'placeholder' => 'Коммерческое имя',
        'validation'  => 'Имя обязательное',
      ],
      'link' => [
        'label'       => 'Ссылка',
        'placeholder' => 'Ваш URL-адрес главной страницы',
        'validation'  => 'Ссылка на главную страницу недействительна',
      ],
      'phone' => [
        'label'       => 'Номер мобильного телефона',
        'placeholder' => 'Номер мобильного телефона',
      ],
      'postal_address' => [
        'label'       => 'Почтовый адрес',
        'placeholder' => 'Название и номер улицы, площадь, город, страна ',
      ],
      'social_facebook' => [
        'label'       => 'Страница Facebook',
        'placeholder' => 'https://www.facebook.com/timegrid.io',
      ],
      'timezone' => [
        'label' => 'Часовой пояс',
      ],
      'slug' => [
        'label'       => 'Псевдоним',
        'placeholder' => 'это будет ваш URL-адрес',
        'validation'  => 'Требуется псевдоним',
      ],
    ],
    'index' => [
      'help' => 'Здесь вы можете управлять все ваши бизнесы',
      'msg'  => [
        'no_appointments' => 'Нет активных назначений',
      ],
      'register_business_help' => 'Если вы являетесь поставщиком услуг и хотите предоставить онлайн-бронирование, это ваш шанс!',
      'title'                  => 'Мой бизнес',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Бизнес удален',
      ],
      'index' => [
        'only_one_found' => 'У вас зарегистрирован только один бизнес. Здесь ваша панель инструментов.',
      ],
      'preferences' => [
        'success' => 'Настройки успешно обновлены!',
      ],
      'register' => 'Отлично! Мы собираемся зарегистрировать ваш бизнес',
      'store'    => [
        'business_already_exists' => 'Бизнес уже зарегистрирован',
        'success'                 => 'Бизнес успешно зарегистрирован',
      ],
      'update' => [
        'success' => 'Обновлено',
      ],
    ],
    'notifications' => [
      'help'  => 'Все, что произошло недавно',
      'title' => 'Уведомления',
    ],
    'preferences' => [
      'instructions' => 'Здесь вы можете редактировать настройки бизнеса.',
      'title'        => 'Бизнес-настройки',
    ],
    'vacancies' => [
      'btn' => [
        'update' => 'Обновить доступность',
      ],
    ],
  ],
  'contacts' => [
    'btn' => [
      'confirm_delete' => 'Вы уверены, что хотите удалить контакт?',
      'delete'         => 'Удалить',
      'edit'           => 'Редактировать',
      'store'          => 'Сохранить',
      'update'         => 'Обновить',
    ],
    'create' => [
      'title' => 'Контакты',
    ],
    'form' => [
      'birthdate' => [
        'label' => 'Дата рождения',
      ],
      'description' => [
        'label' => 'Описание',
      ],
      'email' => [
        'label' => 'Эл. адрес',
      ],
      'firstname' => [
        'label'      => 'Имя',
        'validation' => 'Имя обязательное',
      ],
      'gender' => [
        'female' => [
          'label' => 'Женский',
        ],
        'label' => 'Пол',
        'male'  => [
          'label' => 'Мужской',
        ],
      ],
      'lastname' => [
        'label'      => 'Фамилия',
        'validation' => 'Фамилия обязательна',
      ],
      'mobile' => [
        'label' => 'Мобильный телефон',
      ],
      'nin' => [
        'label' => 'ID',
      ],
      'notes' => [
        'label' => 'Заметки',
      ],
      'postal_address' => [
        'label'      => 'Почтовый адрес',
        'validation' => 'Адрес почты является обязательным',
      ],
      'prerequisites' => [
        'label' => 'Условия',
      ],
    ],
    'label' => [
      'birthdate'      => 'Дата рождения',
      'email'          => 'Эл. адрес',
      'member_since'   => 'Подписано с',
      'mobile'         => 'Мобильный телефон',
      'nin'            => 'ID',
      'notes'          => 'Заметки',
      'postal_address' => 'Почтовый адрес',
    ],
    'list' => [
      'btn' => [
        'filter' => 'Фильтр',
      ],
      'header' => [
        'email'     => 'Эл. адрес',
        'firstname' => 'Имя',
        'lastname'  => 'Фамилия',
        'mobile'    => 'Мобильный телефон',
        'username'  => 'Имя пользователя',
      ],
      'msg' => [
        'filter_no_results' => 'Ничего нет',
      ],
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Контакт удален!',
      ],
      'store' => [
        'success'                          => 'Контакт успешно зарегистрирован!',
        'warning_showing_existing_contact' => 'Совет: мы нашли этот контакт',
      ],
      'update' => [
        'success' => 'Обновлено',
      ],
    ],
    'title' => 'Мои клиенты',
  ],
  'humanresource' => [
    'btn' => [
      'create' => 'Добавить',
      'delete' => 'Удалить',
      'store'  => 'Сохранить',
      'update' => 'Обновить',
    ],
    'create' => [
      'title'        => 'Добавить специалистов',
      'subtitle'     => 'Кто будет предоставлять услуги',
      'instructions' => 'Добавить специалиста',
    ],
    'edit' => [
      'title'        => 'Редактировать специалиста',
      'subtitle'     => 'Информация',
      'instructions' => 'Редактировать информацию специалиста',
    ],
    'index' => [
      'title'        => 'Специалисты',
      'subtitle'     => 'Список',
      'instructions' => 'Список специалистов',
    ],
    'show' => [
      'title'        => 'Специалист',
      'subtitle'     => 'Информация',
      'instructions' => 'Информация специалиста',
    ],
    'form' => [
      'calendar_link' => [
        'label' => 'Ссылка Календаря',
      ],
      'capacity' => [
        'label' => 'Объем',
      ],
      'name' => [
        'label' => 'Имя',
      ],
    ],
  ],
  'humanresources' => [
    'msg' => [
      'destroy' => [
        'success' => 'Специалист удален',
      ],
      'store' => [
        'success' => 'Специалист добавлен ',
      ],
      'update' => [
        'success' => 'Специалист обновлен',
      ],
    ],
  ],
  'service' => [
    'btn' => [
      'delete' => 'Удалить',
      'update' => 'Обновить',
    ],
    'form' => [
      'color' => [
        'label' => 'Цвет'
      ],
      'duration' => [
        'label' => 'Длительность в минутах',
      ],
      'name' => [
        'label' => 'Имя сервиса',
      ],
      'servicetype' => [
        'label' => 'Тип сервиса',
      ],
    ],
    'msg' => [
      'store' => [
        'success' => 'Сервис успешно сохранен!',
      ],
    ],
  ],
  'services' => [
    'btn' => [
      'create' => 'Добавить услугу',
      'store'  => 'Сохранить',
    ],
    'create' => [
      'alert' => [
        'go_to_vacancies' => 'Теперь вы можете опубликовать свое рабочее время.',
      ],
      'btn' => [
        'go_to_vacancies' => 'Установить и опубликовать мою доступность',
      ],
      'instructions' => 'Опишите вашу службу.',
      'title'        => 'Добавить службу',
    ],
    'edit' => [
      'title' => 'Изменить услугу',
    ],
    'index' => [
      'instructions' => 'Добавьте столько сервисов, сколько хотите.',
      'title'        => 'Сервисы',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Сервис удален!'
      ],
    ],
  ],
  'vacancies' => [
    'edit' => [
      'instructions' => 'Сколько назначений вы можете обрабатывать в день? »,?',
      'title'        => 'Доступность',
    ],
    'msg' => [
      'edit' => [
        'no_services' => 'Там нет зарегистрированных услуг..',
      ],
      'store' => [
        'nothing_changed' => 'Вы должны указать свою готовность',
        'success'         => 'Доступность зарегистрирована !',
      ],
    ],
    'table' => [
      'th' => [
        'date' => 'Дата',
      ],
    ],
  ],
];
