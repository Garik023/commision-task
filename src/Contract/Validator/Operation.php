<?php

declare(strict_types=1);

namespace CommissionTask\Contract\Validator;

use CommissionTask\Exception\Validation\{
    Amount\InvalidNumber as InvalidAmountNumberException,
    Currency\InvalidCode as InvalidCurrencyCodeException,
    Operation\InvalidDate as InvalidOperationDateException,
    Operation\InvalidType as InvalidOperationTypeException
};

/**
 * Interface Operation
 * Describes an operation validator component's interface.
 */
interface Operation
{
    /**
     * @throws InvalidOperationDateException
     */
    public function isDateValid(string $date): bool;

    /**
     * @throws InvalidOperationTypeException
     */
    public function isOperationTypeValid(string $operationType): bool;

    /**
     * @throws InvalidAmountNumberException
     */
    public function isAmountValid(string $amount): bool;

    /**
     * @throws InvalidCurrencyCodeException
     */
    public function isCurrencyCodeValid(string $currencyCode): bool;
}
