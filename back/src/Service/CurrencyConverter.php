<?php

declare(strict_types=1);

namespace App\Service;

use App\Graphql\Enum\CurrencyEnum;

class CurrencyConverter
{
    public function convert(float $price, CurrencyEnum $to): float
    {
        switch ($to) {
            case CurrencyEnum::USD():
                return $price * 1.1;
            case CurrencyEnum::JPY():
                return $price * 129.93;
            case CurrencyEnum::XPF():
                return $price * 120.12;
            default:
            case CurrencyEnum::EUR():
                return $price;
        }
    }
}
