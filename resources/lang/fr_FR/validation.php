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

    'accepted'             => 'Le :attribute doit être accepté.',
    'active_url'           => 'Le :attribute n\'est pas une URL valide.',
    'after'                => 'Le :attribute doit être une date après :date.',
    'alpha'                => 'Le :attribute ne peut contenir que letters.',
    'alpha_dash'           => 'Le :attribute ne peut contenir que des lettres, chiffres et tirets.',
    'alpha_num'            => 'Le :attribute ne peut contenir que des lettres et des chiffres.',
    'array'                => 'Le :attribute doit être un tableau.',
    'before'               => 'Le :attribute doit être une date avant :date.',
    'between'              => [
        'numeric' => 'Le :attribute doit être entre :min et :max.',
        'file'    => 'Le :attribute doit être entre :min et :max kilobytes.',
        'string'  => 'Le :attribute doit être entre :min et :max caractères.',
        'array'   => 'The :attribute doit être entre :min et :max éléments.',
    ],
    'boolean'              => 'Le :attribute champ doit être vrai ou faux.',
    'confirmed'            => 'Le :attribute confirmation ne correspond pas.',
    'date'                 => 'Le :attribute n\'est pas une date valide',
    'date_format'          => 'Le :attribute ne correspond pas au format :format.',
    'different'            => 'Le :attribute et :other doivent être différent.',
    'digits'               => 'Le :attribute doit être :digits chiffres.',
    'digits_between'       => 'Le :attribute doit être entre :min et :max chiffres.',
    'distinct'             => 'Le :attribute champ a une valeur en double.',
    'email'                => 'Le :attribute doit être une adresse e-mail valide.',
    'exists'               => 'Le :attribute choisi n\'est pas valide.',
    'filled'               => 'Le :attribute champ est requis.',
    'image'                => 'Le :attribute doit être une image.',
    'in'                   => 'Le :attribute choisi n\'est pas valide.',
    'in_array'             => 'Le champ :attribute n\'existe pas dans :other.',
    'integer'              => 'Le :attribute doit être un nombre entier.',
    'ip'                   => 'Le :attribute doit être une adresse IP valide.',
    'json'                 => 'Le :attribute doit être une chaîne JSON valide.',
    'max'                  => [
        'numeric' => 'Le :attribute ne peut pas être supérieur à :max.',
        'file'    => 'Le :attribute ne peut pas être supérieur à :max kilobytes.',
        'string'  => 'Le :attribute ne peut pas être supérieur à :max caractères.',
        'array'   => 'Le :attribute ne peut pas être supérieur à :max éléments.',
    ],
    'mimes'                => 'Le :attribute doit être un fichier de type: :values.',
    'min'                  => [
        'numeric' => 'Le :attribute doit être au moins :min.',
        'file'    => 'Le :attribute doit être au moins :min kilobytes.',
        'string'  => 'The :attribute doit être au moins :min caractères.',
        'array'   => 'The :attribute doit avoir au moins :min éléments.',
    ],
    'not_in'               => 'L\' :attribute sélectionné n\'est pas valide.',
    'numeric'              => 'Le :attribute doit être un nombre.',
    'regex'                => 'Le :attribute format n\'est pas valide.',
    'required'             => 'Le champ :attribute est requis.',
    'required_if'          => 'Le champ :attribute est requis quand :other est :value.',
    'required_unless'      => 'Le champ :attribute est requis sauf si :other est dans :values.',
    'required_with'        => 'Le champ :attribute est requis quand :values est défini.',
    'required_with_all'    => 'Le champ :attribute est requis quand :values est défini.',
    'required_without'     => 'Le champ :attribute est requis quand :values n\'est pas défini.',
    'required_without_all' => 'Le champ :attribute est requis lorsque aucun de :values sont définis.',
    'same'                 => 'Le :attribute et :other doit correspondre.',
    'size'                 => [
        'numeric' => 'Le :attribute doit être :size.',
        'file'    => 'Le :attribute doit être :size kilobytes.',
        'string'  => 'Le :attribute doit être :size caractères.',
        'array'   => 'Le :attribute doit contenir :size éléments.',
    ],
    'string'               => 'Le :attribute oit être une chaîne de caractères.',
    'timezone'             => 'Le :attribute doit être une zone valide.',
    'unique'               => 'Le :attribute a déjà été pris.',
    'url'                  => 'Le :attribute Le format n\'est pas valide.',

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
            'rule-name' => 'message personnalisé',
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
