<?php
declare(strict_types=1);

namespace CommissionTask\Validation;

use Throwable;

class AppException extends ValidationException
{
    const INVALID_VALIDATION_METHOD = 'invalidValidationMethod';
    const FILE_PATH_NOT_PROVIDED = 'filePathNotProvided';
    const ROW_INVALID = 'rowInvalid';
    const FILE_PATH_INVALID = 'filePathInvalid';
    const AMOUNT_NUMBER_INVALID = 'numberInvalid';
    const CURRENCY_INVALID = 'currencyInvalid';
    const OPERATION_DATE_INVALID = 'operationDateInvalid';
    const OPERATION_TYPE_INVALID = 'operationTypeInvalid';
    const USER_ID_INVALID = 'userIdInvalid';
    const USER_TYPE_INVALID = 'userTypeInvalid';

    const EXCEPTION_MESSAGES = [
        self::INVALID_VALIDATION_METHOD => 'Invalid Validation Method',
        self::FILE_PATH_NOT_PROVIDED => 'File path has been not provided',
        self::FILE_PATH_INVALID => 'Invalid file path',
        self::ROW_INVALID => 'Invalid row in the file',
        self::AMOUNT_NUMBER_INVALID => 'Incorrect number for amount',
        self::CURRENCY_INVALID => 'Unsupported currency',
        self::OPERATION_DATE_INVALID => 'Invalid date or format',
        self::OPERATION_TYPE_INVALID => 'Unsupported operation type',
        self::USER_ID_INVALID => 'Invalid User ID',
        self::USER_TYPE_INVALID => 'Invalid User Type',
    ];

    public function __construct(string $method, string $optionalMessage = '', $code = 0, Throwable $previous = null)
    {
        $message = self::EXCEPTION_MESSAGES[$method] ?? 'Exception not found';
        if ($optionalMessage) {
            $message .= " - $optionalMessage";
        }
        parent::__construct($message, $code, $previous);
    }



}