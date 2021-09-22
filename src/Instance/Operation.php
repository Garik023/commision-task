<?php

declare(strict_types=1);

namespace CommissionTask\Instance;

use CommissionTask\Factory\Operation as OperationRepositoryFactory;
use CommissionTask\Repository\Operation as StorageOperationRepository;

/**
 * Make Operation instance
 */
class Operation
{
    public static function getInstance(): OperationRepositoryFactory
    {
        return StorageOperationRepository::getInstance();
    }
}
