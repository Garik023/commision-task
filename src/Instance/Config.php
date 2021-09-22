<?php

declare(strict_types=1);

namespace CommissionTask\Instance;

use CommissionTask\Factory\Config as ConfigAccessorFactory;
use CommissionTask\Service\Config as ConfigService;

/**
 * Make Config instance
 */
class Config
{

    public static function getInstance(): ConfigAccessorFactory
    {
        return ConfigService::getInstance();
    }
}
