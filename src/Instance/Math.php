<?php

declare(strict_types=1);

namespace CommissionTask\Instance;

use CommissionTask\Service\Math as MathService;

/**
 * Make Math instance
 */
class Math
{

    public static function getInstance(): MathService
    {
        return new MathService();
    }
}
