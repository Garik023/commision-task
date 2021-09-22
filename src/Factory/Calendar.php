<?php

declare(strict_types=1);

namespace CommissionTask\Factory;

/**
 * Interface Calendar
 */
interface Calendar
{
    /**
     * Returns supported date formats
     */
    public function getSupportedDateFormat(): string;

    /**
     * Checks the passed date is a Monday or not.
     */
    public function isMonday(string $date): bool;

    /**
     * Returns date of first day of week (Monday) for passed $date.
     */
    public function getStartDayOfWeekForDate(string $date): string;

}
