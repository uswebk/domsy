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

    /**
     * @param \Carbon\Carbon $targetDate
     * @param integer $interval
     * @param string $intervalCategory
     * @return \Carbon\Carbon
     */
    public static function getDateByIntervalIntervalCategory(
        \Carbon\Carbon $_targetDate,
        int $interval,
        string $intervalCategory
    ): \Carbon\Carbon {
        $targetDate = $_targetDate->copy();

        if ($intervalCategory == 'DAY') {
            return $targetDate->addDays($interval);
        }

        if ($intervalCategory == 'WEEK') {
            return $targetDate->addWeeks($interval);
        }

        if ($intervalCategory == 'MONTH') {
            return $targetDate->addMonths($interval);
        }

        if ($intervalCategory == 'YEAR') {
            return $targetDate->addYears($interval);
        }
    }
}
