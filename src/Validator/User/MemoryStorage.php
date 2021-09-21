<?php

declare(strict_types=1);

namespace CommissionTask\Validator\User;

use CommissionTask\Contract\Validator\User as UserValidator;
use CommissionTask\Contract\Entity\User;
use CommissionTask\Exception\Validation\Singleton\WakeUpAttempt as SingletonWakeUpAttemptException;

/**
 * Provides a set of methods to validate user input data.
 */
class MemoryStorage implements UserValidator
{
    /**
     * @var array
     */
    private static $instances = [];

    /**
     * Hidden constructor in terms of Singleton pattern.
     */
    protected function __construct()
    {
    }

    /**
     * Returns new or existing instance of the MemoryStorage class.
     */
    public static function getInstance(): MemoryStorage
    {
        $className = static::class;

        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new static();
        }

        return self::$instances[$className];
    }

    /** {@inheritdoc} */
    public function isIdValid(string $userId): bool
    {
        // could not check for existence due to In Memory storage
        return is_numeric($userId);
    }

    /** {@inheritdoc} */
    public function isTypeValid(string $userType): bool
    {
        $supportedUserTypes = User::USER_TYPES;
        return in_array($userType, $supportedUserTypes, true);
    }

    /**
     * Prevent object to be restored from a string.
     *
     * @throws SingletonWakeUpAttemptException
     */
    public function __wakeup()
    {
        throw new SingletonWakeUpAttemptException(static::class);
    }

    /**
     * Hidden __clone method in terms of Singleton pattern.
     */
    protected function __clone()
    {
    }
}
