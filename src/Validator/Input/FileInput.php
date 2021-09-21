<?php

declare(strict_types=1);

namespace CommissionTask\Validator\Input;

use CommissionTask\Contract\Validator\File as InputValidatorContract;
use CommissionTask\Factory\Service\Config as ConfigFactory;

/**
 * Class FileInput.
 */
class FileInput implements InputValidatorContract
{
    /** {@inheritdoc} */
    public function isValidFile(string $file): bool
    {
        // checks path to valid file.
        if (is_file($file) && is_readable($file)) {
            // get allowed file extensions
            $supportedFileExtensions = ConfigFactory::getInstance()->get('app.supported.input.file.extensions');
            // get extension of target file
            $targetFileExtension = pathinfo($file, PATHINFO_EXTENSION);

            if (in_array($targetFileExtension, $supportedFileExtensions, true)) {
                return true;
            }
        }

        return false;
    }
}
