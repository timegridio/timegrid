<?php

return [
  'user' => [
    'welcome'     => ['subject' => 'Bienvenido a timegrid.io'],
    'appointment' => [
      'reserved'  => ['subject' => 'Información de tu reserva'],
      'confirmed' => ['subject' => 'Tu turno en :business fue confirmado'],
    ],
  ],
  'manager' => [
    'appointment' => [
      'reserved' => ['subject' => 'Tenés una reserva nueva'],
    ],
    'business' => [
      'report' => ['subject' => ':date Agenda de :business'],
    ],
  ],
];
