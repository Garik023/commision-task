<?php

declare(strict_types=1);

namespace CommissionTask\Factory\Validator;

use CommissionTask\Contract\Validator\File as InputValidatorContract;
use CommissionTask\Validator\Input\FileInput as LocalFileValidator;

/**
 * Input validator factory.
 */
class Input
{
    /**
     * Provides with an Input validator instance.
     */
    public static function getInstance(): InputValidatorContract
    {
        return new LocalFileValidator();
    }
}
