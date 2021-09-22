<?php

declare(strict_types=1);

namespace CommissionTask\Service;

use CommissionTask\Factory\Calendar as CalendarServiceFactory;
use DateTime;

/**
 * Class Calendar.
 * Implements Calendar interface with built-in DateTime PHP components.
 */
class Calendar implements CalendarServiceFactory
{
    const MONDAY_NUM = 1;

    /**
     * Date format from app configs.
     *
     * @var string
     */
    protected string $supportedDateFormat;

    public function __construct(string $supportedDateFormat)
    {
        $this->supportedDateFormat = $supportedDateFormat;
    }

    public function getSupportedDateFormat(): string
    {
        return $this->supportedDateFormat;
    }

    /** {@inheritdoc} */
    public function isMonday(string $date): bool
    {
        $dateTime = $this->formatDate($date);
        $dateDayNum = (int) $dateTime->format('N');
        return $dateDayNum === static::MONDAY_NUM;
    }

    /** {@inheritdoc} */
    public function getStartDayOfWeekForDate(string $date): string
    {
        if ($this->isMonday($date)) {
            return $date;
        }
        $dateTime = $this->formatDate($date);
        return $dateTime->modify('last monday')->format($this->supportedDateFormat);
    }

    /**
     * Converts passed date (string representation) to DateTime instance.
     */
    protected function formatDate(string $date): DateTime
    {
        return DateTime::createFromFormat($this->supportedDateFormat, $date);
    }
}
