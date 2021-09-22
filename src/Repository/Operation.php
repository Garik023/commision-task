<?php

declare(strict_types=1);

namespace CommissionTask\Repository;

use CommissionTask\Factory\Calendar as CalendarFactory;
use CommissionTask\Factory\Operation as OperationRepositoryFactory;
use CommissionTask\Validation\AppException;
use CommissionTask\Instance\Calendar as CalendarInstance;
use CommissionTask\Model\{
    Operation as OperationModel,
    User as UserModel
};

/**
 * Class Operation for storing data.
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
class Operation implements OperationRepositoryFactory
{
    /**
     *
     * @var array
     */
    protected $storage = [];

    /**
     *
     * @var CalendarFactory
     */
    public $calendarService;

    /**
     * @var array
     */
    private static $instances = [];

    protected function __construct()
    {
        $this->calendarService = CalendarInstance::getInstance();
    }

    /**
     * Returns new or existing instance of the Operation class.
     */
    public static function getInstance(): Operation
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
        $supportedDateFormat = $this->calendarService->getSupportedDateFormat();
        $operationDate = $operation->getDate()->format($supportedDateFormat);
        $weekStartDate = $this->calendarService->getStartDayOfWeekForDate($operationDate);
        $this->storage[$operationUserId][$weekStartDate][] = $operation;
    }

    /**
     * Returns operations array by User and given weekstart date.
     */
    public function getUserWithdrawForWeekStart(UserModel $user, string $weekStart): array
    {
        return  $this->storage[$user->getId()][$weekStart] ?? [];
    }
}
