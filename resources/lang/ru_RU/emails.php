<?php

return [
    'root'    => [
        'report' => [
            'subject' => 'Отчет',
        ],
    ],
    'manager' => [
        'business-report' => [
            'subject'      => 'Расписание отчета :date из :businessName',
            'welcome'      => 'Привет :ownerName',
            'button'       => 'Посмотреть расписание',
        ],
        'appointment-notification' => [
            'subject'      => 'У вас новая встреча',
            'welcome'      => ':ownerName, у вас есть новая встреча',
            'instructions' => 'A new appointment was reserved',
            'title'        => 'Детали встречи',
        ],
    ],
    'user'    => [
        'welcome' => [
            'subject'              => 'Добро пожаловать в timegrid.io',
            'hello-title'          => 'Здравствуйте :userName',
            'hello-paragraph'      => 'Timegrid позволяет сделать онлайн назначения.',
            'quickstart-title'     => 'Вы готовы к работе',
            'quickstart-paragraph' => 'Просто заходите в timegrid в любое время, когда вы хотите сделать бронирование',
        ],
        'appointment-notification' => [
            'subject'              => 'Детали вашего нового бронирования',
            'hello-title'          => ':userName, вы сделали новое бронирование',
            'hello-paragraph'      => 'Ваше бронирование было принято.',
            'appointment-title'    => 'Ваши данные бронирования',
            'button'               => 'Мои назначения',
        ],
        'appointment-confirmation' => [
            'subject'              => 'Ваше бронирование в :businessName было подтверждено',
            'hello-title'          => 'Здравствуйте :userName,',
            'hello-paragraph'      => 'Ваше бронирование подтверждено.',
            'appointment-title'    => 'Ваши данные бронирования',
            'button'               => 'Мои назначения',
        ],
        'appointment-cancellation' => [
            'subject'              => 'Ваше бронирование в :businessName было отменено',
            'hello-title'          => 'Здравствуйте :userName,',
            'hello-paragraph'      => 'Извините, ваше бронирование было отменено.',
            'appointment-title'    => 'Узнать больше',
            'button'               => 'Мои назначения',
        ],
    ],
    'guest'   => [
        'password' => [
            'subject'      => 'Сброс пароля',
            'hello'        => 'Здравствуйте :userName,',
            'instructions' => 'Просто нажмите кнопку сброса пароля и сбросьте пароль.',
            'button'       => 'Сбросить пароль.',
        ],
        'appointment-validation' => [
            'subject'            => 'Пожалуйста, подтвердите свое бронирование',
            'hello-title'        => 'Подтвердить ваше назначение',
            'hello-paragraph'    => 'Вы сделали бронирование как гость. Если вы не подтвердите, оно будет автоматически истекать',
            'appointment-title'  => 'Детали бронирования', 
            'button'             => 'Подтвердить назначение',
        ],
    ],
    'text'  => [
        'business'          => 'Бизнес',
        'user'              => 'Пользователь',
        'date'              => 'Дата',
        'time'              => 'Время',
        'code'              => 'Код',
        'where'             => 'Где',
        'phone'             => 'Телефон',
        'service'           => 'Сервис',
        'important'         => 'важно',
        'customer_notes'    => 'Замечания клиентов для вас',
        'there_are'         => 'Есть',
        'registered'        => 'Зарегистрированные пользователи до сих пор',
    ],
];
