<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute deve essere accettato.',
    'active_url'           => ':attribute non &egrave; un URL valido.',
    'after'                => ':attribute deve essere una data successiva a :date.',
    'alpha'                => ':attribute pu&ograve; contenere solo lettere.',
    'alpha_dash'           => ':attribute pu&ograve; contenere solo lettere, numeri e trattini.',
    'alpha_num'            => ':attribute pu&ograve; contenere solo lettere e numeri.',
    'array'                => ':attribute deve essere un array.',
    'before'               => ':attribute deve essere una data precedente a :date.',
    'between'              => [
        'numeric' => ':attribute deve essere compreso tra :min e :max.',
        'file'    => ':attribute deve essere compreso tra :min e :max kilobytes.',
        'string'  => ':attribute deve essere compreso tra :min e :max caratteri.',
        'array'   => ':attribute deve contenere minimo :min e massimo :max elementi.',
    ],
    'boolean'              => ':attribute deve essere true o false.',
    'confirmed'            => ':attribute di conferma non corrisponde.',
    'date'                 => ':attribute non &egrave; una data valida.',
    'date_format'          => ':attribute non &egrave; nel formato :format.',
    'different'            => ':attribute e :other devono essere diversi.',
    'digits'               => ':attribute deve contenere :digits cifre.',
    'digits_between'       => ':attribute deve contenere minimo :min e massimo :max cifre.',
    'distinct'             => ':attribute ha un valore duplicato.',
    'email'                => ':attribute deve essere un indirizzo e-mail valido.',
    'exists'               => ':attribute non &egrave; valido.',
    'filled'               => ':attribute -> campo richiesto.',
    'image'                => ':attribute deve essere un\'immagine.',
    'in'                   => ':attribute non &egrave; valido.',
    'in_array'             => ':attribute non esiste in :other.',
    'integer'              => ':attribute deve essere un numero intero.',
    'ip'                   => ':attribute deve essere un indirizzo IP valido.',
    'json'                 => ':attribute deve essere una stringa JSON.',
    'max'                  => [
        'numeric' => ':attribute non pu&ograve; essere maggiore di :max.',
        'file'    => ':attribute non pu&ograve; essere maggiore di :max kilobytes.',
        'string'  => ':attribute non pu&ograve; essere maggiore di :max caratteri.',
        'array'   => ':attribute non pu&ograve; contenere pi&ugrave; di :max elementi.',
    ],
    'mimes'                => ':attribute deve essere un file di tipo: :values.',
    'min'                  => [
        'numeric' => ':attribute deve essere minimo :min.',
        'file'    => ':attribute deve essere almeno di :min kilobytes.',
        'string'  => ':attribute deve contenere almeno :min caratteri.',
        'array'   => ':attribute deve contenere minimo :min elementi.',
    ],
    'not_in'               => ':attribute non &egrave; valido.',
    'numeric'              => ':attribute deve essere un numero.',
    'regex'                => 'il formato di :attribute non &egrave; valido.',
    'required'             => ':attribute -> campo richiesto.',
    'required_if'          => ':attribute -> campo richiesto se :other &egrave; :value.',
    'required_unless'      => ':attribute -> campo richiesto salvo che :other &egrave; compreso in :values.',
    'required_with'        => ':attribute -> campo richiesto quando &egrave; presente :values.',
    'required_with_all'    => ':attribute -> campo richiesto quando &egrave; presente :values.',
    'required_without'     => ':attribute -> campo richiesto quando non &egrave; presente :values.',
    'required_without_all' => ':attribute -> campo richiesto quando nessuno dei valori :values &egrave; presente.',
    'same'                 => ':attribute e :other devono combaciare.',
    'size'                 => [
        'numeric' => ':attribute deve essere :size.',
        'file'    => ':attribute deve essere di :size kilobytes.',
        'string'  => ':attribute deve avere :size caratteri.',
        'array'   => ':attribute deve contenere :size elementi.',
    ],
    'string'               => ':attribute deve essere una stringa.',
    'timezone'             => ':attribute deve essere una zona valida.',
    'unique'               => ':attribute non disponibile.',
    'url'                  => ':attribute -> formato non valido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
