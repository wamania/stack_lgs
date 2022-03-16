<?php

declare(strict_types=1);

namespace App\Graphql\Type;

use App\Entity\Variant;
use TheCodingMachine\GraphQLite\Annotations\SourceField;
use TheCodingMachine\GraphQLite\Annotations\Type;

#[Type(class: Variant::class, name: 'Variant')]
#[SourceField(name: 'id', outputType: 'ID')]
#[SourceField(name: 'sku')]
#[SourceField(name: 'color')]
#[SourceField(name: 'price')]
#[SourceField(name: 'product')]
class VariantType
{

}
