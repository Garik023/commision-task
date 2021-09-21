<?php

use CommissionTask\Contract\Entity\{
    Currency,
    Operation,
    User
};

return [
    'supported' => [
        // here you may specify supported input formats
        'input' => [
            'file' => [
                'extensions' => [
                    'csv',
                ]
            ]
        ],
        'values_in_row' => 6,
        // list of currency codes supported by the application
        'currencies' => [
            Currency::CURRENCY_EUR,
            Currency::CURRENCY_USD,
            Currency::CURRENCY_JPY,
        ],
        // list of operation types supported by the application
        'operation_types' => [
            Operation::TYPE_DEPOSIT,
            Operation::TYPE_WITHDRAW,
        ],
        // list of user types supported by the application
        'user_types' => [
            User::TYPE_PRIVATE,
            User::TYPE_BUSINESS,
        ],
    ],

    'format' => [
        // specify format for all dates in the App
        'date' => 'Y-m-d',
    ],
    'exchangeRatesApi' =>
        [
            'token' => '376f487d73e145027f4390f2dd2093da',
            'endpoint' => 'http://api.exchangeratesapi.io/v1/latest'
        ],
];