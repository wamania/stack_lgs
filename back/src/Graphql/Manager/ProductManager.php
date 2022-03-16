<?php

declare(strict_types=1);

namespace App\Graphql\Manager;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductManager
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function saveProduct(Product $product): void
    {
        $this->em->persist($product);
        $this->em->flush();
    }
}
