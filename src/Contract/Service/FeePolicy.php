<?php

declare(strict_types=1);

namespace CommissionTask\Contract\Service;

use CommissionTask\Model\Operation;

/**
 * Interface FeePolicy.
 */
interface FeePolicy
{
    /**
     * Creates instance of implemented class with parameters defined in configurations.
     */
    public static function getInstance(string $feePercent, array $freeOfCharge): self;

    /**
     * Calculates commission fee for provided operation.
     * Calculation performs based on provided operation, it's user and his history.
     */
    public function getFeeForOperation(Operation $operation);
}
