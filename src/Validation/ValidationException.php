<?php

declare(strict_types=1);

namespace CommissionTask\Validation;

abstract class ValidationException extends \Exception
{
    /**
     * Prints validation error's message.
     */
    public function log()
    {
        echo $this->message.PHP_EOL;
    }
}
