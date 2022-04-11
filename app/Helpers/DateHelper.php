<?php

declare(strict_types=1);

namespace App\Helpers;

use Carbon\Carbon;

final class DateHelper
{
    public static function getFormattedDate(\Carbon\Carbon $date): string
    {
        $date = Carbon::parse($date);

        return $date->format('Y/m/d');
    }
}
