<?php

declare(strict_types=1);

namespace CommissionTask\Contract\Entity;

/**
 * Operation entity interface.
 */
interface Operation
{
    const TYPE_DEPOSIT = 'deposit';
    const TYPE_WITHDRAW = 'withdraw';

    const OPERATION_TYPES = [
        self::TYPE_DEPOSIT,
        self::TYPE_WITHDRAW,
    ];
}
