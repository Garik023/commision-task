<?php

declare(strict_types=1);

namespace CommissionTask\Contract\Validator;

use CommissionTask\Exception\Validation\ValidationException;

/**
 * Interface File
 * File validator interface.
 */
interface File
{
    /**
     * Validates file argument string.
     *
     * @throws ValidationException
     */
    public function isValidFile(string $file): bool;
}
