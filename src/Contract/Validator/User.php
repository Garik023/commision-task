<?php

declare(strict_types=1);

namespace CommissionTask\Contract\Validator;

use CommissionTask\Exception\Validation\User\{
    InvalidId as InvalidUserIdException,
    InvalidType as InvalidUserTypeException
};

/**
 * Interface User
 * Describes an user validator component's interface.
 */
interface User
{
    /**
     * @throws InvalidUserIdException
     */
    public function isIdValid(string $userId): bool;

    /**
     * @throws InvalidUserTypeException
     */
    public function isTypeValid(string $userType): bool;
}
