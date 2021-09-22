<?php

declare(strict_types=1);

namespace CommissionTask\Factory;

use CommissionTask\Validation\AppException;
use CommissionTask\Validation\ValidationException;

/**
 * Interface File
 * File validator interface.
 */
interface Validator
{
    /**
     * Validates file argument string.
     *
     * @throws ValidationException
     */
    public function isValidFile(string $file): bool;

    /**
     * @throws ValidationException
     */
    public function isIdValid(string $userId): bool;

    /**
     * @throws ValidationException
     */
    public function isTypeValid(string $userType): bool;

    /**
     * @throws AppException
     */
    public function isDateValid(string $date): bool;

    /**
     * @throws AppException
     */
    public function isOperationTypeValid(string $operationType): bool;

    /**
     * @throws AppException
     */
    public function isAmountValid(string $amount): bool;

    /**
     * @throws AppException
     */
    public function isCurrencyCodeValid(string $currencyCode): bool;
}
