<?php

declare(strict_types=1);

namespace CommissionTask\Instance;

use CommissionTask\Factory\Parser as ParserFactory;
use CommissionTask\Service\CSVParser;

/**
 * Make Parser instance
 */
class Parser
{
    public static function getInstanceByInput(string $input): ParserFactory
    {
        return new CSVParser($input);
    }
}
