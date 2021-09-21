<?php

declare(strict_types=1);

namespace CommissionTask\Factory\Repository;

use CommissionTask\Contract\Repository\Operation as OperationRepositoryContract;
use CommissionTask\Repository\Operation\MemoryStorage as MemoryStorageOperationRepository;

/**
 * Operation factory.
 */
class Operation
{
    /**
     * Provides with an Operation Repository instance.
     */
    public static function getInstance(): OperationRepositoryContract
    {
        return MemoryStorageOperationRepository::getInstance();
    }
}
