<?php

declare(strict_types=1);

namespace CommissionTask\Service;

use CommissionTask\Validation\AppException;
use CommissionTask\Instance\Config as ConfigFactory;
use CommissionTask\Factory\Parser as ParserContract;
use CommissionTask\Model\AmountCurrency;
use CommissionTask\Instance\Validator as ValidatorFactory;
use CommissionTask\Model\Operation;
use CommissionTask\Model\User;

/**
 * Class CSVParser.
 * Makes operation instances from csv rows.
 */
class CSVParser implements ParserContract
{
    /**
     * File to be operated.
     *
     * @var string
     */
    protected $filePath;

    /**
     *
     * @throws AppException
     */
    public function __construct(string $filePath)
    {
        if (!ValidatorFactory::getInstance()->isValidFile($filePath)) {
            throw new AppException(AppException::FILE_PATH_INVALID, $filePath);
        }
        $this->filePath = $filePath;
    }

    public function getPathToFile(): string
    {
        return $this->filePath;
    }

    /**
     * Loops over file rows and Makes new Operation from row of file
     *
     * @throws AppException
     */
    public function operations()
    {
        $file = fopen($this->filePath, 'rb');
        while (($values = fgetcsv($file)) !== false) {
            // values count in row
            $valuesInRow = ConfigFactory::getInstance()->get('app.formats.file.values_in_row');
            if (count($values) < $valuesInRow) {
                throw new AppException(AppException::ROW_INVALID, implode(',', $values));
            }
            yield $this->makeOperationFromRaw($values);
        }
        fclose($file);
    }

    /**
     * Makes new Operation from row of file
     *
     */
    private function makeOperationFromRaw(array $rawInput): Operation
    {
        $date = $rawInput[0];
        $userId = $rawInput[1];
        $userType = $rawInput[2];
        $operationType = $rawInput[3];
        $amount = $rawInput[4];
        $currency = $rawInput[5];
        $user = new User($userId, $userType);
        $amountCurrency = new AmountCurrency($amount, $currency);
        return new Operation($date, $operationType, $user, $amountCurrency);
    }
}
