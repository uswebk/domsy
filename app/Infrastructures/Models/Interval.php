<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

final class Interval
{
    private const DAY = 'Day';

    private const WEEK = 'Week';

    private const MONTH = 'Month';

    private const YEAR = 'Year';

    private const INTERVAL_LIST = [
        'DAY' => self::DAY,
        'WEEK' => self::WEEK,
        'MONTH' => self::MONTH,
        'YEAR' => self::YEAR,
    ];

    /**
     * @return array
     */
    public static function getIntervalList(): array
    {
        return self::INTERVAL_LIST;
    }
}
