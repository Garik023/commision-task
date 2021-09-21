<?php

declare(strict_types=1);

namespace CommissionTask\Exception\Validation\Operation;

use CommissionTask\Exception\Validation\ValidationException;
use Throwable;

/**
 * Operation Date validation exception.
 */
class InvalidDate extends ValidationException
{
    /**
     * InvalidDate constructor.
     *
     * @param int $code
     */
    public function __construct(string $date = '', $code = 0, Throwable $previous = null)
    {
        $exceptionMessage = $this->generateExceptionMessageWithInvalidDate($date);

        parent::__construct($exceptionMessage, $code, $previous);
    }

    protected function generateExceptionMessageWithInvalidDate(string $invalidDate): string
    {
        return "Invalid date or format = {$invalidDate}";
    }
}
