<?php

declare(strict_types=1);

namespace App\Graphql\Manager;

use App\Entity\Supplier;
use Doctrine\ORM\EntityManagerInterface;
use TheCodingMachine\GraphQLite\Annotations\Query;

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

    ) {
        return $this->em->getRepository(Supplier::class)
            ->findall();
    }
}
