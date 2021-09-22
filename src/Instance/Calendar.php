<?php

declare(strict_types=1);

namespace CommissionTask\Instance;

use CommissionTask\Factory\Calendar as CalendarServiceFactory;
use CommissionTask\Instance\Config as ConfigFactory;
use CommissionTask\Service\Calendar as CalendarService;

/**
 * Make Calendar instance
 */
class Calendar
{
    public static function getInstance(): CalendarServiceFactory
    {
        $supportedDateFormat = ConfigFactory::getInstance()->get('app.formats.file.date');

        return new CalendarService($supportedDateFormat);
    }
}
