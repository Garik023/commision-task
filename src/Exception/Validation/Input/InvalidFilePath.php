<?php

declare(strict_types=1);

namespace CommissionTask\Exception\Validation\Input;

use CommissionTask\Exception\Validation\ValidationException;
use Throwable;

/**
 * Input file path validation exception.
 */
class InvalidFilePath extends ValidationException
{
    /**
     * InvalidFilePath constructor.
     *
     * @param int $code
     */
    public function __construct(string $filePath = '', $code = 0, Throwable $previous = null)
    {
        $exceptionMessage = $this->generateExceptionMessageWithInvalidFilePath($filePath);

        parent::__construct($exceptionMessage, $code, $previous);
    }

    protected function generateExceptionMessageWithInvalidFilePath(string $invalidFilePath): string
    {
        return "Invalid file path provided {$invalidFilePath}";
    }
}
