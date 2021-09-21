<?php

declare(strict_types=1);

namespace CommissionTask\Contract\Entity;

/**
 * User entity interface.
 */
interface User
{
    const TYPE_PRIVATE = 'private';
    const TYPE_BUSINESS = 'business';

    const USER_TYPES = [
        self::TYPE_PRIVATE,
        self::TYPE_BUSINESS,
    ];
}
