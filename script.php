<?php

namespace CommissionTask;

require_once 'vendor/autoload.php';

use CommissionTask\Validation\AppException;
use CommissionTask\Instance\{
    Operation as OperationRepositoryInstance,
    Parser as FileParser
};
use CommissionTask\Validation\ValidationException;

try {
    // check for file existence
    if (empty($argv[1])) {
        throw new AppException(AppException::FILE_PATH_NOT_PROVIDED);
    }
    $fileFullPath = realpath($argv[1]);
    $fileParser = FileParser::getInstanceByInput($fileFullPath);
    $operationRepository = OperationRepositoryInstance::getInstance();

    // looping over all operation rows in file
    foreach ($fileParser->operations() as $operation) {
        /* @var $operation \CommissionTask\Model\Operation */
        echo $operation->getFee() . PHP_EOL;
        // saves operation in memory
        $operationRepository->save($operation);
    }
} catch (ValidationException $validationException) {
    $validationException->log();
}
