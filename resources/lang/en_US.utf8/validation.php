<?php

return [
  'phone' => 'The mobile number must be in international format.',
  'required' => 'Did not complete a required field.',
  'custom' => [
    'name' => [
        'min' => 'Tell us your full name',
    ],
    'email' => [
        'email' => 'Give us a valid email address',
        'required' => 'Please give us your email address',
        'unique' => 'Seems you are already registered!',
    ],
    'password' => [
        'required' => 'Set a password',
        'confirmed' => 'Please confirm your password correctly',
        'min' => 'Password must be at least :min characters long',
    ],
  ],
];
