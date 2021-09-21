<?php

declare(strict_types=1);

namespace CommissionTask\Model;

use CommissionTask\Exception\Validation\Amount\InvalidNumber as InvalidAmountNumberException;
use CommissionTask\Exception\Validation\Currency\InvalidCode as InvalidCurrencyCodeException;
use CommissionTask\Factory\Validator\Operation as OperationValidatorFactory;

/**
 * Class AmountCurrency.
 *
 */
class AmountCurrency
{
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
     * @throws InvalidAmountNumberException
     */
    public function setAmount(string $amount)
    {
        if (!OperationValidatorFactory::getInstance()->isAmountValid($amount)) {
            throw new InvalidAmountNumberException($amount);
        }

        $this->amount = $amount;
    }

    /**
     * @throws InvalidCurrencyCodeException
     */
    public function setCurrency(string $currencyCode)
    {
        $currencyCode = strtolower($currencyCode);

        if (!OperationValidatorFactory::getInstance()->isCurrencyCodeValid($currencyCode)) {
            throw new InvalidCurrencyCodeException($currencyCode);
        }

        $this->currency = $currencyCode;
    }


}
