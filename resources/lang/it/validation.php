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
    'active_url'           => ':attribute non è un URL valido.',
    'after'                => ':attribute deve essere una data successiva a :date.',
    'alpha'                => ':attribute può contenere solo lettere.',
    'alpha_dash'           => ':attribute può contenere solo lettere, numeri, e trattini.',
    'alpha_num'            => ':attribute può contenere solo lettere e numeri.',
    'array'                => ':attribute deve essere un array.',
    'before'               => ':attribute deve essere una data antecedente a :date.',
    'between'              => [
        'numeric' => ':attribute deve essere compreso tra :min e :max.',
        'file'    => ':attribute deve essere compreso tra :min e :max kilobytes.',
        'string'  => ':attribute deve essere compreso tra :min e :max caratteri.',
        'array'   => ':attribute deve essere compreso tra :min e :max items.',
    ],
    'boolean'              => 'Il campo :attribute deve essere vero o falso.',
    'confirmed'            => 'Errore nella conferma del campo :attribute.',
    'date'                 => ':attribute non è una data valida.',
    'date_format'          => ':attribute non è nel giusto formato :format.',
    'different'            => ':attribute e :other devono essere diversi.',
    'digits'               => ':attribute deve essere di :digits caratteri.',
    'digits_between'       => ':attribute deve avere tra :min and :max caratteri.',
    'dimensions'           => ':attribute dimensioni immagine non valide.',
    'distinct'             => 'Il campo :attribute ha un valore duplicato.',
    'email'                => ':attribute deve essere un indirizzo e-mail valido.',
    'exists'               => 'Il :attribute selezionato non è valido.',
    'file'                 => 'Il :attribute deve essere un file.',
    'filled'               => 'Il campo :attribute è richiesto.',
    'image'                => ':attribute deve essere un\'immagine.',
    'in'                   => 'Il :attribute selezionato non è valido.',
    'in_array'             => 'Il campo :attribute non esiste in :other.',
    'integer'              => ':attribute deve essere un numero intero.',
    'ip'                   => ':attribute deve essere un indirizzo IP valido.',
    'json'                 => ':attribute deve essere una stringa in formato json valido.',
    'max'                  => [
        'numeric' => ':attribute non può essere maggiore di :max.',
        'file'    => ':attribute non può essere maggiore di :max kilobytes.',
        'string'  => ':attribute non può essere maggiore di :max caratteri.',
        'array'   => ':attribute non può avere più di :max items.',
    ],
    'mimes'                => ':attribute deve essere un file di tipo: :values.',
    'mimetypes'            => ':attribute deve essere un file di tipo: :values.',
    'min'                  => [
        'numeric' => ':attribute deve essere almeno :min.',
        'file'    => ':attribute deve essere almeno :min kilobytes.',
        'string'  => ':attribute deve essere almeno :min caratteri.',
        'array'   => ':attribute deve avere almeno :min items.',
    ],
    'not_in'               => 'Il :attribute selezionato non è valido.',
    'numeric'              => ':attribute deve essere un numero.',
    'present'              => 'Il campo :attribute deve essere presente.',
    'regex'                => 'Il formato di :attribute non è valido.',
    'required'             => 'Il campo :attribute è obbligatorio.',
    'required_if'          => 'Il campo :attribute è obbligatorio quando :other è :value.',
    'required_unless'      => 'Il campo :attribute è obbligatorio a meno che :other è in :values.',
    'required_with'        => 'Il campo :attribute è obbligatorio quando :values è presente.',
    'required_with_all'    => 'Il campo :attribute è obbligatorio quando :values è presente.',
    'required_without'     => 'Il campo :attribute è obbligatorio quando :values non è presente.',
    'required_without_all' => 'Il campo :attribute è obbligatorio quando nessuno dei :values è presente.',
    'same'                 => ':attribute e :other devono corrispondere.',
    'size'                 => [
        'numeric' => ':attribute deve essere :size.',
        'file'    => ':attribute deve essere :size kilobytes.',
        'string'  => ':attribute deve essere di :size caratteri.',
        'array'   => ':attribute deve contenere :size items.',
    ],
    'string'               => ':attribute deve essere una stringa.',
    'timezone'             => ':attribute deve essere una zona valida.',
    'unique'               => ':attribute già presente in database.',
    'uploaded'             => ':attribute , errore durante l\'upload.',
    'url'                  => ':attribute , formato non valido.',

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
