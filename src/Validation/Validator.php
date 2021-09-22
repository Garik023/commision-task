<?php

declare(strict_types=1);

namespace CommissionTask\Validation;

use CommissionTask\Model\AmountCurrency;
use CommissionTask\Model\Operation;
use CommissionTask\Model\User;
use CommissionTask\Factory\Validator as ValidatorFactory;
use CommissionTask\Instance\Calendar as CalendarFactory;
use CommissionTask\Instance\Config as ConfigFactory;
use DateTime;

/**
 * Class FileInput.
 */
class Validator implements ValidatorFactory
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
    public static function getInstance(): self
    {
        $className = static::class;
        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new static();
        }
        return self::$instances[$className];
    }

    /** {@inheritdoc} */
    public function isValidFile(string $file): bool
    {
        // checks path to valid file.
        if (is_file($file) && is_readable($file)) {
            // get allowed file extensions
            $supportedFileExtensions = ConfigFactory::getInstance()->get('app.formats.file.extensions');
            // get extension of target file
            $targetFileExtension = pathinfo($file, PATHINFO_EXTENSION);

            if (in_array($targetFileExtension, $supportedFileExtensions, true)) {
                return true;
            }
        }

        return false;
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
        $supportedCurrencyCodes = AmountCurrency::SUPPORTED_CURRENCIES;
        return in_array($currencyCode, $supportedCurrencyCodes, true);
    }

    /** {@inheritdoc} */
    public function isIdValid(string $userId): bool
    {
        // could not check for existence due to In Memory storage
        return is_numeric($userId);
    }

    /** {@inheritdoc} */
    public function isTypeValid(string $userType): bool
    {
        $supportedUserTypes = User::USER_TYPES;
        return in_array($userType, $supportedUserTypes, true);
    }

}
