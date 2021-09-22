<?php

declare(strict_types=1);

namespace CommissionTask\Instance;

use CommissionTask\Service\RateAPI as RateService;

/**
 * Make Math instance
 */
class RateAPI
{

    public static function getInstance(): RateService
    {
        return new RateService();
    }
}
