<?php

declare(strict_types=1);

namespace App\Enums;

enum Interval: string
{
    case DAY = 'Day';
    case WEEK = 'Week';
    case MONTH = 'Month';
    case YEAR = 'Year';
}
