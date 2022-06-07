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
    public static function getFormattedDateSlashSlash(\Carbon\Carbon $date): string
    {
        return (Carbon::parse($date))->format('Y/m/d');
    }

    /**
     * @param \Carbon\Carbon $date
     * @return string
     */
    public static function getFormattedDateSlashHyphen(\Carbon\Carbon $date): string
    {
        return (Carbon::parse($date))->format('Y-m-d');
    }
}
