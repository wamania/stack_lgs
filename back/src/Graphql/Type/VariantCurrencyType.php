<?php

declare(strict_types=1);

namespace App\Graphql\Type;

use App\Entity\Variant;
use App\Graphql\Enum\CurrencyEnum;
use App\Service\CurrencyConverter;
use TheCodingMachine\GraphQLite\Annotations\ExtendType;
use TheCodingMachine\GraphQLite\Annotations\Field;

#[ExtendType(class: Variant::class)]
class VariantCurrencyType
{
    public function __construct(
        private CurrencyConverter $currencyConverter,
    ) {
    }

    #[Field]
    public function convertPrice(Variant $variant, CurrencyEnum $to): float
    {
        return $this->currencyConverter->convert($variant->getPrice(), $to);
    }
}
