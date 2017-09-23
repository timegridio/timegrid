<?php

return  [
  //============================== New strings to translate ==============================//
  'booking' => [
    'msg' => [
      'validate' => [
        'error' => [
          'bad-code'                              => 'Извините, неверный код назначения',
          'no-appointment-was-found'              => 'Извините, никаких встреч с этим кодом',
        ],
        'success' => [
          'your-appointment-is-already-confirmed' => 'Круто, ваше бронирование уже подтверждено',
          'your-appointment-was-confirmed'        => 'Вы подтвердили бронирование успешно',
        ],
      ],
      'store' => [
        'error'            => 'Извините, это время бронирования больше не доступно.',
        'not-registered'   => 'Вы должны быть указаны в адресной книге контрагента, чтобы сделать бронирование.',
        'sorry_duplicated' => 'Извините, ваша встреча дублируется :code reserved before',
        'success'          => 'Ваше назначение зарегистрировано с кодом :code',
      ],
      'you_are_not_subscribed_to_business' => 'Чтобы сделать заказ, вы должны сначала подписаться на бизнес',
    ],
  ],
  //==================================== Translations ====================================//
  'appointments' => [
    'alert' => [
      'book_in_biz_on_behalf_of' => 'Cделать бронирование для :contact at :biz',
      'empty_list'               => 'У вас нет текущих встречи.',
      'no_vacancies'             => 'Извините, вы не можете сделать бронирование сейчас.',
    ],
    'btn' => [
      'book'                     => 'Бронировать',
      'book_in_biz'              => 'Cделать бронирование в :biz',
      'book_in_biz_on_behalf_of' => 'Cделать бронирование для :contact at :biz',
      'calendar'                 => 'Календарь',
      'confirm_booking'          => 'Подтвердить бронирование',
      'more_dates'               => 'Проверить другие даты',
    ],
    'form' => [
      'btn' => [
        'submit' => 'Подтвердить',
      ],
      'comments' => [
        'label' => 'Вы хотите оставить комментарии для специалиста?',
      ],
      'date' => [
        'label' => 'Дата',
      ],
      'email' => [
        'label' => 'Ваш адрес электронной почты',
      ],
      'service' => [
        'label' => 'Сервис',
      ],
      'time' => [
        'label' => 'В какое время вы хотите забронировать?',
      ],
      'timetable' => [
        'instructions' => 'Выберите услугу для резервирования',
        'msg'          => [
          'no_vacancies' => 'Нет доступности для этой даты',
        ],
        'title' => 'Cделать бронирование в :business',
      ],
    ],
    'index' => [
      'th' => [
        'business'    => 'Бизнес',
        'calendar'    => 'Дата',
        'code'        => 'Код',
        'contact'     => 'Клиент',
        'duration'    => 'Длительность',
        'finish_time' => 'Заканчивается',
        'remaining'   => 'Внутри',
        'service'     => 'Сервис',
        'start_time'  => 'Начинается',
        'status'      => 'Статус',
      ],
      'title' => 'Назначения',
    ],
  ],
  'business' => [
    'btn' => [
      'subscribe_to' => 'Подписаться на :business',
    ],
  ],
  'businesses' => [
    'index' => [
      'btn' => [
        'create'       => 'Зарегистрировать бизнес',
        'manage'       => 'Мой бизнес',
        'power_create' => 'Зарегистрируйтесь сейчас',
      ],
      'title' => 'Доступные компании',
    ],
    'list' => [
      'no_businesses' => 'Нет компаний.',
    ],
    'subscriptions' => [
      'none_found' => 'Нет подписки.',
      'title'      => 'Подписки',
    ],
  ],
  'contacts' => [
    'btn' => [
      'store'  => 'Сохранить',
      'update' => 'Обновить',
    ],
    'create' => [
      'help'  => 'Молодец! Заполните профиль счета.',
      'title' => 'Мой профиль',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Удалено',
      ],
      'store' => [
        'associated_existing_contact' => 'Ваш профиль прикреплен к существующему',
        'success'                     => 'Сохранено',
        'warning'                     => [
          'already_registered' => 'Этот профиль уже был зарегистрирован',
        ],
      ],
      'update' => [
        'success' => 'Обновлено',
      ],
    ],
  ],
  'dashboard' => [
    'card' => [
      'agenda' => [
        'button'      => 'Посмотреть график',
        'description' => 'Проверьте свое текущее бронирование.|[2,Inf] Ознакомьтесь с вашими текущими оговорками.',
        'title'       => 'Одно назначение|[2,Inf] Ваши встречи',
      ],
      'directory' => [
        'button'      => 'Искать каталог',
        'description' => 'Просмотрите каталог и забронируйте услугу.',
        'title'       => 'Каталог',
      ],
      'subscriptions' => [
        'button'      => 'Ваши подписки',
        'description' => 'Управление подписками.',
        'title'       => 'Подписки',
      ],
    ],
  ],
  'msg' => [
    'preferences' => [
      'success' => 'Ваши настройки сохранены.',
    ],
  ],
  'preferences' => [
    'title' => 'Мои предпочтения',
  ],
  'go_to_business_dashboard' => 'Перейти на панель инструментов',
];
