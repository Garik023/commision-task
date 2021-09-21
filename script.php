<?php

namespace CommissionTask;

require_once 'vendor/autoload.php';

use CommissionTask\Factory\Repository\Operation as OperationRepositoryFactory;
use CommissionTask\Factory\Service\Input\Parser as FileParser;
use CommissionTask\Exception\Validation\Input\InvalidArgumentCount as InvalidArgumentCountException;
use CommissionTask\Exception\Validation\ValidationException;

try {
    // check for file existence
    if (empty($argv[1])) {
        throw new InvalidArgumentCountException('File path has not provided');
    }
    $fileFullPath = realpath($argv[1]);
    $fileParser = FileParser::getInstanceByInput($fileFullPath);
    $operationRepository = OperationRepositoryFactory::getInstance();

    // looping over all operation rows in file
    foreach ($fileParser->operations() as $operation) {
        echo $operation->getFee() . PHP_EOL;
        // saves operation in memory
        $operationRepository->save($operation);
    }
} catch (ValidationException $validationException) {
    $validationException->log();
}
