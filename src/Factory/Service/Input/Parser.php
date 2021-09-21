<?php

declare(strict_types=1);

namespace CommissionTask\Factory\Service\Input;

use CommissionTask\Contract\Service\Input\File\OperationParser as OperationParserContract;
use CommissionTask\Service\Parser\CSVParser;

class Parser
{
    /**
     * Gets Parser instance for reading file input
     */
    public static function getInstanceByInput(string $input): OperationParserContract
    {
        return new CSVParser($input);
    }
}
