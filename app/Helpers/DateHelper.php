<?php

declare(strict_types=1);

namespace App\Helpers;

use Carbon\Carbon;

final class DateHelper
{
    /**
     * @param \Carbon\Carbon $date
     * @return string
     */
    public static function getDateStringSlash(\Carbon\Carbon $date): string
    {
        return (Carbon::parse($date))->format('Y/m/d');
    }

    /**
     * @param \Carbon\Carbon $date
     * @return string
     */
    public static function getDateStringHyphen(\Carbon\Carbon $date): string
    {
        return (Carbon::parse($date))->format('Y-m-d');
    }

    /**
     * @param \Carbon\Carbon $date
     * @return string
     */
    public static function getDatetimeStartString(\Carbon\Carbon $date): string
    {
        return (Carbon::parse($date->startOfDay()))->format('Y-m-d H:i:s');
    }
}
