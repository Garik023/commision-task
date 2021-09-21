<?php

declare(strict_types=1);

namespace CommissionTask\Factory\Validator;

use CommissionTask\Contract\Validator\Operation as OperationValidatorContract;
use CommissionTask\Validator\Operation\RawInput as RawInputValidator;

/**
 * Operation validator factory.
 */
class Operation
{
    /**
     * Provides with an Operation validator instance.
     */
    public static function getInstance(): OperationValidatorContract
    {
        return RawInputValidator::getInstance();
    }
}
