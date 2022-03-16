<?php

declare(strict_types=1);

namespace App\Graphql\Controller;

use App\Entity\Supplier;
use App\Graphql\Manager\SupplierManager;
use TheCodingMachine\GraphQLite\Annotations\Autowire;
use TheCodingMachine\GraphQLite\Annotations\Query;

class SupplierController
{
    /**
     * @return Supplier[]
     */
    #[Query]
    public function suppliers(
        ?string $sku,
        ?string $reference,
        #[Autowire]
        SupplierManager $supplierManager
    ) {
        return $supplierManager->suppliers($sku, $reference);
    }
}
