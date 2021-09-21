<?php

declare(strict_types=1);

namespace CommissionTask\Factory\Service;

use CommissionTask\Contract\Service\Config as ConfigAccessorContract;
use CommissionTask\Service\Config\InFile as InFileConfig;

/**
 * Config factory.
 */
class Config
{
    /**
     * Provides with a Config accessor instance.
     */
    public static function getInstance(): ConfigAccessorContract
    {
        return InFileConfig::getInstance();
    }
}
