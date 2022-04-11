<?php

declare(strict_types=1);

namespace App\Helpers;

final class AppHelper
{
    public static function getCircleSymbol(int $value): string
    {
        return ($value) ? '○' : '';
    }
}
