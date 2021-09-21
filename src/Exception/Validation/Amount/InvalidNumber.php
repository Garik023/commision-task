<?php

declare(strict_types=1);

namespace CommissionTask\Exception\Validation\Amount;

use CommissionTask\Exception\Validation\ValidationException;
use Throwable;

/**
 * Amount number validation exception.
 */
class InvalidNumber extends ValidationException
{
    /**
     * InvalidNumber constructor.
     *
     * @param int $code
     */
    public function __construct(string $amountNumber = '', $code = 0, Throwable $previous = null)
    {
        $exceptionMessage = $this->generateExceptionMessageWithInvalidAmountNumber($amountNumber);

        parent::__construct($exceptionMessage, $code, $previous);
    }

    protected function generateExceptionMessageWithInvalidAmountNumber(string $invalidAmountNumber): string
    {
        return "Incorrect number for Amount {$invalidAmountNumber}";
    }
}
