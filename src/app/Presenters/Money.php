<?php

namespace App\Presenters;

class Money
{
    const CURRENCY = 'EUR';

    public static function toCents(int $price)
    {
        return $price * 1000;
    }

    public static function calculatePriceWithDiscount($price, $discountPercentage)
    {
        return $price - ($price * ($discountPercentage / 100));
    }
}
