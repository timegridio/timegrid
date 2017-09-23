<?php

return  [
  //============================== New strings to translate ==============================//
  'booking' => [
    'msg' => [
      'validate' => [
        'error' => [
          'bad-code'                              => 'Գրանցման կոդն անվավեր է',
          'no-appointment-was-found'              => 'Տվյալ կոդով գրանցում չկա',
        ],
        'success' => [
          'your-appointment-is-already-confirmed' => 'Ձեր գրանցումը հաստատված է',
          'your-appointment-was-confirmed'        => 'Դուք հաջողությամբ հաստատեցիք Ձեր գրանցումը։',
        ],
      ],
      'store' => [
        'error'            => 'Ձեր նախընտրած ժամն այլևս ազատ չէ',
        'not-registered'   => 'Դուք պետք է լինեք սրահի մենեջերի կոնտակտներում, որպեսզի կարողանաք գրանցվել։',
        'sorry_duplicated' => 'Ձեր գրանցումը կրկնվում է :code reserved before',
        'success'          => 'Ձեր գրանցումը կատարված է հետևյալ կոդով :code',
      ],
      'you_are_not_subscribed_to_business' => 'Գրանցվելու համար պետք է բաժանորդագրվեք սրահին',
    ],
  ],
  //==================================== Translations ====================================//
  'appointments' => [
    'alert' => [
      'book_in_biz_on_behalf_of' => 'Գրանցել :contact -ին  :biz -ում',
      'empty_list'               => 'Ընթացքի մեջ գտնվող գրանցումներ չունեք։',
      'no_vacancies'             => 'Ներկա պահին այս սրահը չի կարող գրանցումներ ընդունել',
    ],
    'btn' => [
      'book'                     => 'Գրանցվել',
      'book_in_biz'              => 'Գրանցվել :biz -ում',
      'book_in_biz_on_behalf_of' => 'Գրանցել :contact -ին :biz -ում',
      'calendar'                 => 'Տեսնել օրացույցը',
      'confirm_booking'          => 'Հաստատել ամրագրված գրանցումը',
      'more_dates'               => 'Տեսնել այլ օրեր',
    ],
    'form' => [
      'btn' => [
        'submit' => 'Հաստատել',
      ],
      'comments' => [
        'label' => 'Ցանկանո՞ւմ եք որևէ բան ասել մասնագետին',
      ],
      'date' => [
        'label' => 'Օր',
      ],
      'email' => [
        'label' => 'Ձեր էլեկտրոնային հասցեն',
      ],
      'service' => [
        'label' => 'Ծառայությունը',
      ],
      'time' => [
        'label' => 'Ո՞ր ժամին եք ցանկանում գրանցվել',
      ],
      'timetable' => [
        'instructions' => 'Ընտրե՛ք ծառայություն',
        'msg'          => [
          'no_vacancies' => 'Ազատ չէ',
        ],
        'title' => 'Գրանցվել :business -ում',
      ],
    ],
    'index' => [
      'th' => [
        'business'    => 'Սրահ',
        'calendar'    => 'Օր',
        'code'        => 'Կոդ',
        'contact'     => 'Հաճախորդ',
        'duration'    => 'Տևողություն',
        'finish_time' => 'Ավարտվում է',
        'remaining'   => 'Միջև',
        'service'     => 'Ծառայություն',
        'start_time'  => 'Սկսվում է',
        'status'      => 'Կարգավիճակ',
      ],
      'title' => 'Գրանցումներ',
    ],
  ],
  'business' => [
    'btn' => [
      'subscribe_to' => 'Բաժանորդագրվել :business -ին',
    ],
  ],
  'businesses' => [
    'index' => [
      'btn' => [
        'create'       => 'Գրանցել սրահ',
        'manage'       => 'Իմ սրահները',
        'power_create' => 'Գրանցվել հիմա',
      ],
      'title' => 'Հասանելի սրահները',
    ],
    'list' => [
      'no_businesses' => 'Հասանելի սրահ չկա',
    ],
    'subscriptions' => [
      'none_found' => 'Բաժանորդագրություններ չկան.',
      'title'      => 'Բաժանորդագրություններ',
    ],
  ],
  'contacts' => [
    'btn' => [
      'store'  => 'Պահպանել',
      'update' => 'Թարմացնել',
    ],
    'create' => [
      'help'  => 'Շատ լավ։ Գրեթե պատրաստ է։ Այժմ լրացրեք Ձեր հաշվի տվյալները։',
      'title' => 'Իմ հաշիվը',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Հաջողությամբ չեղարկվեց',
      ],
      'store' => [
        'associated_existing_contact' => 'Ձեր հաշիվը նույնականացվում է արդեն գոյություն ունեցեղ հաշվի',
        'success'                     => 'Հաջողությամբ պահպանվեց',
        'warning'                     => [
          'already_registered' => 'Այս հաշիվն արդեն գրացված է',
        ],
      ],
      'update' => [
        'success' => 'Հաջողությամբ թարմացվեց',
      ],
    ],
  ],
  'dashboard' => [
    'card' => [
      'agenda' => [
        'button'      => 'Տեսնել գրանցումները',
        'description' => 'Ստուգել ընթացքի մեջ գտնվող գրանցումները|[2,Inf] Ստուգել ընթացքի մեջ գտնվող գրանցումները։',
        'title'       => 'Գրանցում|[2,Inf] Ձեր գրանցումները',
      ],
      'directory' => [
        'button'      => 'Փնտրել սրահներ',
        'description' => 'Փնտրել սրահներ և կատարել գրանցում',
        'title'       => 'Հասցեագիրք',
      ],
      'subscriptions' => [
        'button'      => 'Տեսնել բաժանորդագրությունները',
        'description' => 'Կառավարել բաժանորդագրությունները',
        'title'       => 'Բաժանորդագրություններ',
      ],
    ],
  ],
  'msg' => [
    'preferences' => [
      'success' => 'Ձեր նախընտրությունները պահպանված են',
    ],
  ],
  'preferences' => [
    'title' => 'Իմ նախընտրությունները',
  ],
  'go_to_business_dashboard' => 'Գնալ :business-ի կառավարման վահանակ',
];
