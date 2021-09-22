<?php

declare(strict_types=1);

namespace CommissionTask\Instance;

use CommissionTask\Factory\Validator as ValidatorFactory;
use CommissionTask\Validation\Validator as AppValidator;

/**
 * Make Validator instance
 */
class Validator
{
    public static function getInstance(): ValidatorFactory
    {
        return AppValidator::getInstance();
    }
}
