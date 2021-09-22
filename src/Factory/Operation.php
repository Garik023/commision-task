<?php

declare(strict_types=1);

namespace CommissionTask\Factory;

use CommissionTask\Model\{Operation as OperationModel, User as UserModel};

/**
 * Interface Operation.
 */
interface Operation
{
    /**
     * Stores Operation instance in storage.
     *
     * @return mixed
     */
    public function save(OperationModel $operation);

    public function getUserWithdrawForWeekStart(UserModel $user, string $weekStart): array;

}
