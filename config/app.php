<?php
return [
    'formats' => [
        // supported data formats in file (extension, date format, values in each row)
        'file' => [
            'extensions' => [
                'csv',
            ],
            'values_in_row' => 6,
            'date' => 'Y-m-d',
        ]
    ],
    'scale' => 2,
    'exchangeRatesApi' =>
        [
            'token' => '376f487d73e145027f4390f2dd2093da',
            'endpoint' => 'http://api.exchangeratesapi.io/v1/latest'
        ],
];