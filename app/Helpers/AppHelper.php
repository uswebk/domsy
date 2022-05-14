<?php

declare(strict_types=1);

namespace App\Helpers;

final class AppHelper
{
    public static function getCircleSymbol(int $value): string
    {
        return ($value) ? '○' : '';
    }

    public static function getPrice(int $price): string
    {
        return '￥' . number_format($price);
    }
}
