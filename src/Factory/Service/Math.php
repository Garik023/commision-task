<?php

declare(strict_types=1);

namespace CommissionTask\Factory\Service;

use CommissionTask\Factory\Service\Config as ConfigFactory;
use CommissionTask\Service\Math as MathService;

/**
 * Math service factory.
 */
class Math
{
    /**
     * Provides with a Math Component instance.
     */
    public static function getInstance(): MathService
    {
        $mathServiceScale = ConfigFactory::getInstance()->get('math.scale');

        return new MathService($mathServiceScale);
    }
}
