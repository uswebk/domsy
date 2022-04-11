<?php

declare(strict_types=1);

namespace App\Helpers;

use Carbon\Carbon;

final class DateHelper
{
    public static function getFormattedDate(?\Carbon\Carbon $date): string
    {
        if (! isset($date)) {
            return '';
        }

        return (Carbon::parse($date))->format('Y/m/d');
    }
}
