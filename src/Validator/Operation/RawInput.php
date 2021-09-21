<?php

declare(strict_types=1);

namespace CommissionTask\Validator\Operation;

use CommissionTask\Contract\Entity\Currency;
use CommissionTask\Contract\Entity\Operation;
use DateTime;
use CommissionTask\Contract\Validator\Operation as OperationValidatorContract;
use CommissionTask\Exception\Validation\Singleton\WakeUpAttempt as SingletonWakeUpAttemptException;
use CommissionTask\Factory\Service\Calendar as CalendarFactory;

/**
 * Provides a set of methods to validate operation input data.
 */
class RawInput implements OperationValidatorContract
{
    /**
     * @var array
     */
    private static $instances = [];

    /**
     * Hidden constructor in terms of Singleton pattern.
     */
    protected function __construct()
    {
    }

    /**
     * Returns new or existing instance of the RawInput class.
     */
    public static function getInstance(): RawInput
    {
        $className = static::class;

        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new static();
        }

        return self::$instances[$className];
    }

    /** {@inheritdoc} */
    public function isDateValid(string $date): bool
    {
        $supportedDateFormat = CalendarFactory::getInstance()->getSupportedDateFormat();
        $dateTime = DateTime::createFromFormat($supportedDateFormat, $date);
        return $dateTime && $dateTime->format($supportedDateFormat) === $date;
    }

    /** {@inheritdoc} */
    public function isOperationTypeValid(string $operationType): bool
    {
        $supportedOperationTypes = Operation::OPERATION_TYPES;
        return in_array($operationType, $supportedOperationTypes, true);
    }

    /** {@inheritdoc} */
    public function isAmountValid(string $amount): bool
    {
        // amount should be numeric and greater to 0
        return is_numeric($amount) && $amount > 0;
    }

    /** {@inheritdoc} */
    public function isCurrencyCodeValid(string $currencyCode): bool
    {
        $supportedCurrencyCodes = Currency::SUPPORTED_CURRENCIES;
        return in_array($currencyCode, $supportedCurrencyCodes, true);
    }

    /**
     * Prevent object to be restored from a string.
     *
     * @throws SingletonWakeUpAttemptException
     */
    public function __wakeup()
    {
        throw new SingletonWakeUpAttemptException(static::class);
    }

    /**
     * Hidden __clone method in terms of Singleton pattern.
     */
    protected function __clone()
    {
    }
}
