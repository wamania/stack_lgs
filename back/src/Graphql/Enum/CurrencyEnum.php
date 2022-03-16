<?php

declare(strict_types=1);

namespace App\Graphql\Enum;

use MyCLabs\Enum\Enum;

class CurrencyEnum extends Enum
{
    private const EUR = 'EURO';
    private const JPY = 'JPY';
    private const USD = 'USD';
    private const XPF = 'XPF';
}
