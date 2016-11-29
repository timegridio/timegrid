<?php

return [

    /*
   |--------------------------------------------------------------------------
   | User Model Plan Field
   |--------------------------------------------------------------------------
   |
   | Define the field that is used on the User model to define the
   | plan that the user is subscribed to.
   */

    'plan_field' => 'plan',

    /*
   |--------------------------------------------------------------------------
   | Fallback Plan
   |--------------------------------------------------------------------------
   |
   | The fallback plan will be used if one of the requested attributes
   | is not found in the user's subscription plan. If you don't define a
   | default fallback plan, then set this to false.
   */

    'fallback_plan' => 'free',

    /*
    |--------------------------------------------------------------------------
    | Subscription plans
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the plans that you offer, along with the
    | limits for each plan. The default plan will be used if no plan matches
    | the one provided when calling the plan() helper function.
    */

    'plans'      => [

        'free' => [
            'title'       => 'Free',
            'description' => '',
            'price'       => '0',
            'currency'    => 'USD',
            'limits'      => [
                'contacts'    => 20,
                'services'    => 3,
                'specialists' => 1,
            ],
        ],

        'premium' => [
            'title'       => 'Premium',
            'description' => '',
            'price'       => '5',
            'currency'    => 'USD',
            'limits'      => [
                'contacts'    => 10000,
                'services'    => 100,
                'specialists' => 50,
            ],
        ],

    ],
];
