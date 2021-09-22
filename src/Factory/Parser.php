<?php

declare(strict_types=1);

namespace CommissionTask\Factory;

use Generator;
use CommissionTask\Validation\ValidationException;
use CommissionTask\Model\Operation;

/**
 * Interface OperationParser
 * Describes an input file parser's interface.
 * Provides with a method to iterate file row by row producing Operations.
 */
interface Parser
{
    /**
     * Returns full path to the input file.
     */
    public function getPathToFile(): string;

    /**
     * Loops over file rows and Makes new Operation from row of file
     *
     * @throws ValidationException
     */
    public function operations();
}
