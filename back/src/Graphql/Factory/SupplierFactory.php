<?php

declare(strict_types=1);

namespace App\Graphql\Factory;

use App\Entity\Supplier;
use Doctrine\ORM\EntityManagerInterface;
use TheCodingMachine\GraphQLite\Annotations\Factory;
use TheCodingMachine\GraphQLite\Exceptions\GraphQLException;

class SupplierFactory
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    #[Factory]
    public function get(string $code): Supplier
    {
        $supplier = $this->em->getRepository(Supplier::class)
            ->findOneBy(['code' => $code]);

        if (null === $supplier) {
            throw new GraphQLException('Supplier not existings', 400, null, 'VALIDATION', ['field' => 'supplier', 'code' => $code]);
        }

        return $supplier;
    }
}
