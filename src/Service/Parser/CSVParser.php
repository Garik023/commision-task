<?php

declare(strict_types=1);

namespace CommissionTask\Service\Parser;

use CommissionTask\Factory\Service\Config as ConfigFactory;
use Generator;
use CommissionTask\Contract\Service\Input\File\OperationParser as OperationParserContract;
use CommissionTask\Model\AmountCurrency;
use CommissionTask\Exception\Validation\Input\InvalidFilePath as InvalidFilePathException;
use CommissionTask\Exception\Validation\Input\InvalidRow as InvalidRowException;
use CommissionTask\Exception\Validation\ValidationException;
use CommissionTask\Factory\Validator\Input as InputFactory;
use CommissionTask\Model\Operation;
use CommissionTask\Model\User;

/**
 * Class CSVParser.
 * Makes operation instances from csv rows.
 */
class CSVParser implements OperationParserContract
{
    /**
     * File to be operated.
     *
     * @var string
     */
    protected $filePath;

    public function __construct(string $filePath)
    {
        $this->setPathToFile($filePath);
    }

    /** {@inheritdoc} */
    public function getPathToFile(): string
    {
        return $this->filePath;
    }

    /** {@inheritdoc} */
    public function setPathToFile(string $pathToFile)
    {
        if (!InputFactory::getInstance()->isValidFile($pathToFile)) {
            throw new InvalidFilePathException($pathToFile);
        }

        $this->filePath = $pathToFile;
    }

    /** {@inheritdoc} */
    public function operations(): Generator
    {
        $file = fopen($this->filePath, 'rb');
        while (($values = fgetcsv($file)) !== false) {
            // values count in row
            $valuesInRow = ConfigFactory::getInstance()->get('app.supported.values_in_row');
            if (count($values) < $valuesInRow) {
                throw new InvalidRowException(implode(',', $values));
            }
            yield $this->makeNewOperationInstanceFromRawInput($values);
        }
        fclose($file);
    }

    /**
     * Makes new instance of Operation data structure from $rawInput (single row columns).
     * Throws exception if at least one of values is invalid.
     *
     * @throws ValidationException
     */
    private function makeNewOperationInstanceFromRawInput(array $rawInput): Operation
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
