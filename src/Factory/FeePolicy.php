<?php

declare(strict_types=1);

namespace CommissionTask\Factory;

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
     * Calculates commission fee for provided operation based on user
     *
     */
    public function getFeeForOperation(Operation $operation);
}
