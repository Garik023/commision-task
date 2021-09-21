<?php

declare(strict_types=1);

namespace CommissionTask\Factory\Validator;

use CommissionTask\Contract\Validator\User as UserValidatorContract;
use CommissionTask\Validator\User\MemoryStorage as MemoryStorageUserValidator;

/**
 * User validator factory.
 */
class User
{
    /**
     * Provides with an User validator instance.
     */
    public static function getInstance(): UserValidatorContract
    {
        return MemoryStorageUserValidator::getInstance();
    }
}
