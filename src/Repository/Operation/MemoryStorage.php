<?php

declare(strict_types=1);

namespace CommissionTask\Repository\Operation;

use CommissionTask\Contract\Repository\Operation as OperationRepositoryContract;
use CommissionTask\Exception\Validation\Singleton\WakeUpAttempt as SingletonWakeUpAttemptException;
use CommissionTask\Factory\Service\Calendar as CalendarServiceFactory;
use CommissionTask\Model\{
    Operation as OperationModel,
    User as UserModel
};


/**
 * Class MemoryStorage for storing data.
 * Operations are indexed by composite Key "User ID" => "Week start date of operation date".
 *
 * Example:
 * [
 *      '1' => [
 *          '2021-09-20' => [
 *             // operations date might be from '2021-09-20' to '2021-09-26'
 *          ]
 *      ]
 * ]
 *
 */
class MemoryStorage implements OperationRepositoryContract
{
    /**
     * In-Memory storage.
     *
     * @var array
     */
    protected $storage = [];
    public $calendarService;

    /**
     * @var array
     */
    private static $instances = [];

    protected function __construct()
    {
        $this->calendarService = CalendarServiceFactory::getInstance();
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

    /**
     * Saves operation in storage
     * {@inheritdoc}
     */
    public function save(OperationModel $operation)
    {
        $operationUserId = $operation->getUser()->getId();
        $supportedDateFormat = CalendarServiceFactory::getInstance()->getSupportedDateFormat();
        $operationDate = $operation->getDate()->format($supportedDateFormat);
        $weekStartDate = $this->calendarService->getStartDayOfWeekForDate($operationDate);
        $this->storage[$operationUserId][$weekStartDate][] = $operation;
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

    /**
     * Returns operations array by User and given weekstart date.
     */
    public function getUserWithdrawForWeekStart(UserModel $user, string $weekStart): array
    {
        return  $this->storage[$user->getId()][$weekStart] ?? [];
    }
}
