<?php

declare(strict_types=1);

namespace CommissionTask\Model;

use CommissionTask\Validation\AppException;
use CommissionTask\Instance\Validator as ValidatorInstance;

/**
 * Class AmountCurrency.
 *
 */
class AmountCurrency
{
    const CURRENCY_EUR = 'eur';
    const CURRENCY_USD = 'usd';
    const CURRENCY_JPY = 'jpy';

    const SUPPORTED_CURRENCIES = [
        self::CURRENCY_EUR,
        self::CURRENCY_USD,
        self::CURRENCY_JPY,
    ];

    /**
     * Operation amount.
     *
     * @var string
     */
    protected $amount;

    /**
     * Operation currency.
     *
     * @var string
     */
    protected $currency;

    /**
     * AmountCurrency constructor.
     */
    public function __construct(string $amount, string $currency)
    {
        $this->setAmount($amount);
        $this->setCurrency($currency);
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     *
     * @throws AppException
     */
    public function setAmount(string $amount)
    {
        if (!ValidatorInstance::getInstance()->isAmountValid($amount)) {
            throw new AppException(AppException::AMOUNT_NUMBER_INVALID, $amount);
        }
        $this->amount = $amount;
    }

    /**
     *
     * @throws AppException
     */
    public function setCurrency(string $currencyCode)
    {
        $currencyCode = strtolower($currencyCode);

        if (!ValidatorInstance::getInstance()->isCurrencyCodeValid($currencyCode)) {
            throw new AppException(AppException::CURRENCY_INVALID, $currencyCode);
        }

        $this->currency = $currencyCode;
    }


}
