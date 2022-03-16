<?php

declare(strict_types=1);

namespace App\Graphql\Manager;

use App\Entity\Supplier;
use Doctrine\ORM\EntityManagerInterface;

class SupplierManager
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    /**
     * @return Supplier[]
     */
    public function suppliers(
        ?string $sku,
        ?string $reference,
    ) {
        return $this->em->getRepository(Supplier::class)
            ->list($sku, $reference);
    }
}
