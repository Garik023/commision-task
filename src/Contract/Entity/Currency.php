<?php

declare(strict_types=1);

namespace CommissionTask\Contract\Entity;

/**
 * Currency entity interface.
 */
interface Currency
{
    const CURRENCY_EUR = 'eur';
    const CURRENCY_USD = 'usd';
    const CURRENCY_JPY = 'jpy';

    const SUPPORTED_CURRENCIES = [
        self::CURRENCY_EUR,
        self::CURRENCY_USD,
        self::CURRENCY_JPY,
    ];
}
