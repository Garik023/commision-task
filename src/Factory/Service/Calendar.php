<?php

declare(strict_types=1);

namespace CommissionTask\Factory\Service;

use CommissionTask\Contract\Service\Calendar as CalendarServiceContract;
use CommissionTask\Factory\Service\Config as ConfigFactory;
use CommissionTask\Service\Calendar as CalendarService;

/**
 * Calendar factory.
 */
class Calendar
{
    /**
     * Provides with a Calendar Service instance.
     */
    public static function getInstance(): CalendarServiceContract
    {
        $supportedDateFormat = ConfigFactory::getInstance()->get('app.format.date');

        return new CalendarService($supportedDateFormat);
    }
}
