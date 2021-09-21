<?php

declare(strict_types=1);

namespace CommissionTask\Service;

use CommissionTask\Contract\Service\Calendar as CalendarServiceContract;
use DateTime;

/**
 * Class Calendar.
 * Implements Calendar interface with built-in DateTime PHP components.
 */
class Calendar implements CalendarServiceContract
{
    const MONDAY_NUM = 1;

    /**
     * Date format supported by the App.
     *
     * @var string
     */
    protected $supportedDateFormat;

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
        $dateTime = $this->convertToDateTimeInstance($date);
        $dateDayNum = (int) $dateTime->format('N');
        return $dateDayNum === static::MONDAY_NUM;
    }

    /** {@inheritdoc} */
    public function getStartDayOfWeekForDate(string $date): string
    {
        if ($this->isMonday($date)) {
            return $date;
        }
        $dateTime = $this->convertToDateTimeInstance($date);
        return $dateTime->modify('last monday')->format($this->supportedDateFormat);
    }

    /**
     * Converts passed date (string representation) to DateTime instance.
     */
    protected function convertToDateTimeInstance(string $date): DateTime
    {
        return DateTime::createFromFormat($this->supportedDateFormat, $date);
    }
}
