<?php

use CommissionTask\Model\{User, Operation};
use CommissionTask\Service\FeePolicy\{
    Deposit\DepositFeePolicy,
    Withdraw\BusinessFeePolicy,
    Withdraw\PrivateFeePolicy
};

return [
    /*
    |--------------------------------------------------------------------------
    | Configuration for fee operations
    |
    */
    'operation_type' => [
        Operation::TYPE_DEPOSIT => [
            'user_type' => [
                User::TYPE_PRIVATE => [
                    'policy' => DepositFeePolicy::POLICY_NAME,
                ],
                User::TYPE_BUSINESS => [
                    'policy' => DepositFeePolicy::POLICY_NAME,
                ]
            ]
        ],

        Operation::TYPE_WITHDRAW => [
            'user_type' => [
                User::TYPE_PRIVATE => [
                    'policy' => PrivateFeePolicy::POLICY_NAME,
                ],
                User::TYPE_BUSINESS => [
                    'policy' => BusinessFeePolicy::POLICY_NAME,
                ]
            ]
        ]
    ]
];
