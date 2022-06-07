<?php

declare(strict_types=1);

namespace App\Helpers;

final class AppHelper
{
    /**
     * @param integer $value
     * @return string
     */
    public static function getCircleSymbol(int $value): string
    {
        return ($value) ? '○' : '';
    }

    /**
     * @param integer $price
     * @return string
     */
    public static function getPriceFormat(int $price): string
    {
        return '¥' . number_format($price);
    }
}
