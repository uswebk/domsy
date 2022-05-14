<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Carbon;

final class DateHelper
{
    public static function getFormattedDate(?\Illuminate\Support\Carbon $date): string
    {
        if (! isset($date)) {
            return '';
        }

        return (Carbon::parse($date))->format('Y/m/d');
    }

    public static function getFormattedDateHyphen(?\Illuminate\Support\Carbon $date): string
    {
        if (! isset($date)) {
            return '';
        }

        return (Carbon::parse($date))->format('Y-m-d');
    }
}
