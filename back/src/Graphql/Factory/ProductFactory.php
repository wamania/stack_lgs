<?php

declare(strict_types=1);

namespace App\Graphql\Factory;

use App\Entity\Product;
use App\Entity\Supplier;
use Doctrine\ORM\EntityManagerInterface;
use TheCodingMachine\GraphQLite\Annotations\Factory;
use TheCodingMachine\GraphQLite\Exceptions\GraphQLException;

class ProductFactory
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    #[Factory]
    public function get(string $reference, ?string $name, ?Supplier $supplier): Product
    {
        $product = $this->em->getRepository(Product::class)
            ->findOneBy(['reference' => $reference]);

        if (null === $product) {
            if (null === $supplier) {
                throw new GraphQLException('Field required', 400, null, 'VALIDATION', ['field' => 'supplier']);
            }
            $product = (new Product())
                ->setReference($reference)
                ->setSupplier($supplier);
        }

        if (null !== $name) {
            $product->setName($name);
        }

        return $product;
    }
}
