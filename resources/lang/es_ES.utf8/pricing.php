<?php

return ['plan' => [
                    'free'    => [ 'name' => 'Free',
                                   'fee' => '(Gratis)',
                                   'hint' => 'Ideal para prestadores independientes',
                                   'submit' => 'Empezar',
                                 ],
                    'starter' => [ 'name' => 'Starter',
                                   'fee' => '(Abono mensual)',
                                   'hint' => 'Ideal para negocios en crecimiento',
                                   'submit' => 'Contratar',
                                 ],
                    'feature' => [ 'contacts' => 'contactos en agenda',
                                   'services' => 'servicios registrables',
                                   'appointments' => 'turnos por mes',
                                   'email_alerts' => 'alertas por email',
                                   'reports' => 'reportes gráficos',
                                 ],
                  ],
                  'month' => 'mes',
                  'free' => 'GRATIS',
                  'unlimited' => 'ilimitados|ilimitadas', /* ADVICE: trans_choice not actually for quantity */
                  'currency' => '&euro;', /* ADVICE: trans_choice not actually for quantity */
    ];