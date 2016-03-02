<?php

/*
|--------------------------------------------------------------------------
| Notifynder Configuration
|--------------------------------------------------------------------------
*/

return [

    /*
     * If you have a different user model
     * please specific it here, this option is not
     * considerate if using notifynder as polymorphic
     */
    'model' => 'App\Models\User',

    /*
     * Do you want have notifynder that work polymorphically?
     * just swap the value to true and you will able to use it!
     */
    'polymorphic' => true,

    /*
     * If you need to extend the model class of
     * Notifynder you just need to change this line
     * With the path / NameSpace of your model and extend it
     * with Fenos\Notifynder\Models\Notification
     */
    'notification_model' => 'Fenos\Notifynder\Models\Notification',

    /*
     * If you wish to have the translations in a specific file
     * just require the file on the following option.
     *
     * To get started with the translations just reference a key with
     * the language you wish to translate ex 'it' or 'italian' and pass as
     * value an array with the translations
     */
    'translations'  => [

    ],
];
