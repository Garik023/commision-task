<?php

use CommissionTask\Contract\Entity\Currency;
use CommissionTask\Service\FeePolicy\{
    Deposit\DepositFeePolicy,
    Withdraw\BusinessFeePolicy,
    Withdraw\PrivateFeePolicy
};

return [
    /*
    |--------------------------------------------------------------------------
    | Configuration for fee policies
    |
    */
    DepositFeePolicy::POLICY_NAME => [
        'percent' => '0.03',
        'policy_handler' => DepositFeePolicy::class,
        'free_of_charge' => []
    ],

    BusinessFeePolicy::POLICY_NAME => [
        'percent' => '0.5',
        'policy_handler' => BusinessFeePolicy::class,
        'free_of_charge' => []
    ],

    PrivateFeePolicy::POLICY_NAME => [
        'percent' => '0.3',
        'policy_handler' => PrivateFeePolicy::class,
        'free_of_charge' => [
            'amount' => '1000',
            'currency' => Currency::CURRENCY_EUR,
            'free_operation_limit' => '3',
        ],
    ],
];
