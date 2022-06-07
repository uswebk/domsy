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
    public static function getFormattedDateSlash(\Carbon\Carbon $date): string
    {
        return (Carbon::parse($date))->format('Y/m/d');
    }

    /**
     * @param \Carbon\Carbon $date
     * @return string
     */
    public static function getFormattedDateHyphen(\Carbon\Carbon $date): string
    {
        return (Carbon::parse($date))->format('Y-m-d');
    }
}
